-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Sep 2023 pada 03.13
-- Versi server: 10.4.16-MariaDB
-- Versi PHP: 7.3.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_erp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_reservasi_mobil`
--

CREATE TABLE `ms_reservasi_mobil` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `department` varchar(15) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `cost_center` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `time_from` varchar(255) DEFAULT NULL,
  `time_to` varchar(255) DEFAULT NULL,
  `plant` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `car_load` varchar(1000) DEFAULT NULL,
  `feedback` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ms_reservasi_mobil`
--

INSERT INTO `ms_reservasi_mobil` (`id`, `user_id`, `department`, `company`, `cost_center`, `status`, `date_from`, `date_to`, `time_from`, `time_to`, `plant`, `destination`, `description`, `car_load`, `feedback`, `created_at`, `updated_at`) VALUES
(1, 157, '', NULL, NULL, 'pending', '2023-08-01', '2023-08-02', '12:22', '12:22', 'cibitung', 'jawa barat', 'keperluan meeting', '1', 'oke bacoty', NULL, '2023-09-01 19:08:34'),
(2, 1, 'IT - MIS', NULL, NULL, 'Approved', '2023-08-29', '2023-08-30', '00:05', '00:02', 'Cikarang', 'bogor', 'saddsw', '1', 'care', '2023-08-28 13:16:22', '2023-09-01 17:31:50'),
(3, 1, 'IT - MIS', NULL, NULL, 'Unapproved', '2023-08-29', '2023-08-30', '00:03', '00:02', 'Setu', 'bogorsd', 'sacds', '2', 'ftere', '2023-08-29 13:52:08', '2023-09-01 17:32:07'),
(4, 1, 'IT - MIS', NULL, NULL, 'Unapproved', '2023-09-01', '2023-09-02', '00:00', '07:30', 'Cibitung', 'bsndisbd', 'sfe', '2', 'vaere', '2023-09-01 18:56:49', '2023-09-01 19:02:46'),
(5, 1, 'IT - MIS', NULL, NULL, 'Approved', '2023-09-01', '2023-09-02', '00:00', '10:30', 'Cibitung', 'csacsa', 'scafe', '1', 'asu', '2023-09-01 19:10:26', '2023-09-01 19:10:42'),
(6, 1, 'IT - MIS', NULL, NULL, 'Approved', '2023-09-01', '2023-09-08', '00:00', '00:30', 'Cibitung', 'dv', 'cdxz', '3', 'oke gan', '2023-09-01 20:10:53', '2023-09-04 14:09:07'),
(7, 1, 'IT - MIS', NULL, NULL, 'Unapproved', '2023-09-07', '2023-09-16', '00:00', '04:30', 'Cibitung', 'bogor', 'qwfw', '1', NULL, '2023-09-02 06:10:57', '2023-09-02 07:15:44'),
(8, 1094, 'Consumer Care &', NULL, NULL, 'Approved', '2023-09-18', '2023-09-19', '00:00', '08:30', 'Cibitung', 'CASASdwqfqgw', 'fqvqvgqqrg', '1', 'daw', '2023-09-02 06:11:57', '2023-09-04 14:17:49'),
(9, 1094, 'Consumer Care &', NULL, NULL, 'Approved', '2023-09-03', '2023-09-12', '00:00', '02:00', 'Cibitung', 'bogor', 'adsw', '1', 'dwa', '2023-09-02 06:33:12', '2023-09-04 14:18:05'),
(10, 1094, 'Consumer Care &', NULL, NULL, 'Approved', '2023-09-02', '2023-09-02', '00:00', '03:00', 'Cikarang', 'esf', 'csae', '3', 'oke', '2023-09-02 06:35:44', '2023-09-02 07:12:20'),
(11, 1094, 'Consumer Care &', NULL, NULL, 'Unapproved', '2023-09-15', '2023-09-16', '00:00', '04:30', 'Cibitung', 'bedraw', 'cfew', '4', 'tolol resign', '2023-09-02 06:37:26', '2023-09-02 06:54:16'),
(12, 1094, 'Consumer Care &', NULL, NULL, 'Approved', '2023-09-15', '2023-09-16', '09:30', '07:30', 'sentul', 'bogor', 'efw', '2', 'cadave', '2023-09-02 06:45:15', '2023-09-02 06:49:18'),
(13, 1, 'IT - MIS', NULL, NULL, 'Approved', '2023-09-02', '2023-09-02', '07:00', '16:30', 'Cibitung', 'Jakarata Menteng', 'Maintance', '4', 'oke ambil kuncinya di ga', '2023-09-02 08:37:03', '2023-09-02 08:37:49'),
(14, 1, 'IT - MIS', NULL, NULL, 'Unapproved', '2023-09-05', '2023-09-05', '08:30', '09:00', 'Cibitung', 'Depok', 'Meeting', '5', 'csaev', '2023-09-04 13:52:56', '2023-09-04 14:14:07'),
(15, 1, 'IT - MIS', NULL, NULL, 'Approved', '2023-09-07', '2023-09-09', '07:30', '10:30', 'Cibitung', 'Karawang', 'Customer CARE', '4', 'oke silahkan ke ga', '2023-09-04 14:27:10', '2023-09-04 14:28:47'),
(16, 1, 'IT - MIS', 'Haldin', '603-07', 'pending', '2023-09-13', '2023-09-13', '07:00', '09:00', 'Cibitung', 'Cikarang', 'Ke Cikarang', '4', NULL, '2023-09-05 13:30:28', '2023-09-13 03:46:04'),
(17, 106, 'General Affair', NULL, NULL, 'pending', '2023-09-09', '2023-09-09', '09:00', '18:30', 'Cibitung', 'Bekasi', 'Metting', '3', NULL, '2023-09-05 14:05:31', '2023-09-05 14:05:31'),
(19, 1, 'IT - MIS', 'Haldin', '307-05', 'pending', '2023-09-13', '2023-09-13', '08:00', '17:00', 'Cibitung', 'Banten', 'yang gw liat di google \r\nLembaga Bahasa LIA adalah unit terbesar dari Yayasan LIA yang memulai kiprahnya di tahun 1959 dengan nama Lembaga Indonesia Amerika. Berawal dari hanya 19 siswa yang belajar Bahasa Inggris di LIA untuk mempersiapkan studi mereka d', '4 orang', NULL, '2023-09-13 02:43:34', '2023-09-13 04:23:50'),
(20, 1, 'IT - MIS', 'Talasi', 'X52-07', 'Approved', '2023-09-14', '2023-09-15', '10:00', '12:30', 'Cibitung', 'Bekasi', 'yang gw liat di google \r\nLembaga Bahasa LIA adalah unit terbesar dari Yayasan LIA yang memulai kiprahnya di tahun 1959 dengan nama Lembaga Indonesia Amerika. Berawal dari hanya 19 siswa yang belajar Bahasa Inggris di LIA untuk mempersiapkan studi mereka d', 'Lembaga Bahasa LIA adalah unit terbesar dari Yayasan LIA yang memulai kiprahnya di tahun 1959 dengan nama Lembaga Indonesia Amerika. Berawal dari hanya 19 siswa yang belajar Bahasa Inggris di LIA untuk mempersiapkan studi mereka di luar negeri, saat ini L', 'yang gw liat di google \nLembaga Bahasa LIA adalah unit terbesar dari Yayasan LIA yang memulai kiprahnya di tahun 1959 dengan nama Lembaga Indonesia Amerika. Berawal dari hanya 19 siswa yang belajar Bahasa Inggris di LIA untuk mempersiapkan studi mereka d', '2023-09-13 03:31:34', '2023-09-14 00:56:21'),
(21, 1, 'IT - MIS', 'Haldin', 'X60-01', 'Approved', '2023-09-13', '2023-09-14', '10:00', '16:30', 'Cibitung', 'Bekasi', 'yang gw liat di google \r\nLembaga Bahasa LIA adalah unit terbesar dari Yayasan LIA yang memulai kiprahnya di tahun 1959 dengan nama Lembaga Indonesia Amerika. Berawal dari hanya 19 siswa yang belajar Bahasa Inggris di LIA untuk mempersiapkan studi mereka di luar negeri, saat ini LIA telah melayani lebih dari 60.000 siswa per triwulannya.\r\n\r\nDengan komitmen yang tinggi terhadap pendidikan, Lembaga Bahasa LIA telah berhasil meraih berbagai penghargaan dari pemerintah dan memiliki reputasi sebagai lembaga bahasa Inggris terbaik dan terbesar, dengan lebih dari 60 outlet yang tersebar di berbagai penjuru Indonesia.', 'yang gw liat di google \r\nLembaga Bahasa LIA adalah unit terbesar dari Yayasan LIA yang memulai kiprahnya di tahun 1959 dengan nama Lembaga Indonesia Amerika. Berawal dari hanya 19 siswa yang belajar Bahasa Inggris di LIA untuk mempersiapkan studi mereka di luar negeri, saat ini LIA telah melayani lebih dari 60.000 siswa per triwulannya.\r\n\r\nDengan komitmen yang tinggi terhadap pendidikan, Lembaga Bahasa LIA telah berhasil meraih berbagai penghargaan dari pemerintah dan memiliki reputasi sebagai lembaga bahasa Inggris terbaik dan terbesar, dengan lebih dari 60 outlet yang tersebar di berbagai penjuru Indonesia.', 'oke gan', '2023-09-13 04:26:05', '2023-09-13 06:52:54');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ms_reservasi_mobil`
--
ALTER TABLE `ms_reservasi_mobil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `ms_reservasi_mobil`
--
ALTER TABLE `ms_reservasi_mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `ms_reservasi_mobil`
--
ALTER TABLE `ms_reservasi_mobil`
  ADD CONSTRAINT `ms_reservasi_mobil_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
