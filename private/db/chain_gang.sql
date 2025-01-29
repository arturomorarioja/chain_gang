-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2025 at 05:04 PM
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
-- Database: `chain_gang`
--
CREATE DATABASE IF NOT EXISTS `chain_gang` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `chain_gang`;

-- --------------------------------------------------------

--
-- Table structure for table `bicycles`
--

DROP TABLE IF EXISTS `bicycles`;
CREATE TABLE IF NOT EXISTS `bicycles` (
  `nBicycleID` int(11) NOT NULL AUTO_INCREMENT,
  `cBrand` varchar(255) NOT NULL,
  `cModel` varchar(255) NOT NULL,
  `nYear` int(4) NOT NULL,
  `cCategory` varchar(255) NOT NULL,
  `cGender` varchar(255) NOT NULL,
  `cColour` varchar(255) NOT NULL,
  `nPrice` decimal(9,2) NOT NULL,
  `nWeightKg` decimal(9,5) NOT NULL,
  `nConditionID` tinyint(3) NOT NULL,
  `cDescription` text NOT NULL,
  PRIMARY KEY (`nBicycleID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bicycles`
--

INSERT INTO `bicycles` (`nBicycleID`, `cBrand`, `cModel`, `nYear`, `cCategory`, `cGender`, `cColour`, `nPrice`, `nWeightKg`, `nConditionID`, `cDescription`) VALUES
(3, 'Trek', 'Emonda', 2017, 'Hybrid', 'Unisex', 'black', '1495.00', '1.50000', 5, 'Offers a smooth, lightweight, and versatile ride. Designed for comfort and performance on any terrain.'),
(4, 'Cannondale', 'Synapse', 2016, 'Road', 'Unisex', 'matte black', '1999.00', '1.00000', 5, 'Delivers a smooth, fast, and efficient ride. Engineered for performance and comfort on long road journeys.'),
(5, 'Schwinn', 'Cutter', 2016, 'City', 'Unisex', 'white', '450.00', '18.00000', 4, 'Provides a smooth, comfortable, and reliable ride. Perfect for commuting and urban exploration.'),
(6, 'Mongoose', 'Switchback Sport', 2015, 'Mountain', 'Mens', 'blue', '399.00', '24.00000', 2, 'Built for rugged trails and tough terrain, offering durability, control, and performance for every adventure.'),
(7, 'Diamondback', 'Overdrive', 2016, 'Mountain', 'Unisex', 'dark green', '565.00', '23.70000', 3, 'Designed for versatility and durability, offering a smooth, controlled ride on rugged trails and rough terrain.'),
(8, 'Schwinn', '21-Speed Suburban CS', 2015, 'Hybrid', 'Womens', 'burgundy', '299.00', '20.00000', 3, 'Combines comfort and efficiency, offering a smooth, versatile ride for city streets and scenic pathways.'),
(9, 'Schwinn', 'Sanctuary 7-Speed', 2016, 'Cruiser', 'Womens', 'purple', '190.00', '19.50000', 3, 'Designed for comfort and style, offering a smooth, relaxing ride perfect for casual strolls and coastal paths.'),
(10, 'Vilano', 'Forza', 2015, 'Road', 'Unisex', 'silver', '390.00', '13.60000', 4, 'Engineered for speed and endurance, delivering a smooth, efficient ride for long-distance road cycling.'),
(11, 'SE', 'Creature', 2016, 'BMX', 'Mens', 'dark grey', '410.00', '9.10000', 2, 'Built for agility and durability, offering precision control and high performance for tricks and tough rides.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
