-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jul 2023 pada 10.50
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekolah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_tugas`
--

CREATE TABLE `t_tugas` (
  `id` int(11) NOT NULL,
  `tugas` text NOT NULL,
  `dl` date NOT NULL,
  `datecreate` date NOT NULL DEFAULT current_timestamp(),
  `id_guru` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `id_mapel` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_tugas`
--

INSERT INTO `t_tugas` (`id`, `tugas`, `dl`, `datecreate`, `id_guru`, `id_sekolah`, `id_mapel`) VALUES
(1, 'Menampilkan data pada web', '2023-07-22', '2023-07-06', 1, 1, 'm101'),
(2, 'membuat sianida', '2023-07-30', '2023-07-08', 1, 1, 'm102');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_tugas`
--
ALTER TABLE `t_tugas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_tugas`
--
ALTER TABLE `t_tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
