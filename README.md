<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

# Hampersly - Platform Marketplace Hampers

Hampersly adalah sebuah aplikasi web marketplace yang dibangun menggunakan framework Laravel. Platform ini memungkinkan para penjual (seller) untuk membuka toko mereka sendiri dan menjual produk hampers, sementara para pelanggan (customer) dapat menelusuri, membeli, dan memberikan ulasan pada produk tersebut. Proyek ini juga dilengkapi dengan panel admin untuk mengelola keseluruhan platform.

---

## Fitur Utama

### Untuk Customer
-   **Penjelajahan Produk:** Halaman utama dengan galeri semua produk, pencarian, dan paginasi.
-   **Halaman Detail:** Halaman detail untuk setiap produk dan toko.
-   **Review & Rating:** Kemampuan untuk memberikan dan melihat ulasan/rating produk.
-   **Keranjang Belanja:** Sistem keranjang belanja fungsional berbasis Session.
-   **Checkout & Pembayaran:** Alur checkout yang aman dengan integrasi **Midtrans** (mendukung QRIS, E-Wallet, Virtual Account, dll).
-   **Riwayat Pesanan:** Halaman untuk melihat semua riwayat transaksi dan statusnya.

### Untuk Seller
-   **Dashboard Khusus:** Ruang kerja terpusat untuk mengelola toko, produk, dan pesanan.
-   **Manajemen Toko:** Membuat dan mengedit profil toko, termasuk foto profil.
-   **Manajemen Produk (CRUD):** Kemampuan penuh untuk menambah, melihat, mengedit, dan menghapus produk.
-   **Manajemen Pesanan:** Melihat pesanan yang masuk dan mengubah status pesanan (Diproses, Dikirim, Selesai).

### Untuk Admin
-   **Panel Admin Terproteksi:** Dashboard khusus untuk admin yang dilindungi middleware.
-   **Manajemen Platform:** Melihat statistik, mengelola semua user, toko, produk, dan pesanan.
-   **Sistem Persetujuan Toko:** Admin dapat menyetujui (approve) toko baru sebelum produknya bisa tampil secara publik.

---

## Teknologi yang Digunakan
-   **Framework:** Laravel 11+
-   **Bahasa:** PHP 8.2+
-   **Database:** MySQL
-   **Frontend:** Tailwind CSS, Alpine.js
-   **Build Tool:** Vite
-   **Payment Gateway:** Midtrans (Sandbox)

---

## Panduan Instalasi & Konfigurasi Lokal

Ikuti langkah-langkah ini untuk menjalankan proyek di lingkungan development lokal Anda.

### Prasyarat
-   Lingkungan server lokal (direkomendasikan **Laragon** atau sejenisnya, yang sudah termasuk PHP, MySQL, Composer, Node.js & npm).
-   Akun [GitHub](https://github.com/) untuk clone repositori.
-   Akun [Ngrok](https://ngrok.com/download) untuk pengetesan webhook.
-   Akun [Midtrans Sandbox](https://dashboard.sandbox.midtrans.com/register).

### Langkah-langkah Instalasi
1.  **Clone Repositori**
    Buka terminal dan jalankan:
    ```bash
    git clone [https://github.com/NAMA_USER_ANDA/NAMA_REPO_ANDA.git](https://github.com/NAMA_USER_ANDA/NAMA_REPO_ANDA.git)
    cd NAMA_REPO_ANDA
    ```

2.  **Install Dependensi PHP**
    ```bash
    composer install
    ```

3.  **Siapkan File Konfigurasi Lingkungan (`.env`)**
    Salin file contoh dan buat file `.env` Anda sendiri.
    ```bash
    # Untuk Windows
    copy .env.example .env

    # Untuk Mac/Linux
    cp .env.example .env
    ```

4.  **Konfigurasi Database & Midtrans di `.env`**
    Buka file `.env` yang baru dibuat dan isi bagian-bagian berikut sesuai dengan pengaturan lokal Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=hampersly  # Pastikan Anda sudah membuat database kosong dengan nama ini
    DB_USERNAME=root
    DB_PASSWORD=

    # Isi dengan key dari dashboard Midtrans Sandbox Anda
    MIDTRANS_MERCHANT_ID=...
    MIDTRANS_CLIENT_KEY=...
    MIDTRANS_SERVER_KEY=...
    MIDTRANS_IS_PRODUCTION=false
    ```

5.  **Generate Kunci Aplikasi Laravel**
    ```bash
    php artisan key:generate
    ```

6.  **Buat Struktur Database (Migrasi)**
    Perintah ini akan membuat semua tabel yang dibutuhkan di database Anda.
    ```bash
    php artisan migrate
    ```

7.  **Buat Symbolic Link untuk Storage**
    Ini wajib agar file yang di-upload (gambar produk & toko) bisa diakses.
    ```bash
    php artisan storage:link
    ```

8.  **Install Dependensi JavaScript**
    ```bash
    npm install
    ```

---

## Menjalankan Proyek & Simulasi Pembayaran

Untuk menjalankan proyek dengan semua fitur (termasuk notifikasi pembayaran), Anda perlu menjalankan 3 terminal.

1.  **Terminal 1: Jalankan Vite**
    Proses ini meng-compile aset CSS dan JS. Biarkan terus berjalan.
    ```bash
    npm run dev
    ```

2.  **Terminal 2: Jalankan Server Laravel**
    Ini adalah server utama aplikasi web Anda.
    ```bash
    php artisan serve
    ```
    Aplikasi Anda sekarang bisa diakses di `http://127.0.0.1:8000`.

3.  **Terminal 3: Jalankan Ngrok**
    Ini adalah jembatan agar server Midtrans bisa mengirim notifikasi ke laptop Anda.
    ```bash
    ngrok http 8000
    ```
    Ngrok akan memberikan Anda sebuah URL publik, contoh: `https://xxxxxxxx.ngrok-free.app`.

4.  **Konfigurasi Webhook di Midtrans**
    - Login ke dashboard Midtrans Sandbox Anda.
    - Pergi ke **Settings > Configuration**.
    - Di kolom **Payment Notification URL**, masukkan URL Ngrok Anda diikuti dengan `/api/midtrans-webhook`.
    - Contoh: `https://xxxxxxxx.ngrok-free.app/api/midtrans-webhook`
    - Klik **Save**.

5.  **Simulasi Pembayaran**
    - Lakukan proses checkout di website Anda sampai muncul pop-up Midtrans.
    - Untuk melakukan pembayaran tes, Anda bisa menggunakan nomor kartu, e-wallet, atau instruksi lain yang disediakan di dokumentasi resmi Midtrans.
    - **Lihat di sini:** [Cara Testing Pembayaran di Sandbox Midtrans](https://docs.midtrans.com/docs/testing-payments-on-sandbox)

---

## Struktur Role

-   **Customer:** Role default saat user mendaftar.
-   **Seller:** Customer yang sudah membuat toko. Role di database akan otomatis berubah menjadi `seller`.
-   **Admin:** Dibuat secara manual. Daftarkan akun baru, lalu ubah nilainya di tabel `users` pada kolom `role` menjadi `admin`.
