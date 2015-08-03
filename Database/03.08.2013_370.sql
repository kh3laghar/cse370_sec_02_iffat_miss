-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2015 at 09:26 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rent_a_car_cse370`
--
CREATE DATABASE IF NOT EXISTS `rent_a_car_cse370` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `rent_a_car_cse370`;

-- --------------------------------------------------------

--
-- Table structure for table `billing_details`
--
-- Creation: Jun 29, 2015 at 09:18 PM
-- Last update: Aug 02, 2015 at 09:06 PM
--

DROP TABLE IF EXISTS `billing_details`;
CREATE TABLE IF NOT EXISTS `billing_details` (
`bill_id` int(13) NOT NULL,
  `book_id` int(13) NOT NULL,
  `advance_amount` int(4) NOT NULL,
  `total_amount` int(4) NOT NULL,
  `bill_status` tinyint(1) NOT NULL,
  `bill_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=500201 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- RELATIONS FOR TABLE `billing_details`:
--   `book_id`
--       `customer_datails` -> `cust_id`
--

--
-- Dumping data for table `billing_details`
--

INSERT DELAYED IGNORE INTO `billing_details` (`bill_id`, `book_id`, `advance_amount`, `total_amount`, `bill_status`, `bill_date`) VALUES
(1, 0, 1500, 8000, 1, '2015-07-25 16:22:59'),
(2, 0, 1500, 8000, 0, '2015-07-25 16:51:09'),
(3, 0, 1500, 8000, 0, '2015-07-25 16:51:16'),
(4, 0, 1500, 8000, 0, '2015-07-25 16:51:38'),
(5, 0, 500, 2000, 0, '2015-08-02 21:05:15'),
(500200, 0, 3500, 6000, 0, '2015-08-02 21:06:13');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--
-- Creation: Jun 29, 2015 at 09:18 PM
--

DROP TABLE IF EXISTS `booking_details`;
CREATE TABLE IF NOT EXISTS `booking_details` (
`book_id` int(13) NOT NULL,
  `cust_id` int(13) NOT NULL,
  `amount` int(4) NOT NULL,
  `booking_status` tinyint(1) NOT NULL,
  `drive_option` tinyint(1) NOT NULL,
  `sec_per_pay` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- RELATIONS FOR TABLE `booking_details`:
--   `book_id`
--       `booking_details` -> `book_id`
--   `cust_id`
--       `booking_details` -> `book_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_datails`
--
-- Creation: Jul 13, 2015 at 07:16 AM
-- Last update: Aug 02, 2015 at 12:48 AM
--

DROP TABLE IF EXISTS `customer_datails`;
CREATE TABLE IF NOT EXISTS `customer_datails` (
`cust_id` int(13) NOT NULL COMMENT 'Name of the user',
  `FName` varchar(20) COLLATE utf8_bin NOT NULL,
  `LName` varchar(60) COLLATE utf8_bin NOT NULL,
  `user_id` varchar(25) COLLATE utf8_bin NOT NULL,
  `UserLevel` int(11) NOT NULL DEFAULT '1',
  `password` varchar(256) COLLATE utf8_bin NOT NULL,
  `email_id` varchar(60) COLLATE utf8_bin NOT NULL,
  `PhoneNo` varchar(15) COLLATE utf8_bin NOT NULL,
  `address_user` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=12301027 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- RELATIONS FOR TABLE `customer_datails`:
--   `cust_id`
--       `booking_details` -> `book_id`
--

--
-- Dumping data for table `customer_datails`
--

INSERT DELAYED IGNORE INTO `customer_datails` (`cust_id`, `FName`, `LName`, `user_id`, `UserLevel`, `password`, `email_id`, `PhoneNo`, `address_user`, `timestamp`) VALUES
(12201000, 'Md. Asiful', 'Haque', 'kh3laghar', 2, 'kh3laghar', 'kh3laghar@gmail.com', '1717887196', 'GP-CHA 161, TB GATE , Moh', '2015-07-11 10:20:22'),
(12301021, 'Md.', 'Haque', 'test2', 1, 'test2', 'test2@test.com', '2147483647', NULL, '2015-07-11 10:22:45'),
(12301023, 'Test 4', 'test4', 'test1', 1, 'test1', 'test1@test1.com', '1670769694', 'jadfajsd', '2015-07-11 10:54:52'),
(12301024, 'asd', 'dfasgf', 'test5', 1, '123456', '456@gmail.com', '1558871355', 'dfg', '2015-07-13 05:30:58'),
(12301025, 'Administrator', 'Access ', 'admin', 2, 'admin', 'admin@test.com', '5555555', 'dfd', '2015-07-13 07:15:24'),
(12301026, 'khaled', 'hasan', 'khaled', 1, '1234', 'khaledhasan301@gmail.com', '1752177438', NULL, '2015-07-28 03:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `driver_details`
--
-- Creation: Aug 01, 2015 at 08:52 PM
-- Last update: Aug 01, 2015 at 09:28 PM
--

DROP TABLE IF EXISTS `driver_details`;
CREATE TABLE IF NOT EXISTS `driver_details` (
`driver_id` int(13) NOT NULL,
  `name` char(25) COLLATE utf8_bin NOT NULL,
  `gender` char(6) COLLATE utf8_bin NOT NULL,
  `dob` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `email_id` varchar(25) COLLATE utf8_bin NOT NULL,
  `address_driver` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `driver_details`
--

INSERT DELAYED IGNORE INTO `driver_details` (`driver_id`, `name`, `gender`, `dob`, `status`, `email_id`, `address_driver`) VALUES
(1, 'Md. Asiful Haque', 'Y', '2031-08-15', 0, 'kh3laghar@gmail.com', '12301025');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_details`
--
-- Creation: Jul 13, 2015 at 10:49 AM
-- Last update: Jul 13, 2015 at 10:49 AM
--

DROP TABLE IF EXISTS `vehicle_details`;
CREATE TABLE IF NOT EXISTS `vehicle_details` (
`vehicle_id` int(13) NOT NULL,
  `vehicle_reg_no` int(13) NOT NULL,
  `vechicle_status` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=121315157 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- RELATIONS FOR TABLE `vehicle_details`:
--   `vehicle_id`
--       `vehicle_type` -> `vehicle_id`
--

--
-- Dumping data for table `vehicle_details`
--

INSERT DELAYED IGNORE INTO `vehicle_details` (`vehicle_id`, `vehicle_reg_no`, `vechicle_status`) VALUES
(1, 121314155, 1),
(12201011, 121315156, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_type`
--
-- Creation: Aug 03, 2015 at 04:08 PM
-- Last update: Aug 03, 2015 at 04:08 PM
--

DROP TABLE IF EXISTS `vehicle_type`;
CREATE TABLE IF NOT EXISTS `vehicle_type` (
`vehicle_id` int(13) NOT NULL,
  `name` char(25) COLLATE utf8_bin NOT NULL,
  `Model` varchar(16) COLLATE utf8_bin NOT NULL,
  `deposit` int(4) NOT NULL,
  `cost_per_mile` int(4) NOT NULL,
  `Seat Quantity` int(11) NOT NULL,
  `availbility_vechicle` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12201015 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `vehicle_type`
--

INSERT DELAYED IGNORE INTO `vehicle_type` (`vehicle_id`, `name`, `Model`, `deposit`, `cost_per_mile`, `Seat Quantity`, `availbility_vechicle`) VALUES
(1, 'Audi', 'Audi A3', 1500, 1266, 4, 1),
(12201011, 'Audi', 'Audi S3', 1500, 1266, 3, 1),
(12201014, 'toyota', 'sedan', 1300, 65, 4, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing_details`
--
ALTER TABLE `billing_details`
 ADD PRIMARY KEY (`bill_id`), ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
 ADD PRIMARY KEY (`book_id`), ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `customer_datails`
--
ALTER TABLE `customer_datails`
 ADD PRIMARY KEY (`cust_id`), ADD UNIQUE KEY `user` (`user_id`), ADD UNIQUE KEY `PhoneNo` (`PhoneNo`);

--
-- Indexes for table `driver_details`
--
ALTER TABLE `driver_details`
 ADD PRIMARY KEY (`driver_id`);

--
-- Indexes for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
 ADD PRIMARY KEY (`vehicle_reg_no`), ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `vehicle_type`
--
ALTER TABLE `vehicle_type`
 ADD PRIMARY KEY (`vehicle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing_details`
--
ALTER TABLE `billing_details`
MODIFY `bill_id` int(13) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=500201;
--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
MODIFY `book_id` int(13) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_datails`
--
ALTER TABLE `customer_datails`
MODIFY `cust_id` int(13) NOT NULL AUTO_INCREMENT COMMENT 'Name of the user',AUTO_INCREMENT=12301027;
--
-- AUTO_INCREMENT for table `driver_details`
--
ALTER TABLE `driver_details`
MODIFY `driver_id` int(13) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
MODIFY `vehicle_id` int(13) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=121315157;
--
-- AUTO_INCREMENT for table `vehicle_type`
--
ALTER TABLE `vehicle_type`
MODIFY `vehicle_id` int(13) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12201015;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
ADD CONSTRAINT `SET` FOREIGN KEY (`cust_id`) REFERENCES `booking_details` (`book_id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
