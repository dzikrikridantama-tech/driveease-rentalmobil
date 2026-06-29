<?php
session_start();
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data input dan amankan dari celah SQL Injection
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp    = mysqli_real_escape_string($conn, $_POST['no_hp']); // BARU
    $role = 'user';
    $password = $_POST['password'];

    // 1. Validasi: Cek apakah email yang dimasukkan sudah pernah terdaftar atau belum
    $cek_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($cek_email) > 0) {
        // Jika email sudah ada, kembalikan ke register.php dengan tanda peringatan
        header("Location: register.php?pesan=email_terdaftar");
        exit;
    } else {
        // 2. Enkripsi Password demi keamanan data privasi user
        $password_aman = password_hash($password, PASSWORD_DEFAULT);
        
        // 3. Masukkan data lengkap ke tabel database termasuk no_hp dan role baru
        $query_daftar = "INSERT INTO users (nama, email, no_hp, password, role) 
                         VALUES ('$nama', '$email', '$no_hp', '$password_aman', '$role')";
        
        if (mysqli_query($conn, $query_daftar)) {
            // Pendaftaran sukses! Otomatis buat session login agar user tidak perlu mengetik ulang form login
            $id_baru = mysqli_insert_id($conn);
            $_SESSION['user_id']   = $id_baru;
            $_SESSION['user_nama'] = $nama;
            $_SESSION['user_role'] = $role; // Session membaca role baru secara dinamis
            
            // Lempar langsung ke index.php dengan status sukses_login
            header("Location: index.php?status=sukses_login");
            exit;
        } else {
            // Jika query gagal eksekusi akibat sistem database error
            header("Location: register.php?pesan=gagal");
            exit;
        }
    }
} else {
    // Blokir akses langsung tanpa form POST
    header("Location: register.php");
    exit;
}
?>