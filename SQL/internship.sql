-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2015 at 01:26 PM
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
  `label` varchar(20) NOT NULL,
  `description` blob,
  `status` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `label`, `description`, `status`) VALUES
(1, 'HTML', 'frontend', 0x3c703e637572732068746d6c3c2f703e, 0),
(2, 'test', 'Frontend', 0x3c703e746573743c2f703e, 0),
(3, 'Javascript', 'Frontend', 0x3c703e63757273206a733c2f703e, 1),
(8, 'test', 'Frontend', 0x3c703e746573743c2f703e, 0),
(9, 'SQL', 'Backend', 0x3c703e637572732073716c3c2f703e, 1),
(10, 'Beta', 'Frontend, Backend', 0x3c703e6371776975746f69676e746a663c2f703e, 1);

-- --------------------------------------------------------

--
-- Table structure for table `presentors`
--

CREATE TABLE IF NOT EXISTS `presentors` (
  `id` int(3) NOT NULL,
  `course_id` int(3) NOT NULL,
  `presentor_id` int(3) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `presentors`
--

INSERT INTO `presentors` (`id`, `course_id`, `presentor_id`) VALUES
(1, 1, 4),
(2, 2, 4),
(3, 3, 4),
(10, 2, 5),
(11, 9, 5),
(12, 10, 4);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_role`, `profile_image`, `session_id`, `status`, `reset_password`, `deletion_link_time`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1, NULL, 'sp8jg4q5krnb7m5l63e916cr43', 1, NULL, NULL),
(2, 'Ungureanu', 'Alex', 'ualex', 'ungureanualex17@yahoo.com', '081d29b9330707cc21a1bf4132f7d3f7', 3, NULL, 'fvout77q7sbim7g9qbqeuiqsm0', 1, NULL, NULL),
(3, 'Csiki', 'Andrei', 'candrei', 'andrei.g.csiki@gmail.com', '081d29b9330707cc21a1bf4132f7d3f7', 3, NULL, NULL, 1, NULL, NULL),
(4, 'Pfeiffer', 'Andrei', 'pandrei', 'andrei.pfeiffer@e-spres-oh.com', '23cbeacdea458e9ced9807d6cbe2f4d6', 2, '21232f297a57a5a743894a0e4a801fc3.png', 'o7s5blhttccltt3bo74ppm6pi5', 1, NULL, NULL),
(5, 'Sitov', 'Cristian', 'scristi', 'cristian.sitov@e-spres-oh.com', '23cbeacdea458e9ced9807d6cbe2f4d6', 2, NULL, NULL, 1, NULL, NULL),
(6, 'test', 'test', 'test', 'test@yahoo.com', '05a671c66aefea124cc08b76ea6d30bb', 2, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL),
(7, 'test', 'test', 'test1', 'test@saf.com', '05a671c66aefea124cc08b76ea6d30bb', 3, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL);

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
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `presentors`
--
ALTER TABLE `presentors`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
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
