
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 45.40.164.69
-- Generation Time: Feb 01, 2019 at 12:57 PM
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
-- Table structure for table 'direction_holiday_group'
--

DROP TABLE IF EXISTS direction_holiday_group;
CREATE TABLE IF NOT EXISTS direction_holiday_group (
  group_rowid int(11) NOT NULL AUTO_INCREMENT,
  group_direction int(11) NOT NULL,
  group_name varchar(255) DEFAULT NULL,
  group_tour varchar(255) DEFAULT NULL COMMENT 'Used for order by, real tour list in holiday list ',
  sub_group text,
  sub_group_group text,
  PRIMARY KEY (group_rowid)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;

--
-- Dumping data for table 'direction_holiday_group'
--

INSERT INTO direction_holiday_group VALUES(1, 51, 'КЕЙП-КОД', '78,79,80,81,152', NULL, NULL);
INSERT INTO direction_holiday_group VALUES(2, 36, 'ЗВЕЗДЫ АТЛАНТИКИ', '206,207,208,64,218,209,300,210,301', 'АТЛАНТИКА <br/>\r\nАТЛАНТИКА и ВИРДЖИНИЯ', NULL);
INSERT INTO direction_holiday_group VALUES(3, 36, 'ЗВЕЗДЫ АТЛАНТИКИ', '62,123,258,261,217,245,264,259,262,122,229', 'АТЛАНТИКА и ЗАПАДНОЕ ПОБЕРЕЖЬЕ США - ДВА ОКЕАНА <br/>\r\nВключая пляжи Майами', NULL);
INSERT INTO direction_holiday_group VALUES(4, 36, 'ЗВЕЗДЫ АТЛАНТИКИ', '236,61,164', 'АТЛАНТИКА И ФЛОРИДА', 'АТЛАНТИКА И ФЛОРИДА - Экскурсионный тур');
INSERT INTO direction_holiday_group VALUES(5, 36, 'ЗВЕЗДЫ АТЛАНТИКИ', '120,163', 'АТЛАНТИКА И ФЛОРИДА', 'АТЛАНТИКА И ФЛОРИДА - отдых в Майами');
INSERT INTO direction_holiday_group VALUES(6, 36, 'ЗВЕЗДЫ АТЛАНТИКИ', '213,214', 'АТЛАНТИКА И ФЛОРИДА', 'АТЛАНТИКА И ФЛОРИДА - отдых в Майами и Орландо');
INSERT INTO direction_holiday_group VALUES(7, 36, 'ЗВЕЗДЫ АТЛАНТИКИ', '439', 'АТЛАНТИКА И ФЛОРИДА', 'АТЛАНТИКА и солнечная ФЛОРИДА \r\nс Карибским круизом');
INSERT INTO direction_holiday_group VALUES(8, 36, 'ЗВЕЗДЫ АТЛАНТИКИ', '121,205', 'АТЛАНТИКА И СРЕДНИЙ ЗАПАД\r\n<br/>\r\n(АТЛАНТИКА-ЧИКАГО)', NULL);
INSERT INTO direction_holiday_group VALUES(9, 36, 'ЗВЕЗДЫ АТЛАНТИКИ', '146,235', 'ВСЯ КАНАДА - ВОСТОК И ЗАПАД', NULL);
INSERT INTO direction_holiday_group VALUES(10, 36, 'ЗВЕЗДЫ АТЛАНТИКИ', '211,302', 'КАНАДА \r\n<br/>\r\n(без заезда в США)', NULL);
INSERT INTO direction_holiday_group VALUES(11, 36, 'ЗВЕЗДЫ АТЛАНТИКИ', '215,216', 'КАНАДА и ФЛОРИДА', NULL);
INSERT INTO direction_holiday_group VALUES(12, 36, 'ЗВЕЗДЫ АТЛАНТИКИ', '60,59,147,148,288', 'АТЛАНТИКА И КАНАДА', NULL);
