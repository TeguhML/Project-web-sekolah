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
-- Struktur dari tabel `t_upload`
--

CREATE TABLE `t_upload` (
  `id` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `id_mapel` varchar(25) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nis` int(25) NOT NULL,
  `jawaban` text NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_upload`
--

INSERT INTO `t_upload` (`id`, `id_guru`, `id_sekolah`, `id_mapel`, `nama`, `nis`, `jawaban`, `file_path`) VALUES
(1, 1, 1, 'm101', 'Teguh', 2130511075, '265 juta', 'uploads/Tugas Tampilan_ Teguh Mulya Lesmana.docx'),
(2, 1, 1, 'm102', 'Daffa Miya', 2130511080, '', 'uploads/teori-bahasa-automata-state-chart-diagrampdf-1687217028 (1).pdf'),
(4, 1, 1, 'm102', 'Akhsan', 2130511094, 'Atom adalah satuan dasar materi yang terdiri atas inti atom yang terdiri atas proton yang bermuatan positif dan neutron yang bermuatan netral (kecuali pada inti atom Hidrogen-1, yang tidak memiliki neutron)', 'uploads/');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_upload`
--
ALTER TABLE `t_upload`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_upload`
--
ALTER TABLE `t_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
