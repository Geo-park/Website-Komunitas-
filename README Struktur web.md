# ⬡ HIMA Informatika — Laravel Website

Website resmi Himpunan Mahasiswa Informatika berbasis **Laravel 10**.  
Tema: **Ungu-Putih (Light)** & **Ungu-Hitam (Dark)** dengan theme switcher.

---

## 🚀 Cara Setup & Menjalankan

### Prasyarat
- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js (opsional, untuk asset bundling)

---

### 1. Clone / Ekstrak Project
```bash
# Ekstrak zip ke folder, lalu masuk ke direktori project
cd hima-laravel
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment
```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

Buka file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hima_informatika   # Buat database ini di MySQL dulu
DB_USERNAME=root
DB_PASSWORD=                   # Password MySQL kamu

# Kredensial admin panel
ADMIN_USERNAME=admin
ADMIN_PASSWORD=hima2024
```

### 4. Buat Database
Buka MySQL / phpMyAdmin, buat database baru:
```sql
CREATE DATABASE hima_informatika CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Jalankan Migrasi & Seeder
```bash
# Buat tabel + isi data demo
php artisan migrate --seed
```

### 6. Jalankan Server
```bash
php artisan serve
```

Buka browser: **http://localhost:8000** ✅

---

## 📁 Struktur Project

```
hima-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php        ← Beranda & Visi Misi
│   │   │   ├── KegiatanController.php    ← CRUD Kegiatan
│   │   │   ├── MarketplaceController.php ← CRUD Produk + Cart
│   │   │   ├── GaleriController.php      ← CRUD Galeri
│   │   │   ├── StrukturController.php    ← CRUD Pengurus
│   │   │   └── AdminController.php       ← Auth + Dashboard + Settings
│   │   └── Middleware/
│   │       └── AdminMiddleware.php       ← Proteksi route admin
│   ├── Models/
│   │   ├── Kegiatan.php
│   │   ├── Produk.php
│   │   ├── Pengurus.php
│   │   ├── Galeri.php
│   │   └── Setting.php                  ← Key-value settings helper
│   └── Providers/
│       └── AppServiceProvider.php        ← Share $settings ke semua views
│
├── database/
│   ├── migrations/                       ← Skema database
│   └── seeders/DatabaseSeeder.php        ← Data demo awal
│
├── public/
│   ├── css/
│   │   ├── app.css                       ← Styles utama (dark/light theme)
│   │   └── admin.css                     ← Styles admin panel
│   ├── js/
│   │   └── app.js                        ← JavaScript interaktif
│   └── index.php                         ← Front controller Laravel
│
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php                 ← Layout publik (navbar + footer)
│   │   └── admin.blade.php               ← Layout admin (sidebar)
│   ├── pages/
│   │   ├── home.blade.php                ← Landing page
│   │   ├── visi-misi.blade.php
│   │   ├── kegiatan.blade.php
│   │   ├── kegiatan-detail.blade.php
│   │   ├── marketplace.blade.php
│   │   ├── produk-detail.blade.php
│   │   ├── galeri.blade.php
│   │   └── struktur.blade.php
│   └── admin/
│       ├── login.blade.php
│       ├── dashboard.blade.php
│       ├── settings.blade.php
│       ├── kegiatan/form.blade.php
│       ├── produk/form.blade.php
│       ├── galeri/form.blade.php
│       └── struktur/form.blade.php
│
└── routes/web.php                        ← Semua routing
```

---

## 🔗 Halaman & URL

| Halaman | URL |
|---|---|
| 🏠 Beranda | `/` |
| 📋 Visi & Misi | `/visi-misi` |
| 📅 Kegiatan | `/kegiatan` |
| 🛒 Marketplace | `/marketplace` |
| 🖼 Galeri | `/galeri` |
| 👥 Struktur | `/struktur` |
| 🔐 Admin Login | `/admin/login` |
| 📊 Admin Dashboard | `/admin/dashboard` |
| ⚙ Admin Settings | `/admin/settings` |

---

## 🔐 Admin Panel

Login di `/admin/login` dengan:
- **Username:** `admin`
- **Password:** `hima2024`

*(Bisa diubah di file `.env` → `ADMIN_USERNAME` & `ADMIN_PASSWORD`)*

### Fitur Admin:
- ✅ Dashboard dengan statistik + tabel semua konten
- ✅ CRUD Kegiatan (tambah, edit, hapus, featured toggle)
- ✅ CRUD Produk/Marketplace (harga, stok, kategori)
- ✅ CRUD Galeri (dengan tanggal dan kategori)
- ✅ CRUD Pengurus / Struktur Organisasi
- ✅ Pengaturan sosial media (IG, TikTok, YouTube, WhatsApp)
- ✅ Pengaturan info organisasi (nama, alamat, email, visi)

---

## 🎨 Theme Switcher

- **Dark Mode:** Ungu + Hitam (default)
- **Light Mode:** Ungu + Putih
- Toggle melalui tombol ☀/🌙 di navbar
- Disimpan di **session** Laravel (server-side)
- Bekerja tanpa JavaScript

---

## 🛒 Marketplace & Cart

- Produk tersimpan di database (tabel `produk`)
- Keranjang menggunakan **Laravel Session**
- Checkout redirect ke **WhatsApp** dengan pesan otomatis berisi daftar produk
- Nomor WA bisa diubah di Admin → Pengaturan

---

## 📱 Sosial Media

Update link di Admin → Pengaturan → Sosial Media:
- Instagram
- TikTok  
- YouTube
- WhatsApp (untuk checkout marketplace)

---

## 🛠 Perintah Berguna

```bash
# Reset database + isi ulang data demo
php artisan migrate:fresh --seed

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Buat storage link (jika pakai upload gambar)
php artisan storage:link
```

---

## 💡 Tips Pengembangan Lanjutan

- **Upload Gambar:** Tambahkan field `gambar` handling di controller dengan `$request->file('gambar')->store('public/images')`
- **Email Notifikasi:** Gunakan Laravel Mail untuk notifikasi pendaftaran kegiatan
- **API:** Tambahkan `routes/api.php` untuk mobile app
- **Autentikasi Penuh:** Upgrade ke Laravel Breeze / Sanctum untuk multi-user admin
- **Deploy:** Upload ke VPS/Shared Hosting, jalankan `composer install --no-dev && php artisan config:cache`

---

**Dibuat untuk HIMA Informatika 🚀**  
*Bersama Maju, Berinovasi Tanpa Batas.*
