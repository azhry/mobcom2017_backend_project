-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2017 at 05:15 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mpcafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `musics`
--

CREATE TABLE `musics` (
  `musics_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `artist` varchar(150) NOT NULL,
  `album` varchar(150) NOT NULL,
  `genre` varchar(30) NOT NULL,
  `filename` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `musics`
--

INSERT INTO `musics` (`musics_id`, `title`, `artist`, `album`, `genre`, `filename`, `created_at`, `updated_at`) VALUES
(1, 'Peace Sign', '', '', '', 'Peace_Sign.mp3', '2017-11-14 22:33:46', '2017-11-14 22:33:46'),
(2, 'Never-end Tale', '', '', '', 'Never-end_Tale.mp3', '2017-11-14 22:33:46', '2017-11-14 22:33:46'),
(3, 'Scenarioart', '', '', '', 'Scenarioart.mp3', '2017-11-14 22:34:50', '2017-11-14 22:34:50'),
(4, 'Kara No Kokoro', 'Anly', 'Naruto Shippuden Opening 20', 'Other', 'Kara_No_Kokoro.mp3', '2017-11-28 22:11:43', '2017-11-28 22:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `request_queue`
--

CREATE TABLE `request_queue` (
  `request_id` int(11) NOT NULL,
  `musics_id` int(11) NOT NULL,
  `played` enum('1','0') NOT NULL DEFAULT '0',
  `priority` enum('1','0') NOT NULL DEFAULT '0',
  `schedule` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_queue`
--

INSERT INTO `request_queue` (`request_id`, `musics_id`, `played`, `priority`, `schedule`, `created_at`, `updated_at`) VALUES
(1, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-14 22:35:29', '2017-11-14 22:35:29'),
(2, 2, '1', '0', '0000-00-00 00:00:00', '2017-11-14 22:35:29', '2017-11-14 22:35:29'),
(3, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-14 22:35:38', '2017-11-14 22:35:38'),
(4, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-14 23:45:18', '2017-11-14 23:45:18'),
(5, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 00:23:44', '2017-11-15 00:23:44'),
(6, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 00:28:01', '2017-11-15 00:28:01'),
(7, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 00:32:06', '2017-11-15 00:32:06'),
(8, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 00:36:09', '2017-11-15 00:36:09'),
(9, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 00:40:16', '2017-11-15 00:40:16'),
(10, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 00:44:19', '2017-11-15 00:44:19'),
(11, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 11:27:47', '2017-11-15 11:27:47'),
(12, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 11:28:50', '2017-11-15 11:28:50'),
(13, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 11:29:58', '2017-11-15 11:29:58'),
(14, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 11:32:53', '2017-11-15 11:32:53'),
(15, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 11:35:37', '2017-11-15 11:35:37'),
(16, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 11:35:43', '2017-11-15 11:35:43'),
(17, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 11:35:44', '2017-11-15 11:35:44'),
(18, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 11:35:54', '2017-11-15 11:35:54'),
(19, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 11:36:46', '2017-11-15 11:36:46'),
(20, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-15 11:36:50', '2017-11-15 11:36:50'),
(21, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-22 11:20:39', '2017-11-22 11:20:39'),
(22, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-22 11:41:34', '2017-11-22 11:41:34'),
(23, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-22 11:41:41', '2017-11-22 11:41:41'),
(24, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-22 11:42:29', '2017-11-22 11:42:29'),
(25, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-22 11:46:02', '2017-11-22 11:46:02'),
(26, 2, '1', '0', '0000-00-00 00:00:00', '2017-11-28 10:47:42', '2017-11-28 10:47:42'),
(27, 2, '1', '0', '0000-00-00 00:00:00', '2017-11-28 10:51:30', '2017-11-28 10:51:30'),
(28, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-28 10:51:35', '2017-11-28 10:51:35'),
(29, 2, '1', '0', '0000-00-00 00:00:00', '2017-11-28 10:59:49', '2017-11-28 10:59:49'),
(30, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 11:05:18', '2017-11-28 11:05:18'),
(31, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 14:40:07', '2017-11-28 14:40:07'),
(32, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 14:41:14', '2017-11-28 14:41:14'),
(33, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 14:45:25', '2017-11-28 14:45:25'),
(34, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 14:45:34', '2017-11-28 14:45:34'),
(35, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 14:46:06', '2017-11-28 14:46:06'),
(36, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 14:48:15', '2017-11-28 14:48:15'),
(37, 2, '1', '0', '0000-00-00 00:00:00', '2017-11-28 14:48:18', '2017-11-28 14:48:18'),
(38, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-28 14:59:53', '2017-11-28 14:59:53'),
(39, 2, '1', '0', '0000-00-00 00:00:00', '2017-11-28 14:59:59', '2017-11-28 14:59:59'),
(40, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-28 15:00:59', '2017-11-28 15:00:59'),
(41, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 15:01:37', '2017-11-28 15:01:37'),
(42, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 16:18:31', '2017-11-28 16:18:31'),
(43, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 18:46:01', '2017-11-28 18:46:01'),
(44, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-28 18:46:28', '2017-11-28 18:46:28'),
(45, 2, '1', '0', '0000-00-00 00:00:00', '2017-11-28 18:54:18', '2017-11-28 18:54:18'),
(46, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-28 21:13:59', '2017-11-28 21:13:59'),
(47, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 21:14:08', '2017-11-28 21:14:08'),
(48, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 23:03:21', '2017-11-28 23:03:21'),
(49, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-28 23:08:05', '2017-11-28 23:08:05'),
(50, 4, '1', '0', '0000-00-00 00:00:00', '2017-11-28 23:08:11', '2017-11-28 23:08:11'),
(51, 1, '1', '0', '0000-00-00 00:00:00', '2017-11-28 23:08:17', '2017-11-28 23:08:17'),
(52, 3, '0', '0', '0000-00-00 00:00:00', '2017-11-28 23:11:19', '2017-11-28 23:11:19'),
(53, 4, '0', '0', '0000-00-00 00:00:00', '2017-11-28 23:11:34', '2017-11-28 23:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `vote_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `type` enum('1','0') NOT NULL DEFAULT '1',
  `device_id` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `musics`
--
ALTER TABLE `musics`
  ADD PRIMARY KEY (`musics_id`);

--
-- Indexes for table `request_queue`
--
ALTER TABLE `request_queue`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `musics_id` (`musics_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`),
  ADD KEY `request_id` (`request_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `musics`
--
ALTER TABLE `musics`
  MODIFY `musics_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `request_queue`
--
ALTER TABLE `request_queue`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `request_queue`
--
ALTER TABLE `request_queue`
  ADD CONSTRAINT `request_queue_ibfk_1` FOREIGN KEY (`musics_id`) REFERENCES `musics` (`musics_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `request_queue` (`request_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
