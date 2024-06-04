-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 04, 2024 at 01:45 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokosagita`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int NOT NULL,
  `id_user` int NOT NULL,
  `id_produk` int NOT NULL,
  `qty_cart` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int NOT NULL,
  `id_transaksi` int NOT NULL,
  `id_produk` int NOT NULL,
  `qty_transaksi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `id_produk`, `qty_transaksi`) VALUES
(30, 21, 9, 1),
(31, 21, 8, 1),
(32, 22, 8, 4),
(33, 22, 9, 1),
(34, 23, 9, 1),
(35, 24, 8, 4),
(36, 25, 8, 3);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `harga_produk` int NOT NULL,
  `qty_produk` int NOT NULL,
  `gambar_produk` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `jenis`, `harga_produk`, `qty_produk`, `gambar_produk`) VALUES
(8, 'Jaket Adventure Waterproof', 'Jaket', 350000, 5, 'man-3.jpg'),
(9, 'Atasan Rajut Wanita Grey', 'Towel', 120000, 5, 'women-3.jpg'),
(10, 'Jaket Denim ', 'Jaket', 275000, 10, '1717478694.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `id_pesanan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_user` int NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `total_transaksi` int NOT NULL,
  `bukti_bayar` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `no_resi` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pesanan`, `id_user`, `tanggal_transaksi`, `total_transaksi`, `bukti_bayar`, `status`, `no_resi`) VALUES
(21, 'NRJ1717292421', 2, '2024-06-02', 470000, 'hero.jpg', 'Selesai', 'IDX90935290'),
(22, 'NRJ1717292459', 2, '2024-06-02', 1520000, 'Bukti transfer.jpeg', 'Selesai', 'IDX909292900'),
(23, 'NRJ1717393097', 2, '2024-06-03', 120000, 'Bukti transfer.jpeg', 'Selesai', 'IDX90929289'),
(24, 'NRJ1717423917', 2, '2024-06-03', 1400000, 'Bukti transfer.jpeg', 'Sedang Diproses', 'IDX90929290'),
(25, 'NRJ1717424114', 2, '2024-06-03', 1050000, 'Bukti transfer.jpeg', 'Belum Diproses', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ukuran`
--

CREATE TABLE `ukuran` (
  `id_ukuran` int NOT NULL,
  `id_jenis` int NOT NULL,
  `ukuran` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ukuran`
--

INSERT INTO `ukuran` (`id_ukuran`, `id_jenis`, `ukuran`) VALUES
(1, 1, '28'),
(2, 1, '29'),
(3, 1, '30'),
(4, 1, '31'),
(5, 1, '32'),
(6, 2, 'S'),
(7, 2, 'M'),
(8, 2, 'L'),
(9, 2, 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nomor_hp` varchar(40) NOT NULL,
  `alamat` varchar(500) NOT NULL,
  `level` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `email`, `password`, `nomor_hp`, `alamat`, `level`) VALUES
(1, 'Admin', 'admin@sagita.com', '7815696ecbf1c96e6894b779456d330e', '123123', 'asdasdasd', 2),
(2, 'Habibi', 'asd@asd.com', '7815696ecbf1c96e6894b779456d330e', '123123', 'Perumnas 2 Blok H2 No.23 Tangerang - Banten', 1),
(3, 'Andri Hidayat', 'andrih316@gmail.com', '7815696ecbf1c96e6894b779456d330e', '123123', 'asdasdasd', 1),
(4, 'Owner', 'owner@sagita.com', '7815696ecbf1c96e6894b779456d330e', '123123', 'asdasdasd', 3),
(9, 'Habibi', 'habibi@asd.com', '7815696ecbf1c96e6894b779456d330e', '089922324', 'Perumnas 2 Blok H2 No.23 Tangerang - Banten', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `ukuran`
--
ALTER TABLE `ukuran`
  ADD PRIMARY KEY (`id_ukuran`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `ukuran`
--
ALTER TABLE `ukuran`
  MODIFY `id_ukuran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
