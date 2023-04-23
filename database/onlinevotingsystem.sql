-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2023 at 06:42 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinevotingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate_details`
--

CREATE TABLE `candidate_details` (
  `id` int(11) NOT NULL,
  `election_id` int(11) DEFAULT NULL,
  `candidate_name` varchar(255) DEFAULT NULL,
  `candidate_details` text DEFAULT NULL,
  `candidate_photo` text NOT NULL,
  `inserted_by` varchar(255) DEFAULT NULL,
  `inserted_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidate_details`
--

INSERT INTO `candidate_details` (`id`, `election_id`, `candidate_name`, `candidate_details`, `candidate_photo`, `inserted_by`, `inserted_on`) VALUES
(4, 2, 'Winter', 'cute', '../assets/images/candidate_photos/563_266_winter.jpg', 'ryle', '2023-04-23'),
(5, 2, 'test', 'test', '../assets/images/candidate_photos/569_585_logo.png', 'ryle', '2023-04-23'),
(6, 2, 'wew', 'tesst', '../assets/images/candidate_photos/603_167_winter.jpg', 'ryle', '2023-04-23'),
(7, 3, 'Vice test', 'lmao', '../assets/images/candidate_photos/660_808_winter.jpg', 'ryle', '2023-04-23'),
(8, 3, 'Vice 2', 'qwqw', '../assets/images/candidate_photos/808_238_logo.png', 'ryle', '2023-04-23'),
(9, 3, 'Vice 3', 'asdasd', '../assets/images/candidate_photos/115_291_winter.jpg', 'ryle', '2023-04-23'),
(10, 4, 'idk', 'test', '../assets/images/candidate_photos/354_410_winter.jpg', 'ryle', '2023-04-23');

-- --------------------------------------------------------

--
-- Table structure for table `election`
--

CREATE TABLE `election` (
  `id` int(11) NOT NULL,
  `election_topic` varchar(255) DEFAULT NULL,
  `no_of_candidates` int(11) DEFAULT NULL,
  `starting_date` date DEFAULT NULL,
  `ending_date` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `inserted_by` varchar(255) DEFAULT NULL,
  `inserted_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `election`
--

INSERT INTO `election` (`id`, `election_topic`, `no_of_candidates`, `starting_date`, `ending_date`, `status`, `inserted_by`, `inserted_on`) VALUES
(2, 'President', 3, '2023-04-24', '2023-04-28', 'Active', 'ryle', '2023-04-22'),
(3, 'Vice President', 3, '2023-04-24', '2023-04-28', 'Inactive', 'ryle', '2023-04-23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `su_id_no` int(11) NOT NULL,
  `su_username` varchar(255) DEFAULT NULL,
  `su_password` text DEFAULT NULL,
  `user_role` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `su_id_no`, `su_username`, `su_password`, `user_role`) VALUES
(6, 20220867, 'ryl', '0619a7d9438d75a0ede0bd5ab3b298ee95d06d7a', 'voter'),
(7, 20220868, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'voter'),
(8, 20220864, 'ryle', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `votings`
--

CREATE TABLE `votings` (
  `id` int(11) NOT NULL,
  `election_id` int(11) DEFAULT NULL,
  `voter_id` int(11) DEFAULT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `vote_date` date DEFAULT NULL,
  `vote_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votings`
--

INSERT INTO `votings` (`id`, `election_id`, `voter_id`, `candidate_id`, `vote_date`, `vote_time`) VALUES
(8, 2, 6, 4, '2023-04-23', '03:52:24'),
(9, 2, 7, 5, '2023-04-23', '03:55:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate_details`
--
ALTER TABLE `candidate_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `election`
--
ALTER TABLE `election`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votings`
--
ALTER TABLE `votings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate_details`
--
ALTER TABLE `candidate_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `election`
--
ALTER TABLE `election`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `votings`
--
ALTER TABLE `votings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
