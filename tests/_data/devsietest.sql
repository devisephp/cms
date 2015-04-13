# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.37-0ubuntu0.14.04.1)
# Database: devsietest
# Generation Time: 2015-04-10 17:45:21 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table dvs_collection_instances
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvs_collection_instances`;

CREATE TABLE `dvs_collection_instances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collection_set_id` int(11) NOT NULL,
  `page_version_id` int(10) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `dvs_collection_instances_collection_set_id_index` (`collection_set_id`),
  KEY `dvs_collection_instances_page_version_id_index` (`page_version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table dvs_collection_sets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvs_collection_sets`;

CREATE TABLE `dvs_collection_sets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table dvs_fields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvs_fields`;

CREATE TABLE `dvs_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collection_instance_id` int(10) unsigned DEFAULT NULL,
  `page_version_id` int(10) unsigned NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `human_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `json_value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content_requested` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `collection_instance_page_version_key_unique_index` (`collection_instance_id`,`page_version_id`,`key`),
  KEY `dvs_fields_collection_instance_id_index` (`collection_instance_id`),
  KEY `dvs_fields_page_version_id_index` (`page_version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table dvs_global_fields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvs_global_fields`;

CREATE TABLE `dvs_global_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(10) unsigned NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `human_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `json_value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content_requested` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dvs_global_fields_language_id_key_unique` (`language_id`,`key`),
  KEY `dvs_global_fields_language_id_index` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table dvs_languages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvs_languages`;

CREATE TABLE `dvs_languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `human_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regional_human_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `dvs_languages` WRITE;
/*!40000 ALTER TABLE `dvs_languages` DISABLE KEYS */;

INSERT INTO `dvs_languages` (`id`, `code`, `human_name`, `regional_human_name`, `active`, `created_at`, `updated_at`)
VALUES
	(1,'aa','Afar','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(2,'ab','Abkhazian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(3,'af','Afrikaans','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(4,'ak','Akan','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(5,'sq','Albanian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(6,'am','Amharic','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(7,'ar','Arabic','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(8,'an','Aragonese','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(9,'hy','Armenian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(10,'as','Assamese','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(11,'av','Avaric','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(12,'ae','Avestan','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(13,'ay','Aymara','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(14,'az','Azerbaijani','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(15,'ba','Bashkir','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(16,'bm','Bambara','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(17,'eu','Basque','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(18,'be','Belarusian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(19,'bn','Bengali','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(20,'bh','Bihari languages','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(21,'bi','Bislama','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(22,'bo','Tibetan','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(23,'bs','Bosnian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(24,'br','Breton','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(25,'bg','Bulgarian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(26,'my','Burmese','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(27,'ca','Catalan; Valencian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(28,'cs','Czech','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(29,'ch','Chamorro','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(30,'ce','Chechen','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(31,'zh','Chinese','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(32,'cu','Church Slavic','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(33,'cv','Chuvash','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(34,'kw','Cornish','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(35,'co','Corsican','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(36,'cr','Cree','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(37,'cy','Welsh','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(38,'cs','Czech','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(39,'da','Danish','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(40,'de','German','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(41,'dv','Divehi; Dhivehi; Maldivian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(42,'nl','Dutch; Flemish','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(43,'dz','Dzongkha','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(44,'el','Greek, Modern (1453-)','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(45,'en','English','',1,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(46,'eo','Esperanto','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(47,'et','Estonian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(48,'eu','Basque','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(49,'ee','Ewe','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(50,'fo','Faroese','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(51,'fa','Persian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(52,'fj','Fijian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(53,'fi','Finnish','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(54,'fr','French','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(55,'ka','Georgian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(56,'de','German','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(57,'gd','Gaelic; Scottish Gaelic','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(58,'ga','Irish','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(59,'gl','Galician','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(60,'gv','Manx','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(61,'el','Greek, Modern (1453-)','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(62,'gn','Guarani','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(63,'gu','Gujarati','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(64,'ht','Haitian; Haitian Creole','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(65,'ha','Hausa','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(66,'he','Hebrew','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(67,'hz','Herero','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(68,'hi','Hindi','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(69,'ho','Hiri Motu','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(70,'hr','Croatian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(71,'hu','Hungarian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(72,'hy','Armenian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(73,'ig','Igbo','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(74,'is','Icelandic','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(75,'io','Ido','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(76,'ii','Sichuan Yi; Nuosu','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(77,'iu','Inuktitut','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(78,'ie','Interlingue; Occidental','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(79,'ia','Interlingua (International Auxiliary Language Association)','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(80,'id','Indonesian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(81,'ik','Inupiaq','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(82,'is','Icelandic','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(83,'it','Italian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(84,'jv','Javanese','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(85,'ja','Japanese','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(86,'kl','Kalaallisut; Greenlandic','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(87,'kn','Kannada','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(88,'ks','Kashmiri','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(89,'ka','Georgian','',0,'2015-04-10 17:44:55','2015-04-10 17:44:55'),
	(90,'kr','Kanuri','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(91,'kk','Kazakh','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(92,'km','Central Khmer','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(93,'ki','Kikuyu; Gikuyu','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(94,'rw','Kinyarwanda','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(95,'ky','Kirghiz; Kyrgyz','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(96,'kv','Komi','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(97,'kg','Kongo','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(98,'ko','Korean','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(99,'kj','Kuanyama; Kwanyama','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(100,'ku','Kurdish','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(101,'lo','Lao','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(102,'la','Latin','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(103,'lv','Latvian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(104,'li','Limburgan; Limburger; Limburgish','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(105,'ln','Lingala','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(106,'lt','Lithuanian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(107,'lb','Luxembourgish; Letzeburgesch','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(108,'lu','Luba-Katanga','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(109,'lg','Ganda','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(110,'mk','Macedonian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(111,'mh','Marshallese','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(112,'ml','Malayalam','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(113,'mi','Maori','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(114,'mr','Marathi','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(115,'ms','Malay','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(116,'mk','Macedonian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(117,'mg','Malagasy','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(118,'mt','Maltese','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(119,'mn','Mongolian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(120,'mi','Maori','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(121,'ms','Malay','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(122,'my','Burmese','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(123,'na','Nauru','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(124,'nv','Navajo; Navaho','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(125,'nr','Ndebele, South; South Ndebele','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(126,'nd','Ndebele, North; North Ndebele','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(127,'ng','Ndonga','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(128,'ne','Nepali','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(129,'nl','Dutch; Flemish','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(130,'nn','Norwegian Nynorsk; Nynorsk, Norwegian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(131,'nb','Bokmål, Norwegian; Norwegian Bokmål','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(132,'no','Norwegian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(133,'ny','Chichewa; Chewa; Nyanja','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(134,'oc','Occitan (post 1500)','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(135,'oj','Ojibwa','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(136,'or','Oriya','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(137,'om','Oromo','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(138,'os','Ossetian; Ossetic','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(139,'pa','Panjabi; Punjabi','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(140,'fa','Persian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(141,'pi','Pali','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(142,'pl','Polish','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(143,'pt','Portuguese','Português',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(144,'ps','Pushto; Pashto','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(145,'qu','Quechua','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(146,'rm','Romansh','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(147,'ro','Romanian; Moldavian; Moldovan','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(148,'ro','Romanian; Moldavian; Moldovan','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(149,'rn','Rundi','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(150,'ru','Russian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(151,'sg','Sango','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(152,'sa','Sanskrit','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(153,'si','Sinhala; Sinhalese','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(154,'sk','Slovak','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(155,'sk','Slovak','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(156,'sl','Slovenian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(157,'se','Northern Sami','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(158,'sm','Samoan','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(159,'sn','Shona','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(160,'sd','Sindhi','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(161,'so','Somali','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(162,'st','Sotho, Southern','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(163,'es','Spanish; Castilian','Español',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(164,'sq','Albanian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(165,'sc','Sardinian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(166,'sr','Serbian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(167,'ss','Swati','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(168,'su','Sundanese','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(169,'sw','Swahili','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(170,'sv','Swedish','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(171,'ty','Tahitian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(172,'ta','Tamil','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(173,'tt','Tatar','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(174,'te','Telugu','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(175,'tg','Tajik','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(176,'tl','Tagalog','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(177,'th','Thai','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(178,'bo','Tibetan','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(179,'ti','Tigrinya','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(180,'to','Tonga (Tonga Islands)','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(181,'tn','Tswana','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(182,'ts','Tsonga','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(183,'tk','Turkmen','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(184,'tr','Turkish','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(185,'tw','Twi','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(186,'ug','Uighur; Uyghur','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(187,'uk','Ukrainian','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(188,'ur','Urdu','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(189,'uz','Uzbek','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(190,'ve','Venda','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(191,'vi','Vietnamese','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(192,'vo','Volapük','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(193,'cy','Welsh','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(194,'wa','Walloon','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(195,'wo','Wolof','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(196,'xh','Xhosa','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(197,'yi','Yiddish','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(198,'yo','Yoruba','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(199,'za','Zhuang; Chuang','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(200,'zh','Chinese','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(201,'zu','Zulu','',0,'2015-04-10 17:44:56','2015-04-10 17:44:56');

/*!40000 ALTER TABLE `dvs_languages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dvs_menu_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvs_menu_items`;

CREATE TABLE `dvs_menu_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) unsigned NOT NULL,
  `page_id` int(10) unsigned DEFAULT NULL,
  `parent_item_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `position` int(11) NOT NULL DEFAULT '0',
  `permission` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `dvs_menu_items_menu_id_index` (`menu_id`),
  KEY `dvs_menu_items_page_id_index` (`page_id`),
  KEY `dvs_menu_items_parent_item_id_index` (`parent_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `dvs_menu_items` WRITE;
/*!40000 ALTER TABLE `dvs_menu_items` DISABLE KEYS */;

INSERT INTO `dvs_menu_items` (`id`, `menu_id`, `page_id`, `parent_item_id`, `name`, `url`, `image`, `description`, `position`, `permission`, `created_at`, `updated_at`)
VALUES
	(1,1,NULL,NULL,'Management','#',NULL,NULL,1,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(2,1,NULL,1,'Dashboard','/admin',NULL,NULL,2,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(3,1,NULL,1,'Menus','/admin/menus',NULL,NULL,3,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(4,1,NULL,1,'Pages','/admin/pages',NULL,NULL,4,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(5,1,NULL,1,'Languages','/admin/languages',NULL,NULL,5,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(6,1,NULL,1,'Users','/admin/users',NULL,NULL,6,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(7,1,NULL,1,'Logout','/admin/logout',NULL,NULL,7,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(8,1,NULL,NULL,'Development','#',NULL,NULL,8,'isDeveloper','2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(9,1,NULL,8,'API','/admin/api',NULL,NULL,9,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(10,1,NULL,8,'Groups','/admin/groups',NULL,NULL,10,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(11,1,NULL,8,'Permissions','/admin/permissions',NULL,NULL,11,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(12,1,NULL,8,'Templates','/admin/templates',NULL,NULL,12,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(13,1,NULL,8,'Settings','/admin/settings',NULL,NULL,13,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56');

/*!40000 ALTER TABLE `dvs_menu_items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dvs_menus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvs_menus`;

CREATE TABLE `dvs_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(10) unsigned NOT NULL,
  `translated_from_menu_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `links` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `dvs_menus` WRITE;
/*!40000 ALTER TABLE `dvs_menus` DISABLE KEYS */;

INSERT INTO `dvs_menus` (`id`, `language_id`, `translated_from_menu_id`, `name`, `links`, `created_at`, `updated_at`)
VALUES
	(1,45,0,'Admin Menu',NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56');

/*!40000 ALTER TABLE `dvs_menus` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dvs_model_fields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvs_model_fields`;

CREATE TABLE `dvs_model_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapping` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `json_value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `model_id_type_and_mapping_unique_index` (`model_id`,`model_type`,`mapping`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table dvs_page_versions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvs_page_versions`;

CREATE TABLE `dvs_page_versions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(10) unsigned NOT NULL,
  `created_by_user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `preview_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `dvs_page_versions_page_id_index` (`page_id`),
  KEY `dvs_page_versions_created_by_user_id_index` (`created_by_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `dvs_page_versions` WRITE;
/*!40000 ALTER TABLE `dvs_page_versions` DISABLE KEYS */;

INSERT INTO `dvs_page_versions` (`id`, `page_id`, `created_by_user_id`, `name`, `starts_at`, `ends_at`, `preview_hash`, `deleted_at`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(2,2,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(3,3,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(4,4,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(5,5,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(6,6,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(7,7,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(8,8,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(9,9,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(10,10,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(11,11,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(12,12,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(13,13,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(14,14,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(15,15,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(16,16,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(17,17,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(18,18,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(19,19,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(20,20,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(21,21,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(22,22,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(23,23,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(24,24,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(25,25,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(26,26,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(27,27,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(28,28,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(29,29,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(30,30,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(31,31,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(32,32,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(33,33,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(34,34,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(35,35,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(36,36,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(37,37,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(38,38,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(39,39,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(40,40,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(41,41,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(42,42,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(43,43,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(44,44,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(45,45,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(46,46,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(47,47,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(48,48,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(49,49,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(50,50,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(51,51,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(52,52,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(53,53,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(54,54,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(55,55,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(56,56,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(57,57,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(58,58,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(59,59,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(60,60,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(61,61,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(62,62,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(63,63,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(64,64,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(65,65,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(66,66,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(67,67,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(68,68,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(69,69,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(70,70,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(71,71,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(72,72,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(73,73,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(74,74,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(75,75,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(76,76,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(77,77,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(78,78,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(79,79,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(80,80,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(81,81,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(82,82,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(83,83,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(84,84,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(85,85,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(86,86,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(87,87,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(88,88,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(89,89,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(90,90,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(91,91,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(92,92,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(93,93,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(94,94,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(95,95,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(96,96,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(97,97,1,'Default','2015-04-10 17:44:56',NULL,NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56');

/*!40000 ALTER TABLE `dvs_page_versions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dvs_pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvs_pages`;

CREATE TABLE `dvs_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `translated_from_page_id` int(11) NOT NULL DEFAULT '0',
  `view` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `http_verb` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'get',
  `route_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `dvs_admin` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `head` text COLLATE utf8_unicode_ci,
  `footer` text COLLATE utf8_unicode_ci,
  `before` text COLLATE utf8_unicode_ci,
  `after` text COLLATE utf8_unicode_ci,
  `response_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'View',
  `response_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `response_params` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dvs_pages_language_id_index` (`language_id`),
  KEY `dvs_pages_translated_from_page_id_index` (`translated_from_page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `dvs_pages` WRITE;
/*!40000 ALTER TABLE `dvs_pages` DISABLE KEYS */;

INSERT INTO `dvs_pages` (`id`, `language_id`, `translated_from_page_id`, `view`, `title`, `http_verb`, `route_name`, `is_admin`, `dvs_admin`, `slug`, `short_description`, `meta_title`, `meta_description`, `meta_keywords`, `head`, `footer`, `before`, `after`, `response_type`, `response_path`, `response_params`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,45,0,'devise::admin.pages.index','Manage Pages','get','dvs-pages',1,1,'/admin/pages','Allows the management of devise pages',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(2,45,0,'devise::admin.pages.list','JSON List of pages','get','dvs-pages-list',1,1,'/admin/pages/list','Returns a JSON encoded list of pages',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Pages\\PageResponseHandler.requestPageList','params.name, params.page','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(3,45,0,'devise::admin.pages.create','Create Page','get','dvs-pages-create',1,1,'/admin/pages/create','Create a new page',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(4,45,0,NULL,'Store Page','post','dvs-pages-store',1,1,'/admin/pages','Stores the creation of a new page',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Pages\\PageResponseHandler.requestCreateNewPage','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(5,45,0,'devise::admin.pages.edit','Edit Page','get','dvs-pages-edit',1,1,'/admin/pages/{pageId}/edit','Edits a page',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(6,45,0,NULL,'Update Page','put','dvs-pages-update',1,1,'/admin/pages/{pageId}','Updates the page record',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Pages\\PageResponseHandler.requestUpdatePage','params.pageId, input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(7,45,0,NULL,'Destroy Page','delete','dvs-pages-destroy',1,1,'/admin/pages/{pageId}','Destroys a page record',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Pages\\PageResponseHandler.requestDestroyPage','params.pageId','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(8,45,0,'devise::admin.pages.copy','Copy Page','get','dvs-pages-copy',1,1,'/admin/pages/{pageId}/copy','Copies a page',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(9,45,0,NULL,'Copy Page Store','post','dvs-pages-copy-store',1,1,'/admin/pages/{pageId}/copy','Creates copy record',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Pages\\PageResponseHandler.requestCopyPage','params.pageId, input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(10,45,0,'devise::admin.api.index','Manage API Requests','get','dvs-api',1,1,'/admin/api','Allows the management of devise API requests',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(11,45,0,'devise::admin.api.create','Create API Request Form','get','dvs-api-create',1,1,'/admin/api/create','Create a new API request form',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(12,45,0,NULL,'Store API Request','post','dvs-api-store',1,1,'/admin/api','Stores the data from the API create form',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Pages\\ApiPagesResponseHandler.requestCreateNewPage','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(13,45,0,'devise::admin.api.edit','Edit API Request Form','get','dvs-api-edit',1,1,'/admin/api/{pageId}/edit','Edit an API request form',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(14,45,0,NULL,'Update API Request','put','dvs-api-update',1,1,'/admin/api/{pageId}','Updates the API request record using the form data',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Pages\\ApiPagesResponseHandler.requestUpdatePage','params.pageId, input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(15,45,0,NULL,'Destroy API Request','delete','dvs-api-destroy',1,1,'/admin/api/{pageId}','Destroys a page record',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Pages\\ApiPagesResponseHandler.requestDestroyPage','params.pageId','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(16,45,0,NULL,'Partial Loader','post','dvs-partials',1,1,'/admin/media-manager/upload','Update a field via ajax call',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Media\\Files\\ResponseHandler.requestUpload','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(17,45,0,'devise::admin.content.queue','Content Queue Index','get','dvs-content-queue-index',1,1,'/admin/content','Shows all the content currently in the queue',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(18,45,0,'devise::admin.users.index','Manage Users','get','dvs-users',1,1,'/admin/users','Allows the management of users',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(19,45,0,'devise::admin.users.create','Create User','get','dvs-users-create',1,1,'/admin/users/create','Create a new user',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(20,45,0,NULL,'Store User','post','dvs-users-store',1,1,'/admin/users','Stores the creation of a new user',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Users\\UsersResponseHandler.requestCreateUser','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(21,45,0,'devise::admin.users.edit','Edit User','get','dvs-users-edit',1,1,'/admin/users/{userId}/edit','Edits a user',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(22,45,0,NULL,'Update User','put','dvs-users-update',1,1,'/admin/users/{userId}','Updates the user record',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Users\\UsersResponseHandler.requestUpdateUser','params.userId, input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(23,45,0,NULL,'Destroy User','delete','dvs-users-destroy',1,1,'/admin/users/{userId}','Destroys a user record',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Users\\UsersResponseHandler.requestDestroyUser','params.userId','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(24,45,0,'devise::admin.groups.index','Manage Groups','get','dvs-groups',1,1,'/admin/groups','Allows the management of groups',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(25,45,0,'devise::admin.groups.create','Create Group','get','dvs-groups-create',1,1,'/admin/groups/create','Create a new group',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(26,45,0,NULL,'Store Group','post','dvs-groups-store',1,1,'/admin/groups','Stores the creation of a new group',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Users\\Groups\\GroupsResponseHandler.requestCreateGroup','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(27,45,0,'devise::admin.groups.edit','Edit User','get','dvs-groups-edit',1,1,'/admin/groups/{groupId}/edit','Edits a group',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(28,45,0,NULL,'Update Group','put','dvs-groups-update',1,1,'/admin/groups/{groupId}','Updates the group record',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Users\\Groups\\GroupsResponseHandler.requestUpdateGroup','params.groupId, input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(29,45,0,NULL,'Destroy Group','delete','dvs-groups-destroy',1,1,'/admin/groups/{groupId}','Destroys a group record',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Users\\Groups\\GroupsResponseHandler.requestDestroyGroup','params.groupId','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(30,45,0,'devise::admin.languages.index','All Languages','get','dvs-languages',1,1,'/admin/languages','View list of languages',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(31,45,0,NULL,'Toggle Language Enabled','patch','dvs-languages-patch',1,1,'/admin/languages/{languageId}/patch','Destroys a group record',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Languages\\LanguagesResponseHandler.requestPatchLanguage','params.languageId,input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(32,45,0,'devise::admin.menus.index','All Menus','get','dvs-menus',1,1,'/admin/menus','View list of menus',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(33,45,0,'devise::admin.menus.create','Create a new menu','get','dvs-menus-create',1,1,'/admin/menus/create','Create new menu form',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(34,45,0,NULL,'Store menu','post','dvs-menus-store',1,1,'/admin/menus','Store a new menu',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Menus\\MenusResponseHandler.requestStore','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(35,45,0,'devise::admin.menus.edit','Edit Menu','get','dvs-menus-edit',1,1,'/admin/menus/{menuId}/edit','Edit menu',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(36,45,0,NULL,'Update a menu','put','dvs-menus-update',1,1,'/admin/menus/{menuId}','Edit existing menu',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Menus\\MenusResponseHandler.requestUpdate','params.menuId,input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(37,45,0,NULL,'Update fields ajaxly','put','dvs-fields-update',1,1,'/admin/fields/{fieldId}','Update a field via ajax call',NULL,NULL,NULL,NULL,NULL,'canUseDeviseEditor','','Function','Devise\\Pages\\Fields\\FieldsResponseHandler.requestUpdate','params.fieldId,input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(38,45,0,'devise::admin.fields.index','All the Devise fields you could be using','get','dvs-fields-index',1,1,'/admin/fields','Shows us the list of devise fields we could be using',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(39,45,0,NULL,'Mark all content requested for a particular page complete','get','dvs-fields-content-requested-mark-all-complete',1,1,'/admin/fields/content-requested/{pageId}/mark-complete','Finds all fields which are flagged as \\\"content requested\\\" for all the page versions for a particular page and marks them complete.',NULL,NULL,NULL,NULL,NULL,'canUseDeviseEditor','','Function','Devise\\Pages\\PageManager.markContentRequestedFieldsComplete','params.pageId','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(40,45,0,NULL,'Finds all content requested fields','get','dvs-fields-content-requested',1,1,'/admin/fields/content-requested/{pageVersionId}','Finds all fields which are flagged as \\\"content requested\\\" for a given page version id',NULL,NULL,NULL,NULL,NULL,'canUseDeviseEditor','','Function','Devise\\Pages\\Fields\\FieldsRepository.findContentRequestedFieldsList','params.pageVersionId','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(41,45,0,'devise::admin.media.manager','Media Manager','get','dvs-media-manager',1,1,'/admin/media-manager','User interface for selecting, uploading and managing multi media.',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(42,45,0,NULL,'Handle File Rename','put','dvs-media-rename',1,1,'/admin/media-manager/rename','Update file name',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Media\\Files\\ResponseHandler.requestRename','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(43,45,0,NULL,'Handle File Rename','delete','dvs-media-remove',1,1,'/admin/media-manager/remove','Remove file',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Media\\Files\\ResponseHandler.requestRemove','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(44,45,0,NULL,'Rename Category','put','dvs-media-category-rename',1,1,'/admin/media-manager/category/rename','Renames a category',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Media\\Categories\\ResponseHandler.requestRename','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(45,45,0,NULL,'Handle File Upload','post','dvs-media-upload',1,1,'/admin/media-manager/upload','Update a field via ajax call',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Media\\Files\\ResponseHandler.requestUpload','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(46,45,0,'devise::admin.media.crop','Media Manager Crop','get','dvs-media-crop',1,1,'/admin/media-manager/crop','User interface for cropping images.',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(47,45,0,NULL,'Handle Image Crop','post','dvs-media-crop-image',1,1,'/admin/media-manager/crop','Crop and save new image',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Media\\Images\\ResponseHandler.requestCrop','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(48,45,0,NULL,'Create New Category','post','dvs-media-category-store',1,1,'/admin/media-manager/category/store','Create New Category',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Media\\Categories\\ResponseHandler.requestStore','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(49,45,0,NULL,'Destroy Category','get','dvs-media-category-destroy',1,1,'/admin/media-manager/category/destroy','Deletes a category',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Media\\Categories\\ResponseHandler.requestDestroy','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(50,45,0,NULL,'Create collection instance','post','dvs-collection-instance-add',1,1,'/admin/pages/{pageVersionId}/collections/{collectionSetId}/instances/store','Adds a new collection instance',NULL,NULL,NULL,NULL,NULL,'canUseDeviseEditor','','Function','Devise\\Pages\\Collections\\ResponseHandler.requestStoreInstance','params.pageVersionId,params.collectionSetId,input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(51,45,0,NULL,'List of collections','get','dvs-collection-instance-index',1,1,'/admin/pages/{pageVersionId}/collections/{collectionSetId}/instances','Gets a json index of instances',NULL,NULL,NULL,NULL,NULL,'canUseDeviseEditor','','Function','Devise\\Pages\\Collections\\CollectionsRepository.getInstances','params.pageVersionId,params.collectionSetId','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(52,45,0,NULL,'Update instances sort orders','post','dvs-collection-instance-update-sort-orders',1,1,'/admin/pages/{pageVersionId}/collections/{collectionSetId}/instances/update-sort-orders','Updates the sort order of a collection',NULL,NULL,NULL,NULL,NULL,'canUseDeviseEditor','','Function','Devise\\Pages\\Collections\\ResponseHandler.updateSortOrder','params.pageVersionId,params.collectionSetId,input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(53,45,0,NULL,'Update collection instance field','put','dvs-collection-instance-field-update',1,1,'/admin/collection-fields/{collectionFieldId}','Updates a collection field\'s values',NULL,NULL,NULL,NULL,NULL,'canUseDeviseEditor','','Function','Devise\\Pages\\Collections\\ResponseHandler.updateCollectionInstanceField','params.collectionFieldId,input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(54,45,0,NULL,'Collection update handler','put','dvs-collection-instance-update-name',1,1,'/admin/pages/{pageVersionId}/collections/{collectionSetId}/instances/{collectionInstanceId}/update-name','Collection update handler',NULL,NULL,NULL,NULL,NULL,'canUseDeviseEditor','','Function','Devise\\Pages\\Collections\\ResponseHandler.renameInstance','params.pageVersionId,params.collectionInstanceId,input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(55,45,0,NULL,'Deleting collection instance','post','dvs-collection-instance-delete',1,1,'/admin/collections/{collectionSetId}/instances/{collectionInstanceId}/delete','Deletes a collection instance',NULL,NULL,NULL,NULL,NULL,'canUseDeviseEditor','','Function','Devise\\Pages\\Collections\\ResponseHandler.requestDeleteInstance','params.collectionInstanceId','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(56,45,0,NULL,'New Page Version','post','dvs-page-version-store',1,1,'/admin/page-versions','Create a new page version',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Pages\\PageResponseHandler.requestStorePageVersion','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(57,45,0,NULL,'Destroy Page Version','delete','dvs-page-version-destroy',1,1,'/admin/page-versions/{pageVersionId}','Destroys a page version record',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Pages\\PageResponseHandler.requestDestroyPageVersion','params.pageVersionId','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(58,45,0,NULL,'Update Devise Page Version Dates','put','dvs-update-page-versions-dates',1,1,'/admin/page-versions/{pageVersionId}/dates','Updates the starts_at and ends_at dates for a page version',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Pages\\PageResponseHandler.requestUpdatePageVersionDates','params.pageVersionId,input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(59,45,0,'devise::admin.pages.page-versions._card','Page Versions Card','get','dvs-page-versions-card',1,1,'/admin/pages/{pageId}/page-versions/card','',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,'params.pageId','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(60,45,0,NULL,'Toggle Sharing Preview URL for a Page Version','put','dvs-toggle-page-version-share',1,1,'/admin/page-versions/{pageVersionId}/toggle-share','Allows admin users to turn on/off the hashed preview url for a page version',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Pages\\PageResponseHandler.requestTogglePageVersionShare','params.pageVersionId','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(61,45,0,NULL,'Deletes a Page Version','delete','dvs-delete-page-version',1,1,'/admin/page-versions/{pageVersionId}','Deletes a page version',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Pages\\Response\\ResponseHandler.requestDestroyPageVersion','params.pageVersionId','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(62,45,0,'devise::admin.dashboard.index','Administration Dashboard','get','dvs-dashboard',1,1,'/admin',NULL,NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(63,45,0,NULL,'Translate Pages','get','dvs-translate-all',1,1,'/admin/pages/translate/all','',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Atlantis\\Pages\\ResponseHandler.copyAllToLanguage',NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(64,45,0,'devise::admin.users.login','Admin Users Login','get','dvs-user-login',1,1,'/admin/login','Allows users to login',NULL,NULL,NULL,NULL,NULL,'ifLoggedInGoToDash','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(65,45,0,NULL,'User Attempt Login','post','dvs-user-attempt-login',1,1,'/admin/attempt-login','Attempt to login user',NULL,NULL,NULL,NULL,NULL,'','','Function','Devise\\Users\\UsersResponseHandler.requestLogin','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(66,45,0,NULL,'User Logout','get','dvs-user-logout',1,1,'/admin/logout','Allows users to logout',NULL,NULL,NULL,NULL,NULL,'','','Function','Devise\\Users\\UsersResponseHandler.requestLogout',NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(67,45,0,'devise::admin.users.forgot','Admin Users Forgot Password','get','dvs-user-recover-password',1,1,'/admin/recover-password','Allows users which have forgotten password to recover vai email address',NULL,NULL,NULL,NULL,NULL,'ifLoggedInGoToDash','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(68,45,0,NULL,'User Password Recovery','post','dvs-user-attempt-recover',1,1,'/admin/attempt-recover','Password recovery using user email address',NULL,NULL,NULL,NULL,NULL,'','','Function','Devise\\Users\\UsersResponseHandler.requestRecoverPassword','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(69,45,0,'devise::admin.users.reset','User Reset Password','get','dvs-user-reset-password',1,1,'/admin/reset-password','Allows users which have forgotten password to recover vai email address',NULL,NULL,NULL,NULL,NULL,'ifLoggedInGoToDash','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(70,45,0,NULL,'User Attempt Password Reset','post','dvs-user-attempt-reset',1,1,'/admin/attempt-reset','Attempt to reset password',NULL,NULL,NULL,NULL,NULL,'','','Function','Devise\\Users\\UsersResponseHandler.requestResetPassword','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(71,45,0,'devise::admin.users.register','User Registration','get','dvs-user-register',1,1,'/admin/register','Allows new users to register',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(72,45,0,NULL,'User Attempt Register','post','user-attempt-register',1,1,'/admin/attempt-register','Attempt to register new user',NULL,NULL,NULL,NULL,NULL,'','','Function','Devise\\Users\\UsersResponseHandler.requestRegister','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(73,45,0,'','User Activation','get','dvs-user-activate',1,1,'/admin/activate/{userId}/{activateCode}','Route used to activate a newly registered user',NULL,NULL,NULL,NULL,NULL,'ifLoggedInGoToDash','','Function','Devise\\Users\\UsersResponseHandler.requestActivation','params.userId,params.activateCode','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(74,45,0,'devise::admin.calendar.index','Devise Admin Calendar that keeps up with different scheduled events','get','dvs-calendar-index',1,1,'/admin/calendar','Shows the calendar for devise admin where we can change schedules',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(75,45,0,NULL,'Devise Admin Calendar Source for Page Versions','get','dvs-calendar-page-version-source',1,1,'/admin/calendar/sources/page-versions','Shows the json data for page versions event source',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Calendar\\CalendarResponseHandler.requestPageVersionEventSource','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(76,45,0,NULL,'Patches Devise Admin Calendar Source for Page Versions','patch','dvs-calendar-page-version-source-update',1,1,'/admin/calendar/sources/page-versions/{pageVersionId}','Updates the page versions dates and information',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin','','Function','Devise\\Calendar\\CalendarResponseHandler.requestPageVersionEventUpdate','params.pageVersionId,input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(77,45,0,'devise::admin.templates.index','Devise Admin Templates','get','dvs-templates',1,1,'admin/templates','Allows the management of devise templates',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(78,45,0,'devise::admin.templates.edit','Admin Edit Template','get','dvs-templates-edit',1,1,'admin/templates/{templatePath}/edit','Edit a Template',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(79,45,0,NULL,'Admin Update Template','put','dvs-templates-update',1,1,'admin/templates/{templatePath}','Attempts to update a template',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Templates\\TemplatesResponseHandler.executeUpdate','params.templatePath,input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(80,45,0,NULL,'Destroy Template','delete','dvs-templates-destroy',1,1,'admin/templates/{templatePath}','Destroys a template',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Templates\\TemplatesResponseHandler.executeDestroy','params.templatePath','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(81,45,0,'devise::admin.templates.params.create','Add Parameter to Template Variable','get','dvs-templates-param-create',1,1,'admin/templates/params/create/{varName?}','Add/Create New Parameter for Template Variable',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,'params.varName','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(82,45,0,'devise::admin.templates.register','Admin Register New Template','get','dvs-templates-register',1,1,'admin/templates/register','Register a Template',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(83,45,0,NULL,'Admin Store Template','post','dvs-templates-store',1,1,'admin/templates','Attempts to store a new template',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Templates\\TemplatesResponseHandler.executeStore','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(84,45,0,'devise::admin.templates.variables.create','Create New Variable for a Template','get','dvs-templates-var-create',1,1,'admin/templates/vars/create/{templatePath}','Create/Add new variable to an existing template',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,'params.templatePath','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(85,45,0,NULL,'Store Variable','post','dvs-templates-var-store',1,1,'admin/templates/vars/store/{templatePath}','Attempt to store a new variable for a template path',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Templates\\TemplatesResponseHandler.executeVariableStore','params.templatePath,input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(86,45,0,'devise::admin.permissions.index','Devise Admin Permissions','get','dvs-permissions',1,1,'admin/permissions','Allows The Management of Permissions',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(87,45,0,'devise::admin.permissions.create','Admin Create New Permission','get','dvs-permissions-create',1,1,'admin/permissions/create','Admin Create a New Permission Condition',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(88,45,0,NULL,'Admin Store Permission','post','dvs-permissions-store',1,1,'admin/permissions','Attempts to Store a New Permission Condition',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Users\\Permissions\\PermissionsResponseHandler.executeStore','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(89,45,0,'devise::admin.permissions.edit','Admin Edit Permission','get','dvs-permissions-edit',1,1,'admin/permissions/edit','Edit a Permission Condition',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(90,45,0,NULL,'Admin Update Permission','put','dvs-permissions-update',1,1,'admin/permissions/update','Attempts to Update a Permission Condition',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Users\\Permissions\\PermissionsResponseHandler.executeUpdate','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(91,45,0,NULL,'Destroy Permission','delete','dvs-permissions-destroy',1,1,'admin/permissions/destroy','Destroys a Permission Condition',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Users\\Permissions\\PermissionsResponseHandler.executeDestroy','input.condition','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(92,45,0,'devise::admin.settings.index','Settings Page','get','dvs-settings-index',1,1,'admin/settings','Configure devise settings',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(93,45,0,NULL,'Change devise configuration settings','put','dvs-settings-update',1,1,'admin/settings','Updates the devise configuration settings',NULL,NULL,NULL,NULL,NULL,'ifNotLoggedInGoToLogin|isDeveloper','','Function','Devise\\Support\\Config\\SettingsResponseHandler.executeUpdate','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(94,45,0,NULL,'Create a new model managed by DvsModelField','post','dvs-model-fields-create',1,1,'admin/model-fields','Create a new model managed by DvsModelField',NULL,NULL,NULL,NULL,NULL,'canUseDeviseEditor','','Function','Devise\\Pages\\Models\\ModelsResponseHandler.executeModelFieldsCreate','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(95,45,0,NULL,'Update multiple model fields at one time that are managed by DvsModelField','put','dvs-model-fields-update',1,1,'admin/model-fields','Update multiple model fields as one time that are managed by DvsModelField',NULL,NULL,NULL,NULL,NULL,'canUseDeviseEditor','','Function','Devise\\Pages\\Models\\ModelsResponseHandler.executeModelFieldsUpdate','input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(96,45,0,NULL,'Update a single model field that is managed by a DvsModelField','put','dvs-model-field-update',1,1,'admin/model-field/{modelFieldId}','',NULL,NULL,NULL,NULL,NULL,'canUseDeviseEditor','','Function','Devise\\Pages\\Models\\ModelsResponseHandler.executeModelFieldUpdate','params.modelFieldId,input','2015-04-10 17:44:56','2015-04-10 17:44:56',NULL),
	(97,45,0,'devise::installer.index-post-install','You Have Arrived','get','you-have-arrived',0,0,'/','A welcome page and example to see how pages work',NULL,NULL,NULL,NULL,NULL,'','','View',NULL,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL);

/*!40000 ALTER TABLE `dvs_pages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dvs_seeds
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvs_seeds`;

CREATE TABLE `dvs_seeds` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `dvs_seeds` WRITE;
/*!40000 ALTER TABLE `dvs_seeds` DISABLE KEYS */;

INSERT INTO `dvs_seeds` (`name`, `created_at`, `updated_at`)
VALUES
	('DeviseLanguagesSeeder','2015-04-10 17:44:56','2015-04-10 17:44:56'),
	('DeviseGroupsSeeder','2015-04-10 17:44:56','2015-04-10 17:44:56');

/*!40000 ALTER TABLE `dvs_seeds` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dvs_test_models
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dvs_test_models`;

CREATE TABLE `dvs_test_models` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_version_id` int(10) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `dvs_test_models` WRITE;
/*!40000 ALTER TABLE `dvs_test_models` DISABLE KEYS */;

INSERT INTO `dvs_test_models` (`id`, `page_version_id`, `name`, `created_at`, `updated_at`)
VALUES
	(1,1,'Some name here','2015-04-10 17:44:56','2015-04-10 17:44:56');

/*!40000 ALTER TABLE `dvs_test_models` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table group_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `group_user`;

CREATE TABLE `group_user` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `group_user` WRITE;
/*!40000 ALTER TABLE `group_user` DISABLE KEYS */;

INSERT INTO `group_user` (`group_id`, `user_id`)
VALUES
	(1,1);

/*!40000 ALTER TABLE `group_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`id`, `name`, `created_at`, `updated_at`)
VALUES
	(1,'Developer','2015-04-10 17:44:56','2015-04-10 17:44:56'),
	(2,'Administrator','2015-04-10 17:44:56','2015-04-10 17:44:56');

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2014_08_29_160748_create_dvs_collection_instances',1),
	('2014_08_29_160748_create_dvs_collection_sets',1),
	('2014_08_29_160748_create_dvs_fields',1),
	('2014_08_29_160748_create_dvs_languages',1),
	('2014_08_29_160748_create_dvs_menu_items',1),
	('2014_08_29_160748_create_dvs_menus',1),
	('2014_08_29_160748_create_dvs_pages',1),
	('2014_08_29_160748_create_group_user',1),
	('2014_08_29_160748_create_groups',1),
	('2014_08_29_160748_create_password_resets',1),
	('2014_08_29_160748_create_users',1),
	('2014_09_17_124912_create_dvs_page_versions',1),
	('2014_09_24_150648_create_dvs_global_fields',1),
	('2015_01_09_162848_create_dvs_model_fields',1),
	('2015_02_05_101510_create_dvs_seeds',1),
	('2015_03_09_134915_create_dvs_test_models',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activate_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `remember_token`, `activated`, `activate_code`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,NULL,'no-reply@devisephp.com','devise','$2y$10$Hg6AdDE4dsbW.llUp3goiuf3D3aujB1I8GbU3lEM0GS5me3wkvDhq',NULL,1,NULL,'2015-04-10 17:44:56','2015-04-10 17:44:56',NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
