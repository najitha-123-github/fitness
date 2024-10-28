-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 06:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `registration_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `password`, `email`) VALUES
(1, 'arjun', 'password', 'arjun@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `name`) VALUES
(1, 'BA Arabic'),
(2, 'M.Sc. Biotechnology'),
(3, 'M.Sc. Microbiology'),
(4, 'M.Sc. Biochemistry'),
(5, 'B.Sc. Microbiology'),
(6, 'B.Sc. Biotechnology'),
(7, 'BBA'),
(8, 'Integrated M.Sc Chemistry'),
(9, 'B.Com.Computer Application'),
(10, 'B.Com Finance & Taxation'),
(11, 'M.Sc. Computer Science'),
(12, 'BCA'),
(13, 'B.Sc. Electronics'),
(14, 'M.Sc. Electronics'),
(15, 'B.A. English Literature'),
(16, 'M.A English'),
(17, 'B.Voc Animation & Graphic Design'),
(18, 'B.Voc Fashion Design & Management'),
(19, 'B.Voc IIA'),
(20, 'B.Voc Logistics Management'),
(21, 'B.Voc MSFT'),
(22, 'B.Voc SDSA'),
(23, 'B.Voc Tourism Administration & Hospitality'),
(24, 'M.A (Human Resource Management)'),
(25, 'M.Sc Psychology'),
(26, 'B.Sc. Psychology');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `weight` float NOT NULL,
  `height` float NOT NULL,
  `course` varchar(100) NOT NULL,
  `level` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `weight`, `height`, `course`, `level`, `email`, `password`, `date`) VALUES
(20, 'Sinan anwar', 65, 175, 'B.Voc Animation & Graphic Design', 'Beginner', 'sinan@gmail.com', '$2y$10$f3.7WheHxvnKz0wmMoBgDO5DgmJZXaz.W/U.d7s5oR0E6A8xHxlC6', '2024-10-23'),
(21, 'Mahadevan T G', 60, 172, 'B.Voc MSFT', 'Beginner', 'mahadevantg99@gmail.com', '$2y$10$85zFRBEYmldSCEKnhZfbrOXpNladHTok3a5mcAtLbLpwo2DevB2Qe', '2024-10-23'),
(22, 'subin', 56, 156, 'B.A. English Literature', 'Advance', 'subin123@gmail.com', '$2y$10$O0l07XarR3cZrJutgMTB6.HV/ZXac8Tw1JPaVf2zhxEamcDC2SC8S', '2024-10-23'),
(23, 'aaron k m', 56, 176, 'B.Voc Animation & Graphic Design', 'Beginner', 'aaron@gmail.com', '$2y$10$SvbWddwx/rWC7rm0378f9eZjQ91KanrGlFYkmtjaiuxI1OW06fcSq', '2024-10-23');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `video_title` varchar(255) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `day_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE `workouts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workouts`
--
ALTER TABLE `workouts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;