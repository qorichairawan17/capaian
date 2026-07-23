# Capaian

Dashboard monitoring **Indikator Kinerja Utama (IKU)** berbasis CodeIgniter 3 dengan Clean Architecture.

---

## Tech Stack

| Item | Detail |
|---|---|
| Framework | CodeIgniter 3.x |
| Bahasa | PHP ≥ 5.6 |
| Database | MySQL / MariaDB |
| Arsitektur | Clean Architecture — `App\` (PSR-4) |
| Server | XAMPP (Apache + MySQL) |

---

## Struktur Proyek

```
capaian/
├── application/
│   ├── config/               # Konfigurasi CI3
│   ├── controllers/          # Presentation — HTTP adapter
│   │   ├── Auth.php
│   │   ├── Dashboard.php
│   │   ├── Indicator.php
│   │   └── Migrate.php
│   ├── models/               # Query layer — Active Record CI3
│   ├── views/dashboard/
│   │   └── indicator/        # v_iku_1_1.php … v_iku_1_7.php
│   ├── migrations/           # Skema migrasi database
│   └── src/                  # Business logic (namespace App\)
│       ├── Domain/
│       │   ├── Entities/     # CaseRecord, CaseIku1xRecord, User, …
│       │   └── Repositories/ # Interface kontrak akses data
│       ├── UseCases/
│       │   ├── DTO/          # Request & Response DTO
│       │   └── GetCasesIku1xUseCase.php
│       └── Infrastructure/
│           └── Repositories/ # DbCaseIku1xRepository + MockCaseIku1xRepository
├── assets/                   # CSS, JS, gambar
├── system/                   # Core CI3 — jangan diubah
├── vendor/                   # Composer dependencies
└── composer.json
```

---

## Fitur IKU

| Kode | Indikator |
|---|---|
| IKU 1.1 | Penyelesaian perkara |
| IKU 1.2 | Perkara yang diselesaikan melalui mediasi |
| IKU 1.3 | Perkara yang diselesaikan melalui sidang keliling |
| IKU 1.4 | Perkara yang diselesaikan melalui prodeo |
| IKU 1.5 | Perkara yang diselesaikan tepat waktu |
| IKU 1.6 | Perkara yang diselesaikan dengan diversi |
| IKU 1.7 | Perkara yang diselesaikan dengan restorative justice |

Setiap IKU memiliki stack penuh:
`Entity → Repository Interface → UseCase → Repository (Db/Mock) → Controller → View`

---

## Instalasi

**1. Clone & install dependency**
```bash
git clone <repo-url> capaian
cd capaian
composer install
```

**2. Konfigurasi database**

Edit `application/config/database.php`:
```php
$db['default'] = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'capaian',
    // ...
];
```

**3. Jalankan migrasi**
```bash
php index.php migrate
```
Atau kunjungi `http://localhost/capaian/migrate` (perlu login admin).

**4. Akses aplikasi**
```
http://localhost/capaian
```

---

## Endpoint Utama

| URL | Keterangan |
|---|---|
| `/auth/login` | Halaman login |
| `/dashboard` | Ringkasan semua IKU |
| `/indicator/iku_1_1` … `/indicator/iku_1_7` | Detail per IKU |
| `/migrate` | Manajemen migrasi (admin) |

---

## Testing

Unit test Domain & UseCase berjalan **tanpa** bootstrap CI3:

```bash
# Semua test
vendor/bin/phpunit

# Test spesifik
vendor/bin/phpunit --filter GetCasesIku17UseCaseTest
```

Mock repository tersedia di `application/src/Infrastructure/Repositories/Mock*.php`.

---

## Lisensi

**Proprietary — Hak Cipta © Qori Chairawan. Seluruh hak dilindungi.**

Perangkat lunak ini bersifat rahasia dan merupakan milik eksklusif **Qori Chairawan**.
Dilarang menyalin, mendistribusikan, memodifikasi, atau menggunakan seluruh maupun
sebagian dari perangkat lunak ini tanpa izin tertulis dari pemilik.
