<?php
session_start();
include 'config/database.php';

// Proteksi mutlak: Wajib sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_user           = $_SESSION['user_id'];
    $id_mobil          = mysqli_real_escape_string($conn, $_POST['id_mobil']);
    $tanggal_mulai     = mysqli_real_escape_string($conn, $_POST['tanggal_mulai']);
    $durasi_hari       = intval($_POST['durasi']);
    $harga_per_hari    = intval($_POST['harga_per_hari']);
    $metode_pembayaran = mysqli_real_escape_string($conn, $_POST['metode_pembayaran']);

    // =========================
    // CEK STATUS MOBIL DULU
    // =========================
    $cek_mobil = mysqli_query($conn,
        "SELECT status
         FROM mobil
         WHERE id_mobil='$id_mobil'");

    $mobil = mysqli_fetch_assoc($cek_mobil);

    if (!$mobil) {
        echo "
        <script>
            alert('Mobil tidak ditemukan.');
            window.location='index.php';
        </script>";
        exit;
    }

    if ($mobil['status'] != 'Tersedia') {
        echo "
        <script>
            alert('Maaf, mobil sedang tidak tersedia atau sedang maintenance.');
            window.location='index.php';
        </script>";
        exit;
    }

    // =========================
    // HITUNG TOTAL
    // =========================
    $total_harga = $durasi_hari * $harga_per_hari;

    // Tangkap data rekening penyewa
    $no_rekening_user = isset($_POST['no_rekening_user'])
        ? mysqli_real_escape_string($conn, $_POST['no_rekening_user'])
        : '-';

    $nominal_transfer = isset($_POST['nominal_transfer'])
        ? intval($_POST['nominal_transfer'])
        : 0;

    $nama_file_bukti = "-";

    // =========================
    // VALIDASI NOMINAL TRANSFER
    // =========================
    if ($metode_pembayaran !== 'Bayar di Tempat (COD)') {

        if ($nominal_transfer !== $total_harga) {
            header(
                "Location: booking.php?id="
                .$id_mobil.
                "&pesan=nominal_salah&total="
                .$total_harga.
                "&input="
                .$nominal_transfer
            );
            exit;
        }
    }

    // =========================
    // SIMPAN BOOKING
    // =========================
    $query_booking =
        "INSERT INTO booking
        (
            id_user,
            id_mobil,
            tanggal_mulai,
            durasi_hari,
            total_harga,
            metode_pembayaran,
            no_rekening_user,
            bukti_bayar,
            status_rental
        )
        VALUES
        (
            '$id_user',
            '$id_mobil',
            '$tanggal_mulai',
            '$durasi_hari',
            '$total_harga',
            '$metode_pembayaran',
            '$no_rekening_user',
            '$nama_file_bukti',
            'Menunggu Konfirmasi'
        )";

    if (mysqli_query($conn, $query_booking)) {

        $id_baru = mysqli_insert_id($conn);

        // Kunci mobil agar tidak bisa dibooking orang lain
        mysqli_query($conn,
            "UPDATE mobil
             SET status='Dibooking'
             WHERE id_mobil='$id_mobil'");

        header(
            "Location: riwayat.php?status=sukses&id_nota=".$id_baru
        );
        exit;

    } else {

        echo "Gangguan Query Database: "
             . mysqli_error($conn);
    }

} else {

    header("Location: index.php");
    exit;
}
?>