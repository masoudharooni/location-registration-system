-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2021 at 10:41 AM
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
(22, 2, 'افقانستان', 33.72621977869205, 66.44984747516484, 28, 1, '2021-09-19 01:52:55'),
(23, 3, 'کنار گذر لشکری', 35.70599489461879, 51.261157386213604, 14, 1, '2021-09-19 13:39:47'),
(24, 2, 'میدان نقش جهان', 32.65735476543, 51.67735908685131, 2, 1, '2021-09-20 12:33:03'),
(25, 2, 'پل خواجو ', 32.636791192887046, 51.683303786766444, 2, 1, '2021-09-20 12:33:41'),
(26, 2, 'باغ جوان', 32.62322203650401, 51.731026428505714, 26, 1, '2021-09-20 12:35:34'),
(27, 2, 'عراق', 32.84341283233355, 43.57350288571875, 28, 1, '2021-09-20 12:40:15');

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
(2, 'masoud', 'harooni', 'masoudharooni50@gmail.com', '$2y$10$2e5ShqOri6BQZg.DNtZojeI1D79pQoEd3kc6p1xhFlcK8T6yhLT4S', '2021-09-19 01:44:14'),
(3, 'ملینا', 'هارونی', 'melina@gmail.com', '$2y$10$97xSom3eG/Kuhattto/lvuSrQjbOEDInTYLu3/DlfoPt/vfOU71du', '2021-09-19 13:38:03');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
