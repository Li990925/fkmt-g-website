# Website Paguyuban Mahasiswa FKMT-G

Website resmi **Forum Komunikasi Mahasiswa Toili-Gorontalo (FKMT-G)**. Portal informasi organisasi yang menyediakan profil komunitas, susunan kepengurusan berjenjang, berita & kegiatan, dokumentasi galeri, serta panel manajemen data (*Content Management System*) untuk administrator.

---

## 🚀 Fitur Utama

### Halaman Publik
- **Beranda (Home):** Hero banner slider kegiatan dinamis dan kartu nilai-nilai utama organisasi.
- **Tentang Kami:** Sejarah berdirinya paguyuban, visi, dan misi.
- **Susunan Pengurus:** Struktur organisasi berjenjang (*Tiered Hierarchy*) mulai dari Pimpinan Utama (Ketua Umum), Badan Pengurus Harian (BPH), hingga Koordinator Bidang dengan kartu profil rapi.
- **Berita & Kegiatan:** Publikasi artikel, rilis kegiatan, dan pengumuman komunitas.
- **Galeri Kegiatan:** Dokumentasi foto kegiatan dan arsip momen penting paguyuban.
- **Responsif & Sticky Footer:** Desain adaptif untuk perangkat desktop maupun ponsel pintar.

### Panel Admin
- **Dashboard:** Ringkasan statistik jumlah anggota, berita, pengurus, dan galeri.
- **Kelola Berita:** Tambah, edit, dan hapus artikel berita.
- **Kelola Pengurus:** Manajemen struktur pimpinan, BPH, dan koordinator bidang beserta foto profil.
- **Kelola Anggota:** Pendataan data anggota paguyuban.
- **Kelola Galeri:** Unggah dan kelola dokumentasi foto kegiatan.
- **Kelola Slider:** Atur gambar yang tampil pada slider beranda utama.

---

## 🛠️ Kebutuhan Sistem

- **PHP:** Versi 8.1 ke atas (disarankan PHP 8.2+)
- **Basis Data:** MariaDB 10.4+ atau MySQL 5.7+
- **Ekstensi PHP:**
  - `pdo` & `pdo_mysql`
  - `mbstring`
  - `session`
- **Web Server:** Apache / LiteSpeed (mendukung `mod_rewrite`) atau PHP Built-in Server untuk pengembangan lokal.

---

## 💻 Panduan Instalasi Lokal

### 1. Salin atau Unduh Proyek
Masuk ke direktori proyek:
```bash
cd website-paguyuban
```

### 2. Konfigurasi Variabel Lingkungan (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Sesuaikan kredensial basis data di dalam file `.env`:
```env
APP_NAME="Website FKMT-G"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=fkmtg_db
DB_USER=root
DB_PASS=
```

### 3. Import Skema Basis Data
Buat basis data baru bernama `fkmtg_db` di MySQL/MariaDB, lalu import file skema yang telah disediakan:
```bash
# Melalui terminal:
mariadb -u root -p fkmtg_db < database/skema_paguyuban.sql

# Atau import file database/skema_paguyuban.sql melalui phpMyAdmin
```

### 4. Jalankan Server Lokal
Jalankan menggunakan PHP built-in web server:
```bash
php -S 0.0.0.0:8000 -t public
```
Buka peramban (*browser*) dan akses: **[http://localhost:8000](http://localhost:8000)**

---

## 🔐 Kredensial Login Admin Bawaan

- **Halaman Login:** [http://localhost:8000/login](http://localhost:8000/login)
- **Username:** `admin`
- **Password:** `admin123`

*(Disarankan segera mengubah password setelah proses deployment ke server produksi).*

---

## 📁 Struktur Direktori

```text
website-paguyuban/
├── .github/
│   └── workflows/
│       └── ci.yml               # Pipeline GitHub Actions (Syntax Lint & Validasi)
├── app/
│   ├── Config/
│   │   ├── Database.php         # Koneksi PDO Database
│   │   └── Env.php              # Loader variabel lingkungan (.env)
│   ├── Controllers/             # Controller Publik, Admin, dan Auth
│   ├── Middleware/              # Pengaman rute autentikasi
│   └── Models/                  # Model data (Berita, Pengurus, Anggota, dll)
├── database/
│   └── skema_paguyuban.sql      # Dump struktur tabel & data awal
├── public/                      # Web Root publik (DocumentRoot)
│   ├── assets/                  # CSS, JS, dan Gambar Upload
│   ├── .htaccess                # Aturan URL rewrite Apache
│   └── index.php                # Front controller / entry point utama
├── routes/
│   └── web.php                  # Konfigurasi routing aplikasi
├── views/                       # Tampilan antarmuka HTML/PHP
│   ├── admin/                   # Tampilan panel admin
│   ├── auth/                    # Halaman login
│   ├── layouts/                 # Master layout (master_publik & master_admin)
│   └── publik/                  # Halaman publik (beranda, tentang, pengurus, dll)
├── .env.example                 # Template konfigurasi environment
├── .gitignore                   # Daftar file yang diabaikan Git
├── .htaccess                    # Root rewrite pelindung folder internal
└── README.md                    # Dokumentasi proyek ini
```

---

## 🚀 Panduan Deployment ke Hosting / VPS

### Deployment ke cPanel / Shared Hosting
1. Unggah seluruh file proyek ke server.
2. Jika server mengizinkan pengaturan **DocumentRoot**, arahkan DocumentRoot domain ke folder `public/`.
3. Jika DocumentRoot tidak bisa diubah (tetap `public_html`), file `.htaccess` di root proyek akan otomatis meneruskan request ke folder `public/` sekaligus memblokir akses langsung ke folder sensitif (`app/`, `config/`, `.env`).
4. Buat database baru di cPanel, buat user database, lalu import `database/skema_paguyuban.sql`.
5. Ubah pengaturan di file `.env` server sesuai nama database, user, password, dan ubah `APP_ENV=production` serta `APP_DEBUG=false`.

### Integrasi CI/CD (GitHub Actions)
Repositori ini telah dilengkapi pipeline di `.github/workflows/ci.yml` yang otomatis memvalidasi seluruh sintaks PHP, memastikan tidak ada berkas rusak, serta memastikan integritas skema database saat kode di-push ke GitHub.
