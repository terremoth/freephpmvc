-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 30, 2016 at 02:01 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskero`
--

-- --------------------------------------------------------

--
-- Table structure for table `todo_list`
--

CREATE TABLE `todo_list` (
  `todo_list_id` int(8) NOT NULL,
  `todo_list_creation_data` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `todo_list_name` varchar(255) DEFAULT NULL,
  `todo_list_final_date` date NOT NULL,
  `todo_list_description` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `todo_list`
--

INSERT INTO `todo_list` (`todo_list_id`, `todo_list_creation_data`, `todo_list_name`, `todo_list_final_date`, `todo_list_description`) VALUES
(1, '2016-11-30 08:02:46', 'Dar banho no cachorro', '2016-12-02', ''),
(2, '2016-11-30 08:02:46', 'Ir na casa da sogra', '2016-12-15', ''),
(3, '2016-11-30 11:08:18', 'Ir para a festa 2', '2016-12-30', 'Aniversário do pedro'),
(4, '2016-11-30 11:10:49', 'aaaaaaaaaaaaaaaaa', '2016-11-09', 'aaaaaaaaaaaaaaaaa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todo_list`
--
ALTER TABLE `todo_list`
  ADD PRIMARY KEY (`todo_list_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo_list`
--
ALTER TABLE `todo_list`
  MODIFY `todo_list_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
