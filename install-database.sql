SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xmake_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `album_anh`
--

CREATE TABLE `album_anh` (
  `id` int NOT NULL,
  `uri` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên hiện trên URL',
  `ten` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên ảnh',
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mô tả',
  `phan_loai` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Phân loại ảnh',
  `ftype` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Đuôi mở rộng tệp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bai_viet`
--

CREATE TABLE `bai_viet` (
  `id` int NOT NULL,
  `uri` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên hiện trên url',
  `tieu_de` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tiêu đề',
  `noi_dung` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nội dung bài viết',
  `tac_gia` int NOT NULL COMMENT 'ID người dùng',
  `phan_loai` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Phân loại bài viết',
  `ftype` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `noi_dung_tinh`
--

CREATE TABLE `noi_dung_tinh` (
  `id` int NOT NULL,
  `uri` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `noi_dung` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `noi_dung_tinh`
--

INSERT INTO `noi_dung_tinh` (`id`, `uri`, `ten`, `noi_dung`) VALUES
(1, 'trang_chu', 'Trang chủ', '<p>Trang chủ</p>');

-- --------------------------------------------------------

--
-- Table structure for table `phan_loai`
--

CREATE TABLE `phan_loai` (
  `id` int NOT NULL,
  `uri` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `loai` varchar(41) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hien_thi` tinyint NOT NULL,
  `cap` int NOT NULL,
  `cha` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `san_pham`
--

CREATE TABLE `san_pham` (
  `id` int NOT NULL,
  `uri` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên hiện trên URL',
  `ten` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên hiện trên website',
  `mota` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mô tả sản phẩm',
  `gia` bigint NOT NULL COMMENT 'Giá',
  `hang` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Hãng sản xuất',
  `tac_gia` int NOT NULL COMMENT 'Tác giả',
  `phan_loai` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Phân loại sản phẩm',
  `ftype` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Phân loại tệp ảnh đại diện'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ten_nguoi_dung`
--

CREATE TABLE `ten_nguoi_dung` (
  `id` int NOT NULL,
  `ten` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên người dùng',
  `pass` varchar(41) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mật khẩu bằng 2 lần SHA1',
  `in_group` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nhóm, phân bởi " "',
  `properties` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Thuộc tính người dùng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ten_nguoi_dung`
--

INSERT INTO `ten_nguoi_dung` (`id`, `ten`, `pass`, `in_group`, `properties`) VALUES
(1, 'root', '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', '1 2 3 4', 'sysuser cannot_be_deleted disabled'),
(2, 'administrator', '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', '1 2 3 4', 'cannot_be_deleted');

-- --------------------------------------------------------

--
-- Table structure for table `thanh_ngang`
--

CREATE TABLE `thanh_ngang` (
  `id` int NOT NULL,
  `uri` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album_anh`
--
ALTER TABLE `album_anh`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uri` (`uri`);

--
-- Indexes for table `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uri` (`uri`);

--
-- Indexes for table `noi_dung_tinh`
--
ALTER TABLE `noi_dung_tinh`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uri` (`uri`);

--
-- Indexes for table `phan_loai`
--
ALTER TABLE `phan_loai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uri` (`uri`);

--
-- Indexes for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uri` (`uri`);

--
-- Indexes for table `ten_nguoi_dung`
--
ALTER TABLE `ten_nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten` (`ten`);

--
-- Indexes for table `thanh_ngang`
--
ALTER TABLE `thanh_ngang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uri` (`uri`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album_anh`
--
ALTER TABLE `album_anh`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bai_viet`
--
ALTER TABLE `bai_viet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `noi_dung_tinh`
--
ALTER TABLE `noi_dung_tinh`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `phan_loai`
--
ALTER TABLE `phan_loai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ten_nguoi_dung`
--
ALTER TABLE `ten_nguoi_dung`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `thanh_ngang`
--
ALTER TABLE `thanh_ngang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
