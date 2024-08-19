-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2024 at 07:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `star_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `position` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`user_id`, `first_name`, `last_name`, `gender`, `dob`, `position`, `email`) VALUES
(1, 'Ramesh', 'Rukshan', 'male', '2014-08-13', 'Project Manager', 'ramesh.rukshan@gmail.com'),
(6, 'Test', 'User', 'Male', '0000-00-00', 'Software Engineer', 'thilina@gmail.com'),
(7, 'Oneli', 'Sakura', 'Female', '0000-00-00', 'Software Engineer', 'oneli@gmail.com'),
(8, 'Before', 'Host', 'Male', '0000-00-00', 'Software Engineer', 'email@gmail.cohg');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `user_id` int(11) NOT NULL,
  `basic_salary` int(100) NOT NULL,
  `travel_all` int(100) NOT NULL,
  `meal_all` int(100) NOT NULL,
  `other_all` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`user_id`, `basic_salary`, `travel_all`, `meal_all`, `other_all`) VALUES
(1, 120000, 26000, 15000, 10000),
(6, 22000, 0, 0, 0),
(7, 400000, 25000, 15000, 5000),
(8, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `salary_slip`
--

CREATE TABLE `salary_slip` (
  `user_id` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `ot` int(11) NOT NULL,
  `other` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `row_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary_slip`
--

INSERT INTO `salary_slip` (`user_id`, `date_created`, `ot`, `other`, `total`, `row_id`) VALUES
(1, '2024-08-13', 1, 50000, 221000, 1),
(1, '2024-08-19', 1, 10000, 186000, 2),
(6, '2024-08-19', 3, 100, 37100, 3),
(1, '2024-08-19', 5, 50000, 246000, 4),
(7, '2024-08-19', 0, 10000, 455000, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2a$12$O6U3DBkFy3A5jIo.3Xq49uXVdTS//7KVxA6wuQowk4rIFgLVPV32e', 'admin'),
(6, 'user', '$2y$10$MAxbH4bSuzTwy5iovfGCX.qchpoeEkWxvCfrwSyTbS2C11mc6cPkK', 'user'),
(7, 'oneli', '$2y$10$64nodX0n2uuE73focNN5D..ypYyGfppawoaZeCcWvDMNfaaZmpEb.', 'user'),
(8, 'tplp', '$2y$10$nk/wGSo/yiAvfWYVkbZiaOZWgRUifk4a783GmrpubmOyWL5zSgCsa', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `salary_slip`
--
ALTER TABLE `salary_slip`
  ADD PRIMARY KEY (`row_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `salary_slip`
--
ALTER TABLE `salary_slip`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
