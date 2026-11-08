# MuhariMokas — Platform Showroom Sepeda Motor Bekas

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-3.4-38bdf8.svg)](https://tailwindcss.com)
[![MySQL](https://img.shields.io/badge/MySQL-MariaDB-orange.svg)](https://mysql.com)
[![Tests Status](https://img.shields.io/badge/Tests-17%20Passed%20(100%25)-emerald.svg)](#pengujian--quality-assurance)

**MuhariMokas** adalah aplikasi web jual beli sepeda motor bekas profesional yang dirancang dengan arsitektur MVC bersih (*Clean MVC*), mengutamakan prinsip desain *"Trust before decoration"* dan *"Content first, interface second"*.

---

## 🛵 Fitur Utama Aplikasi

### 1. Customer (Public User — Zero Friction)
- **Tanpa Registrasi & Tanpa Login:** Calon pembeli dapat langsung mengakses seluruh katalog unit motor yang dipublikasikan.
- **Katalog Terpadu:**
  - Pencarian teks terintegrasi (*model, warna, merek*).
  - Multi-filter: Merek (*Honda, Yamaha, Suzuki, Kawasaki, Vespa*), rentang harga (Min/Maks), rentang tahun, dan tipe transmisi (*Automatic, Manual, Semi-Automatic*).
  - Multi-sorting: Terbaru, harga termurah, harga termahal, tahun termuda/tertua, dan kilometer terendah.
  - Filter tetap aktif saat berpindah halaman (*Pagination with Query String*).
- **Halaman Detail Motor:**
  - Galeri foto kendaraan interaktif dengan rasio 4:3.
  - Rincian spesifikasi lengkap (Tahun, Odometer, Kapasitas cc, Transmisi, Warna, Status Dokumen STNK & BPKB).
  - Status ketersediaan (*Tersedia* vs *Terjual*).
  - Rekomendasi motor sejenis dari merek atau kisaran harga serupa.
- **Integrasi WhatsApp Click-to-Chat:**
  - Pesan otomatis terstruktur memuat Nama Motor dan Harga Cash unit.
  - Nomor WhatsApp dikonfigurasi via `.env` (bukan hardcoded).
  - Jika unit berstatus **Terjual**, label TERJUAL muncul dan tombol WhatsApp otomatis dinonaktifkan.

### 2. Employee (Panel Internal Karyawan)
- **Autentikasi Aman:** Login menggunakan Laravel Breeze (Blade stack) tanpa fitur registrasi publik untuk mencegah pihak luar mendaftar.
- **Dashboard Ringkas:** 4 Kartu metrik real-time (*Total Inventaris, Unit Tersedia, Unit Terjual, Unit Draft*).
- **Manajemen Inventaris (CRUD Penuh):**
  - Tabel data responsif dengan filter status dan pencarian.
  - Form input 2-kolom terorganisir dengan validasi server-side lengkap.
  - **Multiple Image Upload:** Unggah hingga 10 foto per unit motor (@ maks. 2 MB) dengan live preview, penentuan foto utama (thumbnail), dan opsi hapus foto spesifik.
  - **Siklus Status Produk:** Transisi `draft` $\rightarrow$ `published` $\rightarrow$ `sold` $\rightarrow$ `inactive`.
  - **Modal Konfirmasi Hapus:** Menghapus unit dan secara otomatis membersihkan file fisik foto dari storage server (*zero orphan files*).

---

## 🎨 Design System & Identitas Brand

- **Filosofi:** Profesional, Modern, Bersih, Transparan.
- **Tipografi:** Font **Inter** dengan skala hierarki yang konsisten.
- **Proporsi Warna:**
  - `75%` White (`#FFFFFF`) — Latar belakang utama.
  - `15%` Slate Neutral (`#F8FAFC` s/d `#0F172A`) — Teks dan pembatas border halus.
  - `7%` Brand Green (`#166534`) — Identitas brand, indikator verifikasi, dan positive badge.
  - `3%` Primary Red (`#C62828`) — Call-to-Action utama dan tombol beli.
- **Aksesibilitas:** Mematuhi standar WCAG 2.2 Level AA (kontras teks tinggi, visible focus rings, label form semantik, touch target $\ge 44 \times 44\text{px}$).

---

## 🛠️ Technology Stack

| Layer | Teknologi |
|---|---|
| **Backend Framework** | Laravel 12 (kompatibel penuh PHP 8.2) |
| **Language** | PHP 8.2 |
| **Database** | MySQL / MariaDB (InnoDB, Foreign Keys, B-Tree Indexes) |
| **Authentication** | Laravel Breeze (Blade Stack) |
| **Styling & CSS** | Tailwind CSS 3.4 & `@tailwindcss/forms` |
| **Frontend Interaction** | Alpine.js 3.x |
| **Build Tool** | Vite 7 |
| **Storage Engine** | Laravel Storage (`public` disk dengan symlink/junction) |

---

## 🚀 Panduan Instalasi Lokal

### 1. Kloning & Masuk ke Direktori
```bash
git clone <repository-url> MuhariMokas
cd MuhariMokas
```

### 2. Instalasi Dependensi PHP & Node.js
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file konfigurasi dan generate application key:
```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi database dan showroom pada `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=muharimokas
DB_USERNAME=root
DB_PASSWORD=

# Showroom Configuration
WHATSAPP_NUMBER=6281234567890
SHOWROOM_ADDRESS="Jl. Raya Otista No. 88, Jakarta Timur"
SHOWROOM_PHONE="+62 812-3456-7890"
SHOWROOM_EMAIL="kontak@muharimokas.com"
```

### 4. Migrasi & Seeding Database
Pastikan service MySQL Anda aktif, lalu jalankan:
```bash
php artisan migrate --seed
```

Perintah di atas akan:
1. Membuat seluruh tabel (`users`, `brands`, `motorcycles`, `motorcycle_images`).
2. Mendaftarkan 1 akun karyawan default.
3. Mengisi master merek (*Honda, Yamaha, Suzuki, Kawasaki, Vespa*).
4. Mengisi 10 unit motor contoh lengkap dengan gambar studio di storage.

### 5. Hubungkan Storage Link
```bash
php artisan storage:link
```
*(Di Windows, junction dibuat otomatis di `public/storage`).*

### 6. Build Aset Frontend
```bash
npm run build
```

### 7. Jalankan Server Lokal
```bash
php artisan serve
```
Akses aplikasi melalui browser di: `http://localhost:8000`

---

## 🔑 Kredensial Login Internal Karyawan

Untuk menguji fitur dashboard dan CRUD inventaris:
- **URL Login:** `http://localhost:8000/login`
- **Email:** `admin@muharimokas.com`
- **Password:** `password123`

---

## 🧪 Pengujian & Quality Assurance

Aplikasi dilengkapi dengan test suite otomatis menggunakan PHPUnit / Pest:

```bash
php artisan test
```

### Hasil Pengujian:
```text
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Feature\Auth\AuthenticationTest
  ✓ login screen can be rendered
  ✓ users can authenticate using the login screen
  ✓ users can not authenticate with invalid password
  ✓ users can logout

   PASS  Tests\Feature\MuhariMokasTest
  ✓ public homepage renders successfully
  ✓ catalog displays only published motorcycles by default
  ✓ catalog search and filters work
  ✓ product detail page renders with whatsapp integration
  ✓ sold motorcycle displays terjual badge and disabled cta
  ✓ draft or inactive motorcycle returns 404 for customer
  ✓ static pages render successfully
  ✓ unauthenticated user cannot access dashboard
  ✓ employee can login and access dashboard
  ✓ employee can create motorcycle with images
  ✓ employee can update motorcycle
  ✓ employee can delete motorcycle

  Tests:    17 passed (58 assertions)
  Duration: 1.42s
```

---

## 📁 Struktur Direktori Penting

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php      # Metrik dashboard ringkas
│   │   │   ├── MotorcycleController.php     # CRUD inventaris kendaraan
│   │   │   └── MotorcycleImageController.php# Hapus & ubah foto utama
│   │   └── Public/
│   │       ├── HomeController.php           # Beranda publik & trust highlight
│   │       ├── CatalogController.php        # Katalog, filter, & detail unit
│   │       └── PageController.php           # Halaman Tentang Kami & Kontak
│   └── Requests/
│       ├── StoreMotorcycleRequest.php       # Validasi penambahan unit motor
│       └── UpdateMotorcycleRequest.php      # Validasi perbaruan unit motor
├── Models/
│   ├── Brand.php                            # Master merek motor
│   ├── Motorcycle.php                       # Model utama kendaraan + scopes
│   ├── MotorcycleImage.php                  # Galeri foto unit kendaraan
│   └── User.php                             # Akun karyawan internal
└── Services/
    ├── ImageUploadService.php               # Upload multiple foto & unlink disk
    └── MotorcycleService.php                # Business logic inventaris motor
resources/views/
├── components/                              # Reusable Blade components
├── layouts/                                 # Layout publik vs admin panel
├── public/                                  # Halaman publik (Home, Catalog, Detail)
└── admin/                                   # Halaman admin panel (Dashboard, CRUD)
```

---

## 👨‍💻 Pengembang & Portofolio

Proyek ini dibangun sebagai demonstrasi kecakapan penuh dalam rekayasa perangkat lunak web: mulai dari arsitektur data relasional, pemisahan lapisan bisnis dan presentasi, implementasi otentikasi tanpa registrasi publik, hingga desain UI/UX yang responsif dan berorientasi pada konversi bisnis nyata.
