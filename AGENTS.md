# AGENTS.md — Panduan AI Coding Agent untuk CodeIgniter 3 (Clean Architecture)

Dokumen ini adalah **sumber kebenaran (source of truth)** bagi AI Coding Agent (Antigravity, Claude Code, Cursor, dll.) saat mengembangkan, memelihara, atau melakukan debug pada project ini. Baca dokumen ini secara penuh sebelum menulis kode apa pun. Jika ada perintah dari user yang bertentangan dengan aturan di sini, **konfirmasi dulu** ke user sebelum melanggar arsitektur.

---

## 1. Ringkasan Proyek

| Item             | Detail                                                                                                |
| ---------------- | ----------------------------------------------------------------------------------------------------- |
| Framework        | CodeIgniter 3.x                                                                                       |
| Bahasa           | PHP (cek versi aktual di `composer.json` / server — jangan asumsikan)                                 |
| Arsitektur       | Clean Architecture (Domain → UseCase → Infrastructure → Presentation)                                 |
| Namespace bisnis | `App\` (PSR-4, di-autoload dari `application/src/`)                                                   |
| Database         | MySQL/MariaDB via CI3 Query Builder (Active Record)                                                   |
| Autentikasi      | Lihat `application/src/Domain/Entities/User.php` & `App\UseCases\LoginUseCase` sebagai referensi pola |

> Project ini **bukan** CI3 standar berbasis Fat Controller + Model Active Record. Semua logika bisnis **wajib** hidup di `application/src/`, bukan di `application/controllers/` maupun `application/models/`.

---

## 2. Perintah & Setup Umum

Sebelum menjalankan perintah di bawah, cek dulu apakah file terkait (`composer.json`, `phpunit.xml`, `.env`) benar-benar ada di project — jangan berasumsi.

```bash
# Install dependency (autoloader Composer dipakai untuk PSR-4 App\)
composer install

# Regenerate autoloader setelah menambah class/namespace baru
composer dump-autoload -o

# Jalankan server lokal bawaan PHP (development)
php -S localhost:8080 -t .

# Jalankan migration (jika library migration CI3 diaktifkan)
php index.php migrate

# Jalankan unit test (Domain & UseCase layer — tanpa bootstrap CI3)
vendor/bin/phpunit

# Jalankan test spesifik
vendor/bin/phpunit --filter LoginUseCaseTest
```

**Aturan untuk AI Agent:** jangan mengasumsikan tool test/lint tertentu tersedia. Cek `composer.json` → `scripts` dan `require-dev` terlebih dahulu. Jika tidak ada PHPUnit, tanyakan ke user apakah perlu disiapkan sebelum menulis test.

---

## 3. Struktur Folder Lengkap

```
capaian/
├── application/
│   ├── config/                # Konfigurasi CI3 (termasuk PSR-4 Autoloader di config.php)
│   │   ├── autoload.php
│   │   ├── config.php
│   │   ├── database.php
│   │   └── routes.php
│   ├── controllers/           # Presentation Layer — HTTP Adapter (CI3 Controller)
│   ├── views/                 # Presentation Layer — UI (HTML/PHP/JS)
│   ├── helpers/                # Helper CI3 murni (formatting, string, dsb) — TIDAK boleh berisi business rule
│   ├── libraries/              # Library CI3 custom (mis. wrapper 3rd-party) — dipanggil hanya dari Infrastructure/Controller
│   ├── models/                 # Query layer CI3 asli (extends CI_Model). Berisi query Active Record MENTAH.
│   │                           # Dipanggil HANYA dari Infrastructure Repository — lihat §4.3 & §5.4
│   └── src/                    # LOGIKA BISNIS UTAMA (Namespace: App\)
│       ├── Domain/             # Lingkaran Terdalam (Enterprise Business Rules)
│       │   ├── Entities/       # Objek bisnis murni (PHP murni, tanpa dependency CI3)
│       │   ├── Repositories/   # Interface / kontrak akses data (abstraksi)
│       │   ├── Exceptions/     # Domain-specific exceptions (mis. InvalidCredentialsException)
│       │   └── ValueObjects/   # (opsional) Value Object immutable, mis. Email, Money
│       ├── UseCases/           # Lingkaran Menengah (Application Business Rules)
│       │   ├── DTO/            # Request & Response DTO per fitur
│       │   └── ...UseCase.php  # Satu class per alur kerja/fitur spesifik
│       └── Infrastructure/     # Lingkaran Terluar (Framework & Drivers)
│           ├── Repositories/   # Implementasi konkret dari Domain\Repositories
│           └── Services/       # Integrasi eksternal (email, payment gateway, storage, dsb)
├── tests/
│   ├── Unit/
│   │   ├── Domain/             # Test Entity & Value Object (PHP murni)
│   │   └── UseCases/           # Test UseCase dengan mock Repository
│   └── Integration/
│       └── Infrastructure/     # Test Repository konkret terhadap DB test (opsional)
├── composer.json
└── phpunit.xml
```

> **Catatan model legacy:** jika project sudah punya file di `application/models/`, JANGAN hapus tanpa diminta. Tapi untuk **fitur baru**, semua akses data wajib lewat `App\Infrastructure\Repositories`, bukan CI3 Model.

---

## 4. Aturan Utama Clean Architecture (The Dependency Rule)

> [!IMPORTANT]
> Kode di lingkaran dalam **tidak boleh mengetahui apa pun** tentang kode di lingkaran luar. Dependency hanya boleh mengarah ke dalam (inward).

```mermaid
graph TD
    subgraph Lingkaran Terluar - Infrastructure and Presentation
        Controller[Controllers CI3]
        DB[Database / Repositories Impl]
        Ext[External Services: Mail, Payment, Storage]
    end
    subgraph Lingkaran Menengah - Use Cases
        UC[Use Cases]
        DTO[DTOs]
    end
    subgraph Lingkaran Terdalam - Domain
        Entity[Entities]
        RepoInterface[Repository Interfaces]
        DomainExc[Domain Exceptions]
    end

    Controller --> UC
    DB -.implements.-> RepoInterface
    Ext -.implements.-> RepoInterface
    UC --> Entity
    UC --> RepoInterface
    UC --> DomainExc
```

### 4.1 Domain Layer (`App\Domain`)

- **Entities**: objek PHP murni yang merepresentasikan data & aturan bisnis kritis.
  - Dilarang mengimpor library CI3, helper CI3, atau class dari UseCase/Infrastructure.
  - Properti di-enkapsulasi (`private`/`protected`), diakses via getter/setter atau method perilaku.
  - Validasi invariant bisnis (mis. "email harus valid", "saldo tidak boleh negatif") ditaruh di sini, bukan di Controller.
- **Repository Interfaces**: hanya `interface`, tanpa logika query/SQL/Active Record.
- **Domain Exceptions**: exception custom untuk pelanggaran aturan bisnis (mis. `InsufficientBalanceException`), dilempar dari Entity atau UseCase, ditangkap di Controller.

### 4.2 UseCase Layer (`App\UseCases`)

- Satu class = satu alur kerja/fitur (Single Responsibility). Mengorkestrasi Entities & Repository Interface.
- **DTO**: struktur data masuk (Request) & keluar (Response).
  - UseCase **tidak boleh** menerima `$_POST`, objek `CI_Input`, atau input HTTP mentah lainnya — harus DTO.
  - UseCase **tidak boleh** mengembalikan entity DB mentah/Active Record — bungkus dengan Response DTO.
  - **Dilarang keras** query database langsung di UseCase. Semua akses data lewat Repository Interface yang disuntik via constructor.

### 4.3 Infrastructure Layer (`App\Infrastructure`)

- **Repositories**: implementasi konkret dari interface di Domain. Repository **tidak menulis query Active Record sendiri** — query sesungguhnya didelegasikan ke **CI3 Model** (`application/models/`), lalu Repository memetakan hasilnya ke Domain Entity. Pembagian tanggung jawabnya:
  - **CI3 Model** (`application/models/..._model.php`, `extends CI_Model`): satu-satunya tempat yang boleh menulis query Active Record (`$this->db->...`) atau raw SQL dengan **query binding** (`?` placeholder, jangan concat string). Model **hanya** mengembalikan data mentah (array/`stdClass`) — **dilarang** mengembalikan Domain Entity dari Model.
  - **Infrastructure Repository** (`App\Infrastructure\Repositories`): memuat Model via `$this->CI->load->model('user_model')`, memanggil methodnya, lalu memetakan hasil array/`stdClass` ke Domain Entity lewat method mapping privat (mis. `mapRowToEntity(array $row): User`). Gunakan `get_instance()` untuk akses super object CI3: `$this->CI =& get_instance();`.
  - **Aturan ketat**: Model **hanya** boleh dipanggil dari Infrastructure Repository. Controller dan UseCase **dilarang** memanggil `$this->load->model()` atau method Model secara langsung.
  - Method Repository **wajib** mengembalikan Domain Entity (atau array of Entities) ke pemanggilnya (UseCase), **tidak pernah** meneruskan raw `stdClass`/array DB mentah dari Model.
- **Services**: wrapper untuk integrasi eksternal (email, payment gateway, file storage). Juga di-abstraksi lewat interface di Domain jika UseCase perlu memanggilnya (mis. `NotifierInterface`).

### 4.4 Presentation Layer (`application/controllers` & `application/views`)

- Controller hanya boleh:
  1. Validasi request HTTP (`$this->form_validation`).
  2. Mapping input form → Request DTO.
  3. Memanggil UseCase.
  4. Menangani session/flashdata & redirect.
  5. Merender View atau mengembalikan JSON response.
- **Dilarang keras** menulis logika bisnis atau query database di Controller.
- Controller bertindak sebagai **Dependency Resolver** di constructor: instansiasi Repository konkret → inject ke UseCase.
- View hanya menampilkan data yang sudah di-escape (`html_escape()` CI3 atau `htmlspecialchars()`). Dilarang memanggil Repository/UseCase/DB dari View.

---

## 5. Contoh Implementasi End-to-End (Referensi Pola)

Gunakan pola di bawah sebagai template, sesuaikan nama/field dengan fitur yang diminta.

### 5.1 Domain Entity

```php
<?php
namespace App\Domain\Entities;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $passwordHash;

    public function __construct(int $id, string $name, string $email, string $passwordHash)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public function id(): int { return $this->id; }
    public function name(): string { return $this->name; }
    public function email(): string { return $this->email; }

    public function verifyPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->passwordHash);
    }

    public function rename(string $newName): void
    {
        if (trim($newName) === '') {
            throw new \App\Domain\Exceptions\InvalidNameException('Nama tidak boleh kosong');
        }
        $this->name = $newName;
    }
}
```

### 5.2 Domain Repository Interface

```php
<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function findById(int $id): ?User;
    public function save(User $user): bool;
}
```

### 5.3 UseCase + DTO

```php
<?php
namespace App\UseCases\DTO;

class LoginRequest
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {}
}
```

```php
<?php
namespace App\UseCases\DTO;

class LoginResponse
{
    public function __construct(
        public readonly int $userId,
        public readonly string $name,
        public readonly string $email
    ) {}
}
```

```php
<?php
namespace App\UseCases;

use App\UseCases\DTO\LoginRequest;
use App\UseCases\DTO\LoginResponse;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Exceptions\InvalidCredentialsException;

class LoginUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(LoginRequest $request): LoginResponse
    {
        $user = $this->userRepository->findByEmail($request->email);

        if ($user === null || !$user->verifyPassword($request->password)) {
            throw new InvalidCredentialsException('Email atau password salah');
        }

        return new LoginResponse($user->id(), $user->name(), $user->email());
    }
}
```

### 5.4 CI3 Model (Query Layer)

Model CI3 standar — **hanya** berisi query Active Record/raw SQL, tanpa logika bisnis, dan **hanya** mengembalikan data mentah (array/`stdClass`), bukan Domain Entity.

```php
<?php
// application/models/User_model.php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function findByEmail(string $email): ?array
    {
        $query = $this->db->get_where($this->table, ['email' => $email]);
        return $query->row_array() ?: null;
    }

    public function findById(int $id): ?array
    {
        $query = $this->db->get_where($this->table, ['id' => $id]);
        return $query->row_array() ?: null;
    }

    public function updateUser(int $id, array $data): bool
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function insertUser(array $data): int
    {
        $this->db->insert($this->table, $data);
        return (int) $this->db->insert_id();
    }
}
```

### 5.5 Infrastructure Repository (Concrete — memanggil Model)

Repository **tidak** menjalankan query sendiri. Ia memuat Model, memanggil methodnya, lalu memetakan hasil array mentah ke Domain Entity.

```php
<?php
namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class DbUserRepository implements UserRepositoryInterface
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('user_model');
    }

    public function findByEmail(string $email): ?User
    {
        $row = $this->CI->user_model->findByEmail($email);
        return $row ? $this->mapRowToEntity($row) : null;
    }

    public function findById(int $id): ?User
    {
        $row = $this->CI->user_model->findById($id);
        return $row ? $this->mapRowToEntity($row) : null;
    }

    public function save(User $user): bool
    {
        return $this->CI->user_model->updateUser($user->id(), [
            'name' => $user->name(),
            'email' => $user->email(),
        ]);
    }

    private function mapRowToEntity(array $row): User
    {
        return new User(
            (int) $row['id'],
            $row['name'],
            $row['email'],
            $row['password_hash']
        );
    }
}
```

> **Catatan:** pola ini menjaga konvensi CI3 asli (Model sebagai query layer) tetap dipakai, sambil Repository berperan sebagai _adapter_ yang menjaga Domain tetap bersih dari detail database. Jika project lebih memilih Repository langsung memakai `$this->db` tanpa Model perantara, itu juga sah — yang **tidak boleh** berubah adalah: satu-satunya lapisan yang boleh menyentuh `$this->db` (baik langsung atau lewat Model) adalah Infrastructure, dan hasilnya wajib dipetakan ke Entity sebelum keluar dari Repository.

### 5.6 Controller (Dependency Resolver)

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    private $loginUseCase;

    public function __construct()
    {
        parent::__construct();

        $userRepository = new \App\Infrastructure\Repositories\DbUserRepository();
        $this->loginUseCase = new \App\UseCases\LoginUseCase($userRepository);
    }

    public function login()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login', ['errors' => validation_errors()]);
            return;
        }

        try {
            $request = new \App\UseCases\DTO\LoginRequest(
                $this->input->post('email'),
                $this->input->post('password')
            );
            $response = $this->loginUseCase->execute($request);

            $this->session->set_userdata('user_id', $response->userId);
            redirect('dashboard');
        } catch (\App\Domain\Exceptions\InvalidCredentialsException $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('auth/login');
        }
    }
}
```

---

## 6. Konvensi Penamaan

| Elemen                   | Konvensi                                               | Contoh                                                                  |
| ------------------------ | ------------------------------------------------------ | ----------------------------------------------------------------------- |
| Class (semua layer)      | PascalCase                                             | `LoginUseCase`, `DbUserRepository`                                      |
| Method & properti        | camelCase                                              | `findByEmail()`, `passwordHash`                                         |
| File PHP di `src/`       | Sama dengan nama class                                 | `LoginUseCase.php`                                                      |
| Nama tabel DB            | snake_case, plural                                     | `users`, `order_items`                                                  |
| Repository Interface     | Suffix `Interface`                                     | `UserRepositoryInterface`                                               |
| Repository konkret       | Prefix sesuai sumber data                              | `DbUserRepository`, `ApiProductRepository`                              |
| UseCase                  | Suffix `UseCase`, kata kerja + objek                   | `UpdateProfileUseCase`                                                  |
| DTO                      | Suffix `Request`/`Response`                            | `UpdateProfileRequest`                                                  |
| Domain Exception         | Suffix `Exception`                                     | `InsufficientBalanceException`                                          |
| Controller CI3           | PascalCase, sesuai konvensi CI3                        | `Auth.php`, `UserProfile.php`                                           |
| Model CI3 (query layer)  | PascalCase + suffix `_model`, file & class sama persis | `User_model.php` → `class User_model`                                   |
| Load Model di Repository | Lowercase, tanpa suffix ganda saat load                | `$this->CI->load->model('user_model');` → akses `$this->CI->user_model` |

---

## 7. Validasi, Error Handling & Format Response

- **Validasi format input** (required, valid_email, numeric, dsb) → CI3 `form_validation` di Controller.
- **Validasi aturan bisnis** (mis. "saldo cukup", "slot penuh") → di Entity atau UseCase, dilempar sebagai Domain Exception.
- Controller menangkap Domain Exception dan menerjemahkannya ke flashdata / HTTP response, **tidak** menampilkan stack trace mentah ke user.
- Untuk endpoint JSON API, gunakan format response konsisten:

```php
// Sukses
$this->output
    ->set_content_type('application/json')
    ->set_output(json_encode([
        'success' => true,
        'data' => $response,
    ]));

// Gagal
$this->output
    ->set_status_header(422)
    ->set_content_type('application/json')
    ->set_output(json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]));
```

---

## 8. Keamanan

1. Setiap file PHP (controller, view, `src/`) wajib diawali:
   ```php
   defined('BASEPATH') OR exit('No direct script access allowed');
   ```
   _(File di bawah `src/` yang di-autoload PSR-4 murni tanpa dependency CI3 boleh mengecualikan ini jika benar-benar tidak pernah diakses lewat web — tapi jika ragu, tetap sertakan.)_
2. Query database **selalu** pakai binding (`?` / Active Record `where()`), **tidak pernah** concat string user-input ke SQL.
3. Password disimpan dengan `password_hash()`, diverifikasi dengan `password_verify()`. Jangan pernah simpan plaintext.
4. Aktifkan CSRF protection CI3 (`$config['csrf_protection'] = TRUE;`) untuk form yang mengubah state.
5. Output ke View selalu di-escape (`html_escape()`) untuk mencegah XSS, kecuali memang sengaja merender HTML tepercaya.
6. Jangan commit credential (`database.php`, API key) ke VCS — gunakan `.env` atau file config yang di-gitignore.

---

## 9. Strategi Testing

Keuntungan utama Clean Architecture di sini: **Domain & UseCase bisa ditest tanpa bootstrap CodeIgniter sama sekali** karena keduanya PHP murni.

```php
<?php
// tests/Unit/UseCases/LoginUseCaseTest.php
use PHPUnit\Framework\TestCase;
use App\UseCases\LoginUseCase;
use App\UseCases\DTO\LoginRequest;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class LoginUseCaseTest extends TestCase
{
    public function testLoginSuccessReturnsResponse(): void
    {
        $fakeUser = new User(1, 'Budi', 'budi@example.com', password_hash('secret', PASSWORD_DEFAULT));

        $repo = $this->createMock(UserRepositoryInterface::class);
        $repo->method('findByEmail')->willReturn($fakeUser);

        $useCase = new LoginUseCase($repo);
        $response = $useCase->execute(new LoginRequest('budi@example.com', 'secret'));

        $this->assertSame(1, $response->userId);
    }

    public function testLoginFailsWithWrongPassword(): void
    {
        $this->expectException(\App\Domain\Exceptions\InvalidCredentialsException::class);

        $fakeUser = new User(1, 'Budi', 'budi@example.com', password_hash('secret', PASSWORD_DEFAULT));
        $repo = $this->createMock(UserRepositoryInterface::class);
        $repo->method('findByEmail')->willReturn($fakeUser);

        (new LoginUseCase($repo))->execute(new LoginRequest('budi@example.com', 'wrong'));
    }
}
```

- **Unit test** (wajib untuk fitur baru): Entity & UseCase, pakai mock Repository — cepat, tanpa DB.
- **Integration test** (opsional, untuk Repository kompleks): jalankan terhadap DB test terpisah, jangan pernah terhadap DB production/development.
- AI Agent **disarankan** menulis/menyertakan unit test untuk setiap UseCase baru yang dibuat, kecuali user secara eksplisit meminta sebaliknya.

---

## 10. Alur Menambahkan Fitur Baru (Checklist)

Contoh: fitur **"Update User Profile"**.

- [ ] **Domain**: update `App\Domain\Entities\User` jika ada field baru; tambah method `update(User $user): bool` di `UserRepositoryInterface`.
- [ ] **UseCase**: buat `UpdateProfileRequest`, `UpdateProfileResponse`, dan `UpdateProfileUseCase` (constructor menerima `UserRepositoryInterface`).
- [ ] **Infrastructure — Model**: tambah/perbarui method query mentah (mis. `updateUser()`) di `application/models/User_model.php`.
- [ ] **Infrastructure — Repository**: implementasikan `update()` di `DbUserRepository`, memanggil `$this->CI->user_model->updateUser()` lalu mapping ke Entity.
- [ ] **Presentation**: buat method `update_profile()` di Controller — validasi form, mapping ke DTO, panggil UseCase, set flashdata, redirect/render.
- [ ] **View**: update template terkait, pastikan output di-escape.
- [ ] **Test**: tambahkan unit test untuk `UpdateProfileUseCase` (happy path + edge case).
- [ ] **Cek arsitektur**: pastikan tidak ada query DB di Controller/UseCase, tidak ada entity mentah dikembalikan ke Controller.

---

## 11. Anti-Pattern yang Harus Dihindari

| ❌ Jangan                                                                      | ✅ Sebagai gantinya                                                                       |
| ------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------------- |
| `$this->db->get('users')` di Controller                                        | Panggil UseCase → Repository                                                              |
| UseCase menerima `$this->input->post()` langsung                               | Controller mapping ke Request DTO dulu                                                    |
| Repository mengembalikan `array`/`stdClass` mentah dari `row_array()`          | Mapping ke Domain Entity sebelum return                                                   |
| Business rule (mis. cek saldo) ditulis di Controller                           | Taruh di Entity atau UseCase                                                              |
| Entity mengimpor `CI_Controller`, helper CI3, atau `get_instance()`            | Entity tetap PHP murni, tanpa dependency CI3                                              |
| View memanggil Repository/UseCase langsung                                     | Controller yang menyiapkan semua data untuk View                                          |
| Menulis SQL dengan concat string dari input user                               | Gunakan query binding / Active Record                                                     |
| Controller/UseCase memanggil `$this->load->model()` atau method Model langsung | Hanya Infrastructure Repository yang boleh memanggil Model                                |
| CI3 Model mengembalikan Domain Entity                                          | Model hanya kembalikan array/`stdClass` mentah; mapping ke Entity dilakukan di Repository |
| Menaruh business rule di dalam Model (mis. `User_model`)                       | Model hanya query; business rule tetap di Entity/UseCase                                  |

---

## 12. Instruksi Khusus untuk AI Coding Agent

> [!WARNING]
> **Pegang teguh aturan berikut. Jangan bypass meskipun terasa lebih cepat:**

1. **DILARANG** mengakses database (`$this->db`) atau CI3 Model langsung dari UseCase atau Controller — hanya Infrastructure Repository yang boleh memanggil Model.
2. **DILARANG** mengembalikan query result CI3 mentah (object/array DB dari Model) ke Controller atau UseCase — wajib di-mapping ke Domain Entity di Infrastructure Repository.
3. **SELALU** gunakan DTO untuk pertukaran data antara Controller dan UseCase.
4. **JAGA** Entities tetap bebas dari dependency framework (PHP murni, tanpa `CI_Controller`/`get_instance()`).
5. **JAGA** CI3 Model (`application/models/`) tetap "bodoh" — hanya query, tanpa business rule dan tanpa mengembalikan Domain Entity.
6. **PERIKSA** kompatibilitas versi PHP di `composer.json` sebelum memakai syntax baru (readonly property, enum, named argument, dsb) — jangan asumsikan PHP 8.1+ tersedia jika belum dicek.
7. **BACA** file/class yang sudah ada di `application/src/` dan `application/models/` sebelum membuat class baru, agar penamaan & pola konsisten dengan yang sudah ada.
8. **JANGAN** menghapus atau mengubah migration/file existing tanpa diminta eksplisit oleh user.
9. **JANGAN** menaruh credential/API key langsung di kode — gunakan config/`.env`.
10. Jika requirement dari user ambigu terhadap layer mana yang bertanggung jawab, **tanyakan** sebelum menebak, atau ambil asumsi paling konsisten dengan pola yang sudah ada dan sebutkan asumsinya.
11. Setelah menambah class baru di `App\`, jalankan `composer dump-autoload -o` (atau ingatkan user untuk menjalankannya) agar autoloader ter-update.
12. Untuk perubahan arsitektur besar (mis. menambah layer baru, mengubah pola DI), **update dokumen AGENTS.md ini** agar tetap jadi source of truth yang akurat.

---

## 13. Cheat Sheet — "Saya Ingin Melakukan X, Taruh di Mana?"

| Kebutuhan                                               | Layer          | Lokasi File                                          |
| ------------------------------------------------------- | -------------- | ---------------------------------------------------- |
| Validasi format input form                              | Presentation   | Controller (`form_validation`)                       |
| Validasi aturan bisnis (mis. umur minimal, saldo cukup) | Domain         | Entity atau UseCase                                  |
| Alur kerja multi-step (mis. checkout, registrasi)       | UseCase        | `App\UseCases\...UseCase`                            |
| Query/insert/update database                            | Infrastructure | `App\Infrastructure\Repositories`                    |
| Kirim email/notifikasi                                  | Infrastructure | `App\Infrastructure\Services` (via interface Domain) |
| Struktur data request dari form                         | UseCase        | `App\UseCases\DTO\...Request`                        |
| Struktur data untuk ditampilkan di View                 | UseCase        | `App\UseCases\DTO\...Response`                       |
| Aturan "apa itu User yang valid"                        | Domain         | `App\Domain\Entities\User`                           |
| Kontrak akses data                                      | Domain         | `App\Domain\Repositories\...Interface`               |
| Session/flashdata/redirect                              | Presentation   | Controller                                           |
| Tampilan HTML                                           | Presentation   | `application/views`                                  |

---

## 14. Design System — Panduan Tampilan UI (Futuristic & Clean)

> [!IMPORTANT]
> Semua tampilan baru di project ini **wajib** mengikuti design system di bawah ini. Jangan menggunakan warna, font, atau class ad-hoc yang tidak konsisten dengan palette yang sudah ada. Cek file CSS yang relevan di `assets/css/` sebelum menulis HTML/CSS baru.

### 14.1 Color Palette (Token Resmi Project)

Seluruh warna bersumber dari CSS Custom Properties yang sudah didefinisikan di `assets/css/custom-home.css` dan digunakan secara konsisten di semua halaman.

| Token CSS                  | Nilai HEX / RGB               | Peran                                          |
| -------------------------- | ----------------------------- | ---------------------------------------------- |
| `--home-primary`           | `#38c66c`                     | Primary brand color — CTA, badge, link, border |
| `--home-primary-rgb`       | `56, 198, 108`                | Versi RGB untuk `rgba(...)` overlay/glassmorphism |
| `--home-primary-dark`      | `#2ea85b`                     | Hover state primary                            |
| `--home-primary-darker`    | `#227741`                     | Active state / badge text                      |
| `--home-accent`            | `#41c3a9`                     | Accent teal — gradient pair dengan primary     |
| `--home-accent-rgb`        | `65, 195, 169`                | Versi RGB untuk rgba accent overlay            |
| `--home-text-dark`         | `#0f172a`                     | Heading utama, teks paling gelap               |
| `--home-text`              | `#1e293b`                     | Body text default                              |
| `--home-text-muted`        | `#64748b`                     | Teks sekunder / subtitle                       |
| `--home-text-light`        | `#94a3b8`                     | Placeholder, label kecil, footer note          |
| `--home-bg`                | `#f8fafc`                     | Background halaman                             |
| `--home-card-bg`           | `#ffffff`                     | Background kartu/panel                         |
| `--home-border`            | `#e2e8f0`                     | Border kartu, divider                          |
| `--home-card-radius`       | `20px`                        | Border radius kartu besar                      |
| `--home-transition`        | `cubic-bezier(0.25, 0.8, 0.25, 1)` | Easing default untuk transisi hover       |

**Aturan warna tambahan:**
- Gunakan **putih murni** (`#ffffff`) sebagai background kartu, bukan abu-abu atau off-white.
- Hindari warna merah/biru/kuning generik. Gunakan varian dari palette di atas.
- Gradient selalu diagonal: `linear-gradient(135deg, #38c66c, #41c3a9)` atau `linear-gradient(135deg, rgba(...primary-rgb..., 0.08), rgba(...accent-rgb..., 0.06))`.

### 14.2 Typography

| Font Stack                       | Penggunaan                                      |
| -------------------------------- | ----------------------------------------------- |
| `'Inter', 'Outfit', sans-serif`  | **Utama** — heading, label, badge, number       |
| `'Outfit', sans-serif`           | Body text, form field, paragraph                |
| `'Inter', monospace`             | Kode, badge kode (IKU/indikator), angka metrik  |

**Import Google Fonts wajib di setiap custom CSS baru:**
```css
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700&display=swap');
```

**Aturan tipografi:**
- Heading utama: `font-weight: 700–800`, `letter-spacing: -0.5px`
- Label kecil/uppercase: `font-weight: 600`, `letter-spacing: 2px`, `text-transform: uppercase`
- Body text: `font-size: 0.9rem–0.95rem`, `line-height: 1.6`
- Jangan gunakan font-size di atas `2rem` kecuali untuk hero section.

### 14.3 Efek Visual & Animasi Wajib

Setiap halaman baru **harus** menggunakan minimal tiga dari pola berikut:

1. **Entrance animation** (`@keyframes fadeFadeUp`):
   ```css
   @keyframes pageFadeUp {
       from { opacity: 0; transform: translateY(24px); }
       to   { opacity: 1; transform: translateY(0); }
   }
   .my-element { animation: pageFadeUp 0.6s ease-out both; }
   ```

2. **Glow/gradient border on hover** (pseudo-element `::before`):
   ```css
   .my-card::before {
       content: '';
       position: absolute;
       inset: -1px;
       border-radius: inherit;
       padding: 1px;
       background: linear-gradient(135deg, transparent, transparent);
       -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
       -webkit-mask-composite: xor;
       mask-composite: exclude;
       transition: background 0.4s ease;
   }
   .my-card:hover::before {
       background: linear-gradient(135deg, var(--home-primary), var(--home-accent));
   }
   ```

3. **Glassmorphism badge/overlay:**
   ```css
   .my-badge {
       background: rgba(56, 198, 108, 0.06);
       backdrop-filter: blur(10px);
       border: 1px solid rgba(56, 198, 108, 0.1);
   }
   ```

4. **Radial gradient mesh background (page wrapper):**
   ```css
   .page-wrapper::before {
       content: '';
       position: fixed;
       inset: 0;
       z-index: -2;
       background:
           radial-gradient(ellipse 80% 50% at 20% 10%, rgba(56, 198, 108, 0.06) 0%, transparent 60%),
           radial-gradient(ellipse 60% 40% at 80% 80%, rgba(65, 195, 169, 0.05) 0%, transparent 60%);
       pointer-events: none;
   }
   ```

5. **Card lift on hover:**
   ```css
   .my-card:hover {
       transform: translateY(-6px);
       box-shadow: 0 20px 40px rgba(56, 198, 108, 0.08), 0 8px 16px rgba(0,0,0,0.04);
   }
   ```

6. **Staggered entrance animation** (untuk grid/list):
   ```css
   .my-card[data-delay="1"] { animation-delay: 0.05s; }
   .my-card[data-delay="2"] { animation-delay: 0.10s; }
   /* dst... */
   ```

7. **Pulse dot** (untuk status "aktif"/"live"):
   ```css
   .pulse-dot {
       width: 8px; height: 8px;
       border-radius: 50%;
       background: var(--home-primary);
       animation: pulseRing 2s ease-in-out infinite;
   }
   @keyframes pulseRing {
       0%, 100% { box-shadow: 0 0 0 0 rgba(56, 198, 108, 0.5); }
       50%       { box-shadow: 0 0 0 8px rgba(56, 198, 108, 0); }
   }
   ```

### 14.4 Komponen UI Standar

#### Kartu/Panel (Card)
```css
.page-card {
    background: #ffffff;
    border-radius: 18px;          /* atau 14px untuk kartu kecil */
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.03), 0 1px 4px rgba(0, 0, 0, 0.02);
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    overflow: hidden;
}
```

#### Banner/Hero Section
- Background: `linear-gradient(135deg, #ffffff 0%, #f0fdf4 50%, #f8fafc 100%)`
- Selalu tambahkan **grid overlay** untuk efek futuristik:
  ```css
  background-image:
      linear-gradient(rgba(56, 198, 108, 0.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(56, 198, 108, 0.03) 1px, transparent 1px);
  background-size: 40px 40px;
  ```
- Left accent bar (`::before`): `width: 6px; background: linear-gradient(180deg, #38c66c, #2ea85b);`

#### Badge/Chip
```css
.page-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 8px;           /* atau 20px untuk pill badge */
    font-size: 0.75rem;
    font-weight: 700;
    background: rgba(56, 198, 108, 0.07);
    color: #227741;
    border: 1px solid rgba(56, 198, 108, 0.1);
}
```

#### Icon Container
```css
.page-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    background: linear-gradient(135deg, rgba(56, 198, 108, 0.08), rgba(65, 195, 169, 0.06));
    color: #38c66c;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
}
```

#### Tombol Utama (CTA)
```css
.btn-primary-custom {
    background: linear-gradient(135deg, #38c66c, #2ea85b);
    border: none;
    border-radius: 10px;
    color: #ffffff;
    font-weight: 600;
    padding: 0.65rem 1.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(56, 198, 108, 0.25);
}
.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(56, 198, 108, 0.35);
}
```

#### Section Header
```html
<div class="section-header" style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1.5rem;">
    <div class="section-icon" style="width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg, rgba(56,198,108,0.12), rgba(65,195,169,0.08)); color:#38c66c;">
        <i class="mdi mdi-chart-bar"></i>
    </div>
    <div>
        <h5 style="margin:0; font-weight:700; color:#0f172a;">Judul Seksi</h5>
        <p style="margin:0; font-size:0.8rem; color:#64748b;">Sub-judul opsional</p>
    </div>
</div>
```

### 14.5 Grid Layout Responsif

Gunakan CSS Grid (bukan Bootstrap col saja) untuk layout kartu yang modern:

```css
.page-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);  /* default desktop */
    gap: 1.25rem;
}
@media (max-width: 1199.98px) { .page-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 991.98px)  { .page-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 575.98px)  { .page-grid { grid-template-columns: 1fr; } }
```

---

## 15. Pemetaan CSS File per Halaman

Gunakan tabel ini sebagai referensi: **CSS mana yang sudah ada, dan mana yang perlu dibuat baru** saat mengerjakan halaman tertentu.

| Halaman / Fitur                    | CSS File yang Digunakan                                    | View File                                   |
| ---------------------------------- | ---------------------------------------------------------- | ------------------------------------------- |
| Login / Autentikasi                | `assets/css/custom-login.css`                              | `application/views/auth/`                   |
| Dashboard Utama                    | `assets/css/custom-dashboard.css`                          | `application/views/dashboard/`              |
| Home / Beranda (Daftar Indikator)  | `assets/css/custom-home.css`                               | `application/views/dashboard/v_home.php`    |
| User Management                    | `assets/css/user_management.css`                           | `application/views/users/`                  |
| Migration / Setup                  | `assets/css/custom-migrate.css`                            | `application/views/migrate/`                |
| Error Pages                        | `assets/css/custom-errors.css`                             | `application/views/errors/`                 |
| Indikator IKU 1.1                  | `assets/css/indicator/iku_1_1.css`                         | `application/views/indicator/iku_1_1/`      |
| Indikator IKU 1.2                  | `assets/css/indicator/iku_1_2.css`                         | `application/views/indicator/iku_1_2/`      |
| Indikator IKU 1.3–1.9              | `assets/css/indicator/iku_1_3.css` – `iku_1_9.css`        | `application/views/indicator/iku_1_x/`      |
| Halaman baru (fitur baru)          | Buat `assets/css/custom-[nama-fitur].css`                  | Sesuaikan dengan nama halaman               |

> **Aturan AI Agent:**
> - Jika mengerjakan halaman yang sudah ada CSS-nya → **baca dulu file CSS yang relevan** sebelum menambah style baru.
> - Jika membuat halaman baru → **buat file CSS baru** di `assets/css/custom-[nama-fitur].css` dengan pola yang sama.
> - **Jangan** menulis inline style yang panjang atau menaruh style di `<style>` tag di View — semua CSS wajib di file terpisah.

---

## 16. Skill & Checklist Desain UI

Gunakan checklist ini setiap kali AI Agent **membuat atau memodifikasi tampilan View**:

### ✅ Checklist Wajib Sebelum Submit View

- [ ] **Font**: Sudah menggunakan `Inter` / `Outfit` dari Google Fonts? Import ada di CSS file?
- [ ] **Warna**: Semua warna merujuk ke token palette resmi (`#38c66c`, `#41c3a9`, `#0f172a`, `#f8fafc`, dll)?
- [ ] **Background halaman**: Menggunakan `#f8fafc` dengan radial gradient mesh overlay?
- [ ] **Kartu/Panel**: Sudah menggunakan `border-radius: 14px–20px`, `border: 1px solid #e2e8f0`, `box-shadow` subtle?
- [ ] **Animasi entrance**: Ada `@keyframes fadeFadeUp` atau `homeSlideIn` pada elemen utama?
- [ ] **Hover effect**: Kartu atau link punya `transform: translateY(-4px)` dan `box-shadow` saat hover?
- [ ] **Badge/Label kode**: Indikator/kode menggunakan glassmorphism badge (`rgba(56, 198, 108, 0.07)` + border tipis)?
- [ ] **Icon container**: Icon dibungkus `div` dengan background gradient tipis + rounded corner?
- [ ] **Section header**: Setiap seksi memiliki section icon + title + subtitle sesuai §14.4?
- [ ] **Responsif**: Grid sudah menggunakan CSS Grid dengan breakpoint 4-3-2-1 kolom?
- [ ] **Output di-escape**: Semua output PHP menggunakan `html_escape()` atau `htmlspecialchars()`?
- [ ] **CSS file**: Style diletakkan di file CSS terpisah (bukan `<style>` inline di View)?

### ✅ Checklist Kualitas Visual

- [ ] **Tidak ada warna generik**: Tidak ada `color: red`, `background: blue`, `#333`, `#666` tanpa alasan.
- [ ] **Tidak ada font browser default**: Tidak ada elemen yang menggunakan Times New Roman / Arial default.
- [ ] **Tidak ada border kasar**: Gunakan `border: 1px solid #e2e8f0` bukan `border: 1px solid black`.
- [ ] **Spacing konsisten**: Gunakan kelipatan `0.25rem` (mis. `0.5rem`, `1rem`, `1.5rem`, `2rem`).
- [ ] **Loading state**: Jika ada data dari DB, ada skeleton loader atau spinner yang on-brand?
- [ ] **Empty state**: Jika data kosong, ada ilustrasi atau pesan yang estetik (bukan tabel kosong polos)?

### Referensi Visual Utama

| Halaman Referensi | Lokasi CSS                        | Fitur Visual Unggulan                                    |
| ----------------- | --------------------------------- | -------------------------------------------------------- |
| Home / Beranda    | `assets/css/custom-home.css`      | Floating particles, hero card, staggered card animation  |
| Dashboard         | `assets/css/custom-dashboard.css` | Welcome card, indicator menu card, sidebar collapse fix  |
| Login             | `assets/css/custom-login.css`     | Minimal clean card, focus glow input, fade entrance      |
| User Management   | `assets/css/user_management.css`  | Banner accent bar, stat cards, table styling             |

> [!TIP]
> Untuk inspirasi cepat: buka `assets/css/custom-home.css` — file ini adalah implementasi paling lengkap dari design system project, mencakup particles background, hero card, grid layout, hover glow border, glassmorphism badge, dan staggered animation.
