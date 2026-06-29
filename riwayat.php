<?php
include 'config/database.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_user = (int) $_SESSION['user_id'];

$query = "
    SELECT booking.*, mobil.nama_mobil, mobil.jenis_mobil
    FROM booking
    JOIN mobil ON booking.id_mobil = mobil.id_mobil
    WHERE booking.id_user = $id_user
    ORDER BY booking.id_booking DESC
";

$result = mysqli_query($conn, $query);
?>

<div class="container my-5" style="min-height: 500px;">
    <h3 class="fw-bold text-dark mb-4">
        <i class="fa-solid fa-clock-rotate-left text-warning me-2"></i>
        Riwayat Rental Anda
    </h3>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark" style="background-color: #1e293b;">
                    <tr>
                        <th class="px-4 py-3" width="10%">Nota #</th>
                        <th class="py-3" width="20%">Nama Mobil</th>
                        <th class="py-3" width="15%">Tipe</th>
                        <th class="py-3" width="15%">Tanggal Mulai</th>
                        <th class="py-3" width="10%">Durasi</th>
                        <th class="py-3" width="15%">Total Bayar</th>
                        <th class="py-3 text-center" width="15%">Status</th>
                        <th class="py-3 text-center" width="15%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
<?php if ($result && mysqli_num_rows($result) > 0): ?>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td class="px-4 fw-bold text-secondary">
                #<?= (int)$row['id_booking']; ?>
            </td>

            <td class="fw-bold text-dark">
                <?= htmlspecialchars($row['nama_mobil']); ?>
            </td>

            <td>
                <span class="badge bg-light text-dark border px-2 py-1">
                    <?= htmlspecialchars($row['jenis_mobil']); ?>
                </span>
            </td>

            <td class="text-muted">
                <?= date('d M Y', strtotime($row['tanggal_mulai'])); ?>
            </td>

            <td>
                <?= (int)$row['durasi_hari']; ?> Hari
            </td>

            <td class="fw-bold text-success">
                Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?>
            </td>

            <td class="text-center">
    <?php 
    $status_clean = trim($row['status_rental']); 
    
    if ($status_clean === 'Berjalan'): 
    ?>
        <span class="badge bg-primary text-white rounded-pill px-3 py-2 fw-bold shadow-sm d-inline-block">
            <i class="fa-solid fa-car-side me-1"></i> Sedang Berjalan
        </span>

    <?php elseif ($status_clean === 'Selesai' || $status_clean === 'Selesai Sewa'): ?>
        <span class="badge bg-success text-white rounded-pill px-3 py-2 fw-bold shadow-sm d-inline-block">
            <i class="fa-solid fa-circle-check me-1"></i> Selesai Sewa
        </span>

    <?php else: ?>
        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold shadow-sm d-inline-block">
            <i class="fa-solid fa-clock me-1"></i> Menunggu Konfirmasi
        </span>
    <?php endif; ?>
</td>

<td class="text-center">

    <?php if ($status_clean === 'Berjalan'): ?>

        <a href="form_pengembalian.php?id_booking=<?= $row['id_booking']; ?>"
           class="btn btn-danger btn-sm rounded-pill">
            <i class="fa-solid fa-rotate-left me-1"></i>
            Kembalikan
        </a>

    <?php elseif ($status_clean === 'Menunggu Konfirmasi'): ?>

        <span class="badge bg-secondary">
            Diproses
        </span>

    <?php else: ?>

        <span class="text-muted">-</span>

    <?php endif; ?>

</td>
        </tr>
    <?php endwhile; ?>
                    <?php else: ?>

                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-folder-open fa-3x mb-3 text-light"></i>

                                <p class="mb-0">
                                    Belum ada riwayat transaksi penyewaan mobil.
                                </p>

                                <a href="index.php"
                                   class="btn btn-sm btn-primary rounded-pill mt-3 px-3">
                                    Sewa Mobil Sekarang
                                </a>
                            </td>
                        </tr>

                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<?php 
if (isset($_GET['status']) && $_GET['status'] == 'sukses' && !empty($_GET['id_nota'])): 
    
    $id_nota = intval($_GET['id_nota']);
    
    $ambil_nota = mysqli_query($conn, "SELECT booking.*, mobil.nama_mobil FROM booking 
                                       JOIN mobil ON booking.id_mobil = mobil.id_mobil 
                                       WHERE booking.id_booking = '$id_nota'");
    
    if ($ambil_nota && mysqli_num_rows($ambil_nota) === 1):
        $nota = mysqli_fetch_assoc($ambil_nota);

        $nomor_whatsapp_admin = "628132636442"; 
        $nama_admin = "Admin Garasi DriveEase";
        
        $pesan_wa = "Halo " . $nama_admin . ", saya ingin mengonfirmasi sewa mobil dengan No. Nota #" . $nota['id_booking'] . ". Unit: " . $nota['nama_mobil'] . ", Metode Pembayaran: " . $nota['metode_pembayaran'] . ". Mohon segera diproses ya, terima kasih!";
        $link_wa = "https://api.whatsapp.com/send?phone=" . $nomor_whatsapp_admin . "&text=" . urlencode($pesan_wa);
?>
<script>
    var duration = 3 * 1000;
    var end = Date.now() + duration;
    (function frame() {
        confetti({ particleCount: 3, angle: 60, spread: 55, origin: { x: 0 } });
        confetti({ particleCount: 3, angle: 120, spread: 55, origin: { x: 1 } });
        if (Date.now() < end) { requestAnimationFrame(frame); }
    }());

    Swal.fire({
        title: '🎉 Hore! Booking Berhasil 🎉',
        icon: 'success',
        html: `
            <div class="text-center mb-3">
                <p class="text-muted small">Pesanan Anda telah tercatat aman di sistem kami!</p>
            </div>
            
            <div class="card border-0 bg-light p-3 text-start mb-3" style="border-radius: 15px; font-family: sans-serif; font-size: 14px;">
                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                    <span class="text-muted">No. Nota:</span>
                    <strong class="text-dark">#<?= $nota['id_booking']; ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Unit Kendaraan:</span>
                    <span class="fw-bold text-primary"><?= htmlspecialchars($nota['nama_mobil']); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Durasi Sewa:</span>
                    <span class="badge bg-secondary"><?= $nota['durasi_hari']; ?> Hari</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Metode Bayar:</span>
                    <span class="fw-bold text-dark"><?= htmlspecialchars($nota['metode_pembayaran']); ?></span>
                </div>
                <div class="d-flex justify-content-between pt-2 mt-1 border-top">
                    <span class="fw-bold text-dark">Total Biaya:</span>
                    <span class="fw-extrabold text-success fs-5">Rp <?= number_format($nota['total_harga'], 0, ',', '.'); ?></span>
                </div>
            </div>

            <div class="p-3 border text-start rounded-3 mb-1" style="background-color: #f0fdf4; border-color: #bbf7d0 !important;">
                <span class="text-dark d-block fw-bold mb-1" style="font-size: 13px;">
                    <i class="fa-solid fa-headset text-success me-1"></i> Hubungi Admin Garasi untuk Pengambilan Unit:
                </span>
                <p class="text-muted mb-3" style="font-size: 12px; line-height: 1.4;">
                    Silakan konfirmasi bukti fisik atau tanyakan lokasi titik temu garasi langsung ke admin standby melalui tombol di bawah.
                </p>
                <a href="<?= $link_wa; ?>" target="_blank" class="btn btn-sm btn-success w-100 fw-bold py-2 rounded-3 shadow-sm text-white" style="background-color: #25d366; border: none;">
                    <i class="fa-brands fa-whatsapp me-2 fs-5"></i> Hubungi <?= $nama_admin; ?>
                </a>
            </div>
        `,
        showConfirmButton: true,
        confirmButtonText: 'Tutup & Lihat Riwayat',
        confirmButtonColor: '#475569', 
        background: '#ffffff',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>
<?php 
    endif;
endif; 
?>

<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'kembali_sukses'): ?>
<script>
    var duration = 2 * 1000;
    var end = Date.now() + duration;

    (function frame() {
        confetti({ particleCount: 4, angle: 60, spread: 55, origin: { x: 0, y: 0.8 } });
        confetti({ particleCount: 4, angle: 120, spread: 55, origin: { x: 1, y: 0.8 } });
        if (Date.now() < end) { requestAnimationFrame(frame); }
    }());

    Swal.fire({
        title: '🏁 Pengembalian Berhasil! 🏁',
        html: `
            <div class="text-center mb-3">
                <p class="text-muted small">Terima kasih telah mempercayakan perjalanan Anda bersama DriveEase!</p>
            </div>
            
            <div class="card border-0 bg-light p-3 text-start mb-2" style="border-radius: 12px; font-size: 14px; border: 1px solid #e2e8f0 !important;">
                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                    <span class="text-muted">No. Nota Transaksi:</span>
                    <strong class="text-dark">#<?= htmlspecialchars($_GET['nota']); ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Unit Kendaraan:</span>
                    <span class="fw-bold text-primary"><?= htmlspecialchars($_GET['mobil']); ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Status Transaksi:</span>
                    <span class="badge bg-success py-1.5 px-3 rounded-pill"><i class="fa-solid fa-circle-check me-1"></i> Selesai Sewa</span>
                </div>
            </div>
            
            <div class="p-2 mt-3 rounded-3 text-center" style="background-color: #f0fdf4; font-size: 12px; color: #166534;">
                <i class="fa-solid fa-heart me-1 text-danger"></i> Unit aman dan status armada Anda telah diperbarui di sistem garasi kami.
            </div>
        `,
        icon: 'success',
        showConfirmButton: true,
        confirmButtonText: 'Sama-Sama, Tutup',
        confirmButtonColor: '#198754', 
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>