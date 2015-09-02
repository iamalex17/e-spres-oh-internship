-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2015 at 02:42 PM
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
  `title` varchar(50) NOT NULL,
  `label` varchar(20) NOT NULL,
  `description` blob,
  `status` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `label`, `description`, `status`) VALUES
(1, 'Introduction', 'Frontend, Backend', 0x3c703e5072657a656e74617265206669726d612073692073656469753c6272202f3e46726f6e74656e642076732e204261636b656e643a3c6272202f3e687474703a2f2f7777772e70727564656e732e636f6d2f696d616765732f6562757366726f6e746261636b656e64322e676966203c6272202f3e436c69656e742076732e205365727665723a3c6272202f3e687474703a2f2f777073686f75742e636f6d2f6d656469612f323031342f30382f636c69656e745f7365727665722e706e67203c6272202f3e68747470733a2f2f6d6964646c6577617265732e66696c65732e776f726470726573732e636f6d2f323030382f30342f372e6a7067203c6272202f3e436f6e74696e756f7573206c6561726e696e673a3c6272202f3e525353202d2068747470733a2f2f6769746875622e636f6d2f7061756c69726973682f66726f6e74656e642d6665656473203c6272202f3e4d656574757073202d20687474703a2f2f7777772e6d65657475702e636f6d2f3c6272202f3e46453a68747470733a2f2f6769746875622e636f6d2f64797073696c6f6e2f66726f6e74656e642d6465762d626f6f6b6d61726b733c6272202f3e42453a687474703a2f2f7777772e6c6561726e2d7068702e6f72672f203c6272202f3e496e74726561626120756e207072696574656e202f20636f6c65673c6272202f3e456469746f7220636f642076732e204944453c2f703e, 1),
(2, 'Tools', 'Frontend', 0x3c703e43616e204920557365202d20687474703a2f2f63616e697573652e636f6d2f3c6272202f3e4a7348696e74202d20687474703a2f2f6a7368696e742e636f6d2f3c6272202f3e4a7342696e202d20687474703a2f2f6a7362696e2e636f6d2f3c6272202f3e5368656c6c20436f6d6d616e6473202d20687474703a2f2f6578706c61696e7368656c6c2e636f6d2f3c6272202f3e4c6f72656d20497073756d202d20687474703a2f2f7777772e6c697073756d2e636f6d2f3c6272202f3e496d61676520706c616365686f6c646572202d20687474703a2f2f706c616365686f6c642e69742f202c20687474703a2f2f6c6f72656d706978656c2e636f6d2f3c2f703e, 1),
(3, 'HTML', 'Frontend', 0x3c703e486973746f72792028416e64726569293a3c6272202f3e687474703a2f2f7777772e617070736c69636b2e636f6d2f77702d636f6e74656e742f75706c6f6164732f323031332f30332f68746d6c352d696e666f67726170686963732e6a7067203c6272202f3e446f63756d656e74206f75746c696e652028416e64726569293a3c6272202f3e687474703a2f2f68746d6c35646f63746f722e636f6d2f6f75746c696e65732f3c6272202f3e687474703a2f2f7777772e736d617368696e676d6167617a696e652e636f6d2f323031332f30312f31382f7468652d696d706f7274616e63652d6f662d73656374696f6e732f3c2f703e0d0a3c703e687474703a2f2f68746d6c35646f63746f722e636f6d2f646f776e6c6f6164732f6835642d73656374696f6e696e672d666c6f7763686172742e706466203c6272202f3e546f6f6c3a20687474703a2f2f686f796f69732e6769746875622e696f2f68746d6c356f75746c696e65722f3c6272202f3e446973706c61792074797065732028416e64726569293c6272202f3e68747470733a2f2f646576656c6f7065722e6d6f7a696c6c612e6f72672f656e2d55532f646f63732f5765622f48544d4c2f426c6f636b2d6c6576656c5f656c656d656e74733c6272202f3e68747470733a2f2f646576656c6f7065722e6d6f7a696c6c612e6f72672f656e2d55532f646f63732f5765622f48544d4c2f496e6c696e655f656c656d656e74653c6272202f3e53656d616e74696320656c656d656e7473202852617a76616e293c6272202f3e687474703a2f2f68746d6c35646f63746f722e636f6d2f61727469636c652d617263686976652f3c6272202f3e5461626c6573202852617a76616e293c6272202f3e687474703a2f2f6373732d747269636b732e636f6d2f636f6d706c6574652d67756964652d7461626c652d656c656d656e742f3c6272202f3e687474703a2f2f6c6561726e2e73686179686f77652e636f6d2f68746d6c2d6373732f6f7267616e697a696e672d646174612d776974682d7461626c65732f3c6272202f3e466f726d73202852617a76616e293c6272202f3e68747470733a2f2f646576656c6f7065722e6d6f7a696c6c612e6f72672f656e2d55532f646f63732f5765622f47756964652f48544d4c2f466f726d733c6272202f3e68747470733a2f2f646576656c6f7065722e6d6f7a696c6c612e6f72672f656e2d55532f646f63732f5765622f47756964652f48544d4c2f466f726d732f486f775f746f5f7374727563747572655f616e5f48544d4c5f666f726d3c6272202f3e687474703a2f2f6c6561726e2e73686179686f77652e636f6d2f68746d6c2d6373732f6275696c64696e672d666f726d732f3c6272202f3e41636365736962696c6974617465202f203530382028416e64726569293c6272202f3e687474703a2f2f77656261696d2e6f72672f7374616e64617264732f3530382f353038636865636b6c6973742e706466203c6272202f3e687474703a2f2f61636865636b65722e63612f636865636b65722f696e6465782e7068703c6272202f3e687474703a2f2f6b68616e2e6769746875622e696f2f746f7461313179203c6272202f3e56616c69646172652028416e64726569293c6272202f3e687474703a2f2f76616c696461746f722e77332e6f72672f3c6272202f3e687474703a2f2f6a69677361772e77332e6f72672f6373732d76616c696461746f722f3c6272202f3e687474703a2f2f67736e6564646572732e68746d6c352e6f72672f6f75746c696e65722f3c2f703e, 1),
(4, 'Variables, Data Types, Expressions, Operators', 'Backend', 0x3c703e53796e7461782c20476c6f62616c732c20436f6e7374616e74732c204d6167696320636f6e7374616e74733a3c6272202f3e687474703a2f2f7573332e7068702e6e65742f6d616e75616c2f656e2f6c616e67756167652e62617369632d73796e7461782e7068703c6272202f3e687474703a2f2f7573332e7068702e6e65742f6d616e75616c2f656e2f6c616e67756167652e7661726961626c65732e7068703c6272202f3e687474703a2f2f7573332e7068702e6e65742f6d616e75616c2f656e2f6c616e67756167652e636f6e7374616e74732e7068703c6272202f3e4f70657261746f72732026616d703b207479706573206f66206f70657261746f72733a3c6272202f3e687474703a2f2f7573332e7068702e6e65742f6d616e75616c2f656e2f6c616e67756167652e6f70657261746f72732e7068703c6272202f3e446174612054797065732c20504850204175746f6d61746963204461746120547970696e673a3c6272202f3e687474703a2f2f7573332e7068702e6e65742f6d616e75616c2f656e2f6c616e67756167652e74797065732e7068703c6272202f3e446174612054797065204a7567676c696e673a3c6272202f3e687474703a2f2f7573332e7068702e6e65742f6d616e75616c2f656e2f6c616e67756167652e74797065732e747970652d6a7567676c696e672e7068703c2f703e, 1),
(5, 'CSS', 'Frontend', 0x3c703e53706563696669636974792028426f6764616e293a3c6272202f3e687474703a2f2f73706563696669636974792e6b656567616e2e73742f3c6272202f3e526573657473202f204e6f726d616c697a65722028426f6764616e293a3c6272202f3e687474703a2f2f6d657965727765622e636f6d2f657269632f746f6f6c732f6373732f72657365742f3c6272202f3e68747470733a2f2f6e65636f6c61732e6769746875622e696f2f6e6f726d616c697a652e6373732f3c6272202f3e426f782d6d6f64656c202f20636f6e74656e742d626f78202f20626f726465722d626f783a3c6272202f3e687474703a2f2f6373732d747269636b732e636f6d2f7468652d6373732d626f782d6d6f64656c2f3c6272202f3e687474703a2f2f717569726b736d6f64652e6f72672f6373732f757365722d696e746572666163652f626f7873697a696e672e68746d6c3c6272202f3e68747470733a2f2f6373732d747269636b732e636f6d2f626f782d73697a696e672f3c6272202f3e466c6f6174732c20636c65617220666c6f6174732028426f6764616e293a3c6272202f3e687474703a2f2f6373732d747269636b732e636f6d2f616c6c2d61626f75742d666c6f6174732f3c6272202f3e687474703a2f2f6373732d747269636b732e636f6d2f616c6d616e61632f70726f706572746965732f632f636c6561722f3c6272202f3e687474703a2f2f7068726f677a2e6e65742f6373732f756e6465727374616e64696e67666c6f6174732e68746d6c3c6272202f3e687474703a2f2f737461636b6f766572666c6f772e636f6d2f612f313633333137303c6272202f3e506f736974696f6e696e672028426f6764616e293a3c6272202f3e687474703a2f2f6373732d747269636b732e636f6d2f6162736f6c7574652d72656c61746976652d66697865642d706f736974696f696e696e672d686f772d646f2d746865792d6469666665722f3c6272202f3e4c61796f75742028426f6764616e293a3c6272202f3e687474703a2f2f6c6561726e6c61796f75742e636f6d3c6272202f3e687474703a2f2f6373736c61796f757467656e657261746f722e636f6d2f3c2f703e, 1),
(6, 'SQL / MySQL', 'Backend', 0x3c703e53514c20696e74726f64756374696f6e3c6272202f3e4d7953514c2073796e7461782026616d703b206578616d706c65733a3c6272202f3e687474703a2f2f7777772e70687074686572696768747761792e636f6d2f236461746162617365733c6272202f3e496e7374616c6c696e67202f20436f6e6e656374696e6720746f204d7953514c20766961205048503c2f703e, 1);

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE IF NOT EXISTS `exercises` (
  `id` int(3) NOT NULL,
  `course_id` int(3) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `presentors`
--

INSERT INTO `presentors` (`id`, `course_id`, `presentor_id`) VALUES
(1, 1, 4),
(2, 1, 5),
(3, 2, 4),
(6, 4, 7),
(7, 5, 8),
(8, 6, 5),
(9, 3, 4),
(10, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `submitted_exercises`
--

CREATE TABLE IF NOT EXISTS `submitted_exercises` (
  `id` int(3) NOT NULL,
  `exercise_id` int(3) NOT NULL,
  `user_id` int(3) unsigned NOT NULL,
  `description` blob NOT NULL
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_role`, `profile_image`, `session_id`, `status`, `reset_password`, `deletion_link_time`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1, NULL, 'dko9a9sgplb46cg5m9iu56jq97', 1, NULL, NULL),
(2, 'Ungureanu', 'Alex', 'ualex', 'ungureanualex17@yahoo.com', '081d29b9330707cc21a1bf4132f7d3f7', 3, NULL, 'jm0m3gv07ejm4gi8kcug9jpsq7', 1, NULL, NULL),
(3, 'Csiki', 'Andrei', 'candrei', 'andrei.g.csiki@gmail.com', '081d29b9330707cc21a1bf4132f7d3f7', 3, NULL, NULL, 1, NULL, NULL),
(4, 'Pfeiffer', 'Andrei', 'pandrei', 'andrei.pfeiffer@e-spres-oh.com', '23cbeacdea458e9ced9807d6cbe2f4d6', 2, '21232f297a57a5a743894a0e4a801fc3.png', '25l4jcokk6dnj3ou3sieorns03', 1, NULL, NULL),
(5, 'Sitov', 'Cristian', 'scristi', 'cristian.sitov@e-spres-oh.com', '23cbeacdea458e9ced9807d6cbe2f4d6', 2, NULL, NULL, 1, NULL, NULL),
(6, 'Stan', 'Razvan', 'srazvan', 'stan.razvan@e-spres-oh.com', 'f03679eb7f2c1571c39a292bdc69abb7', 2, '6_bcb3798d312ed46335afe6b1c0ebd398.jpg', NULL, 1, NULL, NULL),
(7, 'Zaharie', 'Ciprian', 'zciprian', 'zaharie.ciprian@e-spres-oh.com', 'f03679eb7f2c1571c39a292bdc69abb7', 2, '7_28f4e638fbcacc4dcf40a55c12a218d0.jpg', NULL, 1, NULL, NULL),
(8, 'Dinga', 'Bogdan', 'dbogdan', 'dinga.bogdan@e-spres-oh.com', 'f03679eb7f2c1571c39a292bdc69abb7', 2, '8_5aeb1f62f6cd496dc81c07d58b82f143.jpg', NULL, 1, NULL, NULL),
(9, 'Varga', 'Kristine', 'vkristine', 'v.kristine.c@gmail.com', 'de6e127717f29bdef2d54a787b5530de', 3, '9_5415c7fe534a63366b48d388f204c328.jpg', NULL, 1, NULL, NULL),
(10, 'Cristescu', 'Andreea', 'candreea', 'andreea_laura_cristescu@yahoo.', 'de6e127717f29bdef2d54a787b5530de', 3, '21232f297a57a5a743894a0e4a801fc3.png', NULL, 1, NULL, NULL);

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
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`), ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `presentors`
--
ALTER TABLE `presentors`
  ADD PRIMARY KEY (`id`), ADD KEY `course_id` (`course_id`), ADD KEY `presentor_id` (`presentor_id`), ADD KEY `presentor_id_2` (`presentor_id`);

--
-- Indexes for table `submitted_exercises`
--
ALTER TABLE `submitted_exercises`
  ADD PRIMARY KEY (`id`), ADD KEY `exercise_id` (`exercise_id`), ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `presentors`
--
ALTER TABLE `presentors`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `submitted_exercises`
--
ALTER TABLE `submitted_exercises`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
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
