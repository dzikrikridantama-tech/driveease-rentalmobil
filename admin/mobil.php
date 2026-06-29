<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../config/database.php';

$data = mysqli_query($conn, "SELECT * FROM mobil");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Mobil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-4">

    <h2>Kelola Mobil</h2>

    <a href="dashboard.php" class="btn btn-secondary mb-3">
        Kembali
    </a>

    <a href="tambah_mobil.php" class="btn btn-success mb-3">
        Tambah Mobil
    </a>

    <table class="table table-bordered">

        <thead>
        <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Nama Mobil</th>
            <th>Harga/Hari</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>

        <tbody>

        <?php
        $no = 1;

        while($row = mysqli_fetch_assoc($data)):
        ?>

        <tr>

            <td><?= $no++; ?></td>

            <td>
                <img src="../images/<?= $row['gambar']; ?>"
                     width="100">
            </td>

            <td><?= $row['nama_mobil']; ?></td>

            <td>
                Rp <?= number_format($row['harga_per_hari']); ?>
            </td>

            <td><?= $row['status']; ?></td>

            <td>

                <a href="edit_mobil.php?id=<?= $row['id_mobil']; ?>"
                   class="btn btn-warning btn-sm">

                    Edit

                </a>

                <a href="hapus_mobil.php?id=<?= $row['id_mobil']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus?')">

                    Hapus

                </a>

            </td>

        </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

</body>
</html>