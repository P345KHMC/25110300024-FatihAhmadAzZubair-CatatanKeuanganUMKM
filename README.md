# Catatan Keuangan UMKM

Aplikasi web full-stack untuk mencatat pemasukan dan pengeluaran usaha kecil (UMKM), lengkap dengan dashboard ringkasan keuangan. Dibangun dengan Laravel (arsitektur MVC) dan MySQL sebagai tugas UAS Web Application Development, Universitas Cakrawala.

- **Nama / NIM:** Fatih Ahmad Az Zubair / 25110300024
- **Live application:** https://fatihahmadazzubair-catatankeuanganumkm.onrender.com/login
- **Repository:** https://github.com/P345KHMC/25110300024-FatihAhmadAzZubair-CatatanKeuanganUMKM.git
- **Video presentasi dan demo:** https://drive.google.com/file/d/1FJsHWOgvtbIwf86Nko8IZqWbG3v6af9u/view?usp=sharing

## Fitur

- Registrasi, login, dan logout dengan manajemen session
- CRUD **Kategori** (pemasukan / pengeluaran)
- CRUD **Produk** (nama, harga, stok)
- CRUD **Transaksi** (kategori, produk opsional, jumlah, tanggal, keterangan)
- **Dashboard**: total pemasukan, total pengeluaran, saldo, ringkasan bulan berjalan, total per kategori, dan 5 transaksi terakhir
- Hak akses berbasis role (admin dan owner)

## Teknologi

- Laravel 13 (PHP 8.4+), Blade, Eloquent ORM
- MySQL (relasional)
- Git untuk version control
- Deployment: Render (Docker) dengan database MySQL di Aiven

## Hak Akses Pengguna

| Role | Akses |
|---|---|
| **owner** (default saat registrasi) | Mengelola kategori, produk, dan transaksi **miliknya sendiri**. Dashboard hanya menampilkan datanya sendiri. |
| **admin** | Dashboard menampilkan ringkasan data **seluruh pengguna**. Middleware `admin` tersedia untuk membatasi route khusus admin. |

Role `admin` tidak bisa didapat lewat form registrasi. Kolom `role` tidak ada di `$fillable`, sehingga akun admin hanya dibuat lewat seeder.

## Struktur Database

Empat tabel utama yang saling berelasi (selain tabel bawaan Laravel seperti `sessions` dan `migrations`):

- `users` (id, name, email, password, role)
- `categories` (id, user_id, name, type: income/expense)
- `products` (id, user_id, name, price, stock)
- `transactions` (id, user_id, category_id, product_id nullable, amount, description, transaction_date)

Relasi: satu user memiliki banyak categories, products, dan transactions. Satu category dan satu product (opsional) dapat dipakai oleh banyak transactions.

## Struktur MVC

```
app/
  Http/
    Controllers/   AuthController, CategoryController, ProductController,
                   TransactionController, DashboardController
    Middleware/    AdminOnly
  Models/          User, Category, Product, Transaction
database/
  migrations/      skema tabel
  seeders/         AdminSeeder
resources/views/   layouts, auth, categories, products, transactions, dashboard
routes/web.php     definisi routing
```

## Instalasi di Komputer Lokal

**Prasyarat:** PHP 8.4 atau lebih baru, Composer, MySQL (misalnya lewat XAMPP), dan Git.

1. Clone repository dan masuk ke foldernya:
   ```
   git clone https://github.com/P345KHMC/25110300024-FatihAhmadAzZubair-CatatanKeuanganUMKM.git
   cd 25110300024-FatihAhmadAzZubair-CatatanKeuanganUMKM
   ```
2. Pasang dependensi:
   ```
   composer install
   ```
3. Salin file environment dan buat application key:
   ```
   copy .env.example .env
   php artisan key:generate
   ```
   (di Linux/macOS gunakan `cp` sebagai ganti `copy`)
4. Nyalakan MySQL (XAMPP), lalu buat database kosong, misalnya `uas_finansial`, lewat phpMyAdmin.
5. Sesuaikan bagian database di `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=uas_finansial
   DB_USERNAME=root
   DB_PASSWORD=
   ```
6. Siapkan isi database dengan **salah satu** cara:
   - **Migrasi dan seeder:**
     ```
     php artisan migrate
     php artisan db:seed --class=AdminSeeder
     ```
   - **Import file SQL:** import `25110300024-FatihAhmadAzZubair-CatatanKeuanganUMKM.sql` lewat phpMyAdmin (sudah berisi struktur dan data contoh). File-nya berada di folder database
7. Jalankan aplikasi:
   ```
   php artisan serve
   ```
   Buka `http://127.0.0.1:8000`.

## Akun untuk Pengujian

| Role | Email | Password |
|---|---|---|
| admin | admin@example.com | password123 |
| owner | budi@example.com | budi1234 |

Pengguna baru juga bisa mendaftar lewat halaman `/register` (otomatis berperan sebagai owner).

## Keamanan

- **CSRF:** semua form memakai `@csrf`, dan middleware bawaan Laravel memverifikasi token pada setiap request POST/PUT/DELETE.
- **XSS:** keluaran Blade `{{ }}` otomatis di-escape.
- **SQL Injection:** seluruh query lewat Eloquent / Query Builder yang memakai parameter binding.
- **Validasi server-side:** setiap input divalidasi di controller; pilihan kategori dan produk diverifikasi milik user yang sedang login.
- **Password** di-hash (cast `hashed`), session di-regenerate saat login dan di-invalidate saat logout.
- **Otorisasi data:** setiap edit atau hapus memeriksa kepemilikan data (`403` jika bukan pemilik).
- **Mass assignment:** hanya kolom di `$fillable` yang bisa diisi massal.

## Deployment

Aplikasi dijalankan di **Render** sebagai Web Service berbasis Docker (`Dockerfile`), dengan database **MySQL di Aiven** (koneksi SSL memakai sertifikat di folder `certs/`).

Langkah singkat:

1. Buat layanan MySQL di Aiven, catat host, port, user, password, dan nama database, lalu unduh CA certificate ke `certs/`.
2. Push kode ke GitHub.
3. Di Render, buat **Web Service** dari repository, runtime **Docker**.
4. Isi environment variables (`APP_KEY`, `APP_ENV=production`, `APP_DEBUG=false`, `APP_TIMEZONE`, `DB_*`, `MYSQL_ATTR_SSL_CA`).
5. Saat container berjalan, `docker-entrypoint.sh` menjalankan `php artisan migrate --force` dan seeder admin sebelum menyalakan Apache.

Catatan: layanan gratis dapat "tidur" bila lama tidak diakses, sehingga akses pertama bisa lambat.
Catatan (1): Saya meng-deploy proyek ini dengan akun Render teman saya, Fauzi Ilyas Saputra (25110300008) karena akun saya tidak bisa digunakan karena alasan tertentu
