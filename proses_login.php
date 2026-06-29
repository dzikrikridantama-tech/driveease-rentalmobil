<?php
session_start();
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menangkap data input dan melindunginya dari SQL Injection berbahaya
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Mencari baris data user berdasarkan email yang diinput
    $query  = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Memverifikasi password teks mentah dengan hash terenkripsi di database
        if (password_verify($password, $row['password'])) {
            
            // Menyimpan data identitas user ke dalam Session PHP global
            $_SESSION['user_id']   = $row['id_user'];
            $_SESSION['user_nama'] = $row['nama'];
            $_SESSION['user_role'] = $row['role'];

            // Sukses! Alihkan user kembali ke Beranda dengan parameter sukses_login
            header("Location: index.php?status=sukses_login");
            exit;
        }
    }
    
    // Gagal! Kembalikan ke login.php dengan membawa pesan eror lewat URL
    header("Location: login.php?pesan=gagal");
    exit;
} else {
    // Menolak akses jika file ini dibuka langsung tanpa form POST
    header("Location: login.php");
    exit;
}
?>