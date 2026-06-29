<?php
include 'config/database.php';
include 'includes/header.php';

// Proteksi akses Admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: index.php");
    exit;
}

$id_mobil = intval($_GET['id']);
$from = isset($_GET['from']) ? $_GET['from'] : 'index'; // Deteksi asal halaman

// Ambil data mobil, baik yang berstatus 'Tersedia' maupun 'Dibooking'
$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil = '$id_mobil'");
$mobil = mysqli_fetch_assoc($query);

if (!$mobil) {
    header("Location: riwayat.php");
    exit;
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow border-0" style="border-radius: 20px;">
                <h4 class="fw-bold text-dark mb-4"><i class="fa-solid fa-pen-to-square text-warning me-2"></i>Edit Data Armada</h4>
                
                <form action="proses_edit.php" method="POST">
                    <input type="hidden" name="id_mobil" value="<?= $mobil['id_mobil']; ?>">
                    <input type="hidden" name="from" value="<?= $from; ?>"> <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Nama Mobil</label>
                        <input type="text" name="nama_mobil" class="form-control bg-light focus-none" value="<?= htmlspecialchars($mobil['nama_mobil']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Kategori / Jenis</label>
                        <input type="text" name="jenis_mobil" class="form-control bg-light focus-none" value="<?= htmlspecialchars($mobil['jenis_mobil']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Harga Sewa / Hari (Rp)</label>
                        <input type="number" name="harga_per_hari" class="form-control bg-light focus-none" value="<?= $mobil['harga_per_hari']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Nama File Gambar</label>
                        <input type="text" name="gambar" class="form-control bg-light focus-none" value="<?= htmlspecialchars($mobil['gambar']); ?>" required>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="<?= $from == 'riwayat' ? 'riwayat.php' : 'index.php'; ?>" class="btn btn-light rounded-pill px-4 flex-fill">Batal</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold rounded-pill px-4 flex-fill">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>