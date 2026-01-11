-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2026 at 06:47 PM
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
-- Database: `attlogs`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_status`
--

CREATE TABLE `attendance_status` (
  `id` tinyint(1) NOT NULL,
  `message` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_status`
--

INSERT INTO `attendance_status` (`id`, `message`) VALUES
(0, 'Absent'),
(1, 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_status`
--

CREATE TABLE `enrollment_status` (
  `id` tinyint(1) NOT NULL,
  `message` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment_status`
--

INSERT INTO `enrollment_status` (`id`, `message`) VALUES
(0, 'Not Enrolled'),
(1, 'Enrolled');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `role` varchar(50) DEFAULT 'user',
  `is_enrolled` tinyint(1) NOT NULL DEFAULT 0,
  `is_in` tinyint(1) NOT NULL DEFAULT 0,
  `time_in` varchar(15) DEFAULT '00:00',
  `time_out` varchar(15) DEFAULT '00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`, `is_enrolled`, `is_in`, `time_in`, `time_out`) VALUES
(1, 'Dawn Izach Cruz', 'dawn@gmail.com', '$2y$10$Ghpqg3tZn1MDljqJzEQszeAoMjyrHHnkZVSDRS.iU2CspuQ5WNNHy', '2026-01-09 00:53:30', 'user', 1, 0, '00:00', '00:00'),
(2, 'daniella', 'barcelon@gmail.com', '$2y$10$LXpP04N3qa2fImG00PisbuCFtv02xBxHHJ1HZx7ZuACG15NlMTvZi', '2026-01-09 11:34:53', 'user', 1, 0, '00:00', '00:00'),
(3, 'cedillio', 'cedillio@gmail.com', '$2y$10$.7VCmJyiaas4R0Y2A99EFO8Jc0W9vS/ozFwJLvzNcg8D9AnKpVp..', '2026-01-09 11:36:10', 'user', 0, 0, '00:00', '00:00'),
(4, 'webmaster', 'webmaster@gmail.com', '$2y$10$ukoKgU959S.wHhtvf3glY.vzX5.7v0mbpC1FpxXBk.jqH4XnQtzWy', '2026-01-09 12:03:51', 'admin', 0, 0, '00:00', '00:00'),
(5, 'cruzdawn10', 'cruzdawn10@gmail.com', '$2y$10$FtebWsbXusrPpSyKNZBUuusjoJov2yyVK6qqZWNrlkueWSMIte1H.', '2026-01-11 21:42:12', 'user', 1, 0, '00:00', '00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_status`
--
ALTER TABLE `attendance_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollment_status`
--
ALTER TABLE `enrollment_status`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
