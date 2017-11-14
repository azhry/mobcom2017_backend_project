-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2017 at 05:42 PM
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
(3, 'Scenarioart', '', '', '', 'Scenarioart.mp3', '2017-11-14 22:34:50', '2017-11-14 22:34:50');

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
(3, 3, '1', '0', '0000-00-00 00:00:00', '2017-11-14 22:35:38', '2017-11-14 22:35:38');

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
  MODIFY `musics_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `request_queue`
--
ALTER TABLE `request_queue`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
