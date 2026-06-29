<?php
session_start();

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['user_role'] != 'admin'
) {
    header("Location: ../login.php");
    exit;
}

include '../config/database.php';

// Hitung data statistik utama
$totalMobil = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mobil"));
$totalBooking = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM booking"));
$totalUser = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));

// Ambil parameter halaman dari URL (?page=...)
$page = isset($_GET['page']) ? $_GET['page'] : 'overview';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - DriveEase</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 260px;
            background-color: #0f172a; 
            color: #ffffff;
            transition: all 0.3s;
        }

        .sidebar-heading {
            padding: 24px;
            font-size: 1.2rem;
            font-weight: 800;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 14px 24px;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
            border-left: 4px solid #f59e0b;
        }

        .sidebar-link i {
            width: 24px;
            font-size: 1.1rem;
        }

        .admin-content {
            flex: 1;
            background-color: #f8fafc;
        }

        .admin-header {
            background-color: #ffffff;
            padding: 16px 32px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .stat-card {
            border: none !important;
            border-radius: 20px !important;
            background: #ffffff;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.06) !important;
        }

        .icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }
        
        .rounded-4 {
            border-radius: 16px !important;
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    
    <aside class="admin-sidebar">
        <div class="sidebar-heading text-warning">
            <i class="fa-solid fa-car-side me-2"></i>DriveEase <span class="text-white fs-6 fw-normal">Admin</span>
        </div>
        <div class="py-3">
            <a href="dashboard.php?page=overview" class="sidebar-link <?= $page == 'overview' ? 'active' : ''; ?>">
                <i class="fa-solid fa-chart-pie"></i> Dashboard Overview
            </a>
            <a href="dashboard.php?page=mobil" class="sidebar-link <?= $page == 'mobil' ? 'active' : ''; ?>">
                <i class="fa-solid fa-car"></i> Kelola Mobil
            </a>
            <a href="dashboard.php?page=booking" class="sidebar-link <?= $page == 'booking' ? 'active' : ''; ?>">
                <i class="fa-solid fa-calendar-check"></i> Kelola Booking
            </a>

            <a href="../index.php" class="sidebar-link">
                <i class="fa-solid fa-store"></i> Katalog
            </a>

            <div class="border-top border-secondary my-3 opacity-25"></div>
            <a href="../logout.php" class="sidebar-link text-danger">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar / Logout
            </a>
        </div>
    </aside>

    <main class="admin-content">
        
        <header class="admin-header d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">Sistem Manajemen Garasi</h5>
            <div class="d-flex align-items-center">
                <div class="text-end me-2">
                    <small class="text-muted d-block" style="font-size: 11px;">Selamat datang,</small>
                    <strong class="text-dark" style="font-size: 14px;"><?= htmlspecialchars($_SESSION['user_nama']); ?></strong>
                </div>
                <div class="bg-warning text-dark fw-bold rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; font-size: 14px;">
                    AD
                </div>
            </div>
        </header>

        <div class="container-fluid p-4 pt-5">
            
            <?php
            // LOGIKA YANG MENGATUR ISI KONTEN KANAN AGAR TIDAK PINDAH HALAMAN
            switch ($page) {
                case 'mobil':
                    include 'pages/mobil_content.php';
                    break;
                
                case 'booking':
                    include 'pages/booking_content.php';
                    break;

                case 'overview':
                default:
                    // JIKA OVERVIEW / DEFAULT, TAMPILKAN MATRIKS CARD UTAMA ANDA
            ?>
                <div class="mb-4">
                    <h3 class="fw-bold text-dark mb-1">Dashboard Admin</h3>
                    <p class="text-muted small">Pantau metrik performa jumlah kendaraan, data sewa, dan member terdaftar.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card stat-card shadow-sm p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted small fw-bold text-uppercase mb-1">Total Mobil</p>
                                    <h2 class="fw-extrabold text-dark mb-0"><?= $totalMobil ?></h2>
                                </div>
                                <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                    <i class="fa-solid fa-car-rear"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card stat-card shadow-sm p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted small fw-bold text-uppercase mb-1">Total Booking</p>
                                    <h2 class="fw-extrabold text-dark mb-0"><?= $totalBooking ?></h2>
                                </div>
                                <div class="icon-box bg-success bg-opacity-10 text-success">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card stat-card shadow-sm p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted small fw-bold text-uppercase mb-1">Total User</p>
                                    <h2 class="fw-extrabold text-dark mb-0"><?= $totalUser ?></h2>
                                </div>
                                <div class="icon-box bg-warning bg-opacity-15 text-warning">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-12">
                        <div class="bg-white p-5 rounded-4 shadow-sm border text-center">
                            <i class="fa-solid fa-sliders fa-2x text-muted mb-3 opacity-50"></i>
                            <h5 class="fw-bold text-dark">Akses Cepat Pengelolaan data</h5>
                            <p class="text-muted small mb-4">Gunakan tombol pintasan berikut untuk memproses data operasional garasi secara kilat.</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="dashboard.php?page=mobil" class="btn btn-outline-dark rounded-pill px-4 fw-bold btn-sm shadow-sm">
                                    <i class="fa-solid fa-plus me-1"></i> Atur Mobil
                                </a>
                                <a href="dashboard.php?page=booking" class="btn btn-warning text-dark rounded-pill px-4 fw-bold btn-sm shadow-sm">
                                    <i class="fa-solid fa-eye me-1"></i> Validasi Transaksi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                    break;
            } 
            ?>

        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>