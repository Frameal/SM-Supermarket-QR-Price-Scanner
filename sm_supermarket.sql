-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2025 at 12:04 PM
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
-- Database: `sm_supermarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `qr_code` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `qr_code`, `created_at`, `updated_at`) VALUES
(1, 'Deli EG122-BK Press Gel Pen, 0.35mm Ultra-Fine Tip', 15.00, 'QR001', '2025-11-13 10:04:54', '2025-11-13 10:04:54'),
(2, 'Lucky Me! Pancit Canton Original 60g', 12.50, 'QR002', '2025-11-13 10:04:54', '2025-11-13 10:04:54'),
(3, 'Colgate MaxFresh Toothpaste 150g', 89.75, 'QR003', '2025-11-13 10:04:54', '2025-11-13 11:02:28'),
(4, 'Safeguard Soap Classic White 135g', 28.00, 'QR004', '2025-11-13 10:04:54', '2025-11-13 11:02:31'),
(5, 'San Miguel Pale Pilsen 330ml', 45.00, 'QR005', '2025-11-13 10:04:54', '2025-11-13 11:02:35'),
(6, 'Del Monte Spaghetti Sauce Filipino Style 500g', 52.00, 'QR006', '2025-11-13 10:04:54', '2025-11-13 11:02:37'),
(7, 'C2 Green Tea Apple 500ml', 20.00, 'QR007', '2025-11-13 10:04:54', '2025-11-13 11:02:41'),
(8, 'Monde M.Y. San SkyFlakes Crackers 250g', 28.00, 'QR008', '2025-11-13 10:04:54', '2025-11-13 11:02:59'),
(9, 'Surf Powder Detergent Blossom Fresh 120g', 18.00, 'QR009', '2025-11-13 10:04:54', '2025-11-13 11:02:53'),
(10, 'Century Tuna Flakes in Oil 180g', 38.00, 'QR010', '2025-11-13 10:04:54', '2025-11-13 11:03:08'),
(11, 'Purefoods Hotdog Jumbo 500g', 165.00, 'QR011', '2025-11-13 10:04:54', '2025-11-13 11:03:11'),
(12, 'Piattos Cheese Supersized 170g', 76.00, 'QR012', '2025-11-13 10:45:21', '2025-11-13 11:03:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `qr_code` (`qr_code`),
  ADD KEY `idx_qr_code` (`qr_code`),
  ADD KEY `idx_product_name` (`product_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
