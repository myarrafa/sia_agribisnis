# Sistem Informasi Agribisnis (AgriLokal Nusantara)

Repositori ini berisi kode sumber untuk purwarupa **Sistem Informasi Agribisnis (AgriLokal Nusantara)**, sebuah aplikasi web berbasis pencatatan stok dan manajemen penjualan komoditas pangan lokal (seperti tepung mocaf, hanjeli, dan produk olahan kelompok tani). Proyek ini dikembangkan berdasarkan Modul Praktikum Sistem Informasi Agribisnis dengan implementasi antarmuka (*UI/UX*) kustom bertema **Dark Forest & Lime** yang terinspirasi dari standar platform agribisnis modern.

---

## 👤 Identitas Pengembang
* **Nama:** M Yasir Arrafa
* **NIM:** 2430311059
* **Kelas:** 5B

---

## 🌾 Konsep & Latar Belakang Proyek
Sektor agribisnis dan UMKM pangan lokal seringkali menghadapi kendala dalam hal transparansi harga, pencatatan inventori hasil panen yang masih konvensional, serta akses pemasaran digital yang terbatas. Aplikasi **AgriLokal Nusantara** dirancang untuk menjembatani kelompok tani dan konsumen secara langsung (*direct-to-consumer*), memangkas rantai pasok yang merugikan petani, serta menyediakan panel kontrol inventori internal yang andal bagi pengelola (*admin*).

---

## 🚀 Fitur Utama Sistem
1. **Katalog Publik & Pencarian Dinamis (`index.php`)**:
   * Menampilkan daftar komoditas pertanian secara *real-time* dari *database*.
   * Dilengkapi fitur pencarian produk berdasarkan nama atau deskripsi menggunakan parameter `prepared statements` yang aman.
2. **Autentikasi Pengelola (`login.php` & `auth.php`)**:
   * Sistem keamanan berbasis *session* PHP untuk melindungi halaman *backend*.
   * Menggunakan enkripsi kata sandi yang aman (`password_hash` dan `password_verify`).
3. **Dashboard Manajemen Inventori / CRUD (`admin.php`)**:
   * Panel kontrol khusus admin untuk memantau total produk dan ketersediaan stok.
   * **Create:** Menambah data komoditas baru beserta unggah foto produk (*file upload*).
   * **Read:** Menampilkan tabel data inventori secara dinamis.
   * **Update:** Mengubah informasi harga, stok, deskripsi, atau mengganti foto produk.
   * **Delete:** Menghapus data produk dari sistem.
4. **Fitur Pelaporan (`cetak_laporan.php`)**:
   * Fasilitas rekapitulasi data inventori dan stok untuk keperluan pencatatan kelompok tani.

---

## 🛠️ Teknologi yang Digunakan (*Tech Stack*)
* **Front-End:** HTML5, CSS3 Kustom, Bootstrap 5 (Responsive Grid & Card System).
* **Back-End:** PHP Native (Prosedural & Modular).
* **Database:** MySQL / MariaDB via ekstensi `mysqli`.
* **Environment:** XAMPP (Apache Web Server & MySQL Server).

---

## 📁 Struktur Direktori Proyek
```text
sia_agribisnis/
│
├── assets/
│   ├── css/
│   └── images/
│
├── admin.php
├── auth.php
├── cetak_laporan.php
├── edit.php
├── hapus.php
├── index.php
├── koneksi.php
├── login.php
├── logout.php
├── register.php
└── tambah.php
```

---

## ⚙️ Cara Instalasi & Menjalankan Proyek
1. Pastikan aplikasi **XAMPP** sudah terpasang di komputer Anda.
2. Nyalakan modul **Apache** dan **MySQL** melalui XAMPP Control Panel.
3. Unduh atau *clone* repositori ini ke dalam direktori *htdocs* XAMPP Anda (`C:\xampp\htdocs\sia_agribisnis\`).
4. Buka peramban (*browser*) dan akses **`http://localhost/phpmyadmin`**.
5. Buat *database* baru dengan nama **`db_agribisnis`**.
6. Buat tabel yang dibutuhkan (`produk` dan `users`) sesuai struktur kolom berikut:
   * **Tabel `produk`**: `id_produk` (PK, AI), `nama_produk`, `harga`, `stok`, `deskripsi`, `foto`.
   * **Tabel `users`**: `id_user` (PK, AI), `username`, `password`, `nama_lengkap`.
7. Akses aplikasi melalui *browser* pada alamat:
   * **Katalog Publik:** `http://localhost/sia_agribisnis/index.php`
   * **Panel Login Admin:** `http://localhost/sia_agribisnis/login.php`