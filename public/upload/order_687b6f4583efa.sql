-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 08:42 PM
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
-- Database: `studio_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `cost` decimal(8,2) NOT NULL DEFAULT 0.00,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `cost`, `available`, `created_at`, `updated_at`) VALUES
(1, 'Server Copy', 40.00, 1, '2025-07-12 07:07:51', '2025-07-12 04:17:56'),
(2, 'Sign Copy', 10.00, 1, '2025-07-13 11:53:21', '2025-07-13 11:53:21'),
(3, 'NID Pdf', 20.00, 1, '2025-07-13 15:10:17', '2025-07-15 03:31:36'),
(4, 'Smart NID Pdf', 32000.00, 1, '2025-07-15 08:34:41', '2025-07-15 05:46:46'),
(5, 'NID Pass Set', 22.00, 1, '2025-07-15 08:53:27', '2025-07-15 03:41:53'),
(6, 'NID Form ', 25.00, 1, '2025-07-15 08:54:15', '2025-07-16 00:58:38'),
(7, 'Robi/Airtel Biometric', 20.00, 1, '2025-07-16 09:18:02', '2025-07-16 05:38:44'),
(8, 'Banlalink Biometric', 20.00, 1, '2025-07-16 09:18:49', '2025-07-16 05:38:50'),
(9, 'Teletalk Biometric', 30.00, 1, NULL, '2025-07-16 05:38:56'),
(10, 'Grameenphone Biometric', 20.00, 1, NULL, '2025-07-16 05:39:03'),
(11, 'Lost NID', 200.00, 1, '2025-07-16 12:01:41', '2025-07-16 10:34:38'),
(12, 'E-Passport', 100.00, 1, '2025-07-16 18:43:04', '2025-07-16 18:43:04'),
(13, 'MRP-Passport', 80.00, 1, '2025-07-16 18:43:04', '2025-07-16 18:43:04'),
(14, 'MRP to Server Copy', 180.00, 1, '2025-07-16 18:44:53', '2025-07-16 18:44:53'),
(15, 'Number To Location', 400.00, 0, '2025-07-17 10:48:46', '2025-07-18 05:11:51'),
(16, 'Call-list 3-Month', 900.00, 1, '2025-07-18 05:15:51', '2025-07-18 05:15:51'),
(17, 'Sms-GP 1-Month', 500.00, 1, '2025-07-18 05:15:51', '2025-07-18 05:15:51'),
(18, 'Sms-Banglalink 1-Month', 400.00, 1, '2025-07-18 05:17:19', '2025-07-18 05:17:19'),
(19, 'IMEI to Active Number', 700.00, 1, '2025-07-18 09:19:21', '2025-07-18 09:19:21'),
(20, 'NID to All Number', 430.00, 1, '2025-07-18 09:20:17', '2025-07-18 09:20:17'),
(21, 'Number to IMEI', 400.00, 1, '2025-07-18 09:20:17', '2025-07-18 09:20:17'),
(22, 'NID to All GP', 250.00, 1, '2025-07-18 09:20:17', '2025-07-18 09:20:17'),
(23, 'NID to All Banglalink', 200.00, 1, '2025-07-18 09:20:17', '2025-07-18 09:20:17'),
(24, 'IMEI Active Number + Biometric + Location', 1030.00, 1, '2025-07-18 09:20:17', '2025-07-18 09:20:17'),
(25, 'Nagad Information', 1100.00, 1, '2025-07-18 18:32:27', '2025-07-18 18:32:27'),
(26, 'Bikash Personal Info', 1150.00, 1, NULL, NULL),
(27, 'Rocket Info', 1450.00, 1, NULL, NULL),
(28, 'Nagad Personal 3-Month', 2500.00, 1, NULL, NULL),
(29, 'Bikash Merchant Info', 1200.00, 1, NULL, NULL),
(30, 'Bikash Agent Info', 1220.00, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
