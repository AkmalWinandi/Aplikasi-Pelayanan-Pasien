-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2024 at 03:58 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `martharopi`
--

-- --------------------------------------------------------

--
-- Table structure for table `berobat`
--

CREATE TABLE `berobat` (
  `id` int(11) NOT NULL,
  `tindakan` varchar(50) NOT NULL,
  `harga` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `berobat`
--

INSERT INTO `berobat` (`id`, `tindakan`, `harga`) VALUES
(1, 'cek kandungan', 15000),
(2, 'cek gigi', 12000),
(3, 'cek gula', 20000),
(4, 'cek rambut', 25000),
(8, 'cek gula darah', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `data_pasien`
--

CREATE TABLE `data_pasien` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `nik` char(16) NOT NULL,
  `id_pasien` varchar(15) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(12) NOT NULL,
  `agama` varchar(15) NOT NULL,
  `pekerjaan` varchar(20) NOT NULL,
  `notelp` char(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_pasien`
--

INSERT INTO `data_pasien` (`id`, `nama_lengkap`, `nik`, `id_pasien`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `pekerjaan`, `notelp`) VALUES
(14, 'Akmal Winandi', '12233333', 'PUSK00001', '2024-02-06', 'laki-laki', 'Islam', 'programmer', '087742365435'),
(15, 'david', '363636772', 'PUSK00002', '2024-02-14', 'perempuan', 'Islam', 'programmer', '087742365435'),
(16, 'Martha', '7373882', 'PUSK00003', '2001-08-07', 'laki-laki', 'Katolik', 'Mahasiswa', '087742365435'),
(17, 'Yusuf', '9992773', 'PUSK00004', '2001-06-01', 'laki-laki', 'Kristen', 'Swasta', '085251730363'),
(24, 'Muhammad Reza', '98007654321', 'PUSK00005', '2024-04-01', 'laki-laki', 'Islam', 'Mahasiswa', '087742365435'),
(25, 'Ikbal', '234567890', 'PUSK00006', '2024-04-09', 'laki-laki', 'Kristen', 'Mahasiswa', '086758493848');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `kode_pembayaran` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_pasien` varchar(20) NOT NULL,
  `tindakan` varchar(100) NOT NULL,
  `jenis_rawat` varchar(15) NOT NULL,
  `total` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `kode_pembayaran`, `tanggal`, `nama_pasien`, `tindakan`, `jenis_rawat`, `total`) VALUES
(23, 'BYR00003', '2024-02-20', 'Martha', 'cek mata', 'jalan', 15000),
(24, 'BYR00004', '2024-02-20', 'Yusuf', 'cek gula,cek gigi', 'Jalan', 32000),
(25, 'BYR00006', '2024-02-20', 'david', 'cek gigi,cek gula', 'inap', 32000),
(29, 'BYR00008', '2024-02-20', 'Banghaji', 'cek mata,cek gigi,cek gula', 'jalan', 47000),
(31, 'BYR00005', '2024-02-21', 'Akmal Winandi', 'cek mata', 'inap', 15000),
(33, 'BYR00010', '2024-02-22', 'Yusuf', 'cek mata,cek gigi,cek gula,cek rambut', 'inap', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `kunjungan` varchar(5) NOT NULL,
  `umum_bpjs` varchar(10) NOT NULL,
  `poli` varchar(20) NOT NULL,
  `tindakan` varchar(50) NOT NULL,
  `total` int(20) NOT NULL,
  `riwayat` varchar(50) NOT NULL,
  `id_pasien` varchar(20) NOT NULL,
  `kode_pembayaran` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `tanggal`, `nama_lengkap`, `kunjungan`, `umum_bpjs`, `poli`, `tindakan`, `total`, `riwayat`, `id_pasien`, `kode_pembayaran`) VALUES
(15, '2024-02-20', 'david', 'l', 'umum', 'poli umum', 'cek gigi,cek gula', 32000, 'diabetes', 'PUSK00002', 'BYR00006'),
(17, '2024-02-20', 'Banghaji', 'kk', 'bpjs', 'poli gigi', 'cek gigi', 12000, 'Tes', 'PUSK00005', 'BYR00007'),
(18, '2024-02-20', 'Banghaji', 'l', 'umum', 'poli umum', 'cek mata,cek gigi,cek gula', 47000, 'qwerty', 'PUSK00005', 'BYR00008'),
(19, '2024-02-20', 'david', 'l', 'bpjs', 'poli gizi/imun', 'cek gigi', 0, 'yuuu', 'PUSK00002', 'BYR00009'),
(22, '2024-02-22', 'Yusuf', 'b', 'umum', 'poli umum', 'cek mata,cek gigi,cek gula,cek rambut', 72000, 'paru-paru', 'PUSK00004', 'BYR00010'),
(23, '2024-02-18', 'david', 'b', 'umum', 'poli umum', 'cek gigi,cek gula,cek rambut', 57000, 'wwww', 'PUSK00002', 'BYR00011'),
(24, '2024-02-18', 'Akmal Winandi', 'b', 'umum', 'poli gigi', 'cek gigi', 24000, 'sakit gigi', 'PUSK00001', 'BYR00012');

-- --------------------------------------------------------

--
-- Table structure for table `surat_keterangan_kematian`
--

CREATE TABLE `surat_keterangan_kematian` (
  `id` int(11) NOT NULL,
  `nomor_surat` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_dokter` varchar(30) NOT NULL,
  `nip` char(20) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `alamat_dokter` varchar(50) NOT NULL,
  `nama_pasien` varchar(30) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL,
  `desa` varchar(50) NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat_keterangan_kematian`
--

INSERT INTO `surat_keterangan_kematian` (`id`, `nomor_surat`, `tanggal`, `nama_dokter`, `nip`, `jabatan`, `alamat_dokter`, `nama_pasien`, `jenis_kelamin`, `desa`, `keterangan`) VALUES
(1, '86 / YANKES-1/ 04 - 2023', '2024-02-11', 'dr. TEGAR GEMILANG WATARI', '1199331218 2022 03', 'Penata Muda TK.I III / b', 'Dokter Puskesmas Tabak Kanilan', 'KUSMUDIANO', 'laki-laki', 'Desa Ruhing Raya Rt 03 Rw 01', 'Telah meninngal dunia pada hari Rabu Tanggal 28 Oktober 2020 Pada Pukul 11.40 WIB Dengan Diagnosa : TB Paru + Effusi Pleuera'),
(2, '86 / YANKES-1/ 04 - 2024', '2024-02-20', 'dr. TEGAR GEMILANG WATARI', '199331218 2022 03 1', 'Dokter Puskesmas Tabak Kanilan', 'Tabak Kanilan', 'Lapindo', 'laki-laki', 'Tabak Kanilan', 'Telah meninngal dunia pada hari Rabu Tanggal 28 Oktober 2020 Pada Pukul 11 WIB Dengan Diagnosa : kanker');

-- --------------------------------------------------------

--
-- Table structure for table `surat_keterangan_sakit`
--

CREATE TABLE `surat_keterangan_sakit` (
  `id` int(11) NOT NULL,
  `nomor_surat` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_dokter` varchar(30) NOT NULL,
  `nip` char(20) NOT NULL,
  `jabatan` varchar(30) NOT NULL,
  `alamat_dokter` varchar(30) NOT NULL,
  `nama_pasien` varchar(30) NOT NULL,
  `nik` char(16) NOT NULL,
  `umur` int(3) NOT NULL,
  `jenis_kelamin` varchar(11) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `alamat_pasien` varchar(50) NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat_keterangan_sakit`
--

INSERT INTO `surat_keterangan_sakit` (`id`, `nomor_surat`, `tanggal`, `nama_dokter`, `nip`, `jabatan`, `alamat_dokter`, `nama_pasien`, `nik`, `umur`, `jenis_kelamin`, `pekerjaan`, `alamat_pasien`, `keterangan`) VALUES
(2, '86 / YANKES-1/ 04 - 2023', '2024-02-06', 'dr. TEGAR GEMILANG WATARI', '199331218 2022 03 1', 'Dokter Puskesmas Tabak Kanilan', 'Tabak Kanilan', 'DIAN IRIANTO', '877798', 43, 'laki-laki', 'Swasta', 'Tabak Kanilan Kec. Gunung Bintang Awai', 'Sehubungan dengan sakit yang di derita dengan diagnosa HT+  Febris maka pasien tidak bisa bekerja seperti biasa selama 2 (dua) hari pada tanggal 07 S/D 08 Desember 2023'),
(3, '86 / YANKES-1/ 04 - 2024', '2024-02-20', 'dr. TEGAR GEMILANG WATARI', '199331218 2022 03 1', 'Dokter Puskesmas Tabak Kanilan', 'Tabak Kanilan', 'Martha Ropi Delitha', '879899765', 22, 'perempuan', 'Mahasiswa', 'Tabak Kanilan Kec. Gunung Bintang Awai', 'Izin Sakit'),
(4, '86 / YANKES-1/ 04 - 2024', '2024-04-08', 'dr. TEGAR GEMILANG WATARI', '199331218 2022 03 1', 'Dokter Puskesmas Tabak Kanilan', 'Tabak Kanilan', 'William', '1234543256785678', 23, 'laki-laki', 'programmer', 'Tabak Kanilan Kec. Gunung Bintang Awai', 'Galau Karna Wanita');

-- --------------------------------------------------------

--
-- Table structure for table `surat_keterangan_sehat`
--

CREATE TABLE `surat_keterangan_sehat` (
  `id` int(11) NOT NULL,
  `nomor_surat` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_dokter` varchar(50) NOT NULL,
  `nip` char(17) NOT NULL,
  `pangkat_gol` varchar(50) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `alamat_dokter` varchar(50) NOT NULL,
  `nama_pasien` varchar(30) NOT NULL,
  `nik` char(16) NOT NULL,
  `umur` int(3) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `agama` varchar(10) NOT NULL,
  `alamat_pasien` varchar(50) NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `tinggi_badan` varchar(10) NOT NULL,
  `berat_badan` varchar(10) NOT NULL,
  `tekanan_darah` varchar(10) NOT NULL,
  `golongan_darah` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat_keterangan_sehat`
--

INSERT INTO `surat_keterangan_sehat` (`id`, `nomor_surat`, `tanggal`, `nama_dokter`, `nip`, `pangkat_gol`, `jabatan`, `alamat_dokter`, `nama_pasien`, `nik`, `umur`, `jenis_kelamin`, `agama`, `alamat_pasien`, `keperluan`, `tinggi_badan`, `berat_badan`, `tekanan_darah`, `golongan_darah`) VALUES
(4, '86 / YANKES-1/ 04 - 2023', '2024-02-10', 'dr. TEGAR GEMILANG WATARI', '199331218 2022 03', 'Penata Muda TK.I III / b', 'Dokter Puskesmas Tabak Kanilan', 'Tabak Kanilan', 'ARCILYA CRISTIANI', '12345', 18, 'Perempuan', 'katolik', 'Tabak Kanilan Kec. Gunug Bintang Awai', 'Untuk Melengkapi  Persyaratan Melanjutkan Ke Perguruan Tinggi', '156 cm', '47 kg', '110 / 80 m', 'B'),
(5, '86 / YANKES-1/ 04 - 2024', '2024-02-20', 'dr. TEGAR GEMILANG WATARI', '199331218 2022 03', 'Penata Muda TK.I III / b', 'Dokter Puskesmas Tabak Kanilan', 'Tabak Kanilan', 'Martha Ropi Delitha', '54321', 22, 'perempuan', 'katolik', 'Palangkaraya', 'Untuk Beasiswa', '154 cm', '47 kg', '110 / 80 m', 'C'),
(7, '86 / YANKES-1/ 04 - 2024', '2024-04-17', 'tesar', '199331218 2022 03', 'Penata Muda TK.I III / b', 'Dokter Puskesmas Tabak Kanilan', 'tabak kanilan', 'Banghaji 23', '12345477', 43, 'laki-laki', 'islam', 'uuuuyy', 'hhhhhhhhh mnkon iiii', '156 cm', '47 kg', '110 / 80 m', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(20) NOT NULL,
  `login_session_key` varchar(255) DEFAULT NULL,
  `email_status` varchar(255) DEFAULT NULL,
  `password_expire_date` datetime DEFAULT '2024-04-29 00:00:00',
  `password_reset_key` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `login_session_key`, `email_status`, `password_expire_date`, `password_reset_key`) VALUES
(9, 'admin', '$2y$10$uBAm6Z8U/0Dbua551Fdt3OXbPYbeEnEk40Sc/OzseaFi5wRzIGpTO', 'winandy00@gmail.com', NULL, NULL, '2024-04-29 00:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berobat`
--
ALTER TABLE `berobat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_pasien`
--
ALTER TABLE `data_pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_keterangan_kematian`
--
ALTER TABLE `surat_keterangan_kematian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_keterangan_sakit`
--
ALTER TABLE `surat_keterangan_sakit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_keterangan_sehat`
--
ALTER TABLE `surat_keterangan_sehat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berobat`
--
ALTER TABLE `berobat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `data_pasien`
--
ALTER TABLE `data_pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `surat_keterangan_kematian`
--
ALTER TABLE `surat_keterangan_kematian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `surat_keterangan_sakit`
--
ALTER TABLE `surat_keterangan_sakit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `surat_keterangan_sehat`
--
ALTER TABLE `surat_keterangan_sehat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
