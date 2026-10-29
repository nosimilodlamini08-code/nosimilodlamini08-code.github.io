-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2026 at 04:07 PM
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
-- Database: `bling_rental_company`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `face_encoding` longtext DEFAULT NULL,
  `role` varchar(50) DEFAULT 'SuperAdmin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `face_encoding`, `role`, `created_at`, `last_login`) VALUES
(1, 'admin', 'admin@blingrentals.co.sz', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'SuperAdmin', '2026-06-01 10:43:11', NULL),
(2, 'System Admin', 'system.admin@gmail.com', '$2y$10$yr9impbpUpJqyUVH45p40e2PBZYvOxmCr15Dqc.9quo9m5pQProFe', 'admin_face_token_fallback_verify_2026', 'SuperAdmin', '2026-06-01 10:54:58', NULL),
(4, 'Administrator', 'administrator@bling.com', '$2y$10$7R1eBSTBQvkqYXywGclRWOXq8IySWSohbwh0fP.ZDfMQ3mn8xvhdK', 'admin_face_token_fallback_verify_2026', 'SuperAdmin', '2026-06-01 13:35:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `vehicle_name` varchar(255) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `total_payment` decimal(10,2) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `transit_method` varchar(100) DEFAULT NULL,
  `handover_address` text DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Confirmed','Completed','Cancelled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `vehicle_id`, `vehicle_name`, `full_name`, `total_payment`, `driver_name`, `payment_method`, `transit_method`, `handover_address`, `booking_date`, `status`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-01 05:57:16', 'Pending'),
(2, 7, NULL, 'BMW 7 Series M760e', NULL, 2400.00, 'Self-Drive Base Options Selected', 'PayPal Express Account', 'Company Premise Collection', 'Suite 402, Bling Towers, Custom Corporate Highway, Mbabane, Eswatini', '2026-06-01 13:04:24', 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `client_name` varchar(100) DEFAULT 'Anonymous',
  `client_email` varchar(150) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `admin_response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `client_name`, `client_email`, `user_id`, `message`, `admin_response`, `created_at`) VALUES
(1, 'Anonymous', NULL, 1, 'Great service, but the car was slightly dirty.', 'We apologize for the inconvenience and have addressed this with our cleaning team.', '2026-06-01 05:57:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `face_encoding` text DEFAULT NULL,
  `is_blocked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `face_encoding`, `is_blocked`, `created_at`) VALUES
(1, 'John Dlamini', 'john@example.com', 'john@123', NULL, 1, '2026-06-01 05:57:16'),
(4, 'buhle dlamini', 'buhle.dlamini@gmail.com', '$2y$10$kZpxJO4rC4e8kUrEOeYCGusgEaa7zZDogDmSvLeivA3K3ua6lEffC', 'face_vector_matrix_hash_token_verified_bling_system_2026', 0, '2026-06-01 10:19:29'),
(5, 'Phumaphi Hlophe', 'phumaphi.hlophe1513@gmail.com', '$2y$10$Dm9hED4CF5Tegnkem1itmui9hYATuCQ7KDTzHpfKvfGP5TIAIXqua', 'face_vector_matrix_hash_token_verified_bling_system_2026', 1, '2026-06-01 10:22:33'),
(6, 'gemini mbhele', 'gemini.mbhele@icloud.com', '$2y$10$I9O5FQrgLp1hgzSaFhLB7uORuu7B8I00DOagY6Zlc4pDpjq9vejNC', 'face_vector_matrix_hash_token_verified_bling_system_2026', 0, '2026-06-01 10:25:20'),
(7, 'Thubelihle Bhembe', 'thuba.bhembe@gmail.com', '$2y$10$/E.iUixGYZ25vcDees/vduHgfan7p2seMBqjPgifbOEBPHsFolk.O', 'face_vector_matrix_hash_token_verified_bling_system_2026', 0, '2026-06-01 12:58:51');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `status` enum('Available','Booked','Maintenance') DEFAULT 'Available',
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `engine_capacity` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `mileage` varchar(50) DEFAULT NULL,
  `fuel_consumption` varchar(50) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `seats` int(11) DEFAULT NULL,
  `transmission` varchar(50) DEFAULT NULL,
  `fuel` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `name`, `type`, `status`, `price_per_day`, `image`, `engine_capacity`, `color`, `mileage`, `fuel_consumption`, `rating`, `year`, `location`, `seats`, `transmission`, `fuel`) VALUES
(1, 'Toyota Corolla', 'Sedan', 'Available', 1200.00, 'corolla.jpg', '1.8L', 'White', '5000km', '6L/100km', 4.5, 2024, 'Mbabane', 5, 'Automatic', 'Petrol'),
(2, 'Ford Ranger', 'SUV', 'Available', 1800.00, 'ranger.jpg', '2.2L', 'Silver', '12000km', '8L/100km', 4.8, 2023, 'Manzini', 5, 'Manual', 'Diesel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
