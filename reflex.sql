-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2025 at 09:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reflex`
--

-- --------------------------------------------------------

--
-- Table structure for table `mstadmin`
--

CREATE TABLE `mstadmin` (
  `adminId` varchar(6) NOT NULL CHECK (`adminId` like 'A%'),
  `adminUserName` varchar(15) NOT NULL,
  `adminPassword` varchar(255) NOT NULL,
  `adminRole` varchar(15) DEFAULT NULL CHECK (`adminRole` in ('owner','cashier','manager','accountant')),
  `accountStatus` varchar(15) DEFAULT 'active',
  `email` varchar(50) NOT NULL,
  `phoneNumber` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mstadmin`
--

INSERT INTO `mstadmin` (`adminId`, `adminUserName`, `adminPassword`, `adminRole`, `accountStatus`, `email`, `phoneNumber`) VALUES
('A01', 'Rishabh Upadhya', 'Ris@22', 'OWNER', 'active', 'rishabhupadhyay338@gmail.com', '9512456401');

-- --------------------------------------------------------

--
-- Table structure for table `mstcity`
--

CREATE TABLE `mstcity` (
  `cityid` decimal(4,0) NOT NULL,
  `cityName` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mstcity`
--

INSERT INTO `mstcity` (`cityid`, `cityName`) VALUES
(0, 'surat'),
(1, 'ahmedabad'),
(3, 'Baroda'),
(4, 'baruch');

-- --------------------------------------------------------

--
-- Table structure for table `mstcustomer`
--

CREATE TABLE `mstcustomer` (
  `CustomerId` varchar(6) NOT NULL CHECK (`CustomerId` like 'C%'),
  `CustomerName` varchar(35) NOT NULL,
  `Cityid` decimal(4,0) NOT NULL,
  `CustomerArea` varchar(15) NOT NULL,
  `CustomerMobileNo` decimal(11,0) NOT NULL,
  `CustomerAddress` varchar(70) NOT NULL,
  `CustomerType` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mstcustomer`
--

INSERT INTO `mstcustomer` (`CustomerId`, `CustomerName`, `Cityid`, `CustomerArea`, `CustomerMobileNo`, `CustomerAddress`, `CustomerType`) VALUES
('C2170', 'Rishabh Upadhyay', 1, '0', 9512456401, 'A/24 Puspkunj Soc NR Narayan School, Naroda, Ahmedabad', '0'),
('C2756', 'Ram', 1, '0', 9512456401, 'A/24', '0'),
('C3861', 'jatin', 1, '0', 4561321312, 'A-101', '0');

-- --------------------------------------------------------

--
-- Table structure for table `msthsn`
--

CREATE TABLE `msthsn` (
  `HsnId` int(11) NOT NULL,
  `Hsncode` varchar(8) NOT NULL,
  `RateOfGst` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `msthsn`
--

INSERT INTO `msthsn` (`HsnId`, `Hsncode`, `RateOfGst`) VALUES
(1, '13584', 15.00),
(2, '12321', 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `mstitem`
--

CREATE TABLE `mstitem` (
  `ItemId` varchar(3) NOT NULL,
  `ItemName` varchar(15) NOT NULL,
  `Hsncode` varchar(8) NOT NULL,
  `GroupName` varchar(30) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `Labourcode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mstitem`
--

INSERT INTO `mstitem` (`ItemId`, `ItemName`, `Hsncode`, `GroupName`, `ProductName`, `Labourcode`) VALUES
('I01', 'Cotton Jeans', '12321', 'Cotton', 'jeans', '12'),
('I02', 'linen Jeans', '12321', 'Linen', 'jeans', '12');

-- --------------------------------------------------------

--
-- Table structure for table `mstitemgroup`
--

CREATE TABLE `mstitemgroup` (
  `GroupId` int(11) NOT NULL,
  `GroupName` varchar(30) NOT NULL,
  `ShortCodeGroup` varchar(3) NOT NULL,
  `GroupType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mstitemgroup`
--

INSERT INTO `mstitemgroup` (`GroupId`, `GroupName`, `ShortCodeGroup`, `GroupType`) VALUES
(1, 'Cotton', 'CTN', 'Cloth'),
(2, 'Linen', 'LN', 'Cloth');

-- --------------------------------------------------------

--
-- Table structure for table `mstlabourcode`
--

CREATE TABLE `mstlabourcode` (
  `LabourId` int(11) NOT NULL,
  `Labourcode` varchar(20) NOT NULL,
  `LabourType` varchar(10) NOT NULL,
  `ShortCodeL` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mstlabourcode`
--

INSERT INTO `mstlabourcode` (`LabourId`, `Labourcode`, `LabourType`, `ShortCodeL`) VALUES
(1, '125', 'hgs', 'AH'),
(2, '12', 'hs', 'hsa');

-- --------------------------------------------------------

--
-- Table structure for table `mstother`
--

CREATE TABLE `mstother` (
  `OtherId` varchar(6) NOT NULL CHECK (`OtherId` like 'O%'),
  `OtherName` varchar(35) NOT NULL,
  `Cityid` decimal(4,0) NOT NULL,
  `OtherArea` varchar(15) DEFAULT NULL,
  `OtherMobileNo` decimal(11,0) NOT NULL,
  `OtherAddress` varchar(70) NOT NULL,
  `OtherType` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mstother`
--

INSERT INTO `mstother` (`OtherId`, `OtherName`, `Cityid`, `OtherArea`, `OtherMobileNo`, `OtherAddress`, `OtherType`) VALUES
('O00001', 'rishabh', 1, 'Nikol', 9512456401, 'rishabh@mail.com', 'Creditor of Goo');

-- --------------------------------------------------------

--
-- Table structure for table `mstproduct`
--

CREATE TABLE `mstproduct` (
  `ProductId` int(11) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `ShortCodeP` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mstproduct`
--

INSERT INTO `mstproduct` (`ProductId`, `ProductName`, `ShortCodeP`) VALUES
(1, 'jeans', 'JNS'),
(2, 'Shirt', 'SRT');

-- --------------------------------------------------------

--
-- Table structure for table `mstsalesman`
--

CREATE TABLE `mstsalesman` (
  `SalesManId` varchar(6) NOT NULL CHECK (`SalesManId` like 'S%'),
  `SalesManName` varchar(35) NOT NULL,
  `Cityid` decimal(4,0) NOT NULL,
  `SalesManArea` varchar(15) DEFAULT NULL,
  `SalesManMobileNo` decimal(11,0) NOT NULL,
  `SalesManAddress` varchar(70) NOT NULL,
  `SalesManType` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `full_name`, `email`, `password`, `created_at`) VALUES
(1, NULL, 'rishabh', 'rishabh@gmail.com', '123', '2025-04-04 16:41:55'),
(2, 'rishabh', '', 'rishabh@mail.com', '$2y$10$o/CYBS40fO8sJ2fQnKcqK.T1T8bXSmbK7v50UkAkb3axqC1ydKpcm', '2025-04-04 18:41:59'),
(3, 'rakesh', '', 'rakesh@mail.com', '$2y$10$96rUW0KZM7KhSOD205tt5e6aD7as98DUNyEBR4g3.uzpioP767lfK', '2025-04-04 18:42:17'),
(4, 'raka', '', 'raka@mail.com', '$2y$10$9pwi9t4Jv86xeU0Fmd4ypeiKE5jIUmJJzob.tvqJUUKt4MtYePf1q', '2025-04-04 18:43:35'),
(5, 'manish', '', 'manish@mail.com', '$2y$10$4a2j9a0aa2iodZmrzzsO2OzqZspeHdrxqdlNFYk229DnuIkeM8.SG', '2025-04-04 18:47:29'),
(6, 'manish', '', 'manish1@mail.com', '$2y$10$03F7EB3WIsM47leMub5DnObUXCdJTn.eAFA5Tx4ittUHfvsR50cuO', '2025-04-04 18:48:17'),
(7, 'jatin', '', 'jatin@mail.com', '$2y$10$iJ.57m3ea41Dp5TlGqCDRukjn70Ok.VpAN7a9bbO8PP9aUm4Q6SSK', '2025-04-04 20:08:49'),
(8, 'parth', '', 'parth@mail.com', '$2y$10$m0Dp5ga2fdriTSuu2/1rwORfc/okHT6Uo7g4hmA2w.V.RokDtrVIC', '2025-04-05 07:17:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mstadmin`
--
ALTER TABLE `mstadmin`
  ADD PRIMARY KEY (`adminId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `mstcity`
--
ALTER TABLE `mstcity`
  ADD PRIMARY KEY (`cityid`);

--
-- Indexes for table `mstcustomer`
--
ALTER TABLE `mstcustomer`
  ADD PRIMARY KEY (`CustomerId`),
  ADD KEY `Cityid` (`Cityid`);

--
-- Indexes for table `msthsn`
--
ALTER TABLE `msthsn`
  ADD PRIMARY KEY (`HsnId`),
  ADD UNIQUE KEY `Hsncode` (`Hsncode`);

--
-- Indexes for table `mstitem`
--
ALTER TABLE `mstitem`
  ADD PRIMARY KEY (`ItemId`),
  ADD KEY `Hsncode` (`Hsncode`),
  ADD KEY `GroupName` (`GroupName`),
  ADD KEY `ProductName` (`ProductName`),
  ADD KEY `Labourcode` (`Labourcode`);

--
-- Indexes for table `mstitemgroup`
--
ALTER TABLE `mstitemgroup`
  ADD PRIMARY KEY (`GroupId`),
  ADD UNIQUE KEY `GroupName` (`GroupName`),
  ADD UNIQUE KEY `ShortCodeGroup` (`ShortCodeGroup`);

--
-- Indexes for table `mstlabourcode`
--
ALTER TABLE `mstlabourcode`
  ADD PRIMARY KEY (`LabourId`),
  ADD UNIQUE KEY `Labourcode` (`Labourcode`),
  ADD UNIQUE KEY `ShortCodeL` (`ShortCodeL`);

--
-- Indexes for table `mstother`
--
ALTER TABLE `mstother`
  ADD PRIMARY KEY (`OtherId`),
  ADD KEY `Cityid` (`Cityid`);

--
-- Indexes for table `mstproduct`
--
ALTER TABLE `mstproduct`
  ADD PRIMARY KEY (`ProductId`),
  ADD UNIQUE KEY `ProductName` (`ProductName`),
  ADD UNIQUE KEY `ShortCodeP` (`ShortCodeP`);

--
-- Indexes for table `mstsalesman`
--
ALTER TABLE `mstsalesman`
  ADD PRIMARY KEY (`SalesManId`),
  ADD KEY `Cityid` (`Cityid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `msthsn`
--
ALTER TABLE `msthsn`
  MODIFY `HsnId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mstitemgroup`
--
ALTER TABLE `mstitemgroup`
  MODIFY `GroupId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mstlabourcode`
--
ALTER TABLE `mstlabourcode`
  MODIFY `LabourId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mstproduct`
--
ALTER TABLE `mstproduct`
  MODIFY `ProductId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mstcustomer`
--
ALTER TABLE `mstcustomer`
  ADD CONSTRAINT `mstcustomer_ibfk_1` FOREIGN KEY (`Cityid`) REFERENCES `mstcity` (`cityid`);

--
-- Constraints for table `mstitem`
--
ALTER TABLE `mstitem`
  ADD CONSTRAINT `mstitem_ibfk_1` FOREIGN KEY (`Hsncode`) REFERENCES `msthsn` (`Hsncode`),
  ADD CONSTRAINT `mstitem_ibfk_2` FOREIGN KEY (`GroupName`) REFERENCES `mstitemgroup` (`GroupName`),
  ADD CONSTRAINT `mstitem_ibfk_3` FOREIGN KEY (`ProductName`) REFERENCES `mstproduct` (`ProductName`),
  ADD CONSTRAINT `mstitem_ibfk_4` FOREIGN KEY (`Labourcode`) REFERENCES `mstlabourcode` (`Labourcode`);

--
-- Constraints for table `mstother`
--
ALTER TABLE `mstother`
  ADD CONSTRAINT `mstother_ibfk_1` FOREIGN KEY (`Cityid`) REFERENCES `mstcity` (`cityid`);

--
-- Constraints for table `mstsalesman`
--
ALTER TABLE `mstsalesman`
  ADD CONSTRAINT `mstsalesman_ibfk_1` FOREIGN KEY (`Cityid`) REFERENCES `mstcity` (`cityid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
