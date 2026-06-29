<?php 
include 'config/database.php';
include 'includes/header.php'; 
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container my-5">
    <div class="row justify-content-center align-items-center" style="min-height: 450px;">
        <div class="col-md-4">
            <div class="card p-4 shadow border-0" style="border-radius: 20px; background-color: #ffffff;">
                
                <div class="text-center mb-4">
                    <div class="d-inline-block p-3 rounded-circle shadow-sm mb-2" style="background: linear-gradient(135deg, #4f46e5, #6366f1);">
                        <i class="fa-solid fa-user-shield fa-2x text-white"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Selamat Datang</h4>
                    <p class="text-muted small">Silakan masuk untuk mulai menyewa armada</p>
                </div>
                
                <form action="proses_login.php" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-start-0 focus-none" placeholder="nama@email.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Kata Sandi (Password)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-key"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-start-0 focus-none" placeholder="Masukkan password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-primary w-100 fw-bold py-2 rounded-pill mt-3 shadow-sm">
                        <i class="fa-solid fa-right-to-bracket me-2 text-warning"></i> Masuk Sekarang
                    </button>
                </form>
                
                <p class="text-center mt-4 text-muted small mb-0">Belum punya akun? <a href="register.php" class="text-primary fw-bold text-decoration-none">Daftar Akun Baru</a></p>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
<script>
    Swal.fire({
        title: 'Login Gagal! ❌',
        text: 'Email atau password salah, silakan periksa kembali ketikan Anda.',
        icon: 'error',
        confirmButtonText: 'Coba Lagi',
        confirmButtonColor: '#4f46e5'
    }).then(() => {
        window.history.replaceState({}, document.title, window.location.pathname);
    });
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>