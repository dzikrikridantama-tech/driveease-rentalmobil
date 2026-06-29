<?php 
include 'config/database.php';
include 'includes/header.php'; 
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container my-5">
    <div class="row justify-content-center align-items-center" style="min-height: 480px;">
        <div class="col-md-5">
            <div class="card p-4 shadow border-0" style="border-radius: 20px; background-color: #ffffff;">
                
                <div class="text-center mb-4">
                    <div class="d-inline-block p-3 rounded-circle shadow-sm mb-2" style="background: linear-gradient(135deg, #28a745, #20c997);">
                        <i class="fa-solid fa-user-plus fa-2x text-white"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Daftar Akun Baru</h4>
                    <p class="text-muted small">Bergabunglah bersama DriveEase untuk kemudahan sewa mobil</p>
                </div>
                
                <form action="proses_register.php" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                            <input type="text" name="nama" class="form-control bg-light border-start-0 focus-none" placeholder="Masukkan nama lengkap Anda" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-start-0 focus-none" placeholder="nama@email.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Nomor HP / WhatsApp</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-phone"></i></span>
                            <input type="tel" name="no_hp" class="form-control bg-light border-start-0 focus-none" placeholder="Contoh: 08123456789" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Kata Sandi (Password)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-key"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-start-0 focus-none" placeholder="Buat password minimal 6 karakter" minlength="6" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 rounded-pill mt-3 shadow-sm text-white" style="background: linear-gradient(135deg, #28a745, #20c997); border: none;">
                        <i class="fa-solid fa-user-check me-2"></i> Buat Akun Sekarang
                    </button>
                </form>
                
                <p class="text-center mt-4 text-muted small mb-0">Sudah punya akun? <a href="login.php" class="text-primary fw-bold text-decoration-none">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['pesan'])): ?>
<script>
    let pesan = "<?= $_GET['pesan']; ?>";
    
    if (pesan === 'email_terdaftar') {
        Swal.fire({
            title: 'Pendaftaran Gagal! ⚠️',
            text: 'Email tersebut sudah pernah terdaftar di sistem kami. Gunakan email lain atau langsung login.',
            icon: 'warning',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#ffc107'
        }).then(() => { window.history.replaceState({}, document.title, window.location.pathname); });
    } else if (pesan === 'gagal') {
        Swal.fire({
            title: 'Terjadi Kesalahan ❌',
            text: 'Gagal membuat akun karena gangguan database, silakan coba beberapa saat lagi.',
            icon: 'error',
            confirmButtonText: 'Coba Lagi',
            confirmButtonColor: '#dc3545'
        }).then(() => { window.history.replaceState({}, document.title, window.location.pathname); });
    }
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>