-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2015 at 02:51 PM
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
  `email` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_privilege` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `reset_password` char(64) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_privilege`, `status`, `reset_password`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1, 1, NULL),
(2, 'Ungureanu', 'Alex', 'ualex', 'ungureanualex17@yahoo.com', '081d29b9330707cc21a1bf4132f7d3f7', 3, 1, NULL),
(3, 'Csiki', 'Andrei', 'candrei', 'andrei.g.csiki@gmail.com', '081d29b9330707cc21a1bf4132f7d3f7', 3, 1, NULL),
(4, 'Pfeiffer', 'Andrei', 'pandrei', 'andrei.pfeiffer@e-spres-oh.com', '23cbeacdea458e9ced9807d6cbe2f4d6', 2, 1, NULL),
(5, 'Sitov', 'Cristian', 'scristi', 'cristian.sitov@e-spres-oh.com', '23cbeacdea458e9ced9807d6cbe2f4d6', 2, 1, NULL),
(7, 'test', 'test', 'test', 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', 1, 1, 'abc');

-- --------------------------------------------------------

--
-- Table structure for table `users_privileges`
--

CREATE TABLE IF NOT EXISTS `users_privileges` (
  `privilege_id` int(3) NOT NULL,
  `privilege_no` int(1) NOT NULL,
  `privilege_name` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_privileges`
--

INSERT INTO `users_privileges` (`privilege_id`, `privilege_no`, `privilege_name`) VALUES
(1, 1, 'Admin'),
(2, 2, 'Mentor'),
(3, 3, 'Intern');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD KEY `username` (`username`), ADD KEY `email` (`email`), ADD KEY `user_privilege` (`user_privilege`), ADD KEY `resetPassword` (`reset_password`);

--
-- Indexes for table `users_privileges`
--
ALTER TABLE `users_privileges`
  ADD PRIMARY KEY (`privilege_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users_privileges`
--
ALTER TABLE `users_privileges`
  MODIFY `privilege_id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `user_privilege_FK` FOREIGN KEY (`user_privilege`) REFERENCES `users_privileges` (`privilege_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
