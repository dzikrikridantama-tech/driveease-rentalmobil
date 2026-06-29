<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DriveEase - Rental Mobil Modern</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .hero-section {
            background:
            linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
            url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80');

            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }

        .card-mobil {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .card-mobil:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            <i class="fa-solid fa-car-side me-2 text-warning"></i>
            DriveEase
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php">
                        Katalog
                    </a>
                </li>

                <?php if(isset($_SESSION['user_id'])): ?>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="riwayat.php">
                            Riwayat Sewa
                        </a>
                    </li>

                    <!-- MENU KHUSUS ADMIN -->
                    <?php if($_SESSION['user_role'] == 'admin'): ?>

                        <li class="nav-item">
                            <a class="nav-link text-warning fw-bold"
                               href="admin/dashboard.php">

                                <i class="fa-solid fa-user-shield me-1"></i>
                                Dashboard Admin

                            </a>
                        </li>

                    <?php endif; ?>

                    <li class="nav-item ms-2">

                        <span class="badge bg-warning text-dark px-3 py-2">

                            <i class="fa-solid fa-user me-1"></i>

                            Halo,
                            <?= $_SESSION['user_nama']; ?>

                        </span>

                    </li>

                    <li class="nav-item ms-2">

                        <a class="btn btn-sm btn-danger"
                           href="logout.php">

                            Logout

                        </a>

                    </li>

                <?php else: ?>

                    <li class="nav-item">

                        <a class="nav-link text-white"
                           href="login.php">

                            Login

                        </a>

                    </li>

                    <li class="nav-item ms-2">

                        <a class="btn btn-sm btn-warning fw-bold"
                           href="register.php">

                            Daftar

                        </a>

                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>
</nav>