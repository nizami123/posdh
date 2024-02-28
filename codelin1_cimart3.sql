-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 28 Nov 2023 pada 08.45
-- Versi server: 10.5.22-MariaDB-cll-lve
-- Versi PHP: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codelin1_cimart3`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(30) NOT NULL,
  `email_admin` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `level` enum('Owner','Admin','Kasir','Teknisi') NOT NULL,
  `foto` varchar(20) NOT NULL,
  `id_toko` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `nama_admin`, `email_admin`, `password`, `level`, `foto`, `id_toko`) VALUES
(1, 'Septian wahyudi Rahman', 'Admin', '123', 'Owner', '1683668783.jpg', 1),
(13, 'imran', 'imran@gmail.com', 'Kasir', 'Kasir', '', 1),
(15, 'Kasir', 'Kasir', 'Kasir', 'Kasir', '', 1),
(16, 'coba kasir', 'coba kasir', 'cobakasir', 'Kasir', '', 1),
(18, 'Ariyan', 'aricoba@gmail.com', '123456', 'Kasir', '', 3),
(19, 'budi', 'budi@kasir.com', 'budi', 'Kasir', '', 1),
(22, 'BAYU [ Mampang ]', 'test@gmail.com', '123', 'Kasir', '', 4),
(23, 'adul', 'adul@gmail.com', 'adul', 'Kasir', '', 3),
(24, 'Amin', 'amien@cimart.xom', 'Admin', 'Admin', '', 1),
(25, 'Ari', 'ari@cimart.com', '123456', 'Kasir', '', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_akses_menu`
--

CREATE TABLE `tb_akses_menu` (
  `id_akses` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `level` enum('Owner','Admin','Kasir','Reseller') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_akses_menu`
--

INSERT INTO `tb_akses_menu` (`id_akses`, `id_menu`, `level`) VALUES
(1, 1, 'Owner'),
(3, 1, 'Kasir'),
(4, 1, 'Reseller'),
(5, 2, 'Owner'),
(6, 2, 'Admin'),
(7, 2, 'Kasir'),
(8, 3, 'Owner'),
(9, 3, 'Kasir'),
(10, 4, 'Owner'),
(11, 4, 'Kasir'),
(14, 6, 'Owner'),
(15, 6, 'Admin'),
(16, 6, 'Kasir'),
(17, 6, 'Reseller'),
(19, 8, 'Owner'),
(20, 9, 'Owner'),
(21, 10, 'Owner'),
(22, 10, 'Admin'),
(23, 10, 'Kasir'),
(24, 11, 'Owner'),
(25, 11, 'Admin'),
(26, 12, 'Owner'),
(27, 12, 'Admin'),
(28, 13, 'Owner'),
(29, 13, 'Admin'),
(30, 14, 'Owner'),
(31, 14, 'Admin'),
(32, 15, 'Owner'),
(33, 15, 'Admin'),
(34, 16, 'Owner'),
(35, 16, 'Admin'),
(36, 17, 'Owner'),
(38, 19, 'Owner'),
(39, 20, 'Owner'),
(40, 20, 'Admin'),
(41, 21, 'Owner'),
(42, 21, 'Admin'),
(43, 22, 'Owner'),
(44, 22, 'Admin'),
(45, 23, 'Owner'),
(46, 23, 'Admin'),
(47, 24, 'Owner'),
(48, 24, 'Admin'),
(49, 25, 'Owner'),
(50, 25, 'Kasir'),
(51, 26, 'Owner'),
(52, 27, 'Owner'),
(53, 28, 'Owner'),
(54, 28, 'Kasir'),
(59, 29, 'Owner'),
(61, 31, 'Owner'),
(62, 32, 'Owner'),
(63, 27, 'Kasir'),
(64, 31, 'Kasir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id_brg` int(11) NOT NULL,
  `kode_brg` varchar(20) NOT NULL,
  `nama_brg` varchar(100) NOT NULL,
  `stok_tersedia` int(5) NOT NULL,
  `satuan` varchar(30) DEFAULT NULL,
  `harga_modal` int(11) NOT NULL,
  `harga_eceran` int(11) NOT NULL,
  `is_grosir` int(1) NOT NULL DEFAULT 0,
  `is_retur` int(1) NOT NULL DEFAULT 0,
  `kategori` varchar(30) DEFAULT NULL,
  `id_toko` int(11) NOT NULL,
  `tgl_exp` varchar(20) DEFAULT NULL,
  `etalase` varchar(30) DEFAULT NULL,
  `supplier_brg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_barang`
--

INSERT INTO `tb_barang` (`id_brg`, `kode_brg`, `nama_brg`, `stok_tersedia`, `satuan`, `harga_modal`, `harga_eceran`, `is_grosir`, `is_retur`, `kategori`, `id_toko`, `tgl_exp`, `etalase`, `supplier_brg`) VALUES
(9, '2275270623', 'LEM', 6, 'Pcs', 1000, 5000, 0, 0, '1', 4, '2023-06-27', '', 1),
(10, '3555280623', 'GULA', 99, 'Pcs', 5000, 8000, 0, 1, '1', 1, '', '1', 1),
(11, '3110260723', 'xxx', 0, 'Pcs', 100, 150, 0, 1, '1', 3, '', '', 0),
(13, '1679260723', 'yyy', 3, '', 20, 60, 0, 1, '', 3, '', '', 0),
(14, '5364280723', 'Buku IPAS', 84, 'Pcs', 50000, 55000, 0, 1, '1', 3, '2023-10-31', '', 1),
(15, '5083280723', 'Buku MTK', 86, '', 20000, 25000, 0, 0, '', 3, '', '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_brg_keluar`
--

CREATE TABLE `tb_brg_keluar` (
  `id_keluar` int(11) NOT NULL,
  `kode_keluar` varchar(20) NOT NULL,
  `kode_brg` varchar(20) NOT NULL,
  `stok_keluar` int(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_brg_keluar`
--

INSERT INTO `tb_brg_keluar` (`id_keluar`, `kode_keluar`, `kode_brg`, `stok_keluar`, `keterangan`) VALUES
(1, 'BRGK072340001', '2275270623', 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_brg_masuk`
--

CREATE TABLE `tb_brg_masuk` (
  `id_masuk` int(11) NOT NULL,
  `kode_masuk` varchar(20) NOT NULL,
  `kode_brg` varchar(20) NOT NULL,
  `stok_masuk` int(5) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_brg_masuk`
--

INSERT INTO `tb_brg_masuk` (`id_masuk`, `kode_masuk`, `kode_brg`, `stok_masuk`, `harga_beli`, `id_supplier`, `keterangan`) VALUES
(1, 'BRGM072340001', '2275270623', 10, 10000, 1, ''),
(2, 'BRGM072340002', '2275270623', 5, 5000, 1, ''),
(3, 'BRGM072330001', '3110260723', 10, 1000, 1, ''),
(4, 'BRGM072330002', '3110260723', 1, 100, 1, ''),
(5, 'BRGM072330003', '1679260723', 10, 200, 1, ''),
(6, 'BRGM082310001', '3555280623', 100, 500000, 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_conf`
--

CREATE TABLE `tb_conf` (
  `logo` varchar(11) NOT NULL,
  `jml_min_brg` int(2) NOT NULL,
  `ukuran_kertas` varchar(12) NOT NULL,
  `jenis_kertas` varchar(10) NOT NULL,
  `jenis_kertas_struk` enum('Termal','HVS') NOT NULL DEFAULT 'Termal',
  `expired` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_conf`
--

INSERT INTO `tb_conf` (`logo`, `jml_min_brg`, `ukuran_kertas`, `jenis_kertas`, `jenis_kertas_struk`, `expired`) VALUES
('logo.png', 10, '58', 'HVS', 'HVS', 14);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_data_retur`
--

CREATE TABLE `tb_data_retur` (
  `id_retur` int(11) NOT NULL,
  `kode_transaksi` int(15) NOT NULL,
  `kode_brg` varchar(20) NOT NULL,
  `jml` int(4) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `tgl_retur` datetime NOT NULL DEFAULT current_timestamp(),
  `id_admin` varchar(12) NOT NULL,
  `jenis_retur` enum('ganti','refund') NOT NULL,
  `uang_kembali` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_brgk`
--

CREATE TABLE `tb_detail_brgk` (
  `kode_keluar` varchar(20) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `tgl_keluar` datetime NOT NULL DEFAULT current_timestamp(),
  `id_toko` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_detail_brgk`
--

INSERT INTO `tb_detail_brgk` (`kode_keluar`, `id_admin`, `tgl_keluar`, `id_toko`) VALUES
('BRGK072340001', 1, '2023-07-31 17:08:29', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_brgm`
--

CREATE TABLE `tb_detail_brgm` (
  `kode_masuk` varchar(20) NOT NULL,
  `tgl_masuk` datetime NOT NULL DEFAULT current_timestamp(),
  `id_admin` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_detail_brgm`
--

INSERT INTO `tb_detail_brgm` (`kode_masuk`, `tgl_masuk`, `id_admin`, `id_toko`) VALUES
('BRGM072330001', '2023-07-26 11:28:01', 1, 3),
('BRGM072330002', '2023-07-28 16:27:13', 1, 3),
('BRGM072330003', '2023-07-28 18:28:45', 1, 3),
('BRGM072340001', '2023-07-07 17:46:34', 1, 4),
('BRGM072340002', '2023-07-07 17:47:55', 1, 4),
('BRGM082310001', '2023-08-27 18:46:39', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_penjualan`
--

CREATE TABLE `tb_detail_penjualan` (
  `kode_penjualan` varchar(20) NOT NULL,
  `tgl_transaksi` datetime NOT NULL DEFAULT current_timestamp(),
  `id_admin` int(11) NOT NULL,
  `total_keranjang` int(11) NOT NULL,
  `total_kembalian` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `jenis_diskon` enum('uang','persen') NOT NULL,
  `id_plg` varchar(5) NOT NULL DEFAULT 'Umum',
  `id_toko` int(11) NOT NULL,
  `jenis_penjualan` enum('Eceran','Grosir') NOT NULL,
  `is_donasi` int(1) NOT NULL DEFAULT 0,
  `jml_donasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_detail_penjualan`
--

INSERT INTO `tb_detail_penjualan` (`kode_penjualan`, `tgl_transaksi`, `id_admin`, `total_keranjang`, `total_kembalian`, `bayar`, `diskon`, `jenis_diskon`, `id_plg`, `id_toko`, `jenis_penjualan`, `is_donasi`, `jml_donasi`) VALUES
('0707236040001', '2023-07-07 17:47:18', 1, 25000, 25000, 50000, 0, 'uang', 'Umum', 4, 'Eceran', 0, 0),
('1709231110001', '2023-09-17 08:53:05', 1, 8000, 12000, 20000, 0, 'uang', 'Umum', 1, 'Eceran', 0, 0),
('1907237840001', '2023-07-19 19:45:04', 1, 10000, 5000, 15000, 0, 'uang', 'Umum', 1, 'Eceran', 0, 0),
('2807232030005', '2023-07-28 18:57:51', 1, 55000, 45000, 100000, 0, 'uang', 'Umum', 3, 'Eceran', 0, 0),
('2807232030013', '2023-07-28 21:07:52', 23, 100000, 10000, 100000, 10, 'persen', '2', 3, 'Eceran', 0, 0),
('2807232830002', '2023-07-28 18:23:43', 1, 60, 19950, 20000, 10, 'uang', 'Umum', 3, 'Eceran', 0, 0),
('2807233330011', '2023-07-28 19:45:47', 23, 55000, 20000, 75000, 0, 'uang', '2', 3, 'Eceran', 0, 0),
('2807234530004', '2023-07-28 18:55:02', 1, 55000, 20000, 75000, 0, 'uang', '2', 3, 'Eceran', 0, 0),
('2807234830008', '2023-07-28 19:01:15', 1, 25000, 50000, 75000, 0, 'uang', '2', 3, 'Eceran', 0, 0),
('2807235330009', '2023-07-28 19:41:38', 23, 25000, 25000, 50000, 0, 'uang', 'Umum', 3, 'Eceran', 0, 0),
('2807235830006', '2023-07-28 18:58:24', 1, 55000, 20000, 75000, 0, 'uang', '2', 3, 'Eceran', 0, 0),
('2807235930007', '2023-07-28 19:00:45', 1, 25000, 25000, 50000, 0, 'uang', 'Umum', 3, 'Eceran', 0, 0),
('2807236330010', '2023-07-28 19:42:57', 23, 110000, 10000, 120000, 0, 'uang', '2', 3, 'Eceran', 0, 0),
('2807236430012', '2023-07-28 19:50:13', 1, 25060, 24940, 50000, 0, 'uang', 'Umum', 3, 'Eceran', 0, 0),
('2807239530001', '2023-07-28 16:19:37', 1, 60, 49940, 50000, 0, 'uang', 'Umum', 3, 'Eceran', 0, 0),
('2807239730003', '2023-07-28 18:31:43', 1, 55000, 45000, 100000, 0, 'uang', '2', 3, 'Eceran', 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_donasi`
--

CREATE TABLE `tb_donasi` (
  `id_donasi` int(11) NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `tgl_donasi` datetime NOT NULL,
  `jml` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_harga_grosir`
--

CREATE TABLE `tb_harga_grosir` (
  `id_grosir` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `kode_brg` varchar(20) NOT NULL,
  `min_jml_grosir` int(3) NOT NULL,
  `harga_grosir_brg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_harga_grosir`
--

INSERT INTO `tb_harga_grosir` (`id_grosir`, `id_toko`, `kode_brg`, `min_jml_grosir`, `harga_grosir_brg`) VALUES
(1, 1, '4070100523', 10, 1800);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_info_opname`
--

CREATE TABLE `tb_info_opname` (
  `kode_opname` varchar(20) NOT NULL,
  `id_admin` varchar(10) NOT NULL,
  `tgl_opname` datetime NOT NULL DEFAULT current_timestamp(),
  `id_toko` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Snack');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_keranjang`
--

CREATE TABLE `tb_keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `kode_brg` varchar(20) NOT NULL,
  `jml` int(5) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `jenis_penjualan` enum('Eceran','Grosir') NOT NULL,
  `kasir` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_keranjang`
--

INSERT INTO `tb_keranjang` (`id_keranjang`, `kode_brg`, `jml`, `id_toko`, `jenis_penjualan`, `kasir`) VALUES
(18, '3555280623', 0, 1, 'Eceran', 23);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_master_menu`
--

CREATE TABLE `tb_master_menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(20) NOT NULL,
  `slug_menu` varchar(20) NOT NULL,
  `kategori_menu` enum('utama','sub') NOT NULL,
  `grup_menu` enum('main','tambahan') NOT NULL,
  `icon_menu` varchar(20) NOT NULL,
  `menu_utama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_master_menu`
--

INSERT INTO `tb_master_menu` (`id_menu`, `nama_menu`, `slug_menu`, `kategori_menu`, `grup_menu`, `icon_menu`, `menu_utama`) VALUES
(1, 'Dashboard', '', 'utama', 'main', 'home', ''),
(2, 'Inventaris', 'inventaris', 'utama', 'main', 'box-open', ''),
(3, 'Pelanggan', 'pelanggan', 'utama', 'main', 'users', ''),
(4, 'Penjualan', 'penjualan', 'utama', 'main', 'shopping-basket', ''),
(5, 'Pengeluaran', 'pengeluaran', 'utama', 'main', 'arrow-down', ''),
(6, 'Pengeluaran', '', 'sub', '', '', 'lap_global'),
(7, 'Laporan Global', 'lap_global', 'utama', 'tambahan', 'file', ''),
(8, 'Karyawan', 'karyawan', 'utama', 'tambahan', 'user', ''),
(9, 'Toko', 'toko', 'utama', 'tambahan', 'store', ''),
(10, 'Pengaturan', 'pengaturan', 'utama', 'tambahan', 'cogs', ''),
(11, 'Data', '', 'sub', '', '', 'inventaris'),
(12, 'Barang Masuk', 'brg_masuk', 'sub', '', '', 'inventaris'),
(13, 'Barang Keluar', 'brg_keluar', 'sub', '', '', 'inventaris'),
(14, 'Supplier', 'supplier', 'sub', '', '', 'inventaris'),
(15, 'Satuan', 'satuan', 'sub', '', '', 'inventaris'),
(16, 'Kategori', 'kategori', 'sub', '', '', 'inventaris'),
(17, 'Opname', 'opname', 'sub', '', '', 'inventaris'),
(18, 'Umum', '', 'sub', '', '', 'pengaturan'),
(19, 'Menu', 'menu', 'sub', '', '', 'pengaturan'),
(20, 'Tambahan', 'tambahan', 'sub', '', '', 'pengaturan'),
(21, 'Stok Barang', '', 'sub', '', '', 'laporan'),
(22, 'Barang Masuk', 'brg_masuk', 'sub', '', '', 'laporan'),
(23, 'Barang Keluar', 'brg_keluar', 'sub', '', '', 'laporan'),
(24, 'Opname', 'opname', 'sub', '', '', 'laporan'),
(25, 'Penjualan', 'penjualan', 'sub', '', '', 'laporan'),
(26, 'Retur Penjualan', 'retur', 'sub', '', '', 'laporan'),
(27, 'Keuangan', 'keuangan', 'sub', '', '', 'laporan'),
(28, 'Pembaharuan', 'pembaharuan', 'sub', '', '', 'pengaturan'),
(29, 'Donasi', 'donasi', '', '', '', 'laporan'),
(30, 'Global', 'global', 'sub', '', '', ''),
(31, 'Laporan', 'laporan', 'utama', 'main', 'file', ''),
(32, 'Laporan', 'laporan', 'sub', '', '', 'lap_global');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `id_plg` int(11) NOT NULL,
  `nama_plg` varchar(30) NOT NULL,
  `no_ponsel` varchar(12) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `id_admin` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`id_plg`, `nama_plg`, `no_ponsel`, `alamat`, `id_admin`) VALUES
(1, 'Umum', '081124456789', 'Bandung', '1'),
(2, 'Ahsan Sandi', '087336366661', 'Blok Sawo Depok', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengeluaran`
--

CREATE TABLE `tb_pengeluaran` (
  `kode_pengeluaran` varchar(20) NOT NULL,
  `tgl` datetime NOT NULL DEFAULT current_timestamp(),
  `id_admin` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_pengeluaran`
--

INSERT INTO `tb_pengeluaran` (`kode_pengeluaran`, `tgl`, `id_admin`, `id_toko`) VALUES
('230728090947516', '2023-07-28 21:09:47', 23, 3),
('230731064740771', '2023-07-31 18:47:40', 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengeluaran_detail`
--

CREATE TABLE `tb_pengeluaran_detail` (
  `id_pengeluaran` int(11) NOT NULL,
  `kode_pengeluaran` varchar(20) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `harga_modal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_pengeluaran_detail`
--

INSERT INTO `tb_pengeluaran_detail` (`id_pengeluaran`, `kode_pengeluaran`, `nama_barang`, `kategori`, `harga_modal`) VALUES
(2, '230728090947516', 'Gaji', '', 50000),
(3, '230731064740771', 'Gaji', '', 20000),
(4, '230731064740771', 'Beras', '', 150000),
(5, '230731064740771', 'Gaji', '', 20000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengeluaran_item`
--

CREATE TABLE `tb_pengeluaran_item` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pengeluaran_item`
--

INSERT INTO `tb_pengeluaran_item` (`id`, `nama`, `type`) VALUES
(1, 'Gaji', 'owner'),
(2, 'Beras', 'kasir'),
(3, 'abc', 'kasir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_penjualan`
--

CREATE TABLE `tb_penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `kode_penjualan` varchar(20) NOT NULL,
  `kode_brg` varchar(20) NOT NULL,
  `jml` int(5) NOT NULL,
  `harga_jual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_penjualan`
--

INSERT INTO `tb_penjualan` (`id_penjualan`, `kode_penjualan`, `kode_brg`, `jml`, `harga_jual`) VALUES
(1, '0707236040001', '2275270623', 5, 5000),
(2, '1907237840001', '2275270623', 2, 5000),
(5, '2807239530001', '1679260723', 1, 60),
(6, '2807232830002', '1679260723', 1, 60),
(7, '2807239730003', '5364280723', 1, 55000),
(8, '2807234530004', '5364280723', 1, 55000),
(9, '2807232030005', '5364280723', 1, 55000),
(10, '2807235830006', '5364280723', 1, 55000),
(11, '2807235930007', '5083280723', 1, 25000),
(12, '2807234830008', '5083280723', 1, 25000),
(13, '2807235330009', '5083280723', 1, 25000),
(14, '2807236330010', '5364280723', 2, 55000),
(15, '2807233330011', '5364280723', 1, 55000),
(16, '2807236430012', '1679260723', 1, 60),
(17, '2807236430012', '5083280723', 1, 25000),
(18, '2807232030013', '5083280723', 4, 25000),
(19, '1709231110001', '3555280623', 1, 8000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_satuan`
--

CREATE TABLE `tb_satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_satuan`
--

INSERT INTO `tb_satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'Pcs'),
(2, 'Butir'),
(3, 'pack');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_stok_opname`
--

CREATE TABLE `tb_stok_opname` (
  `id_opname` int(11) NOT NULL,
  `kode_opname` varchar(20) NOT NULL,
  `id_brg` int(11) NOT NULL,
  `jml_system` int(4) NOT NULL,
  `jml_fisik` int(4) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `kontak` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_supplier`
--

INSERT INTO `tb_supplier` (`id_supplier`, `nama_supplier`, `kontak`) VALUES
(1, 'Ump', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tambah_opname`
--

CREATE TABLE `tb_tambah_opname` (
  `id` int(11) NOT NULL,
  `id_brg` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_tambah_opname`
--

INSERT INTO `tb_tambah_opname` (`id`, `id_brg`, `id_toko`) VALUES
(5, 10, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_toko`
--

CREATE TABLE `tb_toko` (
  `id_toko` int(11) NOT NULL,
  `nama_toko` varchar(100) NOT NULL,
  `jenis_toko` enum('Pusat','Cabang') NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_toko`
--

INSERT INTO `tb_toko` (`id_toko`, `nama_toko`, `jenis_toko`, `alamat`) VALUES
(1, 'CI MART', 'Pusat', 'Lombok Utara'),
(3, 'TOKO 2', 'Cabang', 'Tanjung Pinang'),
(4, 'TOKO 3', 'Cabang', 'Depok');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `tb_akses_menu`
--
ALTER TABLE `tb_akses_menu`
  ADD PRIMARY KEY (`id_akses`);

--
-- Indeks untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_brg`);

--
-- Indeks untuk tabel `tb_brg_keluar`
--
ALTER TABLE `tb_brg_keluar`
  ADD PRIMARY KEY (`id_keluar`);

--
-- Indeks untuk tabel `tb_brg_masuk`
--
ALTER TABLE `tb_brg_masuk`
  ADD PRIMARY KEY (`id_masuk`);

--
-- Indeks untuk tabel `tb_data_retur`
--
ALTER TABLE `tb_data_retur`
  ADD PRIMARY KEY (`id_retur`);

--
-- Indeks untuk tabel `tb_detail_brgk`
--
ALTER TABLE `tb_detail_brgk`
  ADD PRIMARY KEY (`kode_keluar`);

--
-- Indeks untuk tabel `tb_detail_brgm`
--
ALTER TABLE `tb_detail_brgm`
  ADD PRIMARY KEY (`kode_masuk`);

--
-- Indeks untuk tabel `tb_detail_penjualan`
--
ALTER TABLE `tb_detail_penjualan`
  ADD PRIMARY KEY (`kode_penjualan`);

--
-- Indeks untuk tabel `tb_donasi`
--
ALTER TABLE `tb_donasi`
  ADD PRIMARY KEY (`id_donasi`);

--
-- Indeks untuk tabel `tb_harga_grosir`
--
ALTER TABLE `tb_harga_grosir`
  ADD PRIMARY KEY (`id_grosir`);

--
-- Indeks untuk tabel `tb_info_opname`
--
ALTER TABLE `tb_info_opname`
  ADD PRIMARY KEY (`kode_opname`);

--
-- Indeks untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tb_keranjang`
--
ALTER TABLE `tb_keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indeks untuk tabel `tb_master_menu`
--
ALTER TABLE `tb_master_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`id_plg`);

--
-- Indeks untuk tabel `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  ADD PRIMARY KEY (`kode_pengeluaran`);

--
-- Indeks untuk tabel `tb_pengeluaran_detail`
--
ALTER TABLE `tb_pengeluaran_detail`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indeks untuk tabel `tb_pengeluaran_item`
--
ALTER TABLE `tb_pengeluaran_item`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `tb_satuan`
--
ALTER TABLE `tb_satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `tb_stok_opname`
--
ALTER TABLE `tb_stok_opname`
  ADD PRIMARY KEY (`id_opname`);

--
-- Indeks untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `tb_tambah_opname`
--
ALTER TABLE `tb_tambah_opname`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_toko`
--
ALTER TABLE `tb_toko`
  ADD PRIMARY KEY (`id_toko`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `tb_akses_menu`
--
ALTER TABLE `tb_akses_menu`
  MODIFY `id_akses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id_brg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tb_brg_keluar`
--
ALTER TABLE `tb_brg_keluar`
  MODIFY `id_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_brg_masuk`
--
ALTER TABLE `tb_brg_masuk`
  MODIFY `id_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_data_retur`
--
ALTER TABLE `tb_data_retur`
  MODIFY `id_retur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_donasi`
--
ALTER TABLE `tb_donasi`
  MODIFY `id_donasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_harga_grosir`
--
ALTER TABLE `tb_harga_grosir`
  MODIFY `id_grosir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_keranjang`
--
ALTER TABLE `tb_keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `tb_master_menu`
--
ALTER TABLE `tb_master_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1026;

--
-- AUTO_INCREMENT untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `id_plg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_pengeluaran_detail`
--
ALTER TABLE `tb_pengeluaran_detail`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_pengeluaran_item`
--
ALTER TABLE `tb_pengeluaran_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tb_satuan`
--
ALTER TABLE `tb_satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_stok_opname`
--
ALTER TABLE `tb_stok_opname`
  MODIFY `id_opname` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_tambah_opname`
--
ALTER TABLE `tb_tambah_opname`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_toko`
--
ALTER TABLE `tb_toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
