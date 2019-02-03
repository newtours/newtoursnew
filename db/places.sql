
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 45.40.164.69
-- Generation Time: Feb 01, 2019 at 12:53 PM
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
-- Table structure for table 'places'
--

DROP TABLE IF EXISTS places;
CREATE TABLE IF NOT EXISTS places (
  place_rowid int(11) NOT NULL AUTO_INCREMENT,
  place_district int(11) NOT NULL DEFAULT '1',
  place_name text NOT NULL,
  place_active tinyint(4) NOT NULL DEFAULT '1',
  place_lon float DEFAULT NULL,
  place_lat float DEFAULT NULL,
  PRIMARY KEY (place_rowid)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;

--
-- Dumping data for table 'places'
--

INSERT INTO places VALUES(1, 1, 'Угол Brighton Beach Avenue и Coney Island Avenue, возле Chase Bank', 1, -73.9594, 40.5778);
INSERT INTO places VALUES(3, 1, 'Бенсонхерст. Пересечение 85 Street и Bay Parkway, у Chase Bank', 1, -73.9951, 40.6152);
INSERT INTO places VALUES(5, 2, 'Queens BLVD & 108 St. "Ridgewood Bank"', 1, -73.8438, 40.7217);
INSERT INTO places VALUES(6, 3, 'Верхний Манхэттэн - Пересечение 181 Street & Broadway (181 улицы и Бродвей).  У кафе MCDONALD `S', 1, -73.9357, 40.8503);
INSERT INTO places VALUES(7, 3, 'у здания Музея Американских Индейцев, на ступенях <a href="/new-tours/pdf/ad/new_york_pickup.pdf" target="_blank"><span style="color:#ff0000">Подробности смотрите здесь</span></a>', 1, -74.015, 40.7172);
INSERT INTO places VALUES(8, 4, 'Staten Island Expressway  Exit 7<br/>1441 Richmond Ave, Staten Island, NY 10314  - супермаркет "Stop and Shop" (просьба уточнять конкретное место заранее и не путать с другим супермаркетом с этим же названием', 1, -74.1578, 40.624);
INSERT INTO places VALUES(9, 5, 'Molly Pitcher. First rest area after Exit 8A NJ Turnpike', 1, -74.4848, 40.3416);
INSERT INTO places VALUES(10, 5, 'Exit 4 NJ TurnPike. Gas station -Lukoil', 1, -74.9574, 39.9862);
INSERT INTO places VALUES(11, 5, 'ПЕРЕСЕЧЕНИЕ 4 и 17 ДОРОГ   PARAMUS   (42  Route 17 North,  RUGS AND HOME) с противоположенной стороны от магазина IKEA, по 17 North. <br/>  Высадка ПОСЛЕ ТУРА с противовоположной стороны дороги ( возле IKEA )', 1, -74.0709, 40.9233);
INSERT INTO places VALUES(12, 6, '12 & 13 exit', 1, -73.4666, 41.0751);
INSERT INTO places VALUES(13, 3, 'Люкс сервис, трансфер от отеля  в МАНХЭТТЕНЕ к месту начала тура (время уточняется) <br/><a href="/regular/lux-service" target="_blank"><span style="color:#ff0000">Подробности смотрите здесь</span></a><br/>Для туристов по турам серии «Звезды Атлантики» трансферы включаются по ваучеру.', 1, -73.9852, 40.7588);
