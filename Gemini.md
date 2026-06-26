# Panduan Agentic Coding AI: CodeIgniter 3 dengan Clean Architecture

Dokumen ini adalah pedoman dan instruksi untuk AI Coding Agent (seperti Antigravity) dalam mengembangkan, memelihara, dan melakukan debug pada project CodeIgniter 3 ini yang menerapkan prinsip **Clean Architecture**.

---

## 🏗️ Struktur Arsitektur Sistem

Project ini menggunakan pemisahan yang jelas antara framework (CodeIgniter 3) dan logika bisnis utama (Core Domain). Autoloading class di `application/src/` diatur dengan namespace `App\` menggunakan custom PSR-4 Autoloader pada `application/config/config.php`.

Berikut adalah struktur folder dan tanggung jawab masing-masing bagian:

```
capaian/
├── application/
│   ├── config/              # Konfigurasi CI3 (termasuk PSR-4 Autoloader)
│   ├── controllers/         # Presentation Layer (HTTP Adapter / Controller CI3)
│   ├── views/               # Presentation Layer (UI / View HTML/CSS/JS)
│   ├── src/                 # LOGIKA BISNIS UTAMA (Namespace: App\)
│   │   ├── Domain/          # Lingkaran Terdalam (Enterprise Business Rules)
│   │   │   ├── Entities/    # Objek Bisnis Murni (Model Domain)
│   │   │   └── Repositories/# Interface / Kontrak data (Abstraksi Data)
│   │   ├── UseCases/        # Lingkaran Menengah (Application Business Rules)
│   │   │   ├── DTO/         # Data Transfer Object (Request & Response)
│   │   │   └── ...UseCase.php # Logika Alur Kerja Spesifik Aplikasi
│   │   └── Infrastructure/  # Lingkaran Terluar (Framework & Drivers)
│   │       └── Repositories/# Implementasi Concrete dari Domain Repositories (Active Record, DB Query)
```

---

## 🎯 Aturan Utama Clean Architecture (The Dependency Rule)

> [!IMPORTANT]
> **Aturan Ketergantungan (Dependency Rule):**
> Kode di lingkaran dalam **tidak boleh mengetahui apa pun** tentang kode di lingkaran luar. Ketergantungan (dependency) hanya boleh mengarah ke dalam (inward).

```mermaid
graph TD
    subgraph Lingkaran Terluar (Infrastructure & Presentation)
        Controller[Controllers CI3]
        DB[Database / Repositories Impl]
    end
    subgraph Lingkaran Menengah (Use Cases)
        UC[Use Cases]
        DTO[DTOs]
    end
    subgraph Lingkaran Terdalam (Domain)
        Entity[Entities]
        RepoInterface[Repository Interfaces]
    end

    Controller --> UC
    DB -.-> RepoInterface
    UC --> Entity
    UC --> RepoInterface
```

### 1. Domain Layer (`App\Domain`)
*   **Entities (`App\Domain\Entities`)**: Objek PHP murni yang merepresentasikan data bisnis dan aturan bisnis kritis.
    *   *Aturan:* **Dilarang keras** mengimpor library CodeIgniter, helper, atau class dari layer Use Case & Infrastructure.
    *   *Aturan:* Properti sebaiknya di-enkapsulasi (`private` atau `protected`) dan diakses melalui getter/setter atau method perilaku (behavioral methods).
*   **Repositories Interface (`App\Domain\Repositories`)**: Kontrak/abstraksi untuk operasi data.
    *   *Aturan:* Hanya berupa `interface`. Tidak boleh ada logika query SQL, Active Record, atau koneksi database di sini.

### 2. UseCase Layer (`App\UseCases`)
*   Membungkus alur kerja aplikasi (fitur spesifik). Mengorkestrasi Entities dan berinteraksi dengan Repositories Interface.
*   **DTO (`App\UseCases\DTO`)**: Objek terstruktur untuk memindahkan data masuk (Request) dan keluar (Response) dari Use Case.
    *   *Aturan:* Use Case **tidak boleh** menerima input berupa objek HTTP request (seperti `$_POST` atau controller input) secara langsung. Harus dikonversi menjadi Request DTO terlebih dahulu.
    *   *Aturan:* Use Case **tidak boleh** mengembalikan entitas DB mentah atau objek ActiveRecord. Gunakan Response DTO untuk membungkus data output.
    *   *Aturan:* **Dilarang keras** menulis query database di dalam Use Case. Semua interaksi data harus melalui Repository Interface yang disuntikkan via Constructor (Dependency Injection).

### 3. Infrastructure Layer (`App\Infrastructure`)
*   Berisi detail teknis framework, database, library eksternal, atau file system.
*   **Repositories (`App\Infrastructure\Repositories`)**: Implementasi konkret dari interface yang didefinisikan di Domain.
    *   *Aturan:* Di sini tempatnya menulis query database menggunakan Active Record CodeIgniter 3 (`$this->db`) atau SQL mentah.
    *   *Aturan:* Gunakan `get_instance()` untuk mengakses super object CI3 (`$this->CI =& get_instance()`) guna memanggil database atau library bawaan CI3.
    *   *Aturan:* Method di dalam concrete repository harus selalu mengembalikan Domain Entity (atau array berisi Domain Entities) setelah melakukan query database, **bukan** mengembalikan raw database object/array CI3.

### 4. Presentation Layer (`application/controllers` & `application/views`)
*   **Controllers**:
    *   *Aturan:* Hanya bertugas memvalidasi request HTTP (menggunakan CI3 `$this->form_validation`), memetakan input ke DTO Request, memanggil Use Case, menangani session/flash data, dan merender view atau mengembalikan response JSON.
    *   *Aturan:* **Dilarang keras** menulis logika bisnis atau query database di Controller.
    *   *Aturan:* Controller bertindak sebagai **Dependency Resolver** di constructor untuk membuat instance Repository konkret dan menginjeksinya ke dalam Use Case.

---

## 🛠️ Panduan Implementasi Teknis & Code Style

### 1. Penanganan Dependency Injection (DI)
Karena CodeIgniter 3 tidak memiliki Dependency Injection Container bawaan, penyelesaian dependensi dilakukan secara manual di dalam Constructor Controller:

```php
// Di dalam application/controllers/Auth.php
public function __construct()
{
    parent::__construct();
    
    // 1. Instansiasi concrete repository dari layer Infrastructure
    // (Bisa juga disesuaikan apakah memakai DB atau Mock berdasarkan konfigurasi)
    $userRepository = new \App\Infrastructure\Repositories\DbUserRepository();
    
    // 2. Suntikkan ke Use Case melalui constructor (Dependency Injection)
    $this->loginUseCase = new \App\UseCases\LoginUseCase($userRepository);
}
```

### 2. Format Namespace & Autoloading
Semua file PHP di bawah folder `application/src/` wajib menggunakan namespace yang diawali dengan `App\`.
*   File `application/src/Domain/Entities/User.php` ➡️ `namespace App\Domain\Entities;`
*   File `application/src/UseCases/LoginUseCase.php` ➡️ `namespace App\UseCases;`
*   File `application/src/Infrastructure/Repositories/DbUserRepository.php` ➡️ `namespace App\Infrastructure\Repositories;`

### 3. Keamanan File PHP
Setiap file PHP, baik controller, view, maupun file di bawah `src/` wajib menyertakan pengecekan konstanta `BASEPATH` untuk mencegah eksekusi langsung dari web browser:
```php
defined('BASEPATH') OR exit('No direct script access allowed');
```

---

## 🔄 Contoh Alur Menambahkan Fitur Baru

Misalkan Anda diminta membuat fitur **"Update User Profile"**:

1.  **Domain Layer**:
    *   Perbarui entitas `App\Domain\Entities\User` jika ada field baru.
    *   Tambahkan method `update(User $user): bool` pada `App\Domain\Repositories\UserRepositoryInterface`.
2.  **UseCase Layer**:
    *   Buat Request DTO: `App\UseCases\DTO\UpdateProfileRequest`.
    *   Buat Response DTO: `App\UseCases\DTO\UpdateProfileResponse`.
    *   Buat UseCase class: `App\UseCases\UpdateProfileUseCase` yang menerima `UserRepositoryInterface` di constructor dan memproses logika update.
3.  **Infrastructure Layer**:
    *   Implementasikan method `update(User $user)` di `App\Infrastructure\Repositories\DbUserRepository` dengan menggunakan query `$this->CI->db->update()`.
4.  **Presentation Layer**:
    *   Buat method `update_profile()` di Controller untuk menangani validasi input form CI3, memetakan data form ke `UpdateProfileRequest`, memanggil UseCase, dan menyimpan status sukses ke session flashdata.
    *   Tampilkan perubahan di file View terkait.

---

## 🤖 Instruksi Penting untuk AI Agent (Antigravity & others)

> [!WARNING]
> **Pegang Teguh Aturan Arsitektur Ini:**
> 1. **DILARANG** melakukan bypass arsitektur dengan mengakses database (`$this->db`) secara langsung dari Use Case atau Controller.
> 2. **DILARANG** mengembalikan query result CI3 (object/array database) langsung ke Controller atau Use Case. Semua data database wajib di-mapping terlebih dahulu menjadi **Domain Entity** di dalam class Repository Infrastructure.
> 3. **SELALU** gunakan **DTO** untuk pertukaran data antara Presentation Layer (Controller) dan Application Layer (Use Cases).
> 4. **JAGA** agar Entities tetap bersih dari framework dependency (PHP murni).
> 5. **PERIKSA** kompatibilitas versi PHP pada server (gunakan sintaks PHP yang didukung oleh environment ini).
