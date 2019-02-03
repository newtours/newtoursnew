
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
-- Table structure for table 'direction_holiday_list'
--

DROP TABLE IF EXISTS direction_holiday_list;
CREATE TABLE IF NOT EXISTS direction_holiday_list (
  dir_hol_list_rowid int(11) NOT NULL AUTO_INCREMENT,
  dir_hol_list_direction int(11) NOT NULL,
  dir_hol_list_group int(11) NOT NULL,
  dir_hol_list_tour int(11) NOT NULL,
  PRIMARY KEY (dir_hol_list_rowid),
  UNIQUE KEY arbitrary_index_name (dir_hol_list_direction,dir_hol_list_tour)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;

--
-- Dumping data for table 'direction_holiday_list'
--

INSERT INTO direction_holiday_list VALUES(1, 5, 0, 105);
INSERT INTO direction_holiday_list VALUES(2, 5, 0, 83);
INSERT INTO direction_holiday_list VALUES(4, 5, 0, 194);
INSERT INTO direction_holiday_list VALUES(5, 5, 0, 196);
INSERT INTO direction_holiday_list VALUES(6, 5, 0, 195);
INSERT INTO direction_holiday_list VALUES(7, 5, 0, 230);
INSERT INTO direction_holiday_list VALUES(8, 5, 0, 238);
INSERT INTO direction_holiday_list VALUES(9, 5, 0, 239);
INSERT INTO direction_holiday_list VALUES(10, 5, 0, 247);
INSERT INTO direction_holiday_list VALUES(11, 5, 0, 240);
INSERT INTO direction_holiday_list VALUES(12, 5, 0, 435);
INSERT INTO direction_holiday_list VALUES(13, 5, 0, 438);
INSERT INTO direction_holiday_list VALUES(14, 5, 0, 437);
INSERT INTO direction_holiday_list VALUES(15, 5, 0, 436);
INSERT INTO direction_holiday_list VALUES(16, 5, 0, 250);
INSERT INTO direction_holiday_list VALUES(17, 5, 0, 252);
INSERT INTO direction_holiday_list VALUES(18, 5, 0, 251);
INSERT INTO direction_holiday_list VALUES(19, 5, 0, 106);
INSERT INTO direction_holiday_list VALUES(20, 5, 0, 104);
INSERT INTO direction_holiday_list VALUES(21, 5, 0, 254);
INSERT INTO direction_holiday_list VALUES(22, 5, 0, 407);
INSERT INTO direction_holiday_list VALUES(23, 5, 0, 255);
INSERT INTO direction_holiday_list VALUES(24, 5, 0, 257);
INSERT INTO direction_holiday_list VALUES(25, 5, 0, 256);
INSERT INTO direction_holiday_list VALUES(26, 5, 0, 198);
INSERT INTO direction_holiday_list VALUES(27, 5, 0, 253);
INSERT INTO direction_holiday_list VALUES(28, 37, 0, 17);
INSERT INTO direction_holiday_list VALUES(29, 37, 0, 18);
INSERT INTO direction_holiday_list VALUES(30, 37, 0, 20);
INSERT INTO direction_holiday_list VALUES(31, 37, 0, 2);
INSERT INTO direction_holiday_list VALUES(32, 37, 0, 3);
INSERT INTO direction_holiday_list VALUES(33, 37, 0, 4);
INSERT INTO direction_holiday_list VALUES(34, 37, 0, 69);
INSERT INTO direction_holiday_list VALUES(35, 37, 0, 192);
INSERT INTO direction_holiday_list VALUES(36, 12, 0, 11);
INSERT INTO direction_holiday_list VALUES(37, 12, 0, 29);
INSERT INTO direction_holiday_list VALUES(38, 12, 0, 30);
INSERT INTO direction_holiday_list VALUES(39, 12, 0, 32);
INSERT INTO direction_holiday_list VALUES(40, 12, 0, 34);
INSERT INTO direction_holiday_list VALUES(41, 12, 0, 38);
INSERT INTO direction_holiday_list VALUES(133, 11, 0, 287);
INSERT INTO direction_holiday_list VALUES(43, 38, 0, 39);
INSERT INTO direction_holiday_list VALUES(44, 38, 0, 40);
INSERT INTO direction_holiday_list VALUES(45, 38, 0, 41);
INSERT INTO direction_holiday_list VALUES(46, 38, 0, 42);
INSERT INTO direction_holiday_list VALUES(47, 38, 0, 43);
INSERT INTO direction_holiday_list VALUES(48, 38, 0, 44);
INSERT INTO direction_holiday_list VALUES(49, 38, 0, 45);
INSERT INTO direction_holiday_list VALUES(50, 38, 0, 48);
INSERT INTO direction_holiday_list VALUES(51, 38, 0, 52);
INSERT INTO direction_holiday_list VALUES(52, 38, 0, 53);
INSERT INTO direction_holiday_list VALUES(53, 39, 0, 73);
INSERT INTO direction_holiday_list VALUES(54, 39, 0, 75);
INSERT INTO direction_holiday_list VALUES(55, 39, 0, 76);
INSERT INTO direction_holiday_list VALUES(56, 39, 0, 77);
INSERT INTO direction_holiday_list VALUES(57, 39, 0, 293);
INSERT INTO direction_holiday_list VALUES(189, 9, 0, 466);
INSERT INTO direction_holiday_list VALUES(59, 1, 0, 9);
INSERT INTO direction_holiday_list VALUES(60, 60, 0, 292);
INSERT INTO direction_holiday_list VALUES(61, 60, 0, 291);
INSERT INTO direction_holiday_list VALUES(62, 60, 0, 187);
INSERT INTO direction_holiday_list VALUES(63, 60, 0, 442);
INSERT INTO direction_holiday_list VALUES(64, 60, 0, 443);
INSERT INTO direction_holiday_list VALUES(65, 42, 0, 290);
INSERT INTO direction_holiday_list VALUES(66, 42, 0, 286);
INSERT INTO direction_holiday_list VALUES(67, 42, 0, 287);
INSERT INTO direction_holiday_list VALUES(68, 42, 0, 291);
INSERT INTO direction_holiday_list VALUES(69, 41, 0, 293);
INSERT INTO direction_holiday_list VALUES(70, 41, 0, 260);
INSERT INTO direction_holiday_list VALUES(71, 41, 0, 86);
INSERT INTO direction_holiday_list VALUES(72, 41, 0, 73);
INSERT INTO direction_holiday_list VALUES(73, 9, 0, 74);
INSERT INTO direction_holiday_list VALUES(74, 9, 0, 467);
INSERT INTO direction_holiday_list VALUES(75, 2, 0, 2);
INSERT INTO direction_holiday_list VALUES(76, 2, 0, 3);
INSERT INTO direction_holiday_list VALUES(77, 2, 0, 4);
INSERT INTO direction_holiday_list VALUES(78, 2, 0, 69);
INSERT INTO direction_holiday_list VALUES(79, 2, 0, 192);
INSERT INTO direction_holiday_list VALUES(80, 6, 0, 49);
INSERT INTO direction_holiday_list VALUES(81, 6, 0, 50);
INSERT INTO direction_holiday_list VALUES(82, 6, 0, 51);
INSERT INTO direction_holiday_list VALUES(83, 6, 0, 52);
INSERT INTO direction_holiday_list VALUES(84, 6, 0, 53);
INSERT INTO direction_holiday_list VALUES(85, 6, 0, 54);
INSERT INTO direction_holiday_list VALUES(86, 6, 0, 211);
INSERT INTO direction_holiday_list VALUES(87, 6, 0, 465);
INSERT INTO direction_holiday_list VALUES(88, 8, 0, 65);
INSERT INTO direction_holiday_list VALUES(89, 8, 0, 100);
INSERT INTO direction_holiday_list VALUES(90, 8, 0, 102);
INSERT INTO direction_holiday_list VALUES(91, 8, 0, 103);
INSERT INTO direction_holiday_list VALUES(92, 12, 0, 28);
INSERT INTO direction_holiday_list VALUES(93, 12, 0, 72);
INSERT INTO direction_holiday_list VALUES(94, 37, 0, 70);
INSERT INTO direction_holiday_list VALUES(95, 11, 0, 78);
INSERT INTO direction_holiday_list VALUES(96, 11, 0, 79);
INSERT INTO direction_holiday_list VALUES(97, 11, 0, 80);
INSERT INTO direction_holiday_list VALUES(98, 11, 0, 81);
INSERT INTO direction_holiday_list VALUES(99, 11, 0, 152);
INSERT INTO direction_holiday_list VALUES(100, 11, 0, 491);
INSERT INTO direction_holiday_list VALUES(101, 11, 0, 492);
INSERT INTO direction_holiday_list VALUES(102, 11, 0, 493);
INSERT INTO direction_holiday_list VALUES(103, 11, 0, 293);
INSERT INTO direction_holiday_list VALUES(104, 11, 0, 260);
INSERT INTO direction_holiday_list VALUES(105, 11, 0, 86);
INSERT INTO direction_holiday_list VALUES(106, 11, 0, 73);
INSERT INTO direction_holiday_list VALUES(107, 11, 0, 105);
INSERT INTO direction_holiday_list VALUES(108, 11, 0, 83);
INSERT INTO direction_holiday_list VALUES(109, 11, 0, 194);
INSERT INTO direction_holiday_list VALUES(110, 11, 0, 196);
INSERT INTO direction_holiday_list VALUES(111, 11, 0, 195);
INSERT INTO direction_holiday_list VALUES(112, 11, 0, 230);
INSERT INTO direction_holiday_list VALUES(113, 11, 0, 238);
INSERT INTO direction_holiday_list VALUES(114, 11, 0, 239);
INSERT INTO direction_holiday_list VALUES(115, 11, 0, 247);
INSERT INTO direction_holiday_list VALUES(116, 11, 0, 240);
INSERT INTO direction_holiday_list VALUES(117, 11, 0, 435);
INSERT INTO direction_holiday_list VALUES(118, 11, 0, 438);
INSERT INTO direction_holiday_list VALUES(119, 11, 0, 437);
INSERT INTO direction_holiday_list VALUES(120, 11, 0, 436);
INSERT INTO direction_holiday_list VALUES(121, 11, 0, 250);
INSERT INTO direction_holiday_list VALUES(122, 11, 0, 252);
INSERT INTO direction_holiday_list VALUES(123, 11, 0, 251);
INSERT INTO direction_holiday_list VALUES(124, 11, 0, 106);
INSERT INTO direction_holiday_list VALUES(125, 11, 0, 104);
INSERT INTO direction_holiday_list VALUES(126, 11, 0, 254);
INSERT INTO direction_holiday_list VALUES(127, 11, 0, 407);
INSERT INTO direction_holiday_list VALUES(128, 11, 0, 255);
INSERT INTO direction_holiday_list VALUES(129, 11, 0, 257);
INSERT INTO direction_holiday_list VALUES(130, 11, 0, 256);
INSERT INTO direction_holiday_list VALUES(131, 11, 0, 198);
INSERT INTO direction_holiday_list VALUES(132, 11, 0, 253);
INSERT INTO direction_holiday_list VALUES(134, 11, 0, 292);
INSERT INTO direction_holiday_list VALUES(135, 11, 0, 65);
INSERT INTO direction_holiday_list VALUES(136, 8, 0, 101);
INSERT INTO direction_holiday_list VALUES(137, 38, 0, 152);
INSERT INTO direction_holiday_list VALUES(138, 36, 2, 64);
INSERT INTO direction_holiday_list VALUES(139, 36, 2, 218);
INSERT INTO direction_holiday_list VALUES(140, 36, 2, 209);
INSERT INTO direction_holiday_list VALUES(141, 36, 2, 300);
INSERT INTO direction_holiday_list VALUES(142, 36, 2, 210);
INSERT INTO direction_holiday_list VALUES(143, 36, 2, 301);
INSERT INTO direction_holiday_list VALUES(144, 36, 2, 206);
INSERT INTO direction_holiday_list VALUES(145, 36, 2, 207);
INSERT INTO direction_holiday_list VALUES(146, 36, 2, 208);
INSERT INTO direction_holiday_list VALUES(147, 36, 3, 62);
INSERT INTO direction_holiday_list VALUES(148, 36, 3, 123);
INSERT INTO direction_holiday_list VALUES(149, 36, 3, 258);
INSERT INTO direction_holiday_list VALUES(150, 36, 3, 261);
INSERT INTO direction_holiday_list VALUES(151, 36, 3, 217);
INSERT INTO direction_holiday_list VALUES(152, 36, 3, 245);
INSERT INTO direction_holiday_list VALUES(153, 36, 3, 264);
INSERT INTO direction_holiday_list VALUES(154, 36, 3, 259);
INSERT INTO direction_holiday_list VALUES(155, 36, 3, 262);
INSERT INTO direction_holiday_list VALUES(156, 36, 3, 122);
INSERT INTO direction_holiday_list VALUES(157, 36, 3, 229);
INSERT INTO direction_holiday_list VALUES(158, 36, 4, 236);
INSERT INTO direction_holiday_list VALUES(159, 36, 4, 61);
INSERT INTO direction_holiday_list VALUES(160, 36, 4, 164);
INSERT INTO direction_holiday_list VALUES(161, 36, 5, 120);
INSERT INTO direction_holiday_list VALUES(162, 36, 5, 163);
INSERT INTO direction_holiday_list VALUES(163, 36, 6, 213);
INSERT INTO direction_holiday_list VALUES(164, 36, 6, 214);
INSERT INTO direction_holiday_list VALUES(165, 36, 7, 439);
INSERT INTO direction_holiday_list VALUES(166, 36, 8, 121);
INSERT INTO direction_holiday_list VALUES(167, 36, 8, 205);
INSERT INTO direction_holiday_list VALUES(168, 36, 12, 60);
INSERT INTO direction_holiday_list VALUES(169, 36, 12, 59);
INSERT INTO direction_holiday_list VALUES(170, 36, 12, 147);
INSERT INTO direction_holiday_list VALUES(171, 36, 12, 148);
INSERT INTO direction_holiday_list VALUES(172, 36, 12, 288);
INSERT INTO direction_holiday_list VALUES(173, 36, 9, 146);
INSERT INTO direction_holiday_list VALUES(174, 36, 9, 235);
INSERT INTO direction_holiday_list VALUES(175, 36, 10, 211);
INSERT INTO direction_holiday_list VALUES(176, 36, 10, 302);
INSERT INTO direction_holiday_list VALUES(177, 36, 11, 215);
INSERT INTO direction_holiday_list VALUES(178, 36, 11, 216);
INSERT INTO direction_holiday_list VALUES(179, 5, 13, 283);
INSERT INTO direction_holiday_list VALUES(180, 8, 0, 497);
INSERT INTO direction_holiday_list VALUES(181, 5, 13, 527);
INSERT INTO direction_holiday_list VALUES(182, 5, 13, 528);
INSERT INTO direction_holiday_list VALUES(183, 5, 13, 526);
INSERT INTO direction_holiday_list VALUES(184, 60, 0, 287);
INSERT INTO direction_holiday_list VALUES(185, 12, 0, 582);
INSERT INTO direction_holiday_list VALUES(186, 37, 0, 591);
INSERT INTO direction_holiday_list VALUES(187, 35, 0, 582);
INSERT INTO direction_holiday_list VALUES(188, 35, 0, 591);
