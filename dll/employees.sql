-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Aug 12, 2024 at 03:38 AM
-- Server version: 8.0.39
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employees`
--

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `token` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `token`, `created_at`, `updated_at`) VALUES
(1, 'ecb41c9e86', '2024-08-09 01:38:48', '2024-08-09 01:38:48'),
(2, '044d2be9a4', '2024-08-09 01:41:10', '2024-08-09 01:41:10'),
(3, 'fc67113485', '2024-08-09 01:51:23', '2024-08-09 01:51:23'),
(4, '11cc3ebd9b', '2024-08-09 05:40:06', '2024-08-09 05:40:06'),
(5, 'bd169550b1', '2024-08-09 05:40:29', '2024-08-09 05:40:29'),
(6, '582a33b2e6', '2024-08-09 05:40:37', '2024-08-09 05:40:37'),
(7, '66e8b9e0e0', '2024-08-09 05:40:48', '2024-08-09 05:40:48'),
(8, 'd8505bead1', '2024-08-09 05:40:59', '2024-08-09 05:40:59'),
(9, 'aed45b7933', '2024-08-09 05:41:16', '2024-08-09 05:41:16');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `token` varchar(10) NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `token`, `sender_id`, `receiver_id`, `content`, `timestamp`, `status`) VALUES
(1, 'ecb41c9e86', 2, 1, 'Test send', '2024-08-09 01:38:48', 1),
(2, 'ecb41c9e86', 1, 2, 'test 2', '2024-08-09 01:40:51', 1),
(9, '66e8b9e0e0', 1, 5, 'Sacyyyy!!!', '2024-08-09 05:40:48', 1),
(10, 'd8505bead1', 3, 1, 'Sonia baby!!', '2024-08-09 05:40:59', 1),
(11, 'aed45b7933', 3, 7, 'Sunnt blue!!\r\n', '2024-08-09 05:41:16', 1),
(12, 'd8505bead1', 3, 1, 'hello aloi', '2024-08-09 06:44:28', 1),
(13, 'd8505bead1', 3, 1, 'waazzzzzupp!', '2024-08-09 06:44:38', 1),
(14, 'd8505bead1', 3, 1, 'eeeyyyy!!\r\n', '2024-08-09 06:44:48', 1),
(15, 'd8505bead1', 3, 1, 'kaa ', '2024-08-09 06:44:52', 1),
(16, 'd8505bead1', 3, 1, 'muunaaa', '2024-08-09 06:44:56', 1),
(17, 'd8505bead1', 3, 1, 'eeeyyyyy  ', '2024-08-09 06:46:02', 1),
(18, 'd8505bead1', 1, 3, 'hello', '2024-08-09 09:12:27', 1),
(21, 'd8505bead1', 1, 3, 'Place any pre-save logic in this function. This function executes immediately after model data has been successfully validated, but just before the data is saved. This function should also return true if you want the save operation to continue.\r\n\r\nThis callback is especially handy for any data-massaging logic that needs to happen before your data is stored. If your storage engine needs dates in a specific format, access it at $this->data and modify it.\r\n\r\nBelow is an example of how beforeSave can be used for date conversion. The code in the example is used for an application with a begindate formatted like YYYY-MM-DD in the database and is displayed like DD-MM-YYYY in the application. Of course this can be changed very easily. Use the code below in the appropriate model.', '2024-08-09 10:10:23', 1),
(22, 'd8505bead1', 3, 1, 'reply ni', '2024-08-12 01:07:49', 1),
(23, 'd8505bead1', 3, 1, 'let\'s go!', '2024-08-12 01:08:56', 1),
(24, 'd8505bead1', 3, 1, 'asdf', '2024-08-12 01:09:03', 1),
(25, 'd8505bead1', 3, 1, 'empty after reply', '2024-08-12 01:09:20', 1),
(27, 'd8505bead1', 1, 3, 'reply ko', '2024-08-12 02:55:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_ip` varchar(12) DEFAULT NULL,
  `modified_ip` varchar(12) DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created`, `modified`, `created_ip`, `modified_ip`, `last_login_time`) VALUES
(1, 'aloisacedon@gmail.com', 'a217a0cade89642e42d407c5ce9052ed239ac49b', '2024-08-07 01:48:38', '2024-08-12 01:35:42', NULL, '192.168.65.1', '2024-08-12 01:35:42'),
(2, 'carlsacedon@gmail.com', 'd1e1778537f49cb9990900082e15b449df6ddc8e', '2024-08-07 03:53:51', '2024-08-12 01:03:12', NULL, '192.168.65.1', '2024-08-12 01:03:12'),
(3, 'kim@gmail.com', 'a217a0cade89642e42d407c5ce9052ed239ac49b', '2024-08-08 05:20:38', '2024-08-12 01:06:37', NULL, '192.168.65.1', '2024-08-12 01:06:37'),
(4, 'hannah@gmail.com', 'a217a0cade89642e42d407c5ce9052ed239ac49b', '2024-08-08 08:54:16', '2024-08-08 08:54:16', NULL, NULL, NULL),
(5, 'sacy@gmail.com', 'a217a0cade89642e42d407c5ce9052ed239ac49b', '2024-08-08 08:54:38', '2024-08-08 08:54:38', NULL, NULL, NULL),
(6, 'sonia@gmail.com', 'a217a0cade89642e42d407c5ce9052ed239ac49b', '2024-08-08 08:54:51', '2024-08-08 08:54:51', NULL, NULL, NULL),
(7, 'santos@gmail.com', 'a217a0cade89642e42d407c5ce9052ed239ac49b', '2024-08-08 08:55:07', '2024-08-08 08:55:07', NULL, NULL, NULL),
(8, 'bruz@gmail.com', 'a217a0cade89642e42d407c5ce9052ed239ac49b', '2024-08-08 08:55:24', '2024-08-08 09:04:12', NULL, '192.168.65.1', '2024-08-08 08:55:33');

-- --------------------------------------------------------

--
-- Table structure for table `users_profile`
--

CREATE TABLE `users_profile` (
  `id` int NOT NULL,
  `name` varchar(25) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` enum('M','F') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `hubby` text,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users_profile`
--

INSERT INTO `users_profile` (`id`, `name`, `birthdate`, `gender`, `hubby`, `image_path`) VALUES
(1, 'ALoi Sacedon', '1997-08-01', 'F', 'Anything basta lingaw!', 'img/uploads/avatar2.png'),
(2, 'Carl Sacedon', '2004-08-17', 'M', 'hello world!', 'img/uploads/avatar3.png'),
(3, 'kimlee', NULL, NULL, NULL, NULL),
(4, 'hannah', NULL, NULL, NULL, NULL),
(5, 'sacy roberts', NULL, NULL, NULL, NULL),
(6, 'Sonia Saccs', NULL, NULL, NULL, NULL),
(7, 'Santos Sacs', NULL, NULL, NULL, NULL),
(8, 'bruz ygot', '2001-08-10', 'M', 'asdfasdf', 'img/uploads/our-slime-boy-isnt-ready-for-him-v0-ogdbtrxhgtrb1 Background Removed.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_profile`
--
ALTER TABLE `users_profile`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `id_2` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `FK_token` FOREIGN KEY (`token`) REFERENCES `conversations` (`token`),
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users_profile`
--
ALTER TABLE `users_profile`
  ADD CONSTRAINT `users_profile_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
