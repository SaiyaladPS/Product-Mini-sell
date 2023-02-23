-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2023 at 05:57 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cate_id` int(255) NOT NULL,
  `cate_name` varchar(255) NOT NULL,
  `remark` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cate_id`, `cate_name`, `remark`) VALUES
(31, 'ອາຫານ', ''),
(33, 'ເຄືອງດຶ້ມ', ''),
(34, 'ໂຟນີເຈີ', ''),
(35, 'ເຄືອງໃຊ້ໂຟຟ້າ', ''),
(53, 'ອາຫານກະປ໋ອງ', ''),
(55, 'ໂລຫະ', '');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `dis_id` int(11) NOT NULL,
  `dis_name` varchar(45) NOT NULL,
  `dis_cause` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `goods`
--

CREATE TABLE `goods` (
  `g_id` varchar(255) NOT NULL,
  `g_name` varchar(255) NOT NULL,
  `g_purchase` decimal(12,2) DEFAULT NULL,
  `g_selling` decimal(12,2) NOT NULL,
  `g_qty` varchar(255) NOT NULL,
  `g_sub` varchar(255) NOT NULL DEFAULT 'ບໍ່ໄດ້ຂາຍຍ່ອຍ',
  `unit_u_id` int(255) NOT NULL,
  `g_date` date NOT NULL,
  `Note` varchar(255) DEFAULT NULL,
  `Type_T_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `Tel` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `useradmin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `img`, `fname`, `lname`, `Tel`, `password`, `useradmin`) VALUES
('01', '50924_zoro-katana-3-sword-style-one-piece.jpg', 'ໄຊຍະລາດ', 'ມີໃຈຈາ', '02012345678', '12345678', 'user'),
('1', 'compngwingmfrjz.png', '', '', '', '', ''),
('5', 'WhatsApp Image 2022-07-20 at 21.26.54.jpeg', 'ໄຊຍະລາດ', 'ພຽນສອນ', '02096778932', '96778932', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table ` merchandise`
--

CREATE TABLE ` merchandise` (
  `mer_id` int(11) NOT NULL,
  `mer_name` varchar(255) NOT NULL,
  `mer_cause` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(255) NOT NULL,
  `o_name` varchar(45) NOT NULL,
  `o_purchase` decimal(12,2) NOT NULL,
  `o_selling` decimal(12,2) NOT NULL,
  `o_qty` varchar(255) NOT NULL,
  `unit_u_id` int(255) NOT NULL,
  `o_date` date NOT NULL,
  `o_time` time NOT NULL,
  `Note` varchar(45) DEFAULT NULL,
  `goods_g_id` varchar(255) NOT NULL,
  `Type_T_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orderuser`
--

CREATE TABLE `orderuser` (
  `ou_id` int(255) NOT NULL,
  `ou_name` varchar(255) NOT NULL,
  `ou_purchase` decimal(12,2) NOT NULL,
  `ou_selling` decimal(12,2) NOT NULL,
  `ou_qty` varchar(255) NOT NULL,
  `unit_u_id` int(255) NOT NULL,
  `ou_date` date NOT NULL,
  `ou_time` time NOT NULL,
  `Note` varchar(255) NOT NULL,
  `goods_g_id` varchar(255) NOT NULL,
  `Type_T_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` varchar(255) NOT NULL,
  `cate_id` int(50) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `qty` int(255) NOT NULL,
  `bprice` decimal(12,2) NOT NULL,
  `sprice` decimal(12,2) NOT NULL,
  `remarck` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `cate_id`, `prod_name`, `qty`, `bprice`, `sprice`, `remarck`) VALUES
('333', 55, 'ສັງກະສີ', 456, '6500.00', '1000000.00', 'ໂອນ'),
('3333', 33, 'ແປັບຊີ', 23, '6000.00', '5000.00', ''),
('333333', 33, 'ນ້ຳໜາກນາວໃຫ່ຍ', 33, '7000.00', '5000.00', ''),
('46565', 33, 'ເບຍ', 12, '12000.00', '10000.00', 'ຫ້າມຂາຍຕ້ຳກວ່າ  18 ປີ'),
('4656ູຸູ5655', 34, 'ໂຕະ', 12, '12000.00', '10000.00', ''),
('6767', 33, 'ນ້ຳດື້ມ', 36, '7000.00', '5000.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(45) NOT NULL,
  `pro_cause` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `receive`
--

CREATE TABLE `receive` (
  `r_id` int(255) NOT NULL,
  `r_name` varchar(45) NOT NULL,
  `r_purchase` decimal(12,2) NOT NULL,
  `r_selling` decimal(12,2) NOT NULL,
  `r_qty` varchar(45) NOT NULL,
  `unit_u_id` int(255) NOT NULL,
  `r_date` date NOT NULL,
  `r_time` time DEFAULT NULL,
  `Note` varchar(45) DEFAULT NULL,
  `Type_T_id` int(255) NOT NULL,
  `goods_g_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `receives`
--

CREATE TABLE `receives` (
  `rid` int(255) NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `prod_id` varchar(255) NOT NULL,
  `rqty` int(255) NOT NULL,
  `bprice` decimal(12,2) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `rdate` date NOT NULL,
  `rtime` time NOT NULL,
  `remark` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `receives`
--

INSERT INTO `receives` (`rid`, `bill_no`, `prod_id`, `rqty`, `bprice`, `amount`, `rdate`, `rtime`, `remark`) VALUES
(6, '', '333', 1, '6500.00', '6500.00', '2022-12-01', '07:12:27', ''),
(7, '', '333', 1, '6500.00', '6500.00', '2022-12-03', '10:47:51', ''),
(8, '', '333', 1, '6500.00', '6500.00', '2022-12-02', '10:49:30', ''),
(9, '', '333', 1, '6500.00', '6500.00', '1910-01-05', '10:50:57', ''),
(10, '', '333333', 1, '7000.00', '7000.00', '2021-12-01', '10:58:39', ''),
(11, '', '333333', 1, '7000.00', '7000.00', '2022-12-01', '10:59:17', ''),
(12, '', '333333', 1, '7000.00', '7000.00', '2022-12-01', '11:00:13', ''),
(13, '', '333333', 4, '7000.00', '28000.00', '2022-12-01', '11:00:28', ''),
(14, '', '6767', 2, '7000.00', '14000.00', '2022-12-01', '11:02:22', ''),
(15, '', '333', 1, '6500.00', '6500.00', '2022-12-01', '11:03:51', ''),
(16, '', '333333', 8, '7000.00', '56000.00', '2022-12-07', '05:02:16', ''),
(17, '', '333', 1, '6500.00', '6500.00', '2022-12-07', '05:02:39', '');

-- --------------------------------------------------------

--
-- Table structure for table `sub`
--

CREATE TABLE `sub` (
  `s_id` varchar(255) NOT NULL,
  `s_name` varchar(255) NOT NULL,
  `s_selling` decimal(12,0) NOT NULL,
  `s_qty` varchar(255) NOT NULL,
  `unit_u_id` int(255) NOT NULL,
  `s_story` varchar(255) NOT NULL,
  `s_date` date NOT NULL,
  `Type_T_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `T_id` int(255) NOT NULL,
  `T_name` varchar(255) NOT NULL,
  `T_date` date NOT NULL,
  `Note` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`T_id`, `T_name`, `T_date`, `Note`) VALUES
(9, 'ອາຫານ', '2022-11-11', ''),
(10, 'ເຄືອງດື້ມ', '2022-11-11', '');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `u_id` int(255) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `u_date` date NOT NULL,
  `Note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`u_id`, `u_name`, `u_date`, `Note`) VALUES
(9, 'ຍ່ອຍ', '2022-11-11', ''),
(10, 'ແພັກ', '2022-11-11', ''),
(11, 'ແກ້ວ', '2022-11-11', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cate_id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`dis_id`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`g_id`),
  ADD KEY `Type_T_id` (`Type_T_id`),
  ADD KEY `unit_u_id` (`unit_u_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table ` merchandise`
--
ALTER TABLE ` merchandise`
  ADD PRIMARY KEY (`mer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `fk_order_goods1_idx` (`goods_g_id`),
  ADD KEY `Type_T_id` (`Type_T_id`),
  ADD KEY `unit_u_id` (`unit_u_id`);

--
-- Indexes for table `orderuser`
--
ALTER TABLE `orderuser`
  ADD PRIMARY KEY (`ou_id`),
  ADD KEY `goods_g_id` (`goods_g_id`),
  ADD KEY `Type_T_id` (`Type_T_id`),
  ADD KEY `unit_u_id` (`unit_u_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `cate_id` (`cate_id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `receive`
--
ALTER TABLE `receive`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `goods_g_id` (`goods_g_id`),
  ADD KEY `Type_T_id` (`Type_T_id`),
  ADD KEY `unit_u_id` (`unit_u_id`);

--
-- Indexes for table `receives`
--
ALTER TABLE `receives`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `sub`
--
ALTER TABLE `sub`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `Type_T_id` (`Type_T_id`),
  ADD KEY `unit_u_id` (`unit_u_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`T_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cate_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `dis_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table ` merchandise`
--
ALTER TABLE ` merchandise`
  MODIFY `mer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `orderuser`
--
ALTER TABLE `orderuser`
  MODIFY `ou_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receive`
--
ALTER TABLE `receive`
  MODIFY `r_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=850;

--
-- AUTO_INCREMENT for table `receives`
--
ALTER TABLE `receives`
  MODIFY `rid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `T_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `u_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `goods`
--
ALTER TABLE `goods`
  ADD CONSTRAINT `goods_ibfk_1` FOREIGN KEY (`Type_T_id`) REFERENCES `type` (`T_id`),
  ADD CONSTRAINT `goods_ibfk_2` FOREIGN KEY (`unit_u_id`) REFERENCES `unit` (`u_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`goods_g_id`) REFERENCES `goods` (`g_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`Type_T_id`) REFERENCES `type` (`T_id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`unit_u_id`) REFERENCES `unit` (`u_id`);

--
-- Constraints for table `orderuser`
--
ALTER TABLE `orderuser`
  ADD CONSTRAINT `orderuser_ibfk_1` FOREIGN KEY (`goods_g_id`) REFERENCES `goods` (`g_id`),
  ADD CONSTRAINT `orderuser_ibfk_2` FOREIGN KEY (`Type_T_id`) REFERENCES `type` (`T_id`),
  ADD CONSTRAINT `orderuser_ibfk_3` FOREIGN KEY (`unit_u_id`) REFERENCES `unit` (`u_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cate_id`) REFERENCES `categories` (`cate_id`);

--
-- Constraints for table `receive`
--
ALTER TABLE `receive`
  ADD CONSTRAINT `receive_ibfk_1` FOREIGN KEY (`goods_g_id`) REFERENCES `goods` (`g_id`),
  ADD CONSTRAINT `receive_ibfk_2` FOREIGN KEY (`Type_T_id`) REFERENCES `type` (`T_id`),
  ADD CONSTRAINT `receive_ibfk_3` FOREIGN KEY (`unit_u_id`) REFERENCES `unit` (`u_id`);

--
-- Constraints for table `receives`
--
ALTER TABLE `receives`
  ADD CONSTRAINT `receives_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`);

--
-- Constraints for table `sub`
--
ALTER TABLE `sub`
  ADD CONSTRAINT `sub_ibfk_1` FOREIGN KEY (`Type_T_id`) REFERENCES `type` (`T_id`),
  ADD CONSTRAINT `sub_ibfk_2` FOREIGN KEY (`unit_u_id`) REFERENCES `unit` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
