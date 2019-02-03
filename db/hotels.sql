
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 45.40.164.69
-- Generation Time: Feb 01, 2019 at 12:54 PM
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
-- Table structure for table 'hotels'
--

DROP TABLE IF EXISTS hotels;
CREATE TABLE IF NOT EXISTS hotels (
  hotel_rowid int(11) NOT NULL AUTO_INCREMENT,
  hotel_name varchar(85) NOT NULL,
  hotel_descr varchar(255) DEFAULT NULL,
  hotel_photo varchar(100) DEFAULT NULL,
  hotel_email varchar(100) DEFAULT NULL,
  hotel_zipcode char(6) NOT NULL,
  hotel_state char(2) NOT NULL,
  hotel_city varchar(85) NOT NULL,
  hotel_active int(11) DEFAULT NULL,
  hotel_address_1 varchar(85) NOT NULL,
  hotel_address_2 varchar(85) DEFAULT NULL,
  hotel_phone_area varchar(3) NOT NULL,
  hotel_phone_prefix varchar(3) NOT NULL,
  hotel_phone_digits varchar(4) NOT NULL,
  PRIMARY KEY (hotel_rowid),
  UNIQUE KEY hotel_name (hotel_name)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;

--
-- Dumping data for table 'hotels'
--

INSERT INTO hotels VALUES(1, 'Nevele Grande Resort', 'Resort & Country Club', NULL, '11111111111111', '111111', 'NY', 'Ellenville', NULL, 'addd', 'ddd', '111', '111', '1111');
INSERT INTO hotels VALUES(2, 'Pocono Manor', 'Resort', NULL, '111111111111111', '111111', 'NY', 'Pocono', NULL, 'ddddddd', 'ddddddd', '111', '111', '1111');
INSERT INTO hotels VALUES(3, 'TOURIST class', NULL, NULL, 'kkn@kkkn.us', '123456', 'AK', 'fff', NULL, 'fff', 'ff', '123', '456', '4569');
INSERT INTO hotels VALUES(4, 'Washington', 'Отель туристического класса. Завтрак континентальный \r\nНомер на двоих', NULL, NULL, '21223', 'DC', 'Washington', NULL, 'pen ave', NULL, '212', '467', '4623');
INSERT INTO hotels VALUES(5, 'Кейп Код', NULL, NULL, NULL, '02000', 'MA', 'кейп Код', NULL, 'Кейп Код', NULL, '781', '781', '781');
INSERT INTO hotels VALUES(6, 'Quality Inn & Suites', 'Stay near where Paul Revere made his famous midnight ride to warn the countryside that the British are coming. Nestled in the heart of the birthplace of the American Revolution, the Quality Inn & SuitesTM hotel is a perfect starting point to enjoy all the', NULL, 'http://www.qualityinn.com/ires/en-US/html/PhotoPop?hotel=MA147&gen=yes&sid=cOLdg.9pssSgfy1.2', '02420', 'MA', 'Lexington', NULL, '440 Bedford St. , Lexington, MA, US, 02420', NULL, '781', '861', '0850');
INSERT INTO hotels VALUES(7, 'Quality Hotel & Suites At The Falls', 'The Quality Hotel & SuitesTM At The Falls has an excellent location right where tourists want to be, within walking distance of the mighty Niagara Falls, Seneca Niagara Casino, the Conference Center Niagara Falls and the Canadian border. One of America''s ', NULL, 'http://www.qualityinn.com/ires/en-US/html/PhotoPop?hotel=NY600&gen=yes&sid=cOLdg.9pssSgfy1.2', '14303', 'NY', 'Niagara Falls', NULL, '240 First Street , Niagara Falls, NY, US, 14303', NULL, '716', '282', '1212');
INSERT INTO hotels VALUES(8, 'Quality Inn', 'The Quality Inn® hotel is ideally located near the entrance to Andrews Air Force Base. This Camp Springs, MD hotel is minutes from Bolling Air Force Base, FedExField (home of the Washington Redskins football team), Six Flags America theme park, Verizon Ce', NULL, 'http://www.qualityinn.com/ires/en-US/html/PhotoPop?hotel=MD221&gen=yes&sid=cOLdg.9pssSgfy1.2', '20746', 'DC', 'Washington', NULL, '4783 Allentown Road , Camp Springs, MD, US, 20746', NULL, '301', '420', '2800');
INSERT INTO hotels VALUES(9, 'Travelodge Montreal Centre', 'Newly Renovated Property as of 05/2006 offers 244 Guest rooms with individual air conditioning and temperature controls. Our guest can enjoy Free Coffee in the room, Telephone with voice-mail system, Non-smoking floors, Free Deluxe Continental Breakfast B', NULL, 'http://www.travelodge.com/Travelodge/control/Booking/check_avail?areaCode=137O&brandCode=TL,HJ,DI,RA', 'H2Z 1A', 'CO', 'Montreal', NULL, '50 Boul Rene Levesque West Montreal, QC H2Z 1A2 CA', NULL, '514', '874', '9090');
INSERT INTO hotels VALUES(10, 'Winter Haven Resort and Spa', 'Resort & Country Club New Year 2010', NULL, '11111111111111', '111111', 'NY', 'Ellenville', NULL, 'addd', 'ddd', '111', '111', '1111');
