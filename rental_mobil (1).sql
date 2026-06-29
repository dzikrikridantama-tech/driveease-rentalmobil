-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2026 at 10:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_mobil`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id_booking` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_mobil` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `durasi_hari` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `metode_pembayaran` varchar(50) DEFAULT 'Bayar di Tempat (COD)',
  `no_rekening_user` varchar(50) DEFAULT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `status_rental` enum('Berjalan','Selesai') DEFAULT 'Berjalan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id_booking`, `id_user`, `id_mobil`, `tanggal_mulai`, `durasi_hari`, `total_harga`, `metode_pembayaran`, `no_rekening_user`, `bukti_bayar`, `status_rental`) VALUES
(7, 1, 8, '2026-06-11', 4, 1200000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(8, 1, 8, '2026-06-11', 4, 1200000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(9, 1, 7, '2026-06-10', 1, 550000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(10, 1, 7, '2026-06-10', 1, 550000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(11, 1, 7, '2026-06-10', 1, 550000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(12, 1, 1, '2026-06-09', 2, 700000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(13, 1, 3, '2026-06-09', 3, 750000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(14, 1, 3, '2026-06-09', 4, 1000000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(18, 1, 2, '2026-06-10', 1, 600000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(19, 1, 3, '2026-06-10', 3, 750000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(20, 1, 2, '2026-06-10', 3, 1800000, 'Transfer Bank BCA', NULL, NULL, 'Selesai'),
(21, 1, 3, '2026-06-10', 3, 750000, 'E-Wallet (Dana/OVO)', NULL, NULL, 'Selesai'),
(22, 1, 2, '2026-06-10', 2, 1200000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(23, 1, 3, '2026-06-10', 3, 750000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(24, 1, 7, '2026-06-10', 8, 4400000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(25, 1, 3, '2026-06-10', 3, 750000, 'Transfer Bank BCA', NULL, NULL, 'Selesai'),
(26, 1, 4, '2026-06-10', 4, 3200000, 'Bayar di Tempat (COD)', NULL, NULL, 'Selesai'),
(27, 1, 3, '2026-06-10', 3, 750000, 'E-Wallet (Dana/OVO)', '082325917362', NULL, 'Selesai'),
(28, 1, 3, '2026-06-10', 1, 250000, 'E-Wallet (Dana/OVO)', '082325917362', NULL, 'Selesai'),
(38, 1, 3, '2026-06-10', 1, 250000, 'E-Wallet (Dana/OVO)', '082325917362', NULL, 'Selesai'),
(39, 1, 2, '2026-06-12', 1, 600000, 'Transfer Bank Mandiri', '082325917362', NULL, 'Selesai'),
(40, 1, 2, '2026-06-12', 1, 600000, 'Transfer Bank BCA', '082325917362', 'bukti_1_1781095143.png', 'Selesai'),
(41, 1, 1, '2026-06-11', 1, 350000, 'Transfer Bank BCA', '082325917362', 'bukti_1_1781101542.png', 'Selesai'),
(42, 1, 2, '2026-06-10', 1, 600000, 'Bayar di Tempat (COD)', '', '-', 'Selesai'),
(43, 1, 2, '2026-06-10', 1, 600000, 'Bayar di Tempat (COD)', '', '-', 'Selesai'),
(44, 1, 2, '2026-06-10', 1, 600000, 'Bayar di Tempat (COD)', '', '-', 'Selesai'),
(45, 1, 4, '2026-06-11', 1, 800000, 'Bayar di Tempat (COD)', '', '-', 'Selesai'),
(46, 1, 2, '2026-06-11', 1, 600000, 'Bayar di Tempat (COD)', '', '-', 'Selesai'),
(47, 5, 4, '2026-06-11', 1, 800000, 'E-Wallet (Dana/OVO)', '082325917362', '-', 'Selesai'),
(48, 1, 2, '2026-06-11', 1, 600000, 'Bayar di Tempat (COD)', '', '-', 'Selesai'),
(49, 1, 3, '2026-06-11', 1, 250000, 'Bayar di Tempat (COD)', '', '-', 'Selesai'),
(50, 1, 6, '2026-06-29', 100, 250000000, 'Bayar di Tempat (COD)', '', '-', 'Berjalan');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int(11) NOT NULL,
  `nama_mobil` varchar(50) NOT NULL,
  `jenis_mobil` varchar(30) NOT NULL,
  `kapasitas_penumpang` int(11) DEFAULT 5,
  `bahan_bakar` varchar(20) DEFAULT 'Bensin',
  `fasilitas` varchar(255) DEFAULT 'AC, Audio, Charger Port',
  `gambar` varchar(255) DEFAULT 'default.jpg',
  `harga_per_hari` int(11) NOT NULL,
  `status` enum('Tersedia','Dibooking') DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `nama_mobil`, `jenis_mobil`, `kapasitas_penumpang`, `bahan_bakar`, `fasilitas`, `gambar`, `harga_per_hari`, `status`) VALUES
(1, 'Avanza Veloz', 'MPV', 7, 'Bensin', 'AC, Audio Pioneer, Rear Camera', 'avanza.jpg', 350000, 'Tersedia'),
(2, 'Innova Zenix', 'MPV', 7, 'Bensin', 'AC Double Blower, Screen Audio, USB, Captain Seat', 'innova.jpg', 600000, 'Tersedia'),
(3, 'Honda Brio', 'City Car', 4, 'Bensin', 'AC, Compact Audio, Sangat Lincah', 'brio.jpg', 250000, 'Tersedia'),
(4, 'Pajero Sport', 'SUV', 5, 'Bensin', 'AC, Audio, Charger Port', 'pajero.jpg', 800000, 'Tersedia'),
(5, 'Innova Reborn Dieng', 'MPV', 7, 'Diesel', 'AC Double Blower, Audio, Jok Kulit, Bagasi Luas', 'innova_reborn.jpg', 500000, 'Tersedia'),
(6, 'Toyota Alphard Transformer', 'Premium VIP', 7, 'Bensin Premium', 'Cool Box, Rear Entertainment, Jok Elektrik, Suspensi Lembut', 'alphard.jpg', 2500000, 'Dibooking'),
(7, 'Honda HR-V Prestige', 'SUV', 5, 'Bensin', 'AC, Audio, Charger Port', 'hrv.jpg', 550000, 'Tersedia'),
(8, 'Suzuki Ertiga Hybrid', 'LMPV', 5, 'Bensin', 'AC, Audio, Charger Port', 'ertiga.jpg', 300000, 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `role` enum('customer','admin') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `no_hp`, `role`) VALUES
(1, 'Muhammad Haikal Amri', 'hakaltok234@gmail.com', '$2y$10$VfgdLLIZ0FYx7t4ooeQSwOmrNF4YtE6rdKFteSFvSHpnEereweQIO', '082325917362', 'customer'),
(5, 'bahlil ganteng', 'bahlil123@gmail.com', '$2y$10$mwPEFMcbYuuZhJAC3uCPQOcNiSgD2LVSRdZv8xycHt3FNn3.25BsG', '082325262728', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `id_mobil` (`id_mobil`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_mobil`) REFERENCES `mobil` (`id_mobil`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
