<?php
session_start();
include 'config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id_mobil = intval($_GET['id']);
    $from = isset($_GET['from']) ? $_GET['from'] : 'index';

    // Hapus mobil (bisa ditambahkan ON DELETE CASCADE di database agar transaksi lama tidak error)
    $query_hapus = "DELETE FROM mobil WHERE id_mobil = '$id_mobil'";
    
    if (mysqli_query($conn, $query_hapus)) {
        if ($from === 'riwayat') {
            header("Location: riwayat.php?status=sukses_hapus");
        } else {
            header("Location: index.php?status=sukses_hapus");
        }
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>