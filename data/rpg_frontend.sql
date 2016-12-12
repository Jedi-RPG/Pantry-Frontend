-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2016 at 05:30 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpgfront`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `stock` int(11) NOT NULL,
  `desc` text NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `stock`, `desc`, `price`) VALUES
(1, 'health potion', 1, 'Restores 150 Health over 15 seconds', '50.00'),
(2, 'mana potion', 100, 'Restores 150 Mana over 15 seconds', '50.00'),
(3, 'iron sword', 233, '+40 Attack Damage', '1300.00'),
(4, 'iron breastplate', 219, '+40 Armor', '800.00'),
(5, 'iron greaves', 3, 'Enhanced Movement: +25 Movement Speed', '300.00'),
(6, 'steel sword', 99, '+75 Attack Damage', '2800.00'),
(7, 'steel breastplate', 1200, '+100 Armor', '2300.00'),
(8, 'steel greaves', 322, 'Enhacned Movement: +55 Movement Speed', '900.00'),
(9, 'arrow', 19, '+25 Attack Damage', '1000.00'),
(10, 'fire scroll', 80, 'Elemental Enchanting: +5% Fire Damage', '700.00'),
(11, 'water scroll', 500, 'Elemental Enchanting: +5% Water Damage', '700.00'),
(12, 'lightning scroll', 43, 'Elemental Enchanting: +5% Lightning Damage', '700.00'),
(13, 'poison scroll', 1234, 'Elemental Enchanting: +5% Poison Damage', '700.00');

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--
DROP TABLE IF EXISTS `recipe`;
CREATE TABLE `recipe` (
  `id` int(11) NOT NULL,
  `MaterialOneId` int(11) NOT NULL,
  `AmountOne` int(11) NOT NULL,
  `MaterialTwoId` int(11) NOT NULL,
  `AmountTwo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`id`, `MaterialOneId`, `AmountOne`, `MaterialTwoId`, `AmountTwo`) VALUES
(1, 2, 2, 1, 1),
(2, 3, 3, 1, 1),
(3, 4, 12, 6, 1),
(4, 4, 15, 6, 5),
(5, 4, 10, 6, 1),
(6, 5, 12, 6, 1),
(7, 5, 15, 6, 5),
(8, 5, 10, 6, 2),
(9, 7, 1, 4, 1),
(10, 9, 5, 8, 1),
(11, 10, 5, 8, 1),
(12, 11, 5, 8, 1),
(13, 12, 5, 8, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
