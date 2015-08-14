-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2015 at 03:10 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `internship`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(3) unsigned NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_privilege` int(1) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_privilege`, `status`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1, 1),
(2, 'Ungureanu', 'Alex', 'alexu', 'ungureanualex17@yahoo.com', '081d29b9330707cc21a1bf4132f7d3f7', 3, 1),
(3, 'Csiki', 'Andrei', 'andreic', 'andrei.g.csiki@gmail.com', '081d29b9330707cc21a1bf4132f7d3f7', 3, 1),
(4, 'Pfeiffer', 'Andrei', 'andreip', 'andrei.pfeiffer@e-spres-oh.com', '23cbeacdea458e9ced9807d6cbe2f4d6', 2, 1),
(5, 'Sitov', 'Cristian', 'cristis', 'cristian.sitov@e-spres-oh.com', '23cbeacdea458e9ced9807d6cbe2f4d6', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD KEY `email` (`email`), ADD KEY `password` (`password`), ADD KEY `user_privilege_FK` (`user_privilege`), ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `user_privilege_FK` FOREIGN KEY (`user_privilege`) REFERENCES `users_privileges` (`privilege_no`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
