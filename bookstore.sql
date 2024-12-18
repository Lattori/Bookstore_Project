-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 10, 2024 at 09:51 AM
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
-- Database: `bookstore`
--

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`uid`, `ISBN`, `CustomerID`, `Score`, `message`, `Comment_Date`, `cid`, `Comment_Limit`) VALUES
(1, NULL, NULL, 10, 'Yooo check do you work or nah?', '2024-10-30', '', 0),
(2, NULL, NULL, 9, 'Do you work or nah', '2024-10-30', '', 0),
(3, NULL, NULL, 9, 'Do you work or nah', '2024-10-30', 'Anonymous', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
