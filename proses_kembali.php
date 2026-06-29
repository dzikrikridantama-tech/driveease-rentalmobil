<?php
session_start();
include 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: riwayat.php");
    exit;
}

$id_booking = isset($_POST['id_booking']) ? intval($_POST['id_booking']) : 0;

$kondisi = mysqli_real_escape_string(
    $conn,
    $_POST['kondisi_pengembalian']
);

$catatan = mysqli_real_escape_string(
    $conn,
    $_POST['catatan_pengembalian']
);

if ($id_booking <= 0) {
    die("ID booking tidak ditemukan.");
}

/*
|--------------------------------------------------------------------------
| Ambil data booking
|--------------------------------------------------------------------------
*/
$query = mysqli_query($conn, "
    SELECT *
    FROM booking
    WHERE id_booking = '$id_booking'
");

if (!$query || mysqli_num_rows($query) == 0) {
    die("Booking tidak ditemukan.");
}

$booking = mysqli_fetch_assoc($query);

/*
|--------------------------------------------------------------------------
| Simpan kondisi pengembalian
|--------------------------------------------------------------------------
*/
$update = mysqli_query($conn, "
    UPDATE booking
    SET
        kondisi_pengembalian = '$kondisi',
        catatan_pengembalian = '$catatan',
        status_rental = 'Menunggu Konfirmasi'
    WHERE id_booking = '$id_booking'
");

if (!$update) {
    die("Gagal menyimpan data pengembalian.");
}

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/
echo "
<script>
alert('Pengembalian berhasil diajukan.');
window.location='riwayat.php';
</script>
";
exit;
?>