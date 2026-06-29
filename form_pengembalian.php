<?php
session_start();
include 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id_booking'])) {
    header("Location: riwayat.php");
    exit;
}

$id_booking = intval($_GET['id_booking']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengembalian Mobil</title>
</head>
<body>

<h2>Form Pengembalian Mobil</h2>

<form action="proses_kembali.php" method="POST">

    <input type="hidden" name="id_booking" value="<?= $id_booking ?>">

    <label>Kondisi Mobil:</label><br>
    <select name="kondisi_pengembalian" required>
        <option value="">-- Pilih Kondisi --</option>
        <option value="Baik">Baik</option>
        <option value="Lecet Ringan">Lecet Ringan</option>
        <option value="Rusak Sedang">Rusak Sedang</option>
        <option value="Rusak Berat">Rusak Berat</option>
    </select>

    <br><br>

    <label>Catatan:</label><br>
    <textarea name="catatan_pengembalian"
              rows="4"
              cols="50"></textarea>

    <br><br>

    <button type="submit">
        Ajukan Pengembalian
    </button>

</form>

</body>
</html>