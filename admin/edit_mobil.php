<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../config/database.php';

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id'");
$mobil = mysqli_fetch_assoc($data);

if (!$mobil) {
    // 🌟 DIUBAH: Jika data tidak ditemukan, kembali ke frame dashboard mobil
    echo "<script>
            alert('Data mobil tidak ditemukan!');
            window.location='dashboard.php?page=mobil';
          </script>";
    exit;
}

if (isset($_POST['update'])) {

    $nama_mobil = mysqli_real_escape_string($conn, $_POST['nama_mobil']);
    $jenis_mobil = mysqli_real_escape_string($conn, $_POST['jenis_mobil']);
    $kapasitas = $_POST['kapasitas_penumpang'];
    $bahan_bakar = mysqli_real_escape_string($conn, $_POST['bahan_bakar']);
    $fasilitas = mysqli_real_escape_string($conn, $_POST['fasilitas']);
    $harga = $_POST['harga_per_hari'];
    $status = $_POST['status'];

    $gambar = $mobil['gambar'];

    if ($_FILES['gambar']['name'] != "") {

        $namaFile = time() . "_" . basename($_FILES['gambar']['name']);
        $tmpFile = $_FILES['gambar']['tmp_name'];

        move_uploaded_file(
            $tmpFile,
            "../images/" . $namaFile
        );

        if (
            $mobil['gambar'] != "default.jpg" &&
            file_exists("../images/" . $mobil['gambar'])
        ) {
            unlink("../images/" . $mobil['gambar']);
        }

        $gambar = $namaFile;
    }

    $query = "UPDATE mobil SET
                nama_mobil='$nama_mobil',
                jenis_mobil='$jenis_mobil',
                kapasitas_penumpang='$kapasitas',
                bahan_bakar='$bahan_bakar',
                fasilitas='$fasilitas',
                gambar='$gambar',
                harga_per_hari='$harga',
                status='$status'
              WHERE id_mobil='$id'";

    if (mysqli_query($conn, $query)) {

        // 🌟 DIUBAH: Jika berhasil update, langsung redirect ke frame dashboard mobil
        echo "<script>
                alert('Data mobil berhasil diperbarui!');
                window.location='dashboard.php?page=mobil';
              </script>";

    } else {

        echo "<script>
                alert('Gagal memperbarui data!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2>Edit Mobil</h2>

    <a href="dashboard.php?page=mobil" class="btn btn-secondary mb-3">
        Kembali
    </a>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Nama Mobil</label>
            <input type="text"
                   name="nama_mobil"
                   class="form-control"
                   value="<?= $mobil['nama_mobil']; ?>"
                   required>
        </div>

        <div class="mb-3">
            <label>Jenis Mobil</label>
            <input type="text"
                   name="jenis_mobil"
                   class="form-control"
                   value="<?= $mobil['jenis_mobil']; ?>"
                   required>
        </div>

        <div class="mb-3">
            <label>Kapasitas Penumpang</label>
            <input type="number"
                   name="kapasitas_penumpang"
                   class="form-control"
                   value="<?= $mobil['kapasitas_penumpang']; ?>"
                   required>
        </div>

        <div class="mb-3">
            <label>Bahan Bakar</label>
            <input type="text"
                   name="bahan_bakar"
                   class="form-control"
                   value="<?= $mobil['bahan_bakar']; ?>"
                   required>
        </div>

        <div class="mb-3">
            <label>Fasilitas</label>
            <textarea name="fasilitas"
                      class="form-control"
                      rows="3"
                      required><?= $mobil['fasilitas']; ?></textarea>
        </div>

        <div class="mb-3">
            <label>Harga Per Hari</label>
            <input type="number"
                   name="harga_per_hari"
                   class="form-control"
                   value="<?= $mobil['harga_per_hari']; ?>"
                   required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Tersedia"
                    <?= ($mobil['status']=="Tersedia") ? "selected" : ""; ?>>
                    Tersedia
                </option>
                <option value="Dibooking"
                    <?= ($mobil['status']=="Dibooking") ? "selected" : ""; ?>>
                    Dibooking
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label>Gambar Saat Ini</label><br>
            <img src="../images/<?= $mobil['gambar']; ?>"
                 width="200"
                 class="mb-2">
        </div>

        <div class="mb-3">
            <label>Ganti Gambar (Opsional)</label>
            <input type="file"
                   name="gambar"
                   class="form-control"
                   accept=".jpg,.jpeg,.png">
        </div>

        <button type="submit"
                name="update"
                class="btn btn-warning">
            Update Mobil
        </button>

    </form>

</div>

</body>
</html>