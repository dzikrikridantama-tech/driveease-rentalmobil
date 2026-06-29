<?php
session_start();
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_mobil       = intval($_POST['id_mobil']);
    $from           = $_POST['from']; // Ambil info asal halaman
    $nama_mobil     = mysqli_real_escape_string($conn, $_POST['nama_mobil']);
    $jenis_mobil    = mysqli_real_escape_string($conn, $_POST['jenis_mobil']);
    $harga_per_hari = intval($_POST['harga_per_hari']);
    $gambar         = mysqli_real_escape_string($conn, $_POST['gambar']);

    $query_update = "UPDATE mobil SET 
                        nama_mobil = '$nama_mobil', 
                        jenis_mobil = '$jenis_mobil', 
                        harga_per_hari = '$harga_per_hari', 
                        gambar = '$gambar' 
                     WHERE id_mobil = '$id_mobil'";

    if (mysqli_query($conn, $query_update)) {
        // Redirect dinamis sesuai asal klik tombol
        if ($from === 'riwayat') {
            header("Location: riwayat.php?status=sukses_edit");
        } else {
            header("Location: index.php?status=sukses_edit");
        }
        exit;
    } else {
        header("Location: index.php?status=gagal");
        exit;
    }
}
?>