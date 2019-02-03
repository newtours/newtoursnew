
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 45.40.164.69
-- Generation Time: Feb 01, 2019 at 12:55 PM
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
-- Table structure for table 'hotel_rooms'
--

DROP TABLE IF EXISTS hotel_rooms;
CREATE TABLE IF NOT EXISTS hotel_rooms (
  room_rowid int(11) NOT NULL AUTO_INCREMENT,
  room_hotel int(11) NOT NULL,
  room_name varchar(64) NOT NULL,
  room_descr varchar(255) DEFAULT NULL,
  room_photo varchar(255) DEFAULT NULL,
  room_active tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (room_rowid),
  UNIQUE KEY room_hotel (room_hotel,room_name)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;

--
-- Dumping data for table 'hotel_rooms'
--

INSERT INTO hotel_rooms VALUES(1, 1, 'Tower Building Lux', NULL, NULL, 1);
INSERT INTO hotel_rooms VALUES(2, 1, 'Empire Extra Lux', NULL, NULL, 1);
INSERT INTO hotel_rooms VALUES(4, 2, 'Main Building', NULL, NULL, 1);
INSERT INTO hotel_rooms VALUES(5, 2, 'Lodge Building', NULL, NULL, 1);
INSERT INTO hotel_rooms VALUES(6, 3, 'standard room', NULL, NULL, 1);
INSERT INTO hotel_rooms VALUES(7, 4, 'standart two bed', NULL, NULL, 1);
INSERT INTO hotel_rooms VALUES(8, 5, 'two beds', NULL, NULL, 1);
INSERT INTO hotel_rooms VALUES(9, 10, 'Комната люкс', NULL, NULL, 1);
INSERT INTO hotel_rooms VALUES(10, 10, 'Комната экстра люкс', NULL, NULL, 1);
INSERT INTO hotel_rooms VALUES(11, 10, 'Свит', NULL, NULL, 1);
INSERT INTO hotel_rooms VALUES(12, 10, 'Улучшенный свит', NULL, NULL, 1);
