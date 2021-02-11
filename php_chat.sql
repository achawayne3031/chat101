-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2021 at 02:25 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_data`
--

CREATE TABLE `chat_data` (
  `id` int(11) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `receiver` varchar(100) NOT NULL,
  `data` text NOT NULL,
  `time_entry` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_data`
--

INSERT INTO `chat_data` (`id`, `sender`, `receiver`, `data`, `time_entry`) VALUES
(1, 'acha61997', 'birdman38222', 'hello mr birdman', '1611430187'),
(2, 'birdman38222', 'acha61997', 'big man, how va', '1611430137'),
(3, 'acha61997', 'birdman38222', 'hye', '1611430190');

-- --------------------------------------------------------

--
-- Table structure for table `chat_log`
--

CREATE TABLE `chat_log` (
  `id` int(11) NOT NULL,
  `user1` varchar(100) NOT NULL,
  `user2` varchar(100) NOT NULL,
  `log_id` varchar(100) NOT NULL,
  `chat_msg` text NOT NULL,
  `chat_time` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_log`
--

INSERT INTO `chat_log` (`id`, `user1`, `user2`, `log_id`, `chat_msg`, `chat_time`) VALUES
(6, 'birdman38222', 'acha61997', 'birdman38222acha61997', 'we are coming', 1613045862),
(7, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'yes, on the wayne', 1613046033),
(8, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'gdgdgdg', 1613046147),
(9, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'we will come now', 1613046165),
(10, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'hello', 1613046817),
(11, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'we are comming', 1613046828),
(12, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'ok', 1613046834),
(13, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'bring it donw', 1613046842),
(14, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'wev are good', 1613046955),
(15, 'acha61997', 'tunechi56177', 'acha61997tunechi56177', 'hello', 1613046991),
(16, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'hello, w ae hete', 1613047899),
(17, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'yesm, we ae here', 1613048303),
(18, 'birdman38222', 'acha61997', 'birdman38222acha61997', 'come on gilr', 1613048377),
(19, 'birdman38222', 'acha61997', 'birdman38222acha61997', 'hwo cab', 1613048422),
(20, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'we rae', 1613048767),
(21, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'ok', 1613048772),
(22, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'hfh', 1613048947),
(23, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'hello', 1613048998),
(24, 'birdman38222', 'acha61997', 'birdman38222acha61997', 'gdgdgd', 1613049006),
(25, 'birdman38222', 'acha61997', 'birdman38222acha61997', 'gdgdg', 1613049863),
(26, 'acha61997', 'birdman38222', 'acha61997birdman38222', 'heool', 1613049879);

-- --------------------------------------------------------

--
-- Table structure for table `last_activity`
--

CREATE TABLE `last_activity` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `last_time` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `last_activity`
--

INSERT INTO `last_activity` (`id`, `username`, `status`, `action`, `last_time`) VALUES
(1, 'acha61997', 'online', 'login', '1613042259'),
(2, 'maka66823', 'offline', 'login', '1611430128'),
(3, 'tunechi56177', 'offline', 'login', '1611430187'),
(4, 'birdman38222', 'online', 'login', '1613044402'),
(5, 'clinton12690', 'offline', 'logout', '1611430435'),
(6, 'amaka42607', 'online', 'login', '1611580724');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `time_record` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `online` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password`, `gender`, `img`, `time_record`, `online`) VALUES
(16, 'gfhhhf', 'gfhhhf70036', 'achawayne1@gmail.com', '$2y$10$BTzcl.tXjqkTzGnPXqmYVedE3v866MJT0z/aOtJl6bdTtp98Qyu4y', 'male', '', '2021-01-23 12:48:29', '0'),
(18, 'acha chiemelie', 'acha61997', 'achawayne@gmail.com', '$2y$10$OAFf5LjVmBQDG790ic..wu3QLVDh66fJAIksqHLrm.ivU4xwrglVC', 'male', 'acha619971611643595.jpg', '2021-01-23 13:37:48', '0'),
(19, 'maka udo', 'maka66823', 'makaveli@yahoo.com', '$2y$10$BghBApoP1/j4DEIg7GdH0eCG6ZhVnVuKjTYbaXM1/QUBbmp6tlrYa', 'male', '', '2021-01-23 19:20:07', '0'),
(20, 'tunechi wayne', 'tunechi56177', 'tunechi@gmail.com', '$2y$10$llF.nGlhPcoSZCOGodxOq.0c5wLixunto1RLa0rDgmoqJ4upCXx3K', 'male', '', '2021-01-23 19:20:28', '0'),
(21, 'clinton east', 'clinton12690', 'clinton@gmail.com', '$2y$10$LgdZd74cj7IrNVvrTMdCb.mQ7xfGKQ002xCaUNwAzbL6Jw3PhIwwS', 'male', '', '2021-01-23 19:32:15', '0'),
(22, 'birdman stunna', 'birdman38222', 'birdman@yahoo.com', '$2y$10$Re8EjI5VEQINwga40xAwoutV9/8FyDgGbdP0UGGeAeWKUduvLI.aC', 'male', '', '2021-01-23 19:32:46', '0'),
(23, 'amaka eke', 'amaka42607', 'amakaeke@gmail.com', '$2y$10$k1HMo/1fGFrcSCHxL39RKenJqn9bvrknq6033LjCJXMFj0IRC4rcy', 'female', 'amaka426071611580693.jpg', '2021-01-25 11:14:55', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_data`
--
ALTER TABLE `chat_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_log`
--
ALTER TABLE `chat_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `last_activity`
--
ALTER TABLE `last_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_data`
--
ALTER TABLE `chat_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chat_log`
--
ALTER TABLE `chat_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `last_activity`
--
ALTER TABLE `last_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
