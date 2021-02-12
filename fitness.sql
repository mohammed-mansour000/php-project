-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2021 at 10:48 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitness`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `coach_id` int(11) NOT NULL,
  `time` varchar(85) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `description`, `coach_id`, `time`) VALUES
(30, 'HIIT', 'Get it done AND have fun. Our own twist on high-intensity interval training, HIIT24 helps maximize results in minimal time, no matter where you’re starting.', 53, 'MW 09:30-10:45'),
(31, 'Strength', 'Fun, functional and always fresh, this workout helps tone and fine-tune major muscle groups to ignite total-body strength and coordination.', 54, 'MW 14:00-15:15'),
(32, 'Cycle', 'An ever-changing mix of sprints, hills and drills. Tap into the music and your pack mindset to bring your best every time.', 59, 'Tth 09:30-10:45'),
(33, 'Yoga', 'Release tension and stiffness, and live more fully. Combining breath work, meditation and movement sequences, our yoga practice leaves you feeling calm and limber from tip to toe.', 61, 'FS 08:00-9:15'),
(34, 'Body Building', 'Mix it up and max it out to build your power, endurance and speed. Relentlessly reinvented routines help you push your limits, then smash them.', 55, 'FS 14:00-15:15');

-- --------------------------------------------------------

--
-- Table structure for table `registered_class`
--

CREATE TABLE `registered_class` (
  `register_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(55) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(55) NOT NULL,
  `userStatus` tinyint(4) NOT NULL DEFAULT 0,
  `date` date DEFAULT NULL,
  `profile_pic` varchar(85) NOT NULL,
  `user_gender` tinyint(4) DEFAULT NULL,
  `user_contact` varchar(60) DEFAULT NULL,
  `full_name` varchar(85) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `userStatus`, `date`, `profile_pic`, `user_gender`, `user_contact`, `full_name`) VALUES
(2, 'mohammed123', '123', 'mohammedmansur123@gmail.com', 1, '2020-11-11', '56881_IMG_20191009_120231_371.jpg', 1, '70121954', 'mohammed mansur'),
(12, 'Walter White', '123', 'walterwhite@hotmail.com', 0, '2020-11-11', '63685_Walter_white-8588bc81-8316-4763-8baa-3deeaf9f65b7.jpg', 1, '35', 'heisenberg'),
(13, 'ram@gmail.com30', '123', 'hamzi.masnour2000@gmail.com', 0, '2020-11-11', '', 0, '', ''),
(37, 'hasan', '123', 'hasan@gmail.com', 0, '2020-11-15', '92090_Marshmello-af355fe6-54a0-4aee-966b-a16a8746ac70.jpg', 0, '', ''),
(38, 'sara', '123', 'sara@gmail.com', 0, '2020-11-16', '48514_20171012_201952.png', 0, '', ''),
(53, 'khalil123', '12', 'khalil@gmail.com', 2, '2020-12-10', '7189_118681_adapted_1080x1920.jpg', 1, '03546284', 'khalil abdallah'),
(54, 'ayman123', '12', 'ayman@gmail.com', 2, '2020-12-10', '88031_Southpaw-wallpaper-11073815.jpg', 1, '70546284', 'ayman l essa'),
(55, 'bashir123', '12', 'bashirahmad@gmail.com', 2, '2020-12-14', '32547_IMG_20190128_224114_880.jpg', 1, '06458744', 'bashir ahmad'),
(58, 'lisa123', '123', 'lisa@gmail.com', 2, '2021-01-15', '80512_IMG_20190709_220828_466.jpg', 2, '76541545', 'lisa smith'),
(59, 'selena123', '12', 'selena@gmail.com', 2, '2021-01-15', '60676_images.jpg', 2, '03546215', 'selena dib'),
(61, 'ritta123', '12', 'ritta@gmail.com', 2, '2021-01-15', '58255_images-1.jpg', 2, '03458754', 'ritta john'),
(62, 'mahmoud123', '12', 'mahmoud@gmail.com', 1, '2021-01-15', '87264_Snapchat-1790102300.jpg', 1, '70660491', 'mahmoud al sayyed'),
(63, 'anyusername', '123', 'any@gmail.com', 0, '2021-01-15', '85518_118878_adapted_1080x1920.jpg', NULL, NULL, ''),
(64, 'anyusername2', '123', 'any2@gmail.com', 0, '2021-01-15', '66476_118514_original_3483x4354.jpg', NULL, NULL, ''),
(65, 'anyusername3', '123', 'any3@gmail.com', 0, '2021-01-15', '4622_20190213_003209.png', NULL, NULL, ''),
(66, 'username with default avatar', '123', 'any4@gmail.com', 0, '2021-01-15', '', NULL, NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `coach_id` (`coach_id`);

--
-- Indexes for table `registered_class`
--
ALTER TABLE `registered_class`
  ADD PRIMARY KEY (`register_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `registered_class`
--
ALTER TABLE `registered_class`
  MODIFY `register_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `coach_id` FOREIGN KEY (`coach_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `registered_class`
--
ALTER TABLE `registered_class`
  ADD CONSTRAINT `class_id` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
