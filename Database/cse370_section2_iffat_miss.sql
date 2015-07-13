-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2015 at 04:24 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cse370_section2_iffat_miss`
--
CREATE DATABASE IF NOT EXISTS `cse370_section2_iffat_miss` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `cse370_section2_iffat_miss`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--
-- Creation: May 28, 2015 at 06:05 PM
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `branch_name` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `account_number` varchar(10) COLLATE utf8_bin NOT NULL,
  `balance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`branch_name`, `account_number`, `balance`) VALUES
('Downtown', 'A-101', 500),
('Perryridge', 'A-102', 400),
('Brighton', 'A-201', 900),
('Mianus', 'A-215', 700),
('Brighton', 'A-217', 750),
('Redwood', 'A-222', 700),
('Round Hill', 'A-305', 350);

-- --------------------------------------------------------

--
-- Table structure for table `borrower`
--
-- Creation: May 28, 2015 at 06:04 PM
--

DROP TABLE IF EXISTS `borrower`;
CREATE TABLE IF NOT EXISTS `borrower` (
  `customer_id` varchar(10) COLLATE utf8_bin NOT NULL,
  `loan_number` varchar(10) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- RELATIONS FOR TABLE `borrower`:
--   `customer_id`
--       `customer` -> `customer_id`
--   `loan_number`
--       `loan` -> `loan_number`
--

--
-- Dumping data for table `borrower`
--

INSERT INTO `borrower` (`customer_id`, `loan_number`) VALUES
('C-201', 'L-11'),
('C-226', 'L-14'),
('C-211', 'L-15'),
('C-225', 'L-16'),
('C-222', 'L-17'),
('C-201', 'L-23'),
('C-212', 'L-93');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--
-- Creation: May 28, 2015 at 06:02 PM
--

DROP TABLE IF EXISTS `branch`;
CREATE TABLE IF NOT EXISTS `branch` (
  `branch_name` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT '',
  `branch_city` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `assets` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_name`, `branch_city`, `assets`) VALUES
('Brighton', 'Brooklyn', 7100000),
('Downtown', 'Brooklyn', 9000000),
('Mianus', 'Horseneck', 400000),
('North Town', 'Rye', 3700000),
('Perryridge', 'Horseneck', 1700000),
('Pownal', 'Bennington', 300000),
('Redwood', 'Palo Alto', 2100000),
('Round Hill', 'Horseneck', 8000000);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--
-- Creation: May 28, 2015 at 06:02 PM
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` varchar(10) COLLATE utf8_bin NOT NULL,
  `customer_name` varchar(20) COLLATE utf8_bin NOT NULL,
  `customer_street` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `customer_city` varchar(30) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_street`, `customer_city`) VALUES
('C-201', 'Smith', 'North', 'Rye'),
('C-211', 'Hayes', 'Main', 'Harrison'),
('C-212', 'Curry', 'North', 'Rye'),
('C-215', 'Lindsay', 'Park', 'Pittsfield'),
('C-220', 'Turner', 'Putnam', 'Stamford'),
('C-222', 'Williams', 'Nassau', 'Princeton'),
('C-225', 'Adams', 'Spring', 'Pittsfield'),
('C-226', 'Johnson', 'Alma', 'Palo Alto'),
('C-233', 'Glenn', 'Sand Hill', 'Woodside'),
('C-234', 'Brooks', 'Senator', 'Brooklyn'),
('C-255', 'Green', 'Walnut', 'Stamford'),
('C101', 'Jones', 'Main', 'Harrison');

-- --------------------------------------------------------

--
-- Table structure for table `depositor`
--
-- Creation: May 28, 2015 at 06:05 PM
--

DROP TABLE IF EXISTS `depositor`;
CREATE TABLE IF NOT EXISTS `depositor` (
  `customer_id` varchar(10) COLLATE utf8_bin NOT NULL,
  `account_number` varchar(10) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- RELATIONS FOR TABLE `depositor`:
--   `customer_id`
--       `customer` -> `customer_id`
--   `account_number`
--       `account` -> `account_number`
--

--
-- Dumping data for table `depositor`
--

INSERT INTO `depositor` (`customer_id`, `account_number`) VALUES
('C-226', 'A-101'),
('C-211', 'A-102'),
('C-226', 'A-201'),
('C-201', 'A-215'),
('C-220', 'A-305');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--
-- Creation: May 28, 2015 at 06:03 PM
--

DROP TABLE IF EXISTS `loan`;
CREATE TABLE IF NOT EXISTS `loan` (
  `branch_name` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `loan_number` varchar(10) COLLATE utf8_bin NOT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`branch_name`, `loan_number`, `amount`) VALUES
('Round Hill', 'L-11', 900),
('Downtown', 'L-14', 1500),
('Perryridge', 'L-15', 1500),
('Perryridge', 'L-16', 1300),
('Downtown', 'L-17', 1000),
('Redwood', 'L-23', 2000),
('Mianus', 'L-93', 500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
 ADD PRIMARY KEY (`account_number`);

--
-- Indexes for table `borrower`
--
ALTER TABLE `borrower`
 ADD PRIMARY KEY (`customer_id`,`loan_number`), ADD KEY `loan_number` (`loan_number`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
 ADD PRIMARY KEY (`branch_name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
 ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `depositor`
--
ALTER TABLE `depositor`
 ADD PRIMARY KEY (`customer_id`,`account_number`), ADD KEY `account_number` (`account_number`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
 ADD PRIMARY KEY (`loan_number`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrower`
--
ALTER TABLE `borrower`
ADD CONSTRAINT `borrower_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
ADD CONSTRAINT `borrower_ibfk_2` FOREIGN KEY (`loan_number`) REFERENCES `loan` (`loan_number`);

--
-- Constraints for table `depositor`
--
ALTER TABLE `depositor`
ADD CONSTRAINT `depositor_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
ADD CONSTRAINT `depositor_ibfk_2` FOREIGN KEY (`account_number`) REFERENCES `account` (`account_number`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
