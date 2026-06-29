<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../config/database.php';

$id = $_GET['id'];

$data = mysqli_query($conn,
    "SELECT * FROM booking WHERE id_booking='$id'");

$booking = mysqli_fetch_assoc($data);

if (!$booking) {
    header("Location: dashboard.php?page=booking");
    exit;
}

// Simpan perubahan status
if (isset($_POST['simpan'])) {

    $status = $_POST['status'];

    $update = mysqli_query($conn,
        "UPDATE booking
         SET status_rental='$status'
         WHERE id_booking='$id'");

    if (!$update) {
        die("Gagal update status: " . mysqli_error($conn));
    }

    // Jika sewa selesai, update status mobil
    if ($status == 'Selesai') {

        $kondisi = strtolower(trim($booking['kondisi_pengembalian']));

        if ($kondisi == 'baik') {
            $status_mobil = 'Tersedia';
        } else {
            $status_mobil = 'Maintenance';
        }

        mysqli_query($conn,
            "UPDATE mobil
             SET status='$status_mobil'
             WHERE id_mobil='".$booking['id_mobil']."'");
    }

    header("Location: dashboard.php?page=booking");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2>Verifikasi Booking</h2>

    <a href="dashboard.php?page=booking" class="btn btn-secondary mb-3">
        Kembali
    </a>

    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            Informasi Pengembalian Mobil
        </div>

        <div class="card-body">

            <p>
                <strong>Kondisi Mobil:</strong><br>
                <?= !empty($booking['kondisi_pengembalian'])
                    ? htmlspecialchars($booking['kondisi_pengembalian'])
                    : '<span class="text-muted">Belum ada laporan</span>'; ?>
            </p>

            <p>
                <strong>Catatan Penyewa:</strong><br>
                <?= !empty($booking['catatan_pengembalian'])
                    ? nl2br(htmlspecialchars($booking['catatan_pengembalian']))
                    : '<span class="text-muted">Tidak ada catatan</span>'; ?>
            </p>

        </div>
    </div>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Status Booking</label>

            <select name="status" class="form-control">

                <option value="Berjalan"
                    <?= ($booking['status_rental'] == "Berjalan") ? "selected" : ""; ?>>
                    Berjalan
                </option>

                <option value="Menunggu Konfirmasi"
                    <?= ($booking['status_rental'] == "Menunggu Konfirmasi") ? "selected" : ""; ?>>
                    Menunggu Konfirmasi
                </option>

                <option value="Selesai"
                    <?= ($booking['status_rental'] == "Selesai") ? "selected" : ""; ?>>
                    Selesai
                </option>

            </select>
        </div>

        <button type="submit" name="simpan" class="btn btn-success">
            Simpan
        </button>

    </form>

</div>

</body>
</html>