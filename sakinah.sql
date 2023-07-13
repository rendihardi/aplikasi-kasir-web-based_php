-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2023 at 06:07 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sakinah`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `ID_BARANG` varchar(10) NOT NULL,
  `ID_KATEGORI` varchar(10) NOT NULL,
  `NAMA_BARANG` varchar(100) NOT NULL,
  `HARGA` int(11) NOT NULL,
  `STOK` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`ID_BARANG`, `ID_KATEGORI`, `NAMA_BARANG`, `HARGA`, `STOK`) VALUES
('BRG003', 'KG002', 'Racik', 13000, 71),
('BRG004', 'KG001', 'Kapalapi ABC', 11000, 40);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `ID_BARANG` varchar(10) NOT NULL,
  `ID_TRANSAKSI` varchar(10) NOT NULL,
  `HARGA_SATUAN` int(11) NOT NULL,
  `KUANTITAS` int(11) NOT NULL,
  `SUB_TOTAL` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`ID_BARANG`, `ID_TRANSAKSI`, `HARGA_SATUAN`, `KUANTITAS`, `SUB_TOTAL`) VALUES
('BRG003', 'TRS001', 13000, 5, 65000),
('BRG003', 'TRS005', 13000, 4, 52000),
('BRG004', 'TRS001', 11000, 4, 44000),
('BRG004', 'TRS002', 11000, 6, 66000),
('BRG004', 'TRS003', 11000, 4, 44000);

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `ID_JABATAN` varchar(10) NOT NULL,
  `NAMA_JABATAN` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`ID_JABATAN`, `NAMA_JABATAN`) VALUES
('JB001', 'Admin'),
('JB002', 'Kasir'),
('JB003', 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `ID_KATEGORI` varchar(10) NOT NULL,
  `NAMA_KATEGORI` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_barang`
--

INSERT INTO `kategori_barang` (`ID_KATEGORI`, `NAMA_KATEGORI`) VALUES
('KG001', 'Makanan'),
('KG002', 'Bumbu');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `ID_PEGAWAI` varchar(10) NOT NULL,
  `ID_JABATAN` varchar(10) NOT NULL,
  `NAMA_PEGAWAI` varchar(100) NOT NULL,
  `NOTELP_PEGAWAI` varchar(15) NOT NULL,
  `ALAMAT_PEGAWAI` varchar(100) NOT NULL,
  `USERNAME` varchar(20) NOT NULL,
  `PASSWORD` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`ID_PEGAWAI`, `ID_JABATAN`, `NAMA_PEGAWAI`, `NOTELP_PEGAWAI`, `ALAMAT_PEGAWAI`, `USERNAME`, `PASSWORD`) VALUES
('PG001', 'JB003', 'Admin', 'HAHAHA', '08121982112', 'manager', '123'),
('PG002', 'JB002', 'iniKasir', 'HAHAHA', '08121982112', 'kasir', '123'),
('PG003', 'JB001', 'iniAdmin', 'AHAHA', '08121982112', 'admin', '123'),
('PG004', 'JB001', 'Budi sol fa mi', 'beijing', '087584738473', 'nyoba', '123');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `ID_PELANGGAN` varchar(10) NOT NULL,
  `NAMA_PELANGGAN` varchar(100) NOT NULL,
  `NOTELP_PELANGGAN` varchar(15) NOT NULL,
  `ALAMAT` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`ID_PELANGGAN`, `NAMA_PELANGGAN`, `NOTELP_PELANGGAN`, `ALAMAT`) VALUES
('MBR001', 'Salwa', '21231231', 'gresik'),
('MBR002', 'Salama', '21231231', 'rungkut'),
('MBR003', 'zidan', '085787463526', 'jombang'),
('MBR004', 'budianto', '085674635264', 'jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `ID_TRANSAKSI` varchar(10) NOT NULL,
  `ID_PEGAWAI` varchar(10) NOT NULL,
  `ID_PELANGGAN` varchar(10) NOT NULL,
  `TANGGAL` datetime NOT NULL,
  `DISKON` float NOT NULL,
  `TOTAL` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`ID_TRANSAKSI`, `ID_PEGAWAI`, `ID_PELANGGAN`, `TANGGAL`, `DISKON`, `TOTAL`) VALUES
('TRS001', 'PG002', 'MBR002', '2023-06-15 07:02:44', 5450, 103550),
('TRS002', 'PG002', '', '2023-06-15 13:55:11', 2600, 66000),
('TRS003', 'PG002', '', '2023-06-15 14:34:44', 2800, 44000),
('TRS004', 'PG002', '', '2023-06-15 14:35:18', 2800, 12000),
('TRS005', 'PG002', '', '2023-06-15 14:36:03', 0, 52000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`ID_BARANG`),
  ADD KEY `FK_MEMPUNYAI` (`ID_KATEGORI`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`ID_BARANG`,`ID_TRANSAKSI`),
  ADD KEY `FK_PUNYA2` (`ID_TRANSAKSI`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`ID_JABATAN`);

--
-- Indexes for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`ID_KATEGORI`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`ID_PEGAWAI`),
  ADD KEY `FK_MEMILIKI` (`ID_JABATAN`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`ID_PELANGGAN`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`ID_TRANSAKSI`),
  ADD KEY `FK_MELAKUKAN` (`ID_PELANGGAN`),
  ADD KEY `FK_MELAYANI` (`ID_PEGAWAI`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `FK_MEMPUNYAI` FOREIGN KEY (`ID_KATEGORI`) REFERENCES `kategori_barang` (`ID_KATEGORI`);

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `FK_PUNYA` FOREIGN KEY (`ID_BARANG`) REFERENCES `barang` (`ID_BARANG`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`ID_TRANSAKSI`) REFERENCES `transaksi` (`ID_TRANSAKSI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `FK_MEMILIKI` FOREIGN KEY (`ID_JABATAN`) REFERENCES `jabatan` (`ID_JABATAN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `FK_MELAYANI` FOREIGN KEY (`ID_PEGAWAI`) REFERENCES `pegawai` (`ID_PEGAWAI`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
