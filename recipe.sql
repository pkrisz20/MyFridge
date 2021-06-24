-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2021 at 11:40 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipe`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE `blocked_users` (
  `id` int(30) NOT NULL,
  `username_id` int(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `mobile` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments_and_ratings`
--

CREATE TABLE `comments_and_ratings` (
  `id` int(30) NOT NULL,
  `recipe_id` int(30) NOT NULL,
  `username_id` int(30) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `rating` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_recipes`
--

CREATE TABLE `favorite_recipes` (
  `id` int(30) NOT NULL,
  `recipe_id` int(30) NOT NULL,
  `registered_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `weight_g` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `meal_recipes`
--

CREATE TABLE `meal_recipes` (
  `id` int(30) NOT NULL,
  `meal_name` varchar(30) NOT NULL,
  `ingredients_id` int(30) NOT NULL,
  `image` varchar(500) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `price` double(6,2) NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(30) NOT NULL,
  `menu_name` varchar(30) NOT NULL,
  `day_of_the_week` varchar(30) NOT NULL,
  `recipes` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `new_comments`
--

CREATE TABLE `new_comments` (
  `id` int(30) NOT NULL,
  `recipe_id` int(30) NOT NULL,
  `username_id` int(30) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `rating` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `new_recipes`
--

CREATE TABLE `new_recipes` (
  `id` int(30) NOT NULL,
  `meal_name` int(30) NOT NULL,
  `ingredients_id` int(30) NOT NULL,
  `image` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` double(6,2) NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `registered`
--

CREATE TABLE `registered` (
  `id` int(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `mobile` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`username_id`);

--
-- Indexes for table `comments_and_ratings`
--
ALTER TABLE `comments_and_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username_id` (`username_id`),
  ADD KEY `recipe` (`recipe_id`);

--
-- Indexes for table `favorite_recipes`
--
ALTER TABLE `favorite_recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `registered_id` (`registered_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meal_recipes`
--
ALTER TABLE `meal_recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rec_ing_id` (`ingredients_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_comments`
--
ALTER TABLE `new_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_recipes`
--
ALTER TABLE `new_recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered`
--
ALTER TABLE `registered`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blocked_users`
--
ALTER TABLE `blocked_users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments_and_ratings`
--
ALTER TABLE `comments_and_ratings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorite_recipes`
--
ALTER TABLE `favorite_recipes`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meal_recipes`
--
ALTER TABLE `meal_recipes`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `new_comments`
--
ALTER TABLE `new_comments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `new_recipes`
--
ALTER TABLE `new_recipes`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registered`
--
ALTER TABLE `registered`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD CONSTRAINT `id` FOREIGN KEY (`username_id`) REFERENCES `registered` (`id`);

--
-- Constraints for table `comments_and_ratings`
--
ALTER TABLE `comments_and_ratings`
  ADD CONSTRAINT `recipe` FOREIGN KEY (`recipe_id`) REFERENCES `meal_recipes` (`id`),
  ADD CONSTRAINT `username_id` FOREIGN KEY (`username_id`) REFERENCES `registered` (`id`);

--
-- Constraints for table `favorite_recipes`
--
ALTER TABLE `favorite_recipes`
  ADD CONSTRAINT `recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `meal_recipes` (`id`),
  ADD CONSTRAINT `registered_id` FOREIGN KEY (`registered_id`) REFERENCES `registered` (`id`);

--
-- Constraints for table `meal_recipes`
--
ALTER TABLE `meal_recipes`
  ADD CONSTRAINT `rec_ing_id` FOREIGN KEY (`ingredients_id`) REFERENCES `ingredients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
