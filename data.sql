-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 02, 2013 at 11:39 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `framework`
--

-- --------------------------------------------------------

--
-- Table structure for table `dz_helloword`
--

CREATE TABLE IF NOT EXISTS `dz_helloword` (
  `dz_id` int(11) NOT NULL AUTO_INCREMENT,
  `dz_title` varchar(20) NOT NULL,
  `dz_content` text NOT NULL,
  PRIMARY KEY (`dz_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `dz_helloword`
--

INSERT INTO `dz_helloword` (`dz_id`, `dz_title`, `dz_content`) VALUES
(1, 'Dezhub', 'Hello World!');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
