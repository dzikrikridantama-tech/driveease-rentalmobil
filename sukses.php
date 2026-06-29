<?php
include 'config/database.php';

$id_booking = $_GET['id_booking'];

$query = "SELECT booking.*, mobil.nama_mobil FROM booking 
          JOIN mobil ON booking.id_mobil = mobil.id_mobil 
          WHERE booking.id_booking = '$id_booking'";
          
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data booking tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Booking Berhasil!</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; text-align: center; }
        .invoice { background: white; padding: 30px; display: inline-block; text-align: left; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); min-width: 400px; }
        .success-msg { color: #28a745; font-weight: bold; }
    </style>
</head>
<body>

<div class="invoice">
    <h2 class="success-msg">🎉 Booking Berhasil!</h2>
    <p>Terima kasih <strong><?= $data['nama_pelanggan']; ?></strong>, pesanan Anda telah kami terima.</p>
    <hr>
    <h3>Detail Nota (#<?= $data['id_booking']; ?>)</h3>
    <table cellpadding="5">
        <tr><td>Mobil</td><td>: <strong><?= $data['nama_mobil']; ?></strong></td></tr>
        <tr><td>Mulai Sewa</td><td>: <?= $data['tanggal_mulai']; ?></td></tr>
        <tr><td>Durasi</td><td>: <?= $data['durasi_hari']; ?> Hari</td></tr>
        <tr><td>Total Bayar</td><td>: <strong>Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?></strong></td></tr>
    </table>
    <hr>
    <p style="font-size: 12px; color: #666;">*Silakan tunjukkan nota ini saat pengambilan unit mobil di garasi kami.</p>
    <a href="index.php" style="display:block; text-align:center; margin-top:20px; color:#007bff; text-decoration:none;">Kembali ke Beranda</a>
</div>

</body>
</html>