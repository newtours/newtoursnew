
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
-- Table structure for table 'directions'
--

DROP TABLE IF EXISTS directions;
CREATE TABLE IF NOT EXISTS directions (
  direction_rowid int(11) NOT NULL AUTO_INCREMENT,
  direction_name varchar(255) NOT NULL DEFAULT '',
  direction_active tinyint(1) DEFAULT '1',
  direction_output int(4) DEFAULT NULL,
  PRIMARY KEY (direction_rowid),
  UNIQUE KEY direction_name (direction_name)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;

--
-- Dumping data for table 'directions'
--

INSERT INTO directions VALUES(1, 'Вашингтон', 0, 600);
INSERT INTO directions VALUES(2, ' Нью-Йорк ', 1, 500);
INSERT INTO directions VALUES(3, 'Бостон', 0, 900);
INSERT INTO directions VALUES(4, 'Ниагарские водопады', 0, 700);
INSERT INTO directions VALUES(5, 'Флорида', 0, 800);
INSERT INTO directions VALUES(6, 'Канада', 0, 1200);
INSERT INTO directions VALUES(7, ' Аляска ', 0, 2000);
INSERT INTO directions VALUES(8, 'КАЛИФОРНИЯ', 0, 2100);
INSERT INTO directions VALUES(9, 'ЧИКАГО', 0, 1000);
INSERT INTO directions VALUES(11, 'Отдых, Развлечения.Музеи', 0, 1300);
INSERT INTO directions VALUES(35, 'Концерты', 0, 3000);
INSERT INTO directions VALUES(12, 'Туры 2 Дня', 0, 200);
INSERT INTO directions VALUES(10, 'Филадельфия', 1, 1100);
INSERT INTO directions VALUES(36, 'Звезды Атлантики ', 0, 2500);
INSERT INTO directions VALUES(37, 'Однодневные Туры', 1, 100);
INSERT INTO directions VALUES(38, 'Туры 3 Дня', 0, 300);
INSERT INTO directions VALUES(39, 'Туры 4-6 дней', 0, 400);
INSERT INTO directions VALUES(40, 'Кейп-Код', 0, 3100);
INSERT INTO directions VALUES(41, 'Вирджиния - Бич', 0, 3200);
INSERT INTO directions VALUES(42, 'Заповедная природа США', 0, 3300);
INSERT INTO directions VALUES(43, 'Pocono', 0, 3500);
INSERT INTO directions VALUES(44, 'Nevele', 0, 3500);
INSERT INTO directions VALUES(13, 'Западная Канада и Аляска', 0, NULL);
INSERT INTO directions VALUES(14, 'Гавайи', 0, NULL);
INSERT INTO directions VALUES(45, 'Европа', 0, NULL);
INSERT INTO directions VALUES(46, 'Африка', 0, NULL);
INSERT INTO directions VALUES(47, 'Новый Год', 0, NULL);
INSERT INTO directions VALUES(48, 'Азия', 0, NULL);
INSERT INTO directions VALUES(49, 'Латинская Америка', 0, NULL);
INSERT INTO directions VALUES(50, 'ИЗРАИЛЬ', 0, NULL);
INSERT INTO directions VALUES(51, 'КУРОРТЫ И ОТДЫХ', 0, NULL);
INSERT INTO directions VALUES(52, 'Австралия', 0, NULL);
INSERT INTO directions VALUES(53, 'Аляска-Калифорния', 1, NULL);
