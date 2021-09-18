-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2021 at 11:30 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `map`
--

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(512) CHARACTER SET utf8 NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `user_id`, `title`, `lat`, `lng`, `type`, `status`, `created_at`) VALUES
(5, 1, 'دانشگاه اصفهان', 32.71848258720716, 51.53188705444337, 23, 1, '2021-09-13 16:07:18'),
(6, 1, 'china', 34.56990638085636, 103.51318359375, 28, 1, '2021-09-13 16:08:26'),
(7, 1, 'میدان شهدا', 32.671897888392124, 51.671217083930976, 29, 1, '2021-09-16 10:49:40'),
(8, 1, 'دروازه شیراز', 32.62221660075766, 51.66446328163147, 29, 1, '2021-09-16 11:41:27'),
(9, 1, 'میدان نقش جهان', 32.657139569676694, 51.677514910697944, 2, 1, '2021-09-16 11:43:05'),
(10, 1, 'میدان آزادی', 35.699708083112306, 51.33809745311738, 29, 1, '2021-09-16 11:44:02'),
(11, 1, 'سی و سه پل ', 32.644691553639234, 51.667537093162544, 2, 1, '2021-09-16 11:46:38'),
(12, 1, 'چهارباغ عباسی', 32.649768529960184, 51.66820764541627, 14, 1, '2021-09-16 13:52:51'),
(13, 1, 'آلاسکا', 64.60268165499696, -153.22082519531253, 28, 1, '2021-09-16 15:41:43'),
(14, 1, 'روسیه', 60.23981116999893, -262.61718750000006, 28, 1, '2021-09-16 15:43:17'),
(15, 1, 'کرمان', 30.107117887092382, 57.12890625000001, 27, 1, '2021-09-16 15:47:06'),
(16, 1, 'برج میلاد', 35.74464880619539, 51.37525141239167, 30, 1, '2021-09-16 16:00:31'),
(17, 1, 'ورزشگاه آزادی', 35.72366017086872, 51.27293586730957, 1, 1, '2021-09-16 16:32:40'),
(19, 1, 'شهرک صنعتی مبارکه', 32.41677650581706, 51.73307418823243, 2, 1, '2021-09-17 09:45:35'),
(20, 1, 'مشهد', 36.286971961162116, 59.61619377136231, 27, 1, '2021-09-17 10:04:14'),
(21, 1, 'رشد ، انزلی', 37.46005417400977, 49.58826595483713, 27, 1, '2021-09-17 16:30:15'),
(22, 2, 'افقانستان', 33.72621977869205, 66.44984747516484, 28, 1, '2021-09-19 01:52:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(256) CHARACTER SET utf8 NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `email` varchar(512) NOT NULL,
  `password` varchar(512) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `created_at`) VALUES
(2, 'masoud', 'harooni', 'masoudharooni50@gmail.com', '$2y$10$qCYK2RKdqgDJqMxFtrznpOgya5jUEIB4YqGcbzDMMakI3xe7OLboq', '2021-09-19 01:44:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
