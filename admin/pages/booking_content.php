<?php
// File: admin/pages/booking_content.php

$query = mysqli_query($conn, "
    SELECT
        booking.*,
        users.nama,
        mobil.nama_mobil
    FROM booking
    LEFT JOIN users ON booking.id_user = users.id_user
    LEFT JOIN mobil ON booking.id_mobil = mobil.id_mobil
    ORDER BY booking.id_booking DESC
");

if (!$query) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Kelola Transaksi Booking</h4>
            <p class="text-muted small mb-0">Validasi pesanan masuk, periksa pembayaran, dan pantau status rental armada.</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle small m-0">
            <thead class="table-dark" style="background-color: #1e293b;">
                <tr>
                    <th class="py-3">ID</th>
                    <th class="py-3">Penyewa</th>
                    <th class="py-3">Mobil</th>
                    <th class="py-3">Tanggal Sewa</th>
                    <th class="py-3">Lama</th>
                    <th class="py-3">Total</th>
                    <th class="py-3">Metode Bayar</th>
                    <th class="py-3 text-center">Status</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td class="fw-bold text-secondary">#<?= $row['id_booking']; ?></td>
                    <td class="fw-bold text-dark">
                        <?= !empty($row['nama']) ? htmlspecialchars($row['nama']) : '<span class="text-muted">User dihapus</span>'; ?>
                    </td>
                    <td>
                        <?= !empty($row['nama_mobil']) ? htmlspecialchars($row['nama_mobil']) : '<span class="text-muted">Mobil dihapus</span>'; ?>
                    </td>
                    <td class="text-muted">
                        <i class="fa-regular fa-calendar me-1"></i> <?= date('d-m-Y', strtotime($row['tanggal_mulai'])); ?>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border px-2 py-1"><?= $row['durasi_hari']; ?> hari</span>
                    </td>
                    <td class="text-success fw-bold">
                        Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?>
                    </td>
                    <td class="small text-uppercase text-muted fw-bold">
                        <i class="fa-solid fa-credit-card me-1 text-primary"></i> <?= htmlspecialchars($row['metode_pembayaran']); ?>
                    </td>
                    <td class="text-center">
                        <?php 
                        $status_admin = trim($row['status_rental']); 
                        
                        if ($status_admin === 'Berjalan'): 
                        ?>
                            <span class="badge bg-primary text-white px-3 py-1.5 rounded-pill fw-bold">
                                <i class="fa-solid fa-car-side me-1"></i> Berjalan
                            </span>
                        <?php elseif ($status_admin === 'Selesai'): ?>
                            <span class="badge bg-success text-white px-3 py-1.5 rounded-pill fw-bold">
                                <i class="fa-solid fa-circle-check me-1"></i> Selesai
                            </span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold">
                                <i class="fa-solid fa-clock me-1"></i> Menunggu Konfirmasi
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <a href="verifikasi_booking.php?id=<?= $row['id_booking']; ?>" class="btn btn-warning btn-sm text-dark fw-bold rounded-pill px-3 shadow-sm">
                            <i class="fa-solid fa-user-check me-1"></i> Verifikasi
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>