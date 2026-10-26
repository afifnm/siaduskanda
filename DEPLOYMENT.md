# Panduan Kebutuhan Environment & Deployment SIADU
## Sistem Informasi Pengaduan SMKN 2 Karanganyar

Dokumen ini berisi spesifikasi kebutuhan dasar (*environment requirements*), konfigurasi server, serta panduan langkah demi langkah untuk mendeploy aplikasi **SIADU** ke server hosting (*Shared Hosting cPanel* maupun *VPS / Cloud Server*).

---

## 1. Spesifikasi Minimum & Rekomendasi Server

| Komponen | Lingkungan Development (Lokal) | Lingkungan Hosting (Production) | Catatan Penting |
| :--- | :--- | :--- | :--- |
| **PHP** | PHP 8.3 / 8.4 | **PHP 8.3** (Rekomendasi: **PHP 8.4**) | Diperlukan oleh Laravel 13 (`^8.3`). |
| **Web Server** | PHP Built-in / Artisan Dev | **Nginx** / **Apache 2.4+** / **LiteSpeed** | **Document Root wajib diarahkan ke subfolder `/public`**. |
| **Database** | SQLite / MySQL 8.0+ | **MySQL 8.0+** / **MariaDB 10.5+** | Default dev menggunakan SQLite, hosting disarankan MySQL. |
| **Node.js & NPM** | Node.js v18+ / v20+ LTS | Tidak wajib di hosting jika di-build lokal | Diperlukan saat compile Tailwind CSS v4 & Alpine.js (`npm run build`). |
| **Composer** | Composer v2.5+ | Composer v2.5+ | Dependency manager PHP. |

---

## 2. Ekstensi PHP yang Wajib Aktif

Pastikan ekstensi PHP berikut dicentang/diaktifkan di server hosting (melalui cPanel: menu *Select PHP Version* -> *Extensions*, atau via package manager di VPS):

1. **`gd` (dengan dukungan format WebP)** & **`exif`** *(Sangat Penting / Kritis)*
   - Digunakan oleh `App\Services\ImageOptimizerService` untuk:
     - Mengubah kompresi foto bukti pengaduan pelapor ke format `.webp`.
     - Membaca metadata EXIF kamera smartphone untuk rotasi otomatis foto.
2. **`pdo`** dan **`pdo_mysql`** (untuk koneksi ke database MySQL/MariaDB).
3. **`fileinfo`** (untuk validasi tipe MIME file gambar pengaduan).
4. **`mbstring`**, **`openssl`**, **`tokenizer`**, **`xml`**, **`dom`**, **`curl`**, **`bcmath`**, **`ctype`**, **`filter`**, **`hash`**, **`session`**, **`zip`** (standar framework Laravel).

### Rekomendasi Nilai `php.ini` di Hosting
```ini
upload_max_filesize = 10M
post_max_size = 12M
memory_limit = 256M
max_execution_time = 120
```

---

## 3. Konfigurasi File `.env` Produksi

Salin `.env.example` menjadi `.env` di server hosting, lalu sesuaikan parameter penting berikut:

```ini
APP_NAME="SIADU SMKN 2 Karanganyar"
APP_ENV=production
APP_KEY=base64:GENERATE_KEY_ANDA_DISINI
APP_DEBUG=false
APP_URL=https://pengaduan.smkn2kra.sch.id

APP_LOCALE=id
APP_FALLBACK_LOCALE=en

# Konfigurasi Database MySQL Hosting
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=user_database_anda
DB_PASSWORD=password_database_anda

# Driver Session, Cache, & Storage
SESSION_DRIVER=database
SESSION_LIFETIME=120
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
CACHE_STORE=database

# Konfigurasi Mail (Opsional untuk notifikasi email)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email_sekolah@smkn2kra.sch.id
MAIL_PASSWORD=app_password_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@smkn2kra.sch.id"
MAIL_FROM_NAME="SIADU SMKN 2 Karanganyar"
```

> [!WARNING]
> Jangan pernah membiarkan `APP_DEBUG=true` di lingkungan produksi/hosting, karena akan membocorkan detail credential dan query database jika terjadi kesalahan.

---

## 4. Panduan Deploy ke Hosting

### Skenario A: Shared Hosting / cPanel

#### Langkah 1: Build Asset di Komputer Lokal
Karena sebagian besar Shared Hosting tidak menyediakan Node.js atau akses build resource:
```bash
npm run build
```
Perintah ini akan membuat folder `public/build/` yang berisi CSS Tailwind v4 dan JS Alpine.js yang sudah terkompilasi dan siap digunakan.

#### Langkah 2: Upload File Project
Ada dua pendekatan struktur folder di Shared Hosting:
1. **Rekomendasi Keamanan (Subdomain / Addon Domain / Custom Root)**:
   - Upload seluruh folder project ke folder sejajar `public_html`, misalnya `/home/username/pengaduan/`.
   - Di pengaturan domain/subdomain cPanel, ubah **Document Root** langsung mengarah ke `/home/username/pengaduan/public`.
2. **Pendekatan Single Domain Utama (`public_html`)**:
   - Letakkan file/folder project selain `public` ke folder privat, contoh: `/home/username/laravel_core/`.
   - Letakkan isi dari folder `public/` (termasuk `index.php`, `.htaccess`, folder `build`) langsung ke dalam folder `/home/username/public_html/`.
   - Edit baris include di `/home/username/public_html/index.php`:
     ```php
     require __DIR__.'/../laravel_core/vendor/autoload.php';
     $app = require_once __DIR__.'/../laravel_core/bootstrap/app.php';
     ```

#### Langkah 3: Setup Storage Link (Symlink Bukti Aduan)
Bukti pengaduan tersimpan di `storage/app/public/pengaduan/`. Agar foto bisa tampil di website:
- **Jika ada akses Terminal cPanel / SSH**:
  ```bash
  php artisan storage:link
  ```
- **Jika tidak ada akses terminal**:
  Buka cPanel File Manager, masuk ke menu **Cron Jobs**, lalu jalankan sekali perintah:
  ```bash
  ln -s /home/username/pengaduan/storage/app/public /home/username/pengaduan/public/storage
  ```
  *(Atau buat route sementara di `routes/web.php` yang memanggil `Artisan::call('storage:link');` lalu hapus kembali setelah dibuka di browser).*

#### Langkah 4: Migrasi & Seeder Database
Di Terminal cPanel:
```bash
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder --force
```
*Akun Administrator bawaan:*
- **Email:** `admin.pengaduan@smkn2kra.sch.id`
- **Password:** `password`
- *(Segera ganti password setelah login pertama kali).*

#### Langkah 5: Cache & Optimasi
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Skenario B: VPS / Cloud Server (Ubuntu / Debian + Nginx)

#### Langkah 1: Install Paket Server
```bash
sudo apt update
sudo apt install -y nginx mysql-server composer git
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.4-fpm php8.4-cli php8.4-mysql php8.4-gd php8.4-mbstring \
                    php8.4-xml php8.4-curl php8.4-zip php8.4-bcmath php8.4-intl
```

#### Langkah 2: Konfigurasi Virtual Host Nginx
Buat file konfigurasi `/etc/nginx/sites-available/siadu.conf`:
```nginx
server {
    listen 80;
    server_name pengaduan.smkn2kra.sch.id;
    root /var/www/pengaduan/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    # Batas ukuran upload foto bukti aduan pelapor
    client_max_body_size 12M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```
Aktifkan konfigurasi dan restart Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/siadu.conf /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

#### Langkah 3: Perizinan Direktori (*Permissions*)
```bash
sudo chown -R www-data:www-data /var/www/pengaduan/storage /var/www/pengaduan/bootstrap/cache
sudo chmod -R 775 /var/www/pengaduan/storage /var/www/pengaduan/bootstrap/cache
```

#### Langkah 4: Instalasi Dependensi & Setup Laravel
```bash
cd /var/www/pengaduan
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan storage:link
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Langkah 5: Pasang SSL (HTTPS) Gratis dengan Certbot
```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d pengaduan.smkn2kra.sch.id
```

---

## 5. Troubleshooting Masalah Umum

| Masalah | Penyebab Umum | Solusi |
| :--- | :--- | :--- |
| **Foto Bukti Pengaduan Tidak Tampil (404 Not Found)** | Symlink `public/storage` belum dibuat atau rusak. | Jalankan `php artisan storage:link` atau periksa apakah folder `storage/app/public` memiliki hak akses baca. |
| **Gagal Upload Foto / Error GD** | Ekstensi `gd` atau WebP belum terpasang di PHP hosting. | Aktifkan ekstensi `gd` dan `exif` di cPanel PHP Selector, pastikan format WebP didukung. |
| **Tampilan Berantakan / CSS Tidak Termuat** | Asset Vite belum di-build ke folder `public/build/`. | Jalankan `npm run build` di lokal sebelum upload, atau pastikan folder `public/build/` terunggah utuh. |
| **Error 500 Tanpa Penjelasan** | Izin folder `storage/` atau `bootstrap/cache` tidak writable. | Set permission folder `storage/` dan `bootstrap/cache` ke `775` (atau `755` di cPanel). Cek file `storage/logs/laravel.log`. |
| **Error Route Not Found / 404 pada rute selain `/`** | Apache `mod_rewrite` tidak aktif atau Nginx `try_files` salah. | Pastikan file `.htaccess` bawaan di folder `public/` ikut terunggah, atau periksa konfigurasi `try_files` di Nginx. |
