<?php
// 1. Ambil data mobil asli dari databasemu
$query_mobil = mysqli_query($conn, "SELECT * FROM mobil");
?>

<div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0">Kelola Armada Mobil</h4>
            <p class="text-muted small mb-0">Tambah, ubah, atau hapus ketersediaan armada mobil.</p>
        </div>
        <a href="tambah_mobil.php" class="btn btn-dark btn-sm rounded-pill px-3 fw-bold">
            <i class="fa-solid fa-plus me-1"></i> Tambah Mobil
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped align-middle small">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mobil</th>
                    <th>Jenis</th>
                    <th>Harga/Hari</th>
                    <th>Status</th>
                    <th>Aksi</th> </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                // 2. Lakukan looping data asli lamamu di sini
                while($row = mysqli_fetch_assoc($query_mobil)): 
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><strong><?= htmlspecialchars($row['nama_mobil']); ?></strong></td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-dark"><?= $row['jenis_mobil']; ?></span></td>
                    <td class="text-danger fw-bold">Rp <?= number_format($row['harga_per_hari'], 0, ',', '.'); ?></td>
                    <td>
                        <span class="badge <?= $row['status'] == 'Tersedia' ? 'bg-success' : 'bg-danger'; ?>">
                            <?= $row['status']; ?>
                        </span>
                    </td>
                    <td>
                        <a href="edit_mobil.php?id=<?= $row['id_mobil']; ?>" class="btn btn-sm btn-warning text-dark"><i class="fa-solid fa-pen"></i></a>
                        <a href="hapus_mobil.php?id=<?= $row['id_mobil']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>