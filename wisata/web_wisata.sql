-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Jan 2025 pada 11.36
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_wisata`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `id` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `nama_pengguna` varchar(100) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ulasan`
--

INSERT INTO `ulasan` (`id`, `id_wisata`, `nama_pengguna`, `rating`, `komentar`, `tanggal`) VALUES
(1, 1, 'Budi', 5.0, 'Tempat yang sangat bagus untuk bersantai dan berolahraga', '2025-01-25 11:58:40'),
(2, 2, 'Budi', 4.7, 'Kebun binatang yang besar dan banyak koleksi satwanya', '2025-01-25 11:58:40'),
(3, 3, 'Citra', 4.5, 'Setu Babakan sangat menyenangkan, terutama untuk anak-anak', '2025-01-25 11:58:40'),
(4, 4, 'Ella', 4.4, 'Tempat yang kreatif dengan berbagai pilihan kuliner', '2025-01-25 11:58:40'),
(5, 5, 'Gita', 4.5, 'Kota Kasablanka sangat lengkap, ada banyak pilihan belanja', '2025-01-25 11:58:40'),
(6, 6, 'Joko', 4.4, 'Citos nyaman untuk berbelanja dan makan, tapi kadang ramai', '2025-01-25 11:58:40'),
(7, 7, 'Mira', 4.3, 'Kampung Main Cipulir punya banyak makanan enak dan wahana', '2025-01-25 11:58:40'),
(8, 8, 'Nina', 4.4, 'Chillax Sudirman nyaman untuk makan sambil santai', '2025-01-25 11:58:40'),
(9, 9, 'Kiki', 4.6, 'Kawasan Kemang punya banyak pilihan restoran dengan suasana nyaman', '2025-01-25 11:58:40'),
(10, 10, 'Oscar', 4.5, 'The Wave Pondok Indah sangat menyenangkan, banyak wahana air', '2025-01-25 11:58:40');

--
-- Trigger `ulasan`
--
DELIMITER $$
CREATE TRIGGER `update_rating` AFTER INSERT ON `ulasan` FOR EACH ROW BEGIN
    UPDATE wisata
    SET rating = (SELECT AVG(rating) FROM ulasan WHERE id_wisata = NEW.id_wisata)
    WHERE id = NEW.id_wisata;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisata`
--

CREATE TABLE `wisata` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `lat` decimal(10,6) DEFAULT NULL,
  `lng` decimal(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `wisata`
--

INSERT INTO `wisata` (`id`, `nama`, `kategori`, `deskripsi`, `lokasi`, `rating`, `foto`, `lat`, `lng`) VALUES
(1, 'Tebet Eco Park', 'Wisata Alam', 'Taman seluas 7,3 hektar yang menawarkan berbagai fasilitas', 'Tebet, Jakarta Selatan', 5.0, 'tebet_park.jpeg', -6.230800, 106.852000),
(2, 'Kebun Binatang Ragunan', 'Wisata Alam', 'Kebun binatang terbesar di Asia Tenggara dengan koleksi satwa yang beragam', 'Ragunan, Jakarta Selatan', 4.7, 'ragunan_zoo.jpg', -6.323200, 106.838000),
(3, 'Setu Babakan', 'Wisata Alam', 'Perkampungan Budaya Betawi yang memiliki danau dan fasilitas wisata', 'Jagakarsa, Jakarta Selatan', 4.5, 'setu_babakan.jpg', -6.319900, 106.860000),
(4, 'M Bloc Space', 'Wisata Belanja', 'Kawasan kreatif yang menawarkan berbagai restoran dan hiburan', 'Blok M, Jakarta Selatan', 4.4, 'mbloc_space.jpg', -6.228200, 106.789000),
(5, 'Kota Kasablanka', 'Wisata Belanja', 'Pusat perbelanjaan dengan berbagai merek ternama dan fasilitas hiburan', 'Casablanca, Jakarta Selatan', 4.5, 'kotakasablanka.jpg', -6.246800, 106.853000),
(6, 'Cilandak Town Square (Citos)', 'Wisata Belanja', 'Mall dengan berbagai pilihan belanja, kuliner, dan hiburan', 'Cilandak, Jakarta Selatan', 4.4, 'citostownsquare.jpg', -6.296400, 106.806000),
(7, 'Kampung Main Cipulir', 'Wisata Kuliner', 'Tempat wisata keluarga dengan banyak makanan enak', 'Cipulir, Jakarta Selatan', 4.3, 'kampungmain_cipulir.jpg', -6.235400, 106.808000),
(8, 'Chillax Sudirman', 'Wisata Kuliner', 'Area komersial dengan berbagai tenant makanan dan minuman', 'Sudirman, Jakarta Selatan', 4.4, 'chillax_sudirman.jpeg', -6.228500, 106.810000),
(9, 'Kawasan Kemang', 'Wisata Kuliner', 'Area dengan berbagai pilihan restoran dan cafe', 'Kemang, Jakarta Selatan', 4.6, 'kemang_area.jpg', -6.290400, 106.801000),
(10, 'The Wave Pondok Indah Water Park', 'Wisata Hiburan', 'Taman bermain air dengan berbagai wahana seru untuk keluarga', 'Pondok Indah, Jakarta Selatan', 4.5, 'pondok_indah_waterpark.jpg', -6.261400, 106.787000),
(11, 'SuperPark Indonesia', 'Wisata Hiburan', 'Taman bermain indoor dengan berbagai wahana untuk anak-anak', 'Sudirman, Jakarta Selatan', 4.3, 'superpark_indonesia.webp', -6.232200, 106.822000),
(12, 'Skywalk Senayan Park', 'Wisata Hiburan', 'Jembatan jalan kaki dengan pemandangan kota yang indah', 'Senayan, Jakarta Selatan', 4.4, 'skywalk_senayan.jpg', -6.228700, 106.796000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_wisata` (`id_wisata`);

--
-- Indeks untuk tabel `wisata`
--
ALTER TABLE `wisata`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `wisata`
--
ALTER TABLE `wisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`id_wisata`) REFERENCES `wisata` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
