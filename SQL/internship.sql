-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Oct 05, 2015 at 04:37 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `internship`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(3) NOT NULL,
  `title` varchar(50) NOT NULL,
  `label` varchar(20) NOT NULL,
  `description` blob,
  `status` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `label`, `description`, `status`) VALUES
(30, 'HTML', 'Frontend, Backend', 0x3c703e6a6b62683c2f703e, 0),
(31, 'test', 'Backend', 0x3c703e67673c2f703e, 1);

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `id` int(3) NOT NULL,
  `course_id` int(3) NOT NULL,
  `description` blob NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `presentors`
--

CREATE TABLE `presentors` (
  `id` int(3) NOT NULL,
  `course_id` int(3) NOT NULL,
  `presentor_id` int(3) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `presentors`
--

INSERT INTO `presentors` (`id`, `course_id`, `presentor_id`) VALUES
(60, 30, 1),
(62, 31, 18);

-- --------------------------------------------------------

--
-- Table structure for table `submitted_exercises`
--

CREATE TABLE `submitted_exercises` (
  `id` int(3) NOT NULL,
  `exercise_id` int(3) NOT NULL,
  `user_id` int(3) unsigned NOT NULL,
  `description` blob NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(3) unsigned NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_role` int(1) NOT NULL,
  `profile_image` varchar(40) DEFAULT NULL,
  `session_id` varchar(40) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `reset_password` char(64) DEFAULT NULL,
  `deletion_link_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_role`, `profile_image`, `session_id`, `status`, `reset_password`, `deletion_link_time`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1, NULL, NULL, 1, NULL, NULL),
(13, 'Kristine', 'Varga', 'vkristine', 'v.kristine.c@gmail.com', '5f1c263ead9c8b960eefc0b5a9973f78', 3, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL),
(14, 'Alex', 'Ungureanu', 'ualex', 'ungureanualex17@yahoo.com', '5f1c263ead9c8b960eefc0b5a9973f78', 3, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL),
(15, 'Andreea', 'Cristescu', 'candreea', 'andreea_laura_cristescu@yahoo.com', '5f1c263ead9c8b960eefc0b5a9973f78', 3, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL),
(16, 'Andrei', 'Csiki', 'candrei', 'andrei.g.csiki@gmail.com', '5f1c263ead9c8b960eefc0b5a9973f78', 3, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL),
(17, 'Andrei', 'Pfeiffer', 'pandrei', 'andrei.pfeiffer@e-spres-oh.com', 'e478b124e04049149dbcc58c81ef3ec3', 2, '21232f297a57a5a743894a0e4a801fc3.png', 'f838c054ad60d6e8dbea48ac1e6545a1', 1, NULL, NULL),
(18, 'Cristi', 'Sitov', 'scristi', 'cristian.sitov@e-spres-oh.com', 'e478b124e04049149dbcc58c81ef3ec3', 2, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL),
(19, 'Razvan', 'Stan', 'srazvan', 'razvan.stan@e-spres-oh.com', 'e478b124e04049149dbcc58c81ef3ec3', 2, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL),
(20, 'Bogdan', 'Dinga', 'dbogdan', 'bogdan.dinga@e-spres-oh.com', 'e478b124e04049149dbcc58c81ef3ec3', 2, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL),
(21, 'Claudiu', 'Vintila', 'vclaudiu', 'claudiu.vintila@e-spres-oh.com', 'e478b124e04049149dbcc58c81ef3ec3', 2, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL),
(22, 'Sorin', 'Pintea', 'psorin', 'sorin.pintea@e-spres-oh.com', 'e478b124e04049149dbcc58c81ef3ec3', 2, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL),
(23, 'Alecs', 'Popa', 'palecs', 'alecs.popa@e-spres-oh.com', 'e478b124e04049149dbcc58c81ef3ec3', 2, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL),
(24, 'Andrei', 'Laza', 'landrei', 'andrei.laza@e-spres-oh.com', 'e478b124e04049149dbcc58c81ef3ec3', 2, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL),
(25, 'Ciprian', 'Zaharie', 'zciprian', 'ciprian.zaharie@e-spres-oh.com', 'e478b124e04049149dbcc58c81ef3ec3', 2, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_privileges`
--

CREATE TABLE `users_privileges` (
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
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `presentors`
--
ALTER TABLE `presentors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `presentor_id` (`presentor_id`),
  ADD KEY `presentor_id_2` (`presentor_id`);

--
-- Indexes for table `submitted_exercises`
--
ALTER TABLE `submitted_exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exercise_id` (`exercise_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`),
  ADD KEY `user_privilege` (`user_role`),
  ADD KEY `resetPassword` (`reset_password`),
  ADD KEY `session_id` (`session_id`);

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
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `presentors`
--
ALTER TABLE `presentors`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `submitted_exercises`
--
ALTER TABLE `submitted_exercises`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `users_privileges`
--
ALTER TABLE `users_privileges`
  MODIFY `privilege_id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `exercises`
--
ALTER TABLE `exercises`
  ADD CONSTRAINT `exercise_course_id_FK` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `presentors`
--
ALTER TABLE `presentors`
  ADD CONSTRAINT `course_id_FK` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `presentor_id_FK` FOREIGN KEY (`presentor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `submitted_exercises`
--
ALTER TABLE `submitted_exercises`
  ADD CONSTRAINT `exercise_id_FK` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`),
  ADD CONSTRAINT `user_id_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_privilege_FK` FOREIGN KEY (`user_role`) REFERENCES `users_privileges` (`privilege_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
