
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 45.40.164.69
-- Generation Time: Feb 01, 2019 at 01:45 PM
-- Server version: 5.5.51
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: 'newtourdbnew'
--

-- --------------------------------------------------------

--
-- Table structure for table 'districts'
--

DROP TABLE IF EXISTS districts;
CREATE TABLE IF NOT EXISTS districts (
  district_rowid int(11) NOT NULL AUTO_INCREMENT,
  district_name varchar(255) NOT NULL DEFAULT '',
  district_active tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (district_rowid)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;

--
-- Dumping data for table 'districts'
--

INSERT INTO districts VALUES(1, 'Бруклин', 1);
INSERT INTO districts VALUES(2, 'Квинс', 1);
INSERT INTO districts VALUES(3, 'Манхэттэн', 1);
INSERT INTO districts VALUES(4, 'Стэйтен Айленд', 1);
INSERT INTO districts VALUES(5, 'New Jersey', 1);
INSERT INTO districts VALUES(6, 'Коннектикут', 1);
