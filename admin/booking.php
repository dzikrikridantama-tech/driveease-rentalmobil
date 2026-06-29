<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../config/database.php';

$query = mysqli_query($conn, "
    SELECT
        booking.*,
        users.nama,
        mobil.nama_mobil
    FROM booking
    LEFT JOIN users ON booking.id_user = users.id_user
    LEFT JOIN mobil ON booking.id_mobil = mobil.id_mobil
    ORDER BY booking.id_booking DESC
");

if (!$query) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Booking</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <h2>Kelola Booking</h2>

    <a href="dashboard.php" class="btn btn-secondary mb-3">
        Kembali
    </a>

    <table class="table table-bordered table-striped">

        <thead class="table-dark">

        <tr>
            <th>ID</th>
            <th>Penyewa</th>
            <th>Mobil</th>
            <th>Tanggal Sewa</th>
            <th>Lama</th>
            <th>Total</th>
            <th>Status</th>
            <th>Metode Pembayaran</th>
            <th>Aksi</th>
        </tr>

        </thead>

        <tbody>

        <?php while($row = mysqli_fetch_assoc($query)): ?>

        <tr>

            <td><?= $row['id_booking']; ?></td>

            <td>
                <?= !empty($row['nama']) ? htmlspecialchars($row['nama']) : 'User telah dihapus'; ?>
            </td>

            <td>
                <?= !empty($row['nama_mobil']) ? htmlspecialchars($row['nama_mobil']) : 'Mobil telah dihapus'; ?>
            </td>

            <td>
                <?= date('d-m-Y', strtotime($row['tanggal_mulai'])); ?>
            </td>

            <td>
                <?= $row['durasi_hari']; ?> hari
            </td>

            <td>
                Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?>
            </td>

            <td>

    <?php if($row['status_rental'] == 'Berjalan'): ?>

        <span class="badge bg-primary">
            Berjalan
        </span>

    <?php elseif($row['status_rental'] == 'Selesai'): ?>

        <span class="badge bg-success">
            Selesai
        </span>

    <?php else: ?>

        <span class="badge bg-secondary">
            <?= $row['status_rental']; ?>
        </span>

    <?php endif; ?>

</td>

            <td>
                <?= htmlspecialchars($row['metode_pembayaran']); ?>
            </td>

            <td>

                <a href="verifikasi_booking.php?id=<?= $row['id_booking']; ?>"
                   class="btn btn-warning btn-sm">

                    Verifikasi

                </a>

            </td>

        </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

</body>
</html>