
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 45.40.164.69
-- Generation Time: Feb 03, 2019 at 03:35 PM
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
-- Table structure for table 'types'
--

DROP TABLE IF EXISTS types;
CREATE TABLE IF NOT EXISTS `types` (
  type_rowid int(11) NOT NULL AUTO_INCREMENT,
  type_name varchar(255) NOT NULL DEFAULT '',
  type_active tinyint(11) DEFAULT '1',
  PRIMARY KEY (type_rowid),
  UNIQUE KEY type_name (type_name)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;

--
-- Dumping data for table 'types'
--

INSERT INTO types VALUES(1, 'Регулярные туры', 1);
INSERT INTO types VALUES(2, 'Туры с перелетом', 1);
INSERT INTO types VALUES(3, 'Туры с круизом', 1);
INSERT INTO types VALUES(4, 'Праздничные Туры', 1);
INSERT INTO types VALUES(5, 'Индивидуальные туры', 1);
INSERT INTO types VALUES(6, 'Международные туры', 1);
INSERT INTO types VALUES(7, 'Экслюзивные туры', 1);
