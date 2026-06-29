<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../config/database.php';

if (isset($_POST['simpan'])) {

    $nama_mobil = mysqli_real_escape_string($conn, $_POST['nama_mobil']);
    $jenis_mobil = mysqli_real_escape_string($conn, $_POST['jenis_mobil']);
    $kapasitas = $_POST['kapasitas_penumpang'];
    $bahan_bakar = mysqli_real_escape_string($conn, $_POST['bahan_bakar']);
    $fasilitas = mysqli_real_escape_string($conn, $_POST['fasilitas']);
    $harga = $_POST['harga_per_hari'];
    $status = $_POST['status'];

    /* Upload Gambar */
    $gambar = "default.jpg";

    if ($_FILES['gambar']['name'] != "") {

        $namaFile = time() . "_" . basename($_FILES['gambar']['name']);
        $tmpFile = $_FILES['gambar']['tmp_name'];

        move_uploaded_file(
            $tmpFile,
            "../images/" . $namaFile
        );

        $gambar = $namaFile;
    }

    $query = "INSERT INTO mobil (
                nama_mobil,
                jenis_mobil,
                kapasitas_penumpang,
                bahan_bakar,
                fasilitas,
                gambar,
                harga_per_hari,
                status
            ) VALUES (
                '$nama_mobil',
                '$jenis_mobil',
                '$kapasitas',
                '$bahan_bakar',
                '$fasilitas',
                '$gambar',
                '$harga',
                '$status'
            )";

    if (mysqli_query($conn, $query)) {

        // 🌟 DIUBAH: Jika berhasil simpan, alert muncul lalu diredirect ke dalam bingkai dashboard mobil
        echo "
        <script>
            alert('Mobil berhasil ditambahkan!');
            window.location='dashboard.php?page=mobil';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Gagal menambahkan mobil!');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2>Tambah Mobil</h2>

    <a href="dashboard.php?page=mobil" class="btn btn-secondary mb-3">
        Kembali
    </a>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Nama Mobil</label>
            <input type="text"
                   name="nama_mobil"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>Jenis Mobil</label>
            <input type="text"
                   name="jenis_mobil"
                   class="form-control"
                   placeholder="MPV / SUV / City Car"
                   required>
        </div>

        <div class="mb-3">
            <label>Kapasitas Penumpang</label>
            <input type="number"
                   name="kapasitas_penumpang"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>Bahan Bakar</label>
            <input type="text"
                   name="bahan_bakar"
                   class="form-control"
                   placeholder="Bensin / Diesel"
                   required>
        </div>

        <div class="mb-3">
            <label>Fasilitas</label>
            <textarea name="fasilitas"
                      class="form-control"
                      rows="3"
                      required></textarea>
        </div>

        <div class="mb-3">
            <label>Harga Per Hari</label>
            <input type="number"
                   name="harga_per_hari"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status"
                    class="form-control">
                <option value="Tersedia">
                    Tersedia
                </option>
                <option value="Dibooking">
                    Dibooking
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label>Gambar Mobil</label>
            <input type="file"
                   name="gambar"
                   class="form-control"
                   accept=".jpg,.jpeg,.png">
        </div>

        <button type="submit"
                name="simpan"
                class="btn btn-success">
            Simpan Mobil
        </button>

    </form>

</div>

</body>
</html>