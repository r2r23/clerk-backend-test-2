-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: r2ratnic.mysql
-- Generation Time: Aug 27, 2021 at 02:24 PM
-- Server version: 5.6.41-84.1
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `r2ratnic_agg_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--
-- Creation: Aug 27, 2021 at 02:22 PM
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `surname` text NOT NULL,
  `name` text NOT NULL,
  `fname` text NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `surname`, `name`, `fname`, `updated`) VALUES
(1, 'Иванов', 'Иван', 'Иванович', '2021-08-27 17:22:39'),
(2, 'Петров', 'Петр', 'Петрович', '2021-08-27 17:22:50'),
(3, 'Васильев', 'Василий', 'Васильевич', '2021-08-27 17:23:00');

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--
-- Creation: Aug 27, 2021 at 02:22 PM
--

DROP TABLE IF EXISTS `phones`;
CREATE TABLE `phones` (
  `id` int(11) NOT NULL,
  `contactId` int(11) NOT NULL,
  `phone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Dumping data for table `phones`
--

INSERT INTO `phones` (`id`, `contactId`, `phone`) VALUES
(1, 1, '79091112223'),
(2, 1, '79180001112'),
(3, 2, '79285559994');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phones_ibfk_1` (`contactId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `phones_ibfk_1` FOREIGN KEY (`contactId`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;
COMMIT;
