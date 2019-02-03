
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 45.40.164.69
-- Generation Time: Feb 01, 2019 at 01:00 PM
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
-- Table structure for table 'tours_private_fields'
--

DROP TABLE IF EXISTS tours_private_fields;
CREATE TABLE IF NOT EXISTS tours_private_fields (
  private_tour_field_rowid int(10) NOT NULL AUTO_INCREMENT,
  private_tour_tour int(11) NOT NULL,
  private_tour_name varchar(255) NOT NULL,
  private_tour_service varchar(255) NOT NULL,
  private_tour_code varchar(255) NOT NULL,
  private_tour_opt1 varchar(255) NOT NULL,
  private_tour_opt2 varchar(255) NOT NULL,
  private_tour_opt3 varchar(255) NOT NULL,
  private_tour_opt4 varchar(255) NOT NULL,
  private_tour_opt5 varchar(255) NOT NULL,
  private_tour_opt6 varchar(255) NOT NULL,
  private_tour_opt7 varchar(255) NOT NULL,
  private_tour_link varchar(255) CHARACTER SET cp1251 COLLATE cp1251_bulgarian_ci NOT NULL,
  private_tour_remark text NOT NULL,
  PRIMARY KEY (private_tour_field_rowid)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;

--
-- Dumping data for table 'tours_private_fields'
--

INSERT INTO tours_private_fields VALUES(1, 2, 'Ванкувер', 'Встреча в аэропорту и транспорт в гостиницу', '', '$150', '$160', '$200', '$23 с чел.', '$22', '', '', '', '');
INSERT INTO tours_private_fields VALUES(2, 2, 'Ванкувер', 'Доставка в аэропорт из отеля', '', '$140', '$150', '$190', '$22 с чел.', '$21', '', '', '', '');
INSERT INTO tours_private_fields VALUES(3, 2, 'Ванкувер', 'Трансфер из отеля в порт или обратно', '', '$120', '$130', '$150', '$20 с чел.', '$22', '', '', '', '');
INSERT INTO tours_private_fields VALUES(4, 2, 'Ванкувер', 'Встреча после круиза и трансфер в аэропорт', '', '$160', '$170', '$210', '$25 с чел.', '$29', '', '', '', '');
INSERT INTO tours_private_fields VALUES(5, 2, 'Ванкувер', 'Обзорная экскурсия по Ванкуверу (5 часов)', 'V1', '$440', '$550', '$790', '$95', '$92', '', '', '/private/vancouver-dsc#v1', '');
INSERT INTO tours_private_fields VALUES(6, 2, 'Ванкувер', 'Обзорная экскурсия по Ванкуверу (8 часов)', 'V2', '$590', '$790', '$950', '$108', '$105', '', '', '/private/vancouver-dsc#v2', '');
INSERT INTO tours_private_fields VALUES(7, 2, 'Ванкувер', 'Северный Ванкувер. Capilano Bridge & Grouse Mountain (6 часов)', 'V3', '$550', '$670', '$950', '$105', '$98', '', '', '/private/vancouver-dsc#v3', '');
INSERT INTO tours_private_fields VALUES(8, 2, 'Ванкувер', 'Дорога «От Океана к Небу» ( 8 часов)', 'V4', '$690', '$760', '$1150', '$110', '$99', '', '', '/private/vancouver-dsc#v4', '');
INSERT INTO tours_private_fields VALUES(9, 2, 'Ванкувер', 'Вистлер и водопады (12 часов)', 'V5', '$890', '$1050', '$1380', '$165', '$160', '', '', '/private/vancouver-dsc#v5', '');
INSERT INTO tours_private_fields VALUES(10, 2, 'Ванкувер', 'Виктория-столица Британской Колумбии, c круизом на пароме (12-14 часов)', 'V6', '$960', '$1100', '$1490', '$185', '$180', '', '', '/private/vancouver-dsc#v6', '');
INSERT INTO tours_private_fields VALUES(11, 2, 'Ванкувер', 'Экскурсия в Сиэттл (необходимы документы на въезд в США из Канады и обратно) 1-дневная экскурсия из Ванкувера (14 часов)', 'V7', '$1050', '$1280', '$1620', '$210', '$205', '', '', '/private/vancouver-dsc#v7', '');
INSERT INTO tours_private_fields VALUES(12, 1, 'Сиэттл', 'Встреча в аэропорту и транспорт в гостиницу', '', '$150', '$160', '$200', '$23', '$22', '', '', '', '');
INSERT INTO tours_private_fields VALUES(13, 1, 'Сиэттл', 'Доставка в аэропорт из отеля', '', '$140', '$150', '$190', '$22', '$21', '', '', '', '');
INSERT INTO tours_private_fields VALUES(14, 1, 'Сиэттл', 'Трансфер из отеля в порт или обратно', '', '$120', '$130', '$150', '$20', '$22', '', '', '', '');
INSERT INTO tours_private_fields VALUES(15, 1, 'Сиэттл', 'Встреча после круиза и трансфер в аэропорт', '', '$160', '$170', '$210', '$25', '$29', '', '', '', '');
INSERT INTO tours_private_fields VALUES(16, 1, 'Сиэттл', 'Обзорная экскурсия по Сиэттлу (4 часа) или по вечернему городу "Огни Сиэттла" (4 часа', 'TS1', '$410', '$480', '$650', '$82', '$79', '', '', '/private/seattle-dsc#ts1', '');
INSERT INTO tours_private_fields VALUES(17, 1, 'Сиэттл', 'Обзорная экскурсия по Сиэттлу (6 часов)', 'TS2', '$490', '$580', '$740', '$89', '$85', '', '', '/private/seattle-dsc#ts2', '');
INSERT INTO tours_private_fields VALUES(18, 1, 'Сиэттл', 'Обзорная экскурсия по Сиэттлу (8 часов)', 'TS3', '$590', '$790', '$970', '$108', '$105', '', '', '/private/seattle-dsc#ts3', '');
INSERT INTO tours_private_fields VALUES(19, 1, 'Сиэттл', 'Комбинированная обзорная экскурсия по Сиэттлу - дневная и вечерняя (8 часов)', 'TS1+TS6', '$620', '$760', '$970', '$110', '$108', '', '', '/private/seattle-dsc#ts6', '');
INSERT INTO tours_private_fields VALUES(20, 1, 'Сиэттл', 'Экскурсия на завод Боинг и пригороды Сиэттла (7 часов)', 'TS4', '$590', '$720', '$1050', '$110', '$99', '', '', '/private/seattle-dsc#ts4', '');
INSERT INTO tours_private_fields VALUES(21, 1, 'Сиэттл', 'Пригороды Сиэттла, водопады, завод Майкрософт*, винодельни (7 часов)', 'TS5', '$590', '$720', '$1050', '$110', '$99', '', '', '/private/seattle-dsc#ts5', '');
INSERT INTO tours_private_fields VALUES(22, 1, 'Сиэттл', 'Экскурсия в город Портленд, штат Орегон<br/> 1-дневная экскурсия из Сиэттла 10-12 часов', 'TS7', '$960', '$1100', '$1480', '$165', '4160', '', '', '/private/seattle-dsc#ts7', '');
INSERT INTO tours_private_fields VALUES(23, 1, 'Сиэттл', 'Экскурсия в Ванкувер, Канада (необходимы документы на въезд в Канаду) <br/>1-дневная экскурсия из Сиэттла 14 часов', 'TS8', '$990', '$1280', '$1620', '$210', '$205', '', '', '/private/seattle-dsc#ts8', '');
