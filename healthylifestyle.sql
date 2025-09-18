-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Mar 12, 2025 at 06:39 PM
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
-- Database: `healthylifestyle`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activity_id` varchar(5) NOT NULL,
  `activity_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  `Fees` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `uploadimage` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activity_id`, `activity_name`, `description`, `duration`, `Fees`, `created_at`, `updated_at`, `uploadimage`) VALUES
('A-01', 'Yoga Classes', 'Here\'s organized a day or weekend retreat focused on yoga and mindfulness in a natural setting.', 180, 25000, '2025-03-12 07:44:00', '2025-03-12 08:01:36', 'A-1.jpg'),
('A-02', 'Pottery Classes', 'An evening where participants can unwind by creating pottery and engaging in other artistic activities.', 240, 25000, '2025-03-12 07:52:00', '2025-03-12 08:08:22', 'A-2.jpg'),
('A-03', 'Hiking Adventures', 'Nature Connection Day, a day of group hikes to explore local trails, promoting physical activity and connection with nature.', 300, 25000, '2025-03-12 07:53:00', '2025-03-12 08:08:30', 'A-3.jpg'),
('A-04', 'Mindfulness Meditation', 'Stress Relief Day, Offer a day dedicated to stress management techniques, including guided meditation sessions and relaxation exercises.', 240, 20000, '2025-03-12 07:54:00', '2025-03-12 08:08:39', 'A-4.jpg'),
('A-05', 'Cycling Groups', 'Community Cycling Day, a day for community members to join group rides, promoting fitness and social interaction.', 300, 25000, '2025-03-12 07:56:00', '2025-03-12 08:09:18', 'A-5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(5) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `email`, `created_at`, `updated_at`) VALUES
('A-01', 'joy123', 'joy12345', 'joy@gmail.com', '2025-03-07 20:50:50', '2025-03-08 21:08:20');

-- --------------------------------------------------------

--
-- Table structure for table `enroll`
--

CREATE TABLE `enroll` (
  `user_id` varchar(5) NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(40) NOT NULL,
  `phnumber` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `e_name` varchar(50) NOT NULL,
  `e_number` int(11) NOT NULL,
  `medical_condition` varchar(150) NOT NULL,
  `current_medication` varchar(150) NOT NULL,
  `event_id` varchar(5) DEFAULT NULL,
  `activity_id` varchar(5) DEFAULT NULL,
  `preferred_time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enroll`
--

INSERT INTO `enroll` (`user_id`, `type`, `name`, `dob`, `gender`, `phnumber`, `email`, `e_name`, `e_number`, `medical_condition`, `current_medication`, `event_id`, `activity_id`, `preferred_time`) VALUES
('U-01', 'activity', 'Sam', '2000-10-17', 'male', 2147483647, 'sam@gmail.com', 'Gabby', 948513256, 'none', 'none', NULL, 'A-02', 'evening ');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` varchar(5) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `max_participants` int(11) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `uploadimage` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_name`, `event_date`, `start_time`, `end_time`, `location`, `description`, `max_participants`, `created_time`, `updated_time`, `uploadimage`) VALUES
('E-01', 'Work-Life Balance Seminars', '2025-03-23', '21:30:00', '12:30:00', 'YANGON', 'Hosting speakers or experts who discuss strategies for achieving work-life balance.', 30, '2025-03-12 06:12:00', '2025-03-12 08:02:42', 'E-1.jpg'),
('E-02', 'Team Retreats', '2025-03-29', '13:00:00', '16:00:00', 'YANGON', 'Organizing off-site retreats that focus on team bonding and stress relief.', 20, '2025-03-12 07:26:00', '2025-03-12 08:02:50', 'E-2.jpg'),
('E-03', 'Wellness Days', '2025-04-05', '15:00:00', '18:00:00', 'YANGON', 'Designating specific days for employees to focus on their well-being, including activities like yoga, massages, or relaxation sessions.', 25, '2025-03-12 07:30:00', '2025-03-12 08:04:24', 'E-3.jpg'),
('E-04', 'Networking Mixers', '2025-04-12', '07:00:00', '09:00:00', 'YANGON', 'Casual events that allow professionals to connect in a relaxed environment, promoting both work and social interaction.', 30, '2025-03-12 07:34:00', '2025-03-12 08:04:34', 'E-4.jpg'),
('E-05', 'Family Fun Days', '2025-04-19', '13:00:00', '17:00:00', 'YANGON', 'Company-sponsored events where employees can bring their families for a day of fun activities, fostering a sense of community.', 25, '2025-03-12 07:37:00', '2025-03-12 08:04:50', 'E-5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `main_admin`
--

CREATE TABLE `main_admin` (
  `main_admin_id` int(5) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_admin`
--

INSERT INTO `main_admin` (`main_admin_id`, `username`, `password`, `email`, `created_at`, `updated_at`) VALUES
(1, 'madmin1', 'madmin12345', 'madmin@gmail.com', '2025-03-08 20:55:53', '2025-03-08 20:55:53');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `user_activity_id` int(11) NOT NULL,
  `user_id` varchar(5) NOT NULL,
  `activity_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_event`
--

CREATE TABLE `user_event` (
  `user_event_id` int(11) NOT NULL,
  `user_id` varchar(5) NOT NULL,
  `event_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `enroll`
--
ALTER TABLE `enroll`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `Fk1` (`event_id`),
  ADD KEY `FkA` (`activity_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `main_admin`
--
ALTER TABLE `main_admin`
  ADD PRIMARY KEY (`main_admin_id`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`user_activity_id`),
  ADD KEY `Fk6` (`activity_id`),
  ADD KEY `Fk7` (`user_id`);

--
-- Indexes for table `user_event`
--
ALTER TABLE `user_event`
  ADD PRIMARY KEY (`user_event_id`),
  ADD KEY `Fk2` (`user_id`),
  ADD KEY `Fk3` (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `user_activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_event`
--
ALTER TABLE `user_event`
  MODIFY `user_event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enroll`
--
ALTER TABLE `enroll`
  ADD CONSTRAINT `Fk1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FkA` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`activity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `Fk6` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`activity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk7` FOREIGN KEY (`user_id`) REFERENCES `enroll` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_event`
--
ALTER TABLE `user_event`
  ADD CONSTRAINT `Fk2` FOREIGN KEY (`user_id`) REFERENCES `enroll` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk3` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
