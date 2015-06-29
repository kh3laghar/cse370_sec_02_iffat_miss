-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 29, 2015 at 10:56 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

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
-- Database: `Rent_A_Car_cse370`
--
CREATE DATABASE IF NOT EXISTS `Rent_A_Car_cse370` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `Rent_A_Car_cse370`;

-- --------------------------------------------------------

--
-- Table structure for table `Billing_details`
--
-- Creation: Jun 29, 2015 at 08:45 PM
-- Last update: Jun 29, 2015 at 08:45 PM
-- Last check: Jun 29, 2015 at 08:45 PM
--

DROP TABLE IF EXISTS `Billing_details`;
CREATE TABLE IF NOT EXISTS `Billing_details` (
  `bill_id` int(13) NOT NULL AUTO_INCREMENT,
  `book_id` int(13) NOT NULL,
  `advance_amount` int(4) NOT NULL,
  `total_amount` int(4) NOT NULL,
  `bill_status` tinyint(1) NOT NULL,
  `bill_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`bill_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `Billing_details`:
--   `book_id`
--       `booking_details` -> `book_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--
-- Creation: Jun 29, 2015 at 08:53 PM
--

DROP TABLE IF EXISTS `booking_details`;
CREATE TABLE IF NOT EXISTS `booking_details` (
  `book_id` int(13) NOT NULL AUTO_INCREMENT,
  `cust_id` int(13) NOT NULL,
  `amount` int(4) NOT NULL,
  `booking_status` tinyint(1) NOT NULL,
  `drive_option` tinyint(1) NOT NULL,
  `sec_per_pay` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`book_id`),
  KEY `cust_id` (`cust_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `booking_details`:
--   `cust_id`
--       `Customer_datails` -> `cust_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `Customer_datails`
--
-- Creation: Jun 29, 2015 at 05:16 PM
-- Last update: Jun 29, 2015 at 05:16 PM
--

DROP TABLE IF EXISTS `Customer_datails`;
CREATE TABLE IF NOT EXISTS `Customer_datails` (
  `cust_id` int(13) NOT NULL AUTO_INCREMENT COMMENT 'Name of the user',
  `name` char(20) COLLATE utf8_bin NOT NULL,
  `gender` char(6) COLLATE utf8_bin NOT NULL,
  `email_id` varchar(25) COLLATE utf8_bin NOT NULL,
  `address_user` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`cust_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Driver_Details`
--
-- Creation: Jun 29, 2015 at 06:32 PM
-- Last update: Jun 29, 2015 at 06:32 PM
--

DROP TABLE IF EXISTS `Driver_Details`;
CREATE TABLE IF NOT EXISTS `Driver_Details` (
  `driver_id` int(13) NOT NULL AUTO_INCREMENT,
  `name` char(25) COLLATE utf8_bin NOT NULL,
  `gender` char(6) COLLATE utf8_bin NOT NULL,
  `dob` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL,
  `email_id` varchar(25) COLLATE utf8_bin NOT NULL,
  `address_driver` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`driver_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_details`
--
-- Creation: Jun 29, 2015 at 08:49 PM
-- Last update: Jun 29, 2015 at 08:49 PM
-- Last check: Jun 29, 2015 at 08:49 PM
--

DROP TABLE IF EXISTS `vehicle_details`;
CREATE TABLE IF NOT EXISTS `vehicle_details` (
  `vehicle_reg_no` int(13) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(13) NOT NULL,
  `vechicle_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`vehicle_reg_no`),
  KEY `vehicle_id` (`vehicle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `vehicle_details`:
--   `vehicle_id`
--       `vehicle_type` -> `vehicle_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_type`
--
-- Creation: Jun 29, 2015 at 08:52 PM
-- Last update: Jun 29, 2015 at 08:52 PM
--

DROP TABLE IF EXISTS `vehicle_type`;
CREATE TABLE IF NOT EXISTS `vehicle_type` (
  `vehicle_id` int(13) NOT NULL AUTO_INCREMENT,
  `name` char(25) COLLATE utf8_bin NOT NULL,
  `deposit` int(4) NOT NULL,
  `cost_per_mile` int(4) NOT NULL,
  `availbility_vechicle` tinyint(1) NOT NULL,
  PRIMARY KEY (`vehicle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
