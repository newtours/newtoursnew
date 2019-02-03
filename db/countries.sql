
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 45.40.164.69
-- Generation Time: Feb 01, 2019 at 12:58 PM
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
-- Table structure for table 'countries'
--

DROP TABLE IF EXISTS countries;
CREATE TABLE IF NOT EXISTS countries (
  country_code char(3) NOT NULL DEFAULT '',
  country_russian varchar(85) DEFAULT NULL,
  country_english varchar(85) DEFAULT NULL,
  country_alpha1 char(2) DEFAULT NULL,
  country_alpha2 char(3) DEFAULT NULL,
  PRIMARY KEY (country_code),
  UNIQUE KEY country_alpha2 (country_alpha2),
  UNIQUE KEY country_alpha1 (country_alpha1),
  UNIQUE KEY country_english (country_english),
  UNIQUE KEY country_russian (country_russian)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Dumping data for table 'countries'
--

INSERT INTO countries VALUES('004', 'Афганистан', NULL, 'AF', 'AFG');
INSERT INTO countries VALUES('008', 'Албания', NULL, 'AL', 'ALB');
INSERT INTO countries VALUES('010', 'Антарктика', NULL, 'AQ', 'ATA');
INSERT INTO countries VALUES('012', 'Алжир', NULL, 'DZ', 'DZA');
INSERT INTO countries VALUES('016', 'Восточное Самоа (США)', NULL, 'AS', 'ASM');
INSERT INTO countries VALUES('020', 'Андорра', NULL, 'AD', 'AND');
INSERT INTO countries VALUES('024', 'Ангола', NULL, 'AO', 'AGO');
INSERT INTO countries VALUES('028', 'Антигуа и Барбуда', NULL, 'AG', 'ATG');
INSERT INTO countries VALUES('031', 'Азербайджан', NULL, 'AZ', 'AZE');
INSERT INTO countries VALUES('032', 'Аргентина', NULL, 'AR', 'ARG');
INSERT INTO countries VALUES('036', 'Австралия', NULL, 'AU', 'AUS');
INSERT INTO countries VALUES('040', 'Австрия', NULL, 'AT', 'AUT');
INSERT INTO countries VALUES('044', 'Багамские острова', NULL, 'BS', 'BHS');
INSERT INTO countries VALUES('048', 'Бахрейн', NULL, 'BH', 'BHR');
INSERT INTO countries VALUES('050', 'Бангладеш', NULL, 'BD', 'BGD');
INSERT INTO countries VALUES('051', 'Армения', NULL, 'AM', 'ARM');
INSERT INTO countries VALUES('052', 'Барбадос', NULL, 'BB', 'BRB');
INSERT INTO countries VALUES('056', 'Бельгия', NULL, 'BE', 'BEL');
INSERT INTO countries VALUES('060', 'Бермудские острова', NULL, 'BM', 'BMU');
INSERT INTO countries VALUES('064', 'Бутан', NULL, 'BT', 'BTN');
INSERT INTO countries VALUES('068', 'Боливия', NULL, 'BO', 'BOL');
INSERT INTO countries VALUES('070', 'Босния и Герцеговина', NULL, 'BA', 'BIH');
INSERT INTO countries VALUES('072', 'Ботсвана', NULL, 'BW', 'BWA');
INSERT INTO countries VALUES('074', 'Буве', NULL, 'BV', 'BVT');
INSERT INTO countries VALUES('076', 'Бразилия', NULL, 'BR', 'BRA');
INSERT INTO countries VALUES('084', 'Белиз', NULL, 'BZ', 'BLZ');
INSERT INTO countries VALUES('086', 'Британская территория в Индийском океане', NULL, 'IO', 'IOT');
INSERT INTO countries VALUES('090', 'Соломоновы острова', NULL, 'SB', 'SLB');
INSERT INTO countries VALUES('092', 'Виргинские острова (Брит.)', NULL, 'VG', 'VGB');
INSERT INTO countries VALUES('096', 'Бруней', NULL, 'BN', 'BRN');
INSERT INTO countries VALUES('100', 'Болгария', NULL, 'BG', 'BGR');
INSERT INTO countries VALUES('104', 'Мьянма', NULL, 'MM', 'MMR');
INSERT INTO countries VALUES('108', 'Бурунди', NULL, 'BI', 'BDI');
INSERT INTO countries VALUES('112', 'Белоруссия', NULL, 'BY', 'BLR');
INSERT INTO countries VALUES('116', 'Камбоджа', NULL, 'KH', 'KHM');
INSERT INTO countries VALUES('120', 'Камерун', NULL, 'CM', 'CMR');
INSERT INTO countries VALUES('124', 'Канада', NULL, 'CA', 'CAN');
INSERT INTO countries VALUES('132', 'Кабо - Верди', NULL, 'CV', 'C?');
INSERT INTO countries VALUES('136', 'Кайман', NULL, 'KY', 'CYM');
INSERT INTO countries VALUES('140', 'Центрально-Африканская Республика', NULL, 'CF', 'CAF');
INSERT INTO countries VALUES('144', 'Шри - Ланка', NULL, 'LK', 'LKA');
INSERT INTO countries VALUES('148', 'Чад', NULL, 'TD', 'TCD');
INSERT INTO countries VALUES('152', 'Чили', NULL, 'CL', 'CHL');
INSERT INTO countries VALUES('156', 'Китай', NULL, 'CN', 'CHN');
INSERT INTO countries VALUES('158', 'Тайвань', NULL, 'TW', 'TWN');
INSERT INTO countries VALUES('162', 'Остров Рождества', NULL, 'CX', 'CXR');
INSERT INTO countries VALUES('166', 'Кокосовые острова', NULL, 'CC', 'CCK');
INSERT INTO countries VALUES('170', 'Колумбия', NULL, 'CO', 'COL');
INSERT INTO countries VALUES('174', 'Коморские острова', NULL, 'KM', 'COM');
INSERT INTO countries VALUES('178', 'Конго', NULL, 'CG', 'COG');
INSERT INTO countries VALUES('180', 'Заир', NULL, 'ZR', 'ZAR');
INSERT INTO countries VALUES('184', 'Острова Кука', NULL, 'CK', 'COK');
INSERT INTO countries VALUES('188', 'Коста - Рика', NULL, 'CR', 'CRI');
INSERT INTO countries VALUES('191', 'Хорватия', NULL, 'HR', 'HRV');
INSERT INTO countries VALUES('192', 'Куба', NULL, 'CU', 'CUB');
INSERT INTO countries VALUES('196', 'Кипр', NULL, 'CY', 'CYP');
INSERT INTO countries VALUES('203', 'Чехия', NULL, 'CZ', 'CZE');
INSERT INTO countries VALUES('204', 'Бенин', NULL, 'BJ', 'BEN');
INSERT INTO countries VALUES('208', 'Дания', NULL, 'DK', 'DNK');
INSERT INTO countries VALUES('212', 'Доминика', NULL, 'DM', 'DMA');
INSERT INTO countries VALUES('214', 'Доминиканская Республика', NULL, 'DO', 'DOM');
INSERT INTO countries VALUES('218', 'Эквадор', NULL, 'EC', 'ECU');
INSERT INTO countries VALUES('222', 'Сальвадор', NULL, 'SV', 'SLV');
INSERT INTO countries VALUES('226', 'Республика Экваториальная Гвинея', NULL, 'GQ', 'GNQ');
INSERT INTO countries VALUES('231', 'Эфиопия', NULL, 'ET', 'ETH');
INSERT INTO countries VALUES('232', 'Эритрея', NULL, 'ER', 'ERI');
INSERT INTO countries VALUES('233', 'Эстония', NULL, 'EE', 'EST');
INSERT INTO countries VALUES('234', 'Фарерские острова', NULL, 'FO', 'FRO');
INSERT INTO countries VALUES('238', 'Фолклендские острова', NULL, 'FK', 'FLK');
INSERT INTO countries VALUES('242', 'Фиджи', NULL, 'FJ', 'FJI');
INSERT INTO countries VALUES('246', 'Финляндия', NULL, 'FI', 'FIN');
INSERT INTO countries VALUES('250', 'Франция', NULL, 'FR', 'FRA');
INSERT INTO countries VALUES('254', 'Гвиана', NULL, 'GF', 'GUF');
INSERT INTO countries VALUES('258', 'Фран. Полинезия', NULL, 'PF', 'PYF');
INSERT INTO countries VALUES('260', 'Фран. Южные территории', NULL, 'TF', 'ATF');
INSERT INTO countries VALUES('262', 'Джибути', NULL, 'DJ', 'DJI');
INSERT INTO countries VALUES('266', 'Габон', NULL, 'GA', 'GAB');
INSERT INTO countries VALUES('268', 'Грузия', NULL, 'GE', 'GEO');
INSERT INTO countries VALUES('270', 'Гамбия', NULL, 'GM', 'GMB');
INSERT INTO countries VALUES('274', 'Газа сектор', NULL, NULL, NULL);
INSERT INTO countries VALUES('276', 'Германия', NULL, 'DE', 'DEU');
INSERT INTO countries VALUES('288', 'Гана', NULL, 'GH', 'GHA');
INSERT INTO countries VALUES('292', 'Гибралтар', NULL, 'GI', 'GIB');
INSERT INTO countries VALUES('296', 'Кирибати', NULL, 'KI', 'KIR');
INSERT INTO countries VALUES('300', 'Греция', NULL, 'GR', 'GRC');
INSERT INTO countries VALUES('304', 'Гренландия', NULL, 'GL', 'GRL');
INSERT INTO countries VALUES('308', 'Гренада', NULL, 'GD', 'GRD');
INSERT INTO countries VALUES('312', 'Гваделупа', NULL, 'GP', 'GLP');
INSERT INTO countries VALUES('316', 'Гуам', NULL, 'GU', 'GUM');
INSERT INTO countries VALUES('320', 'Гватемала', NULL, 'GT', 'GTM');
INSERT INTO countries VALUES('324', 'Гвинея', NULL, 'GN', 'GIN');
INSERT INTO countries VALUES('328', 'Гайана', NULL, 'GY', 'GUY');
INSERT INTO countries VALUES('332', 'Гаити', NULL, 'HT', 'HTI');
INSERT INTO countries VALUES('334', 'Херд и Макдональд', NULL, 'HM', 'HMD');
INSERT INTO countries VALUES('336', 'Ватикан', NULL, 'VA', 'VAT');
INSERT INTO countries VALUES('340', 'Гондурас', NULL, 'HN', 'HND');
INSERT INTO countries VALUES('344', 'Сянган (Гонконг)', NULL, 'HK', 'HKG');
INSERT INTO countries VALUES('348', 'Венгрия', NULL, 'HU', 'HUN');
INSERT INTO countries VALUES('352', 'Исландия', NULL, 'IS', 'ISL');
INSERT INTO countries VALUES('356', 'Индия', NULL, 'IN', 'IND');
INSERT INTO countries VALUES('360', 'Индонезия', NULL, 'ID', 'IDN');
INSERT INTO countries VALUES('364', 'Иран', NULL, 'IR', 'IRN');
INSERT INTO countries VALUES('368', 'Ирак', NULL, 'IQ', 'IRQ');
INSERT INTO countries VALUES('372', 'Ирландия', NULL, 'IE', 'IRL');
INSERT INTO countries VALUES('376', 'Израиль', NULL, 'IL', 'ISR');
INSERT INTO countries VALUES('380', 'Италия', NULL, 'IT', 'ITA');
INSERT INTO countries VALUES('384', 'Кот дИвуар', NULL, 'CI', 'CIV');
INSERT INTO countries VALUES('388', 'Ямайка', NULL, 'JM', 'JAM');
INSERT INTO countries VALUES('392', 'Япония', NULL, 'JP', 'JPN');
INSERT INTO countries VALUES('396', 'Джонстон Атолл', NULL, 'JT', 'JTN');
INSERT INTO countries VALUES('398', 'Казахстан', NULL, 'KZ', 'KAZ');
INSERT INTO countries VALUES('400', 'Иордания', NULL, 'JO', 'JOR');
INSERT INTO countries VALUES('404', 'Кения', NULL, 'KE', 'KEN');
INSERT INTO countries VALUES('408', 'Корея (КНДР)', NULL, 'KP', 'PRK');
INSERT INTO countries VALUES('410', 'Республика Корея', NULL, 'KR', 'KOR');
INSERT INTO countries VALUES('414', 'Кувейт', NULL, 'KW', 'KWT');
INSERT INTO countries VALUES('417', 'Киргизия', NULL, 'KG', 'KGZ');
INSERT INTO countries VALUES('418', 'Лаос', NULL, 'LA', 'LAO');
INSERT INTO countries VALUES('422', 'Ливан', NULL, 'LB', 'LBN');
INSERT INTO countries VALUES('426', 'Лесото', NULL, 'LS', 'LSO');
INSERT INTO countries VALUES('428', 'Латвия', NULL, 'LV', 'LVA');
INSERT INTO countries VALUES('430', 'Либерия', NULL, 'LR', 'LBR');
INSERT INTO countries VALUES('434', 'Ливия', NULL, 'LY', 'LBY');
INSERT INTO countries VALUES('438', 'Лихтенштейн', NULL, 'LI', 'LIE');
INSERT INTO countries VALUES('440', 'Литва', NULL, 'LT', 'LTU');
INSERT INTO countries VALUES('442', 'Люксембург', NULL, 'LU', 'LUX');
INSERT INTO countries VALUES('446', 'Аомынь (Макао)', NULL, 'MO', 'MAC');
INSERT INTO countries VALUES('450', 'Мадагаскар', NULL, 'MG', 'MDG');
INSERT INTO countries VALUES('454', 'Малави', NULL, 'MW', 'MWI');
INSERT INTO countries VALUES('458', 'Малайзия', NULL, 'MY', 'MYS');
INSERT INTO countries VALUES('462', 'Мальдивы', NULL, 'MV', 'MDV');
INSERT INTO countries VALUES('466', 'Мали', NULL, 'ML', 'MLI');
INSERT INTO countries VALUES('470', 'Мальта', NULL, 'MT', 'MLT');
INSERT INTO countries VALUES('474', 'Мартиника', NULL, 'MQ', 'MTQ');
INSERT INTO countries VALUES('478', 'Мавритания', NULL, 'MR', 'MRT');
INSERT INTO countries VALUES('480', 'Маврикий', NULL, 'MU', 'MUS');
INSERT INTO countries VALUES('484', 'Мексика', NULL, 'MX', 'MEX');
INSERT INTO countries VALUES('488', 'Острова Мидуэй', NULL, 'MI', 'MID');
INSERT INTO countries VALUES('492', 'Монако', NULL, 'MC', 'MCO');
INSERT INTO countries VALUES('496', 'Монголия', NULL, 'MN', 'MHG');
INSERT INTO countries VALUES('498', 'Молдавия', NULL, 'MD', 'MDA');
INSERT INTO countries VALUES('500', 'Монтсеррат', NULL, 'MS', 'MSR');
INSERT INTO countries VALUES('504', 'Марокко', NULL, 'MA', 'MAR');
INSERT INTO countries VALUES('508', 'Мозамбик', NULL, 'MZ', 'MOZ');
INSERT INTO countries VALUES('512', 'Оман', NULL, 'OM', 'OMN');
INSERT INTO countries VALUES('516', 'Намибия', NULL, 'NA', 'NAM');
INSERT INTO countries VALUES('520', 'Науру', NULL, 'NR', 'NRU');
INSERT INTO countries VALUES('524', 'Непал', NULL, 'NP', 'NPL');
INSERT INTO countries VALUES('528', 'Нидерланды', NULL, 'NL', 'NLD');
INSERT INTO countries VALUES('530', 'Антильские острова (Нидерланды)', NULL, 'AN', 'ANT');
INSERT INTO countries VALUES('533', 'Аруба', NULL, 'AW', 'ABW');
INSERT INTO countries VALUES('540', 'Новая Каледония', NULL, 'NC', 'NCL');
INSERT INTO countries VALUES('548', 'Вануату', NULL, 'VU', 'VUT');
INSERT INTO countries VALUES('554', 'Новая Зеландия', NULL, 'NZ', 'NZL');
INSERT INTO countries VALUES('558', 'Никарагуа', NULL, 'NI', 'NIC');
INSERT INTO countries VALUES('562', 'Нигер', NULL, 'NE', 'NER');
INSERT INTO countries VALUES('566', 'Нигерия', NULL, 'NG', 'NGA');
INSERT INTO countries VALUES('570', 'Ниуэ', NULL, 'NU', 'NIU');
INSERT INTO countries VALUES('574', 'Норфолк', NULL, 'NF', 'NFK');
INSERT INTO countries VALUES('578', 'Норвегия', NULL, 'NO', 'NOR');
INSERT INTO countries VALUES('580', 'Марианские острова', NULL, 'MP', 'MNP');
INSERT INTO countries VALUES('581', 'Малые Тихоокеанские острова (США)', NULL, 'UM', 'UMI');
INSERT INTO countries VALUES('583', 'Микронезия', NULL, 'FM', 'FSM');
INSERT INTO countries VALUES('584', 'Маршалловы острова', NULL, 'MH', 'MHL');
INSERT INTO countries VALUES('585', 'Палау', NULL, 'PW', 'PLW');
INSERT INTO countries VALUES('586', 'Пакистан', NULL, 'PK', 'PAK');
INSERT INTO countries VALUES('591', 'Панама', NULL, 'PA', 'PAN');
INSERT INTO countries VALUES('598', 'Папуа Новая Гвинея', NULL, 'PG', 'PNG');
INSERT INTO countries VALUES('600', 'Парагвай', NULL, 'PY', 'PRY');
INSERT INTO countries VALUES('604', 'Перу', NULL, 'PE', 'PER');
INSERT INTO countries VALUES('608', 'Филиппины', NULL, 'PH', 'PHL');
INSERT INTO countries VALUES('612', 'Питкэрн', NULL, 'PN', 'PCN');
INSERT INTO countries VALUES('616', 'Польша', NULL, 'PL', 'POL');
INSERT INTO countries VALUES('620', 'Португалия', NULL, 'PT', 'PRT');
INSERT INTO countries VALUES('624', 'Гвинея Бисау', NULL, 'GW', 'GNB');
INSERT INTO countries VALUES('626', 'Восточный Тимор', NULL, 'TP', 'TMP');
INSERT INTO countries VALUES('630', 'Пуэрто - Рико', NULL, 'PR', 'PRI');
INSERT INTO countries VALUES('634', 'Катар', NULL, 'QA', 'QAT');
INSERT INTO countries VALUES('638', 'Реюньон', NULL, 'RE', 'REU');
INSERT INTO countries VALUES('642', 'Румыния', NULL, 'RO', 'ROM');
INSERT INTO countries VALUES('643', 'Россия', NULL, 'RU', 'RUS');
INSERT INTO countries VALUES('646', 'Руанда', NULL, 'RW', 'RWA');
INSERT INTO countries VALUES('654', 'Остров Святой Елены', NULL, 'SH', 'SHN');
INSERT INTO countries VALUES('659', 'Сент Китс и Невис', NULL, 'KN', 'KNA');
INSERT INTO countries VALUES('660', 'Ангилья', NULL, 'AI', 'AIA');
INSERT INTO countries VALUES('662', 'Сент - Люсия', NULL, 'LC', 'LCA');
INSERT INTO countries VALUES('666', 'Сен Пьер и Микелон', NULL, 'PM', 'SPM');
INSERT INTO countries VALUES('670', 'С. Винсент и Гренадины', NULL, 'VC', 'VCT');
INSERT INTO countries VALUES('674', 'Сан - Марино', NULL, 'SM', 'SMR');
INSERT INTO countries VALUES('678', 'Сан Томе и Принсипи', NULL, 'ST', 'STR');
INSERT INTO countries VALUES('682', 'Саудовская Аравия', NULL, 'SA', 'SAU');
INSERT INTO countries VALUES('686', 'Сенегал', NULL, 'SN', 'SEN');
INSERT INTO countries VALUES('690', 'Сейшельские острова', NULL, 'SC', 'SYC');
INSERT INTO countries VALUES('694', 'Сьерра - Леоне', NULL, 'SL', 'SLE');
INSERT INTO countries VALUES('702', 'Сингапур', NULL, 'SG', 'SGP');
INSERT INTO countries VALUES('703', 'Словакия', NULL, 'SK', 'SVK');
INSERT INTO countries VALUES('704', 'Вьетнам', NULL, 'VN', 'VNM');
INSERT INTO countries VALUES('705', 'Словения', NULL, 'SI', 'SVN');
INSERT INTO countries VALUES('706', 'Сомали', NULL, 'SO', 'SOM');
INSERT INTO countries VALUES('710', 'ЮАР', NULL, 'ZA', 'ZAF');
INSERT INTO countries VALUES('716', 'Зимбабве', NULL, 'ZW', 'ZWE');
INSERT INTO countries VALUES('724', 'Испания', NULL, 'ES', 'ЕS');
INSERT INTO countries VALUES('732', 'Западная Сахара', NULL, 'E?', 'ESH');
INSERT INTO countries VALUES('736', 'Судан', NULL, 'SD', 'SDN');
INSERT INTO countries VALUES('740', 'Суринам', NULL, 'SR', 'SUR');
INSERT INTO countries VALUES('744', 'Шпицберген и Ян - Майен', NULL, 'SJ', 'SJM');
INSERT INTO countries VALUES('748', 'Свазиленд', NULL, 'SZ', 'SWZ');
INSERT INTO countries VALUES('752', 'Швеция', NULL, 'SE', 'SWE');
INSERT INTO countries VALUES('756', 'Швейцария', NULL, 'CH', 'CHE');
INSERT INTO countries VALUES('760', 'Сирия', NULL, 'SY', 'SYR');
INSERT INTO countries VALUES('762', 'Таджикистан', NULL, 'TJ', 'TJK');
INSERT INTO countries VALUES('764', 'Таиланд', NULL, 'TH', 'THA');
INSERT INTO countries VALUES('768', 'Того', NULL, 'TG', 'TGO');
INSERT INTO countries VALUES('772', 'Токелау (ЮНИОН)', NULL, 'TK', 'TKL');
INSERT INTO countries VALUES('776', 'Тонга', NULL, 'TO', 'TON');
INSERT INTO countries VALUES('780', 'Тринидад и Тобаго', NULL, 'TT', 'TTO');
INSERT INTO countries VALUES('784', 'Объединенные Арабские Эмираты', NULL, 'AE', 'ARE');
INSERT INTO countries VALUES('788', 'Тунис', NULL, 'TN', 'TUN');
INSERT INTO countries VALUES('792', 'Турция', NULL, 'TR', 'TUR');
INSERT INTO countries VALUES('795', 'Туркмения', NULL, 'TM', 'TKM');
INSERT INTO countries VALUES('796', 'Теркс и Кайкос', NULL, 'TC', 'TCA');
INSERT INTO countries VALUES('798', 'Тувалу', NULL, 'TV', 'TUV');
INSERT INTO countries VALUES('800', 'Уганда', NULL, 'UG', 'UGA');
INSERT INTO countries VALUES('804', 'Украина', NULL, 'UA', 'UKR');
INSERT INTO countries VALUES('807', 'Македония', NULL, 'MK', 'MKD');
INSERT INTO countries VALUES('818', 'Египет', NULL, 'EG', 'EGY');
INSERT INTO countries VALUES('826', 'Великобритания', NULL, 'GB', 'GBR');
INSERT INTO countries VALUES('830', 'Нормандские острова', NULL, NULL, NULL);
INSERT INTO countries VALUES('833', 'Остров Мэн', NULL, 'IM', 'IMY');
INSERT INTO countries VALUES('834', 'Танзания', NULL, 'TZ', 'TZA');
INSERT INTO countries VALUES('840', 'США', NULL, 'US', 'USA');
INSERT INTO countries VALUES('850', 'Виргинские острова (США)', NULL, 'VI', 'VIR');
INSERT INTO countries VALUES('854', 'Буркина - Фасо', NULL, 'BF', 'BFA');
INSERT INTO countries VALUES('858', 'Уругвай', NULL, 'UY', 'URY');
INSERT INTO countries VALUES('860', 'Узбекистан', NULL, 'UZ', 'UZB');
INSERT INTO countries VALUES('862', 'Венесуэла', NULL, 'VE', 'VEN');
INSERT INTO countries VALUES('872', 'Остров Уэйк', NULL, 'WK', 'WAK');
INSERT INTO countries VALUES('876', 'Уоллис и Футуна', NULL, 'WF', 'WLF');
INSERT INTO countries VALUES('882', 'Западное Самоа', NULL, 'WS', 'WSM');
INSERT INTO countries VALUES('887', 'Йемен', NULL, 'YE', 'YEM');
INSERT INTO countries VALUES('891', 'Югославия', NULL, 'YU', 'YUG');
INSERT INTO countries VALUES('894', 'Замбия', NULL, 'ZM', 'ZMB');
