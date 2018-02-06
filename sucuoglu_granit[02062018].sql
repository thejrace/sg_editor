-- MySQL dump 10.13  Distrib 5.7.20, for Win64 (x86_64)
--
-- Host: localhost    Database: sucuoglu_granit
-- ------------------------------------------------------
-- Server version	5.7.20-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eposta` text NOT NULL,
  `isim` text,
  `salt` text NOT NULL,
  `pass` text NOT NULL,
  `durum` int(11) NOT NULL,
  `kayit_tarihi` datetime NOT NULL,
  `son_giris` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin@sucuoglugranit.com','Admin','üþr`ë%Bïòoç\\¹Ç´ÈDééÇ(t!úWªp	aÇJÄR>O}É¦ê«Î¿j%','c9841edcd56db943995a88c2373eff225a1a4fb85bded903fce97a2f789d14d5',1,'2018-02-06 13:52:19','2018-02-06 13:52:19');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baslik_siparisleri`
--

DROP TABLE IF EXISTS `baslik_siparisleri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baslik_siparisleri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` text,
  `kullanici` text NOT NULL,
  `tas_data` text NOT NULL,
  `porselenler` text NOT NULL,
  `engraveler` text NOT NULL,
  `yazilar` text NOT NULL,
  `sekiller` text NOT NULL,
  `notlar` text,
  `adet` int(11) DEFAULT '1',
  `isim` text,
  `telefon` text,
  `eposta` text,
  `eklenme_tarihi` datetime NOT NULL,
  `durum` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baslik_siparisleri`
--

LOCK TABLES `baslik_siparisleri` WRITE;
/*!40000 ALTER TABLE `baslik_siparisleri` DISABLE KEYS */;
INSERT INTO `baslik_siparisleri` VALUES (2,'1517769743EbCL8w9BYE1xx4lOEKH7E8cHocpfeq','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','{\"tas\":\"siyah_granit\",\"w\":50,\"h\":50}','{\"POR0\":{\"seri\":\"oval-seri\",\"ebat\":\"9x12 cm\",\"item_index\":\"POR0\",\"rotated\":false,\"top\":\"155px\",\"left\":\"136px\"}}','{\"ENG0\":{\"item_index\":\"ENG0\",\"cropper_img\":\"\",\"top\":\"174px\",\"left\":\"281px\",\"width\":140.05914039913,\"height\":138.594, \"ext\":\"JPEG\"}}','{\"YAZI0\":{\"item_index\":\"YAZI0\",\"prev_src\":\"http:\\/\\/localhost\\/sg_editor\\/uploads\\/ah_editor\\/imgs\\/X8tPaALshiDAx85PEqygP10tOgWzOZj9.png\",\"top\":\"370px\",\"left\":\"53px\",\"width\":0,\"height\":0,\"text\":\"Test 1\",\"font\":\"24\",\"color\":\"beyaz\"},\"YAZI1\":{\"item_index\":\"YAZI1\",\"prev_src\":\"http:\\/\\/localhost\\/sg_editor\\/uploads\\/ah_editor\\/imgs\\/Zky89ny6KbE5YBOFyZvWHbGv9wPr7QVm.png\",\"top\":\"372px\",\"left\":\"290px\",\"width\":0,\"height\":0,\"text\":\"Test 2\",\"font\":\"24\",\"color\":\"altin\"}}','{\"SEK0\":{\"item_index\":\"SEK0\",\"top\":\"74px\",\"left\":\"115px\",\"data_type\":\"resim\",\"data_content\":\"Bismillah\",\"width\":\"350\",\"height\":\"68\",\"varyant\":\"Beyaz\"},\"SEK1\":{\"item_index\":\"SEK1\",\"top\":\"81px\",\"left\":\"15px\",\"data_type\":\"resim\",\"data_content\":\"Bayrak Kumlama\",\"width\":63.63157894736842,\"height\":52}}','',2,'Ahmet Kanbur','5432390269','ahmet@ahmet.com','2018-02-04 19:43:37',4);
/*!40000 ALTER TABLE `baslik_siparisleri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cookie_tokens`
--

DROP TABLE IF EXISTS `cookie_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cookie_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `selector` text NOT NULL,
  `token` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cookie_tokens`
--

LOCK TABLES `cookie_tokens` WRITE;
/*!40000 ALTER TABLE `cookie_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `cookie_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iletisim_formlari`
--

DROP TABLE IF EXISTS `iletisim_formlari`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iletisim_formlari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eposta` text,
  `konu` text,
  `mesaj` text,
  `tarih` datetime NOT NULL,
  `kullanici` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iletisim_formlari`
--

LOCK TABLES `iletisim_formlari` WRITE;
/*!40000 ALTER TABLE `iletisim_formlari` DISABLE KEYS */;
INSERT INTO `iletisim_formlari` VALUES (3,'ahmet@ahmet.com','Bir manga','test mesaj','2018-02-06 13:33:15','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX');
/*!40000 ALTER TABLE `iletisim_formlari` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kullanicilar`
--

DROP TABLE IF EXISTS `kullanicilar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eposta` text NOT NULL,
  `isim` text,
  `telefon` text,
  `salt` text NOT NULL,
  `pass` text NOT NULL,
  `durum` int(11) NOT NULL,
  `kayit_tarihi` datetime NOT NULL,
  `son_giris` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kullanicilar`
--

LOCK TABLES `kullanicilar` WRITE;
/*!40000 ALTER TABLE `kullanicilar` DISABLE KEYS */;
/*!40000 ALTER TABLE `kullanicilar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `misafirler`
--

DROP TABLE IF EXISTS `misafirler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `misafirler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eposta` text,
  `isim` text,
  `telefon` text,
  `cookie` text NOT NULL,
  `kayit_tarihi` datetime NOT NULL,
  `son_giris` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `misafirler`
--

LOCK TABLES `misafirler` WRITE;
/*!40000 ALTER TABLE `misafirler` DISABLE KEYS */;
INSERT INTO `misafirler` VALUES (1,'ahmet@ahmet.com','Ahmet Kanbur','5432390269','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','2018-01-17 13:28:00','2018-01-17 13:28:00');
/*!40000 ALTER TABLE `misafirler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `porselen_siparisleri`
--

DROP TABLE IF EXISTS `porselen_siparisleri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `porselen_siparisleri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` text,
  `kullanici` text NOT NULL,
  `isim` text,
  `eposta` text,
  `telefon` text,
  `seri` varchar(150) NOT NULL,
  `ebat` varchar(30) NOT NULL,
  `adet` int(11) NOT NULL DEFAULT '1',
  `notlar` text,
  `eklenme_tarihi` datetime NOT NULL,
  `orjinal_resim_ext` varchar(30) DEFAULT NULL,
  `edit_data` text,
  `parent_gid` text,
  `parent_item_id` text,
  `durum` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `porselen_siparisleri`
--

LOCK TABLES `porselen_siparisleri` WRITE;
/*!40000 ALTER TABLE `porselen_siparisleri` DISABLE KEYS */;
INSERT INTO `porselen_siparisleri` VALUES (1,'1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_VqfUgAbSAF64f95I51JxrJ8KafT4A2','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','Ahmet Kanbur','ahmet@ahmet.com','5432390269','oval','9x12 cm',4,'','2018-02-04 15:41:00','PNG','{\r\n  \"img_data\": {\r\n    \"width\": \"230px\",\r\n    \"height\": \"280.875px\",\r\n    \"left\": \"0px\",\r\n    \"top\": \"0px\",\r\n    \"def_height\": \"280.8849557522123\",\r\n    \"def_width\": \"230\",\r\n    \"tas_donuk_flag\": false,\r\n    \"tas_bg_color\": \"rgb(255, 0, 0)\",\r\n    \"tas_aci\": 0\r\n  },\r\n  \"cropper_data\": {\r\n    \"image_data\": {\r\n      \"naturalWidth\": 452,\r\n      \"naturalHeight\": 552,\r\n      \"aspectRatio\": 0.8188405797101449,\r\n      \"width\": 409.42028985507244,\r\n      \"height\": 500,\r\n      \"left\": 0,\r\n      \"top\": 0\r\n    },\r\n    \"canvas_data\": {\r\n      \"left\": 79.28985507246378,\r\n      \"top\": 0,\r\n      \"width\": 409.42028985507244,\r\n      \"height\": 500,\r\n      \"naturalWidth\": 452,\r\n      \"naturalHeight\": 552\r\n    },\r\n    \"crop_box_data\": {\r\n      \"left\": 120.231884057971,\r\n      \"top\": 50,\r\n      \"width\": 327.536231884058,\r\n      \"height\": 400\r\n    },\r\n    \"container_data\": {\r\n      \"width\": 568,\r\n      \"height\": 500\r\n    },\r\n    \"data\": {\r\n      \"x\": 45.199999999999974,\r\n      \"y\": 55.2,\r\n      \"width\": 361.6000000000001,\r\n      \"height\": 441.6,\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1\r\n    }\r\n  }\r\n}',NULL,NULL,4),(2,'1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_kuplYkgZNGYoZpu9jQhlXPkzDH5WAk','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','Ahmet Kanbur','ahmet@ahmet.com','5432390269','oval','9x12 cm',1,'','2018-02-04 19:43:30','PNG','{\r\n  \"img_data\": {\r\n    \"width\": \"279.938px\",\r\n    \"height\": \"341.875px\",\r\n    \"left\": \"-25px\",\r\n    \"top\": \"-1px\",\r\n    \"def_height\": \"280.8849557522123\",\r\n    \"def_width\": \"230\",\r\n    \"tas_donuk_flag\": false,\r\n    \"tas_bg_color\": \"rgb(255, 0, 0)\",\r\n    \"tas_aci\": 0\r\n  },\r\n  \"cropper_data\": {\r\n    \"image_data\": {\r\n      \"naturalWidth\": 452,\r\n      \"naturalHeight\": 552,\r\n      \"aspectRatio\": 0.8188405797101449,\r\n      \"width\": 409.42028985507244,\r\n      \"height\": 500,\r\n      \"left\": 0,\r\n      \"top\": 0\r\n    },\r\n    \"canvas_data\": {\r\n      \"left\": 79.28985507246378,\r\n      \"top\": 0,\r\n      \"width\": 409.42028985507244,\r\n      \"height\": 500,\r\n      \"naturalWidth\": 452,\r\n      \"naturalHeight\": 552\r\n    },\r\n    \"crop_box_data\": {\r\n      \"left\": 120.231884057971,\r\n      \"top\": 50,\r\n      \"width\": 327.536231884058,\r\n      \"height\": 400\r\n    },\r\n    \"container_data\": {\r\n      \"width\": 568,\r\n      \"height\": 500\r\n    },\r\n    \"data\": {\r\n      \"x\": 45.199999999999974,\r\n      \"y\": 55.2,\r\n      \"width\": 361.6000000000001,\r\n      \"height\": 441.6,\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1\r\n    }\r\n  }\r\n}','1517769743EbCL8w9BYE1xx4lOEKH7E8cHocpfeq','POR0',1);
/*!40000 ALTER TABLE `porselen_siparisleri` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-06 16:23:07
