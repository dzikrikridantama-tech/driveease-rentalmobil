<?php
session_start();
include 'config/database.php';
include 'includes/header.php';

// Proteksi: Pastikan pengguna harus login terlebih dahulu sebelum menyewa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil ID mobil dari parameter URL secara aman
$id_mobil = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Cari data spesifikasi mobil di database
$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil = '$id_mobil'");
$mobil = mysqli_fetch_assoc($query);

// Jika ID mobil tidak valid atau tidak ditemukan, kembalikan ke beranda
if (!$mobil) {
    header("Location: index.php");
    exit;
}
// TAMBAHAN BARU: Cek apakah mobil masih tersedia
if ($mobil['status'] != 'Tersedia') {
    echo "
    <script>
        alert('Maaf, mobil ini sedang tidak tersedia untuk disewa.');
        window.location='index.php';
    </script>";
    exit;
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow border-0" style="border-radius: 20px; background-color: #ffffff;">
                
                <h4 class="fw-bold text-dark mb-1">
                    <i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i>Konfirmasi Sewa & Bayar
                </h4>
                <p class="text-muted small mb-4">Lengkapi durasi sewa, pilih metode pembayaran, dan isi detail transfer Anda.</p>
                
                <div class="p-3 mb-4 bg-light rounded-3 d-flex align-items-center border">
                    <img src="images/<?= $mobil['gambar']; ?>" style="width: 90px; height: 65px; object-fit: contain;" class="me-3" alt="Foto Mobil">
                    <div>
                        <h6 class="fw-bold text-dark mb-1"><?= htmlspecialchars($mobil['nama_mobil']); ?></h6>
                        <span class="badge bg-secondary mb-2" style="font-size: 11px;"><?= htmlspecialchars($mobil['jenis_mobil']); ?></span>
                        <p class="text-danger small fw-bold mb-0">Rp <span id="harga_per_hari"><?= $mobil['harga_per_hari']; ?></span> / Hari</p>
                    </div>
                </div>

                <form action="proses_booking.php" method="POST">
                    <input type="hidden" name="id_mobil" value="<?= $mobil['id_mobil']; ?>">
                    <input type="hidden" name="harga_per_hari" value="<?= $mobil['harga_per_hari']; ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Tanggal Mulai Sewa</label>
                            <input type="date" name="tanggal_mulai" class="form-control bg-light" required min="<?= date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Durasi Sewa (Hari)</label>
                            <input type="number" name="durasi" id="durasi_sewa" class="form-control bg-light" value="1" min="1" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select bg-light fw-bold text-dark" required>
                            <option value="Bayar di Tempat (COD)">💵 Bayar di Tempat / Tunai (COD)</option>
                            <option value="Transfer Bank BCA">🏦 Transfer Bank BCA (Manual)</option>
                            <option value="Transfer Bank Mandiri">🏦 Transfer Bank Mandiri (Manual)</option>
                            <option value="E-Wallet (Dana/OVO)">📱 E-Wallet (DANA / OVO)</option>
                        </select>
                    </div>

                    <div id="kolom_transfer_ekstra" class="p-3 mb-3 rounded-3 shadow-sm" style="background-color: #f8fafc; border: 1px solid #e2e8f0; display: none;">
                        
                        <div class="alert alert-warning border-0 mb-3" style="border-radius: 12px; background-color: #fef3c7;">
                            <span class="text-dark small d-block fw-bold mb-1"><i class="fa-solid fa-building-columns me-1 text-primary"></i> Rekening Tujuan Transfer Rental:</span>
                            <div id="instruksi_rekening_toko" class="fs-6 fw-extrabold text-dark py-1">
                                </div>
                            <span class="text-muted d-block" style="font-size: 11px;">*Silahkan salin nomor di atas sebelum melakukan transfer.</span>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small" id="label_rekening">Nomor Rekening Anda</label>
                            <input type="text" name="no_rekening_user" id="no_rekening_user" class="form-control bg-white" placeholder="Masukkan nomor rekening atau nomor HP e-wallet">
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold text-dark small">Nominal Uang yang Ditransfer (Rp)</label>
                            <input type="number" name="nominal_transfer" id="nominal_transfer" class="form-control bg-white" placeholder="Contoh: 350000">
                        </div>
                    </div>

                    <div class="card border-0 p-3 my-4" style="background-color: #f1f5f9; border-radius: 15px;">
                        <div class="d-flex justify-content-between align-items-center mb-2 text-muted small">
                            <span>Harga Pokok Sewa:</span>
                            <span>Rp <?= number_format($mobil['harga_per_hari'], 0, ',', '.'); ?> x <span id="text_durasi">1</span> Hari</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="fw-bold text-dark">Total Wajib Bayar:</span>
                            <span class="fw-extrabold text-success fs-4">Rp <span id="total_nominal"><?= number_format($mobil['harga_per_hari'], 0, ',', '.'); ?></span></span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-pill shadow-sm bg-gradient">
                        <i class="fa-solid fa-circle-check me-2 text-warning"></i> Selesaikan Transaksi Sewa
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    const inputDurasi = document.getElementById('durasi_sewa');
    const textDurasi = document.getElementById('text_durasi');
    const totalNominal = document.getElementById('total_nominal');
    const hargaPerHari = parseInt(document.getElementById('harga_per_hari').innerText);
    
    const selectMetode = document.getElementById('metode_pembayaran');
    const areaEkstra = document.getElementById('kolom_transfer_ekstra');
    const OpenBankInfo = document.getElementById('instruksi_rekening_toko');
    const labelRekening = document.getElementById('label_rekening');
    
    const inputNoRekUser = document.getElementById('no_rekening_user');
    const inputNominalTransfer = document.getElementById('nominal_transfer');

    // 1. Logika Live Mengalikan Durasi Hari dengan Tarif Mobil
    inputDurasi.addEventListener('input', function() {
        let durasi = parseInt(this.value);
        if (isNaN(durasi) || durasi < 1) durasi = 1;
        const total = hargaPerHari * durasi;
        textDurasi.innerText = durasi;
        totalNominal.innerText = total.toLocaleString('id-ID');
    });

    // 2. Logika Menyembunyikan / Menampilkan Form Tambahan secara Otomatis
    selectMetode.addEventListener('change', function() {
        const metode = this.value;

        if (metode === 'Bayar di Tempat (COD)') {
            areaEkstra.style.display = 'none';
            inputNoRekUser.removeAttribute('required');
            inputNominalTransfer.removeAttribute('required');
        } else {
            areaEkstra.style.display = 'block';
            inputNoRekUser.setAttribute('required', 'required');
            inputNominalTransfer.setAttribute('required', 'required');

            // Set Nomor Rekening Resmi Perusahaan berdasarkan Opsi Klik
            if (metode === 'Transfer Bank BCA') {
                OpenBankInfo.innerHTML = "Base BCA: <span class='text-danger'>872-0981-221</span> <br><small class='fw-normal text-muted'>a/n PT DriveEase Sukses Makmur</small>";
                labelRekening.innerText = "Nomor Rekening BCA Anda (Penyewa)";
            } else if (metode === 'Transfer Bank Mandiri') {
                OpenBankInfo.innerHTML = "Base Mandiri: <span class='text-danger'>131-00-29102-11</span> <br><small class='fw-normal text-muted'>a/n PT DriveEase Sukses Makmur</small>";
                labelRekening.innerText = "Nomor Rekening Mandiri Anda (Penyewa)";
            } else if (metode === 'E-Wallet (Dana/OVO)') {
                OpenBankInfo.innerHTML = "📱 DANA / OVO: <span class='text-danger'>0812-3456-7890</span> <br><small class='fw-normal text-muted'>a/n DriveEase Rental Admin</small>";
                labelRekening.innerText = "Nomor HP Akun DANA/OVO Anda (Penyewa)";
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'nominal_salah'): ?>
<script>
    let totalTagihan = parseInt("<?= $_GET['total']; ?>").toLocaleString('id-ID');
    let inputUser = parseInt("<?= $_GET['input']; ?>").toLocaleString('id-ID');

    Swal.fire({
        title: 'Pembayaran Gagal! ❌',
        icon: 'error',
        html: `
            <div class="text-start p-3 rounded-3 small" style="background-color: #fff1f2; color: #991b1b;">
                <p class="mb-2 text-center fw-bold">⚠️ Nominal Uang Tidak Sesuai</p>
                <hr class="my-1 border-danger">
                <div class="d-flex justify-content-between mb-1"><span>Total Tagihan:</span><strong>Rp ${totalTagihan}</strong></div>
                <div class="d-flex justify-content-between"><span>Anda Mentransfer:</span><strong>Rp ${inputUser}</strong></div>
            </div>
            <p class="text-muted small mt-3 mb-0">Silakan isi ulang dengan nominal uang yang sama persis untuk memverifikasi sewa.</p>
        `,
        confirmButtonText: 'Perbaiki Data',
        confirmButtonColor: '#dc3545'
    }).then(() => { window.history.replaceState({}, document.title, window.location.pathname + "?id=<?= $_GET['id']; ?>"); });
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>