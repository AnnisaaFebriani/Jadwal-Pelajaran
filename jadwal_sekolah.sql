-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 19, 2026 at 07:44 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jadwal_sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aktivitas`
--

INSERT INTO `aktivitas` (`id`, `user_id`, `nama`, `role`, `aktivitas`, `waktu`) VALUES
(37, 1, 'Admin', 'admin', 'Login ke sistem', '2026-08-26 11:49:12'),
(38, 34, 'denti', 'siswa', 'Login ke sistem', '2026-08-26 11:53:12'),
(39, 34, 'denti', 'siswa', 'Melihat jadwal', '2026-08-26 11:53:12'),
(42, 1, 'Admin', 'admin', 'Login ke sistem', '2026-08-26 11:54:56'),
(43, 1, 'Admin', 'admin', 'Login ke sistem', '2026-08-26 12:56:06'),
(44, 31, 'Bu Eling', 'guru', 'Login ke sistem', '2026-08-26 12:59:56'),
(45, 31, 'Bu Eling', 'guru', 'Melihat jadwal mengajar', '2026-08-26 12:59:56'),
(46, 1, 'Admin', 'admin', 'Login ke sistem', '2026-08-26 13:00:07'),
(47, 1, 'Admin', 'admin', 'Login ke sistem', '2026-08-26 13:02:24'),
(48, 33, 'Annisa', 'siswa', 'Login ke sistem', '2026-08-26 13:03:33'),
(49, 33, 'Annisa', 'siswa', 'Melihat jadwal', '2026-08-26 13:03:33'),
(50, 1, 'Admin', 'admin', 'Login ke sistem', '2026-08-26 13:04:56'),
(51, 1, 'Admin', 'admin', 'Login ke sistem', '2026-08-26 13:17:04'),
(52, 33, 'Annisa', 'siswa', 'Login ke sistem', '2026-08-26 13:17:38'),
(53, 33, 'Annisa', 'siswa', 'Melihat jadwal', '2026-08-26 13:17:38'),
(54, 1, 'Admin', 'admin', 'Login ke sistem', '2026-08-26 13:18:14'),
(55, 1, 'Admin', 'admin', 'Login ke sistem', '2026-08-26 13:32:35');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `hari` varchar(50) DEFAULT NULL,
  `jam` varchar(50) DEFAULT NULL,
  `mapel` varchar(100) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `guru` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `hari`, `jam`, `mapel`, `kelas`, `guru`) VALUES
(115, 'Senin', '1', 'Informatika', 'XI RPL', 'Bu Eling'),
(116, 'Selasa', '2', 'Kejuruan', 'XI TKJ', 'Pak Slamet');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('admin','siswa','guru') DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `mapel` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `password`, `role`, `kelas`, `nis`, `jurusan`, `mapel`) VALUES
(1, 'Admin', '$2y$10$kOSeSt2ZzlZcEaIipm9plOb/FgEPI8gMTrrvVEobXIiLpomYhBxEO', 'admin', NULL, NULL, NULL, NULL),
(29, 'Pak Slamet', '$2y$10$DiIoHrwwDG5Fp6c1cLd1H.acOpdTr25Vd8yEO52DyMINYCzcM4FLW', 'guru', NULL, NULL, 'TKJ', 'Kejuruan'),
(31, 'Bu Eling', '$2y$10$/yK1pM7QN/njwKpcQ8EO3.twoKELEhyE69Qn/pPWIvrMb4oTxvbSa', 'guru', NULL, NULL, 'RPL', 'Informatika'),
(32, 'Bu Dyan', '$2y$10$lmUqZ9VVnW8iOZ9EXmvAMeRuyfsxRsk2HbY8duhWRUQ3Vwvn9Jzqe', 'guru', NULL, NULL, 'RPL', 'Bahasa Jawa'),
(33, 'Annisa', '$2y$10$wE92h66LWmDf6PcHZazScuJPJfePiolq45VDJW6kbBJacrHtBYVQm', 'siswa', 'XI RPL', '8687', NULL, NULL),
(34, 'denti', '$2y$10$XKJV74XcV53Ut./rOqW8su7O1NUqoaUXiPeeC0cXmYzU9rnr587MW', 'siswa', 'XI TKJ', '7676', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
