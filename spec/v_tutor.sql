-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2021 at 07:36 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `v_tutor`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2021_08_06_092612_create_admin_password_resets_table', 1),
(4, '2021_08_06_092612_create_admins_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `f_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` enum('T','U') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'T=Teacher, U=User',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_type` enum('G','P','S') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'G=GURDAIN, P=PARENT, S=STUDENT',
  `platform_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` enum('U','A','I','D','AA') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'U' COMMENT 'U=unverified,AA=Awaiting approval, A=active, I=Inactive, D=delete',
  `email_vcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_email_verify` enum('Y','N') COLLATE utf8mb4_unicode_ci DEFAULT 'N' COMMENT '	Y=YES, N=NO',
  `profile_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('M','F','O','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'M=MALE,F=FEMALE,O=OTHER,P=PREFERNOT TO SAY',
  `school` text COLLATE utf8mb4_unicode_ci,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_full_time` enum('Y','N') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Y=YES, N=NO',
  `grade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_f_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_l_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annual_income` enum('A','B','C','D','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '	A= <100,000, B=100,000 – 150,000, C=150,000 –200,000, D= 200,000 > ,P=PREFER NOT TO SAY',
  `about_me` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `f_name`, `l_name`, `email`, `user_type`, `phone`, `student_type`, `platform_type`, `platform_id`, `email_verified_at`, `password`, `address`, `status`, `email_vcode`, `is_email_verify`, `profile_pic`, `gender`, `school`, `dob`, `is_full_time`, `grade`, `parent_f_name`, `parent_l_name`, `annual_income`, `about_me`, `remember_token`, `created_at`, `updated_at`) VALUES
(34, 'Arijit', 'Jeet Basak', 'jeetbasak54@gmail.com', 'T', NULL, NULL, 'google', '105410618802396658197', NULL, NULL, NULL, 'AA', NULL, 'Y', 'https://lh3.googleusercontent.com/a-/AOh14Gibg0Yt6upJpR0_LKchkbek43M5L3gepFR94lLR5w=s96-c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-11 23:23:19', '2021-08-11 23:23:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_to_student`
--

CREATE TABLE `user_to_student` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `gender` enum('M','F','O','P') DEFAULT NULL COMMENT 'M=MALE,F=FEMALE,O=OTHER,P=PREFERNOT TO SAY',
  `school` text,
  `dob` varchar(255) DEFAULT NULL,
  `is_full_time` enum('Y','N') DEFAULT NULL COMMENT 'Y=YES, N=NO',
  `grade` varchar(255) DEFAULT NULL,
  `parent_f_name` varchar(255) DEFAULT NULL,
  `parent_l_name` varchar(255) DEFAULT NULL,
  `annual_income` enum('A','B','C','D','P') DEFAULT NULL COMMENT 'A= <100,000,   B=100,000 – 150,000,   C=150,000 –200,000,   D= 200,000 >   ,P=PREFER NOT TO SAY',
  `about_me` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD KEY `admin_password_resets_email_index` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_to_student`
--
ALTER TABLE `user_to_student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `user_to_student`
--
ALTER TABLE `user_to_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
