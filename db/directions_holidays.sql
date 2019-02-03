
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 45.40.164.69
-- Generation Time: Feb 01, 2019 at 12:56 PM
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
-- Table structure for table 'directions_holidays'
--

DROP TABLE IF EXISTS directions_holidays;
CREATE TABLE IF NOT EXISTS directions_holidays (
  direction_h_rowid int(11) NOT NULL AUTO_INCREMENT,
  direction_h_name varchar(255) NOT NULL,
  direction_h_active tinyint(1) DEFAULT '1',
  direction_h_output int(4) DEFAULT NULL,
  direction_h_subdir varchar(127) DEFAULT NULL,
  direction_h_list varchar(127) DEFAULT NULL,
  direction_h_comment text,
  PRIMARY KEY (direction_h_rowid),
  KEY direction_name_2 (direction_h_name),
  KEY direction_name (direction_h_name)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;

--
-- Dumping data for table 'directions_holidays'
--

INSERT INTO directions_holidays VALUES(1, 'Вашингтон', 1, 600, NULL, '495,9', NULL);
INSERT INTO directions_holidays VALUES(2, ' Нью-Йорк ', 1, 500, NULL, '2 3 4 69 192', NULL);
INSERT INTO directions_holidays VALUES(3, 'Бостон', 0, 900, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(4, 'Ниагарские водопады', 0, 700, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(5, 'Флорида', 1, 800, NULL, '105, 83, 194,196,195, 230,238,239,247,240, 435,438,437,436, 250,252,251, 106,104, 254,407,255,257,256,198,253', NULL);
INSERT INTO directions_holidays VALUES(6, 'Канада', 1, 1200, NULL, '49,50, 51, 52,53,54,211,465', NULL);
INSERT INTO directions_holidays VALUES(7, ' Аляска ', 0, 2000, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(8, 'КАЛИФОРНИЯ', 1, 2100, NULL, '65, 100,101,102,103', NULL);
INSERT INTO directions_holidays VALUES(9, 'ЧИКАГО', 1, 1000, NULL, '74,467', NULL);
INSERT INTO directions_holidays VALUES(11, 'ОТДЫХ В ПУТЕШЕСТВИИ', 1, 1300, NULL, '60,287,78,79,80,81,152,491,492,493,293,260,86,73', 'ЛЕТНИЙ ОТДЫХ');
INSERT INTO directions_holidays VALUES(35, 'Концерты', 0, 3000, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(12, 'Туры 2 Дня', 1, 200, NULL, '11, 28,29, 30, 32, 34, 38,9,72', NULL);
INSERT INTO directions_holidays VALUES(10, 'Филадельфия', 0, 1100, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(36, 'Звезды Атлантики ', 1, 2500, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(37, 'Однодневные Туры', 1, 100, NULL, '17, 18, 20, 27,2, 3, 4, 69, 192', NULL);
INSERT INTO directions_holidays VALUES(38, 'Туры 3 Дня', 1, 300, NULL, '39, 40, 41, 42, 43, 44, 45, 48,52,53', NULL);
INSERT INTO directions_holidays VALUES(39, 'Туры 4-6 дней', 1, 400, NULL, '73, 75, 76, 77, 293', NULL);
INSERT INTO directions_holidays VALUES(40, 'Кейп-Код', 0, 3100, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(41, 'Вашингтон и вся Вирджиния', 1, 3200, NULL, '293,260,86,73', NULL);
INSERT INTO directions_holidays VALUES(42, 'Заповедная природа США', 1, 3300, NULL, '290,287,291,286', NULL);
INSERT INTO directions_holidays VALUES(43, 'Pocono', 0, 3500, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(44, 'Nevele', 0, 3500, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(13, 'Западная Канада и Аляска', 0, NULL, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(14, 'Гавайи', 0, NULL, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(45, 'Европа', 0, NULL, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(46, 'Африка', 0, NULL, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(47, 'Новый Год', 0, NULL, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(48, 'Азия', 0, NULL, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(49, 'Латинская Америка', 0, NULL, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(50, 'ИЗРАИЛЬ', 0, NULL, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(51, 'КУРОРТЫ И ОТДЫХ', 0, NULL, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(52, 'Австралия', 0, NULL, NULL, NULL, NULL);
INSERT INTO directions_holidays VALUES(53, 'Флорида', 0, NULL, 'always_summer', '105,83', NULL);
INSERT INTO directions_holidays VALUES(54, 'Флорида', 0, NULL, 'miami_express', '194,196,195', NULL);
INSERT INTO directions_holidays VALUES(55, 'Флорида', 0, NULL, 'miami_beach-marco-polo', '230,238,239,247,240', NULL);
INSERT INTO directions_holidays VALUES(56, 'Флорида', 0, NULL, 'miami_beach-trump', '435,438,437,436', NULL);
INSERT INTO directions_holidays VALUES(57, 'Флорида', 0, NULL, 'disney_world', '250,252,251', NULL);
INSERT INTO directions_holidays VALUES(58, 'Флорида', 0, NULL, 'dytona_beach', '106,104', NULL);
INSERT INTO directions_holidays VALUES(59, 'Флорида', 0, NULL, 'baghamas_cruise', '254,407,255,257,256,198,253', NULL);
INSERT INTO directions_holidays VALUES(60, 'Новый Орлеан и Юг ', 1, NULL, NULL, '292,291,287,442,443', NULL);
