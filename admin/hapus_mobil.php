<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../config/database.php';

if (!isset($_GET['id'])) {
    // 🌟 DIUBAH: Jika ID tidak ada, kembali ke halaman dashboard mobil
    header("Location: dashboard.php?page=mobil");
    exit;
}

$id = $_GET['id'];

/* Ambil data mobil */
$data = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id'");

if (mysqli_num_rows($data) == 0) {

    // 🌟 DIUBAH: Mengarahkan alert kembali ke dalam dashboard utama jika data kosong
    echo "
    <script>
        alert('Mobil tidak ditemukan!');
        window.location='dashboard.php?page=mobil';
    </script>
    ";

    exit;
}

$mobil = mysqli_fetch_assoc($data);

/* Hapus gambar jika bukan default */
if (
    !empty($mobil['gambar']) &&
    $mobil['gambar'] != 'default.jpg' &&
    file_exists("../images/" . $mobil['gambar'])
) {
    unlink("../images/" . $mobil['gambar']);
}

/* Hapus data dari database */
$query = mysqli_query(
    $conn,
    "DELETE FROM mobil WHERE id_mobil='$id'"
);

if ($query) {

    // 🌟 DIUBAH: Jika sukses hapus, alert muncul lalu refresh ke halaman dashboard mobil
    echo "
    <script>
        alert('Mobil berhasil dihapus!');
        window.location='dashboard.php?page=mobil';
    </script>
    ";

} else {

    // 🌟 DIUBAH: Jika gagal hapus, alert muncul lalu refresh ke halaman dashboard mobil
    echo "
    <script>
        alert('Gagal menghapus mobil!');
        window.location='dashboard.php?page=mobil';
    </script>
    ";
}
?>