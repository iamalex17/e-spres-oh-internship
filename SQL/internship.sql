-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2015 at 12:24 PM
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
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(3) NOT NULL,
  `title` varchar(30) NOT NULL,
  `label` varchar(15) NOT NULL,
  `description` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `presentors`
--

CREATE TABLE IF NOT EXISTS `presentors` (
  `id` int(3) NOT NULL,
  `course_id` int(3) NOT NULL,
  `presentor_id` int(3) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `user_role` int(1) NOT NULL,
  `profile_image` varchar(40) DEFAULT NULL,
  `session_id` varchar(40) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `reset_password` char(64) DEFAULT NULL,
  `deletion_link_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_role`, `profile_image`, `session_id`, `status`, `reset_password`, `deletion_link_time`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1, NULL, '2dd3drnmhmj1t07v78ntkc58l3', 1, NULL, NULL),
(2, 'Ungureanu', 'Alex', 'ualex', 'ungureanualex17@yahoo.com', '081d29b9330707cc21a1bf4132f7d3f7', 3, NULL, NULL, 1, NULL, NULL),
(3, 'Csiki', 'Andrei', 'candrei', 'andrei.g.csiki@gmail.com', '081d29b9330707cc21a1bf4132f7d3f7', 3, NULL, NULL, 0, NULL, NULL),
(4, 'Pfeiffer', 'Andrei', 'pandrei', 'andrei.pfeiffer@e-spres-oh.com', '23cbeacdea458e9ced9807d6cbe2f4d6', 2, NULL, NULL, 1, NULL, NULL),
(5, 'Sitov', 'Cristian', 'scristi', 'cristian.sitov@e-spres-oh.com', '23cbeacdea458e9ced9807d6cbe2f4d6', 2, NULL, NULL, 1, NULL, NULL),
(7, 'test', 'test', 'test', 'test@test.test', '05a671c66aefea124cc08b76ea6d30bb', 3, NULL, NULL, 1, NULL, NULL),
(8, 'test1', 'test1', 'test1', 'test1@test.test', '05a671c66aefea124cc08b76ea6d30bb', 2, '46f0f485940e6e16afcf77cc29a63e32.png', NULL, 1, NULL, NULL);

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
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `presentors`
--
ALTER TABLE `presentors`
  ADD PRIMARY KEY (`id`), ADD KEY `course_id` (`course_id`), ADD KEY `presentor_id` (`presentor_id`), ADD KEY `presentor_id_2` (`presentor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD KEY `username` (`username`), ADD KEY `email` (`email`), ADD KEY `user_privilege` (`user_role`), ADD KEY `resetPassword` (`reset_password`), ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `users_privileges`
--
ALTER TABLE `users_privileges`
  ADD PRIMARY KEY (`privilege_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `presentors`
--
ALTER TABLE `presentors`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users_privileges`
--
ALTER TABLE `users_privileges`
  MODIFY `privilege_id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `presentors`
--
ALTER TABLE `presentors`
ADD CONSTRAINT `course_id_FK` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
ADD CONSTRAINT `presentor_id_FK` FOREIGN KEY (`presentor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `user_privilege_FK` FOREIGN KEY (`user_role`) REFERENCES `users_privileges` (`privilege_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
