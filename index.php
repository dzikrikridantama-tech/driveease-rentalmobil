<?php
include 'config/database.php';
include 'includes/header.php';

$keyword = "";
if (isset($_GET['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['cari']);
    $query = "SELECT * FROM mobil WHERE status = 'Tersedia' 
              AND (nama_mobil LIKE '%$keyword%' OR jenis_mobil LIKE '%$keyword%')";
} else {
    $query = "SELECT * FROM mobil WHERE status = 'Tersedia'";
}

$result = mysqli_query($conn, $query);
?>

<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-5 fw-bold text-white mb-2">Mau Jalan-Jalan Kemana Hari Ini? 🌟</h1>
        <p class="lead text-white-50 mb-4">Temukan armada terbaik dengan harga super hemat dan proses secepat kilat!</p>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="index.php" method="GET" class="d-flex shadow-lg rounded-pill bg-white p-2 border border-2 border-warning">
                    <input class="form-control border-0 px-4 rounded-pill me-2 focus-none" 
                           type="search" 
                           name="cari" 
                           placeholder="Ketik mobil impianmu di sini..." 
                           value="<?= htmlspecialchars($keyword); ?>"
                           aria-label="Search">
                    <button class="btn btn-warning text-dark rounded-pill px-4 fw-bold shadow-sm" type="submit">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    
    <?php if (!empty($keyword)): ?>
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-pill shadow-sm px-4">
            <p class="text-muted mb-0">Menemukan hasil pencarian untuk: <span class="badge bg-primary text-white fs-6">"<?= htmlspecialchars($keyword); ?>"</span></p>
            <a href="index.php" class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="fa-solid fa-arrow-rotate-left me-1"></i> Reset</a>
        </div>
    <?php else: ?>
        <h3 class="fw-bold mb-4 text-center text-dark"><i class="fa-solid fa-star text-warning me-2"></i>Rekomendasi Mobil Terbaik Untukmu</h3>
    <?php endif; ?>

    <div class="row g-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-3">
                    <div class="card card-mobil h-100 shadow-sm">
                        <div class="p-3 text-center" style="background-color: #ffffff; border-radius : 20px 20px 0 0;">
                            <img src="images/<?= !empty($row['gambar']) ? $row['gambar'] : 'default.jpg'; ?>" 
                                 class="img-fluid" 
                                 alt="<?= $row['nama_mobil']; ?>" 
                                 style="height: 140px; object-fit: contain;">
                        </div>  
                        <div class="card-body d-flex flex-column p-4">
                            <span class="badge align-self-start mb-2 px-3 py-1 rounded-pill" style="background-color: #e6fffa; color: #008080; font-weight: 600;">
                                <i class="fa-solid fa-tags me-1"></i><?= $row['jenis_mobil']; ?>
                            </span>
                            <h5 class="card-title fw-bold text-dark mb-1"><?= $row['nama_mobil']; ?></h5>
                            
                            <h5 class="fw-extrabold mb-3 mt-2 text-danger">
                                Rp <?= number_format($row['harga_per_hari'], 0, ',', '.'); ?> 
                                <span class="text-muted fs-6 fw-normal">/hari</span>
                            </h5>
                            
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill mb-2 fw-bold" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $row['id_mobil']; ?>">
                                <i class="fa-solid fa-circle-info me-1"></i> Informasi Detail
                            </button>

                            <a href="booking.php?id=<?= $row['id_mobil']; ?>" class="btn btn-gradient-primary w-100 rounded-pill mt-auto fw-bold py-2">
                                <i class="fa-solid fa-key me-2 text-warning"></i>Sewa Sekarang
                            </a>    
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalDetail<?= $row['id_mobil']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                            <div class="modal-header border-0 bg-light p-4" style="border-radius: 20px 20px 0 0;">
                                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-circle-info text-primary me-2"></i>Spesifikasi Armada</h5>
                                <button type="button" class="btn-close" data-bs-toggle="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4 text-center">
                                <img src="images/<?= !empty($row['gambar']) ? $row['gambar'] : 'default.jpg'; ?>" class="img-fluid mb-3" style="max-height: 150px; object-fit: contain;" alt="">
                                <h4 class="fw-bold text-dark mb-9"><?= $row['nama_mobil']; ?></h4>
                                
                                <div class="table-responsive text-start">
                                    <table class="table table-bordered table-striped small">
                                        <tr>
                                            <td width="40%"><strong>Kategori / Tipe</strong></td>
                                            <td><?= $row['jenis_mobil']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kapasitas Kursi</strong></td>
                                            <td><i class="fa-solid fa-user-group me-1 text-muted"></i> Max <?= $row['kapasitas_penumpang']; ?> Orang</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Bahan Bakar</strong></td>
                                            <td><i class="fa-solid fa-gas-pump me-1 text-muted"></i> <?= $row['bahan_bakar']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Fasilitas Utama</strong></td>
                                            <td><i class="fa-solid fa-star-of-life me-1 text-muted"></i> <?= $row['fasilitas']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer border-0 p-3 bg-light" style="border-radius: 0 0 20px 20px;">
                                <button type="button" class="btn btn-secondary rounded-pill px-4 btn-sm" data-bs-toggle="modal">Tutup</button>
                                <a href="booking.php?id=<?= $row['id_mobil']; ?>" class="btn btn-warning text-dark rounded-pill px-4 btn-sm fw-bold">Sewa Mobil Ini</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
        <?php else: ?>
            <div class="col-md-8 text-center py-5 mx-auto bg-white rounded-4 shadow-sm">
                <i class="fa-solid fa-face-frown fa-4x text-warning mb-3"></i>
                <h4 class="fw-bold text-dark">Aduh, Mobilnya Lagi Kosong nih!</h4>
                <p class="text-muted">Coba cari dengan kata kunci lain.</p>
                <a href="index.php" class="btn btn-primary rounded-pill fw-bold px-4">Lihat Koleksi Semua Mobil</a>
            </div>
        <?php endif; ?>
    </div>

    <div class="row mt-5 pt-4 border-top g-4">
        <div class="col-md-6">
            <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                <h4 class="fw-bold text-dark mb-3"><i class="fa-solid fa-shield-halved text-success me-2"></i>Syarat & Ketentuan Rental</h4>
                <ol class="text-muted small ps-3">
                    <li class="mb-2">Penyewa wajib memiliki SIM A aktif yang sah sesuai hukum Indonesia.</li>
                    <li class="mb-2">Menyerahkan KTP asli / Kartu Identitas berfoto lainnya sebagai jaminan selama masa rental.</li>
                    <li class="mb-2">Durasi sewa minimal dihitung 1 hari (24 jam) sejak serah terima kunci dilakukan.</li>
                    <li class="mb-2">Keterlambatan pengembalian unit dikenakan denda sesuai tarif jam operasional garasi.</li>
                </ol>
            </div>
        </div>
        <div class="col-md-6">
            <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                <h4 class="fw-bold text-dark mb-3"><i class="fa-solid fa-map-location-dot text-primary me-2"></i>Lokasi & Kontak Garasi</h4>
                <p class="text-muted small mb-2"><i class="fa-solid fa-location-dot me-2 text-danger"></i> Jl. Raya Boulevard Utama No. 45, Kebayoran Baru, Jakarta Selatan, Indonesia</p>
                <p class="text-muted small mb-2"><i class="fa-solid fa-phone me-2 text-success"></i> Hotline CS: <strong>(021) 8888-9999</strong></p>
                <p class="text-muted small mb-2"><i class="fa-solid fa-envelope me-2 text-warning"></i> Email: support@driveease.com</p>
                <p class="text-muted small"><i class="fa-solid fa-clock me-2 text-info"></i> Jam Operasional: <strong>07.00 WIB - 22.00 WIB (Setiap Hari)</strong></p>
            </div>
        </div>
    </div>
    </div>

<?php if (isset($_GET['status']) && $_GET['status'] == 'sukses_login' && isset($_SESSION['user_nama'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: 'Selamat Datang Kembali! 👋',
        text: 'Halo <?= htmlspecialchars($_SESSION['user_nama']); ?>, senang melihatmu lagi. Selamat memilih mobil impian!',
        icon: 'success',
        timer: 3000,
        showConfirmButton: false,
        background: '#ffffff',
        iconColor: '#4f46e5'
    }).then(() => {
        window.history.replaceState({}, document.title, window.location.pathname);
    });
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_GET['status']) && $_GET['status'] == 'logout_sukses'): ?>
<script>
    Swal.fire({
        title: 'Sampai Jumpa! 👋',
        text: 'Anda telah berhasil keluar dari akun DriveEase. Terima kasih telah mempercayai layanan rental kami!',
        icon: 'success',
        timer: 3500, // Pop-up akan otomatis menutup sendiri setelah 3,5 detik
        timerProgressBar: true, // Menampilkan garis durasi berjalan di bawah pop-up
        showConfirmButton: true,
        confirmButtonText: 'Sama-sama',
        confirmButtonColor: '#212529', // Warna hitam elegan senada dengan tema navbar
        background: '#ffffff',
        customClass: {
            title: 'fw-bold text-dark',
            popup: 'rounded-4 shadow-lg p-4'
        }
    }).then(() => {
        // Bersihkan parameter '?status=logout_sukses' dari URL browser agar ketika di-refresh tidak muncul lagi
        window.history.replaceState({}, document.title, window.location.pathname);
    });
</script>
<?php endif; ?>