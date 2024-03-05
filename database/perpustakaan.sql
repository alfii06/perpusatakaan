-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Feb 2024 pada 23.58
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `BukuID` int(11) NOT NULL,
  `Judul` varchar(255) DEFAULT NULL,
  `Penulis` varchar(255) DEFAULT NULL,
  `Penerbit` varchar(255) DEFAULT NULL,
  `TahunTerbit` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`BukuID`, `Judul`, `Penulis`, `Penerbit`, `TahunTerbit`, `gambar`) VALUES
(15, 'Panduan Praktis bagi Guru', 'surya', 'bayu mahardika', 2021, '../upload_foto/20240220211811_guru2.jpg'),
(16, 'Pemikiran Kritis dalam Pendidikan', 'raga', 'satria', 2003, '../upload_foto/20240220212042_kritis.jpg'),
(17, 'Laskar Pelangi', 'tika', 'yustin', 1999, '../upload_foto/20240220212258_laskar.jpg'),
(18, 'Sang Pemimpi', 'niko', 'kasira', 1889, '../upload_foto/20240220212425_pemimpi.jpg'),
(19, 'Perahu Kertas', 'bambang', 'abdul', 2000, '../upload_foto/20240220212531_kertas.jpg'),
(20, 'Attack on Titan', 'bambang', 'siro', 1999, '../upload_foto/20240220212656_titan.jfif'),
(21, 'One Piece', 'rizal', 'febri', 2000, '../upload_foto/20240220212816_pice.jpg'),
(22, 'Dragon Ball', 'bara', 'sinta', 2023, '../upload_foto/20240220213035_dg.jpg'),
(23, 'Death Note', 'Tsugumi Ohba', ' Takeshi Obata', 1999, '../upload_foto/20240220213208_dn.jpg'),
(24, 'Pembelajaran Kolaboratif', 'Rini Hartini', 'intan', 1997, '../upload_foto/20240220213435_d.jpg'),
(26, 'Tantangan Pembelajaran Jarak Jauh', 'tika', 'salwa', 1998, '../upload_foto/20240220214032_x.jfif'),
(27, 'Tokyo Ghoul', 'irkham', 'wahyu', 1887, '../upload_foto/20240220214140_xx.jfif'),
(28, 'Negeri 5 Menara', 'ahmad', 'fuadi', 1887, '../upload_foto/20240220214403_hh.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoribuku`
--

CREATE TABLE `kategoribuku` (
  `KategoriID` int(11) NOT NULL,
  `NamaKategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategoribuku`
--

INSERT INTO `kategoribuku` (`KategoriID`, `NamaKategori`) VALUES
(1, 'Manga'),
(2, 'Novel'),
(3, 'Pendidikan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoribuku_relasi`
--

CREATE TABLE `kategoribuku_relasi` (
  `KategoriBukuID` int(11) NOT NULL,
  `BukuID` int(11) DEFAULT NULL,
  `KategoriID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategoribuku_relasi`
--

INSERT INTO `kategoribuku_relasi` (`KategoriBukuID`, `BukuID`, `KategoriID`) VALUES
(19, 15, 3),
(20, 16, 3),
(21, 17, 2),
(22, 18, 2),
(23, 19, 2),
(24, 20, 1),
(25, 21, 1),
(26, 22, 1),
(27, 23, 1),
(28, 24, 3),
(30, 26, 3),
(31, 27, 1),
(32, 28, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `koleksipribadi`
--

CREATE TABLE `koleksipribadi` (
  `KoleksiID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `BukuID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `koleksipribadi`
--

INSERT INTO `koleksipribadi` (`KoleksiID`, `UserID`, `BukuID`) VALUES
(7, 9, 18),
(8, 9, 15),
(9, 5, 17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `PeminjamanID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `BukuID` int(11) DEFAULT NULL,
  `TanggalPeminjaman` date DEFAULT NULL,
  `TanggalPengembalian` date DEFAULT NULL,
  `StatusPeminjaman` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`PeminjamanID`, `UserID`, `BukuID`, `TanggalPeminjaman`, `TanggalPengembalian`, `StatusPeminjaman`) VALUES
(13, 5, 20, '0000-00-00', '2024-02-22', 'Dikembalikan'),
(14, 5, 21, '2024-01-31', '2024-03-02', 'Dikembalikan'),
(15, 5, 18, '2024-02-21', '2024-02-23', 'Dipinjam'),
(16, 9, 22, '2024-02-21', '2024-02-29', 'Dikembalikan'),
(17, 9, 15, '2024-02-21', '2024-02-29', 'Dikembalikan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasanbuku`
--

CREATE TABLE `ulasanbuku` (
  `UlasanID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `BukuID` int(11) DEFAULT NULL,
  `Ulasan` text DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ulasanbuku`
--

INSERT INTO `ulasanbuku` (`UlasanID`, `UserID`, `BukuID`, `Ulasan`, `Rating`) VALUES
(8, 7, 17, 'sebuah karya sastra yang menggugah dan menginspirasi, mengisahkan tentang perjuangan sekelompok anak-anak muda di desa kecil Belitong dalam mengejar impian mereka untuk mendapatkan pendidikan yang layak.', 4),
(9, 9, 15, 'sebuah buku yang sangat berharga bagi para pendidik. Dengan penekanan pada aplikasi praktis, buku ini', 2),
(10, 9, 16, 'sebuah karya yang menggugah pemikiran dan memberikan wawasan mendalam tentang pentingnya mengembangkan keterampilan pemikiran kritis di dalam konteks pendidikan.', 5),
(11, 5, 17, 'Rating untuk buku \"Laskar Pelangi\" adalah 5.0. Buku ini sangat terkenal dan mendapat banyak ulasan positif dari pembaca', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `NamaLengkap` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userID`, `Username`, `Password`, `Email`, `NamaLengkap`, `alamat`) VALUES
(5, 'derrel', '12345678', 'derrel@gmail.com', 'derrel septiawan', 'Sidoarjo, Jawa Timur'),
(6, 'petugas', '12345678', 'petugas@gmail.com', 'Petugas Ayo Membaca', 'Sidoarjo, Jawa Timur'),
(7, 'admin', '12345678', 'admin@gmail.com', 'Admin Ayo Membaca', 'Sidoarjo, Jawa Timur'),
(8, 'radit', 'sawocangkring', 'yustinamalia22@gmail.com', 'DAVANO ALIF RAMADHAN', 'sawocangkring,wonoayu'),
(9, 'dika', '12345678', 'tim4@gmail.com', 'dika bayundra', 'surabaya mer');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`BukuID`);

--
-- Indeks untuk tabel `kategoribuku`
--
ALTER TABLE `kategoribuku`
  ADD PRIMARY KEY (`KategoriID`);

--
-- Indeks untuk tabel `kategoribuku_relasi`
--
ALTER TABLE `kategoribuku_relasi`
  ADD PRIMARY KEY (`KategoriBukuID`),
  ADD KEY `BukuID` (`BukuID`),
  ADD KEY `KategoriID` (`KategoriID`);

--
-- Indeks untuk tabel `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  ADD PRIMARY KEY (`KoleksiID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `BukuID` (`BukuID`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`PeminjamanID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `BukuID` (`BukuID`);

--
-- Indeks untuk tabel `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  ADD PRIMARY KEY (`UlasanID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `BukuID` (`BukuID`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `BukuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `kategoribuku`
--
ALTER TABLE `kategoribuku`
  MODIFY `KategoriID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kategoribuku_relasi`
--
ALTER TABLE `kategoribuku_relasi`
  MODIFY `KategoriBukuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  MODIFY `KoleksiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `PeminjamanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  MODIFY `UlasanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kategoribuku_relasi`
--
ALTER TABLE `kategoribuku_relasi`
  ADD CONSTRAINT `kategoribuku_relasi_ibfk_1` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`),
  ADD CONSTRAINT `kategoribuku_relasi_ibfk_2` FOREIGN KEY (`KategoriID`) REFERENCES `kategoribuku` (`KategoriID`);

--
-- Ketidakleluasaan untuk tabel `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  ADD CONSTRAINT `koleksipribadi_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `koleksipribadi_ibfk_2` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`);

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`);

--
-- Ketidakleluasaan untuk tabel `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  ADD CONSTRAINT `ulasanbuku_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `ulasanbuku_ibfk_2` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
