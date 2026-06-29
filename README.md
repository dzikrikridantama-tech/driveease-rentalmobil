# 🚗 DriveEase Rental Mobil

## Deskripsi
DriveEase adalah website rental mobil berbasis web yang memungkinkan pengguna melakukan pemesanan mobil secara online dan admin mengelola armada serta booking kendaraan.

---

## Fitur

### 👤 Customer
- Registrasi akun
- Login
- Melihat katalog mobil
- Booking mobil
- Pembayaran
- Riwayat penyewaan
- Pengembalian mobil

### 👨‍💼 Admin
- Login admin
- CRUD data mobil
- Kelola booking
- Verifikasi pengembalian
- Mengubah status mobil

---

## Teknologi yang Digunakan

- PHP Native
- MySQL
- Bootstrap 5
- JavaScript
- SweetAlert2
- Font Awesome
- XAMPP
- InfinityFree
- Git & GitHub

---

## Cara Menjalankan Project

### 1. Clone Repository

```bash
git clone https://github.com/dzikrikridantama-tech/driveease-rentalmobil.git
```

### 2. Import Database

Import file:

```
rental_mobil.sql
```

ke phpMyAdmin.

### 3. Konfigurasi Database

Edit:

```
config/database.php
```

```php
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "rental_mobil"
);
```

### 4. Jalankan XAMPP

Aktifkan:

- Apache
- MySQL

Buka:

```
http://localhost/rental_mobil
```

---

## Struktur Folder

```text
rental_mobil/
│
├── admin/
├── api/
├── config/
├── images/
├── includes/
├── index.php
├── login.php
├── register.php
├── booking.php
├── riwayat.php
├── proses_booking.php
└── rental_mobil.sql
```

---

## API Endpoint

### Daftar Mobil
https://driveeaser.site.je/api/mobil.php

## Link Website

https://driveeaser.site.je

---

## Link Github

https://github.com/dzikrikridantama-tech/driveease-rentalmobil

---

## Tim Pengembang

- Dzikri Kridantama
- M. Haikal Amri
- Fina Oktaviani
