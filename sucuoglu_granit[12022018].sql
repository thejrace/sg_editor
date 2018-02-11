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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baslik_siparisleri`
--

LOCK TABLES `baslik_siparisleri` WRITE;
/*!40000 ALTER TABLE `baslik_siparisleri` DISABLE KEYS */;
INSERT INTO `baslik_siparisleri` VALUES (1,'1518357774jK9JlldyvmcDgRkQztkvUhotfSf53l','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','{\"tas\":\"siyah_granit\",\"w\":50,\"h\":50}','{\"POR0\":{\"seri\":\"dikdortgen\",\"ebat\":\"9x12 cm\",\"item_index\":\"POR0\",\"rotated\":false,\"top\":\"18px\",\"left\":\"36px\"}}','{\"ENG0\":{\"item_index\":\"ENG0\",\"top\":\"36px\",\"left\":\"201px\",\"width\":230,\"height\":257.41212268007,\"ext\":\"image\\/jpeg\"}}','[]','{}','',1,'Ahmet Kanbur','5432390269','ahmet@ahmet.com','2018-02-11 15:03:42',1),(2,'1518357870WadaVqEdki0FwhmLkjje5RXgDVTAlW','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','{\"tas\":\"siyah_granit\",\"w\":50,\"h\":50}','{\"POR0\":{\"seri\":\"oval\",\"ebat\":\"9x12 cm\",\"item_index\":\"POR0\",\"rotated\":false,\"top\":\"17px\",\"left\":\"58px\"}}','{\"ENG0\":{\"item_index\":\"ENG0\",\"top\":\"74px\",\"left\":\"217px\",\"width\":230,\"height\":235.68972746331,\"ext\":\"image\\/jpeg\"}}','[]','{}','',1,'Ahmet Kanbur','5432390269','ahmet@ahmet.com','2018-02-11 15:04:58',1),(3,'1518357899xcITxwaHC0sICB9DUMlHixED9j8Di5','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','{\"tas\":\"siyah_granit\",\"w\":50,\"h\":50}','{\"POR0\":{\"seri\":\"oval\",\"ebat\":\"9x12 cm\",\"item_index\":\"POR0\",\"rotated\":false,\"top\":\"46px\",\"left\":\"69px\"}}','[]','{\"YAZI0\":{\"item_index\":\"YAZI0\",\"prev_src\":\"http:\\/\\/localhost\\/sg_editor\\/uploads\\/ah_editor\\/imgs\\/fF3lPsDnDJO4LIpoN6MNQ8LgtxIgOvtL.png\",\"top\":\"203px\",\"left\":\"254px\",\"width\":0,\"height\":0,\"text\":\"Test\",\"font\":\"24\",\"color\":\"beyaz\"}}','{}','',1,'Ahmet Kanbur','5432390269','ahmet@ahmet.com','2018-02-11 15:05:53',1),(4,'1518370035yuWpr1A46cHBNRgCdmIczx3VCKJVxO','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','{\"tas\":\"siyah_granit\",\"w\":50,\"h\":50}','{\"POR0\":{\"seri\":\"oval\",\"ebat\":\"9x12 cm\",\"item_index\":\"POR0\",\"rotated\":\"true\",\"top\":0,\"left\":0}}','[]','[]','{}','',1,'Ahmet Kanbur','5432390269','ahmet@ahmet.com','2018-02-11 18:27:29',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `porselen_siparisleri`
--

LOCK TABLES `porselen_siparisleri` WRITE;
/*!40000 ALTER TABLE `porselen_siparisleri` DISABLE KEYS */;
INSERT INTO `porselen_siparisleri` VALUES (1,'1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_VqfUgAbSAF64f95I51JxrJ8KafT4A2','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','Ahmet Kanbur','ahmet@ahmet.com','5432390269','oval','9x12 cm',4,'','2018-02-04 15:41:00','PNG','{\r\n  \"img_data\": {\r\n    \"width\": \"230px\",\r\n    \"height\": \"280.875px\",\r\n    \"left\": \"0px\",\r\n    \"top\": \"0px\",\r\n    \"def_height\": \"280.8849557522123\",\r\n    \"def_width\": \"230\",\r\n    \"tas_donuk_flag\": false,\r\n    \"tas_bg_color\": \"rgb(255, 0, 0)\",\r\n    \"tas_aci\": 0\r\n  },\r\n  \"cropper_data\": {\r\n    \"image_data\": {\r\n      \"naturalWidth\": 452,\r\n      \"naturalHeight\": 552,\r\n      \"aspectRatio\": 0.8188405797101449,\r\n      \"width\": 409.42028985507244,\r\n      \"height\": 500,\r\n      \"left\": 0,\r\n      \"top\": 0\r\n    },\r\n    \"canvas_data\": {\r\n      \"left\": 79.28985507246378,\r\n      \"top\": 0,\r\n      \"width\": 409.42028985507244,\r\n      \"height\": 500,\r\n      \"naturalWidth\": 452,\r\n      \"naturalHeight\": 552\r\n    },\r\n    \"crop_box_data\": {\r\n      \"left\": 120.231884057971,\r\n      \"top\": 50,\r\n      \"width\": 327.536231884058,\r\n      \"height\": 400\r\n    },\r\n    \"container_data\": {\r\n      \"width\": 568,\r\n      \"height\": 500\r\n    },\r\n    \"data\": {\r\n      \"x\": 45.199999999999974,\r\n      \"y\": 55.2,\r\n      \"width\": 361.6000000000001,\r\n      \"height\": 441.6,\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1\r\n    }\r\n  }\r\n}',NULL,NULL,4),(2,'1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_kuplYkgZNGYoZpu9jQhlXPkzDH5WAk','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','Ahmet Kanbur','ahmet@ahmet.com','5432390269','oval','9x12 cm',1,'','2018-02-04 19:43:30','PNG','{\r\n  \"img_data\": {\r\n    \"width\": \"279.938px\",\r\n    \"height\": \"341.875px\",\r\n    \"left\": \"-25px\",\r\n    \"top\": \"-1px\",\r\n    \"def_height\": \"280.8849557522123\",\r\n    \"def_width\": \"230\",\r\n    \"tas_donuk_flag\": false,\r\n    \"tas_bg_color\": \"rgb(255, 0, 0)\",\r\n    \"tas_aci\": 0\r\n  },\r\n  \"cropper_data\": {\r\n    \"image_data\": {\r\n      \"naturalWidth\": 452,\r\n      \"naturalHeight\": 552,\r\n      \"aspectRatio\": 0.8188405797101449,\r\n      \"width\": 409.42028985507244,\r\n      \"height\": 500,\r\n      \"left\": 0,\r\n      \"top\": 0\r\n    },\r\n    \"canvas_data\": {\r\n      \"left\": 79.28985507246378,\r\n      \"top\": 0,\r\n      \"width\": 409.42028985507244,\r\n      \"height\": 500,\r\n      \"naturalWidth\": 452,\r\n      \"naturalHeight\": 552\r\n    },\r\n    \"crop_box_data\": {\r\n      \"left\": 120.231884057971,\r\n      \"top\": 50,\r\n      \"width\": 327.536231884058,\r\n      \"height\": 400\r\n    },\r\n    \"container_data\": {\r\n      \"width\": 568,\r\n      \"height\": 500\r\n    },\r\n    \"data\": {\r\n      \"x\": 45.199999999999974,\r\n      \"y\": 55.2,\r\n      \"width\": 361.6000000000001,\r\n      \"height\": 441.6,\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1\r\n    }\r\n  }\r\n}','1517769743EbCL8w9BYE1xx4lOEKH7E8cHocpfeq','POR0',1),(4,'1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_MsSZzSIk9eoJt7Cv0DAxJn397rdb7p','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','Ahmet Kanbur','ahmet@ahmet.com','5432390269','oval','13x18 cm',3,'test 2','2018-02-06 17:34:50','jpg','{\r\n  \"img_data\": {\r\n    \"width\": \"252.641px\",\r\n    \"height\": \"379px\",\r\n    \"left\": \"34px\",\r\n    \"top\": \"-20px\",\r\n    \"def_height\": \"345\",\r\n    \"def_width\": \"230\",\r\n    \"tas_donuk_flag\": true,\r\n    \"tas_bg_color\": \"rgb(145, 31, 31)\",\r\n    \"tas_aci\": 90\r\n  },\r\n  \"cropper_data\": {\r\n    \"image_data\": {\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1,\r\n      \"naturalWidth\": 300,\r\n      \"naturalHeight\": 450,\r\n      \"aspectRatio\": 0.6666666666666666,\r\n      \"width\": 333.33333333333326,\r\n      \"height\": 500,\r\n      \"left\": 2.842170943040401e-14,\r\n      \"top\": 0\r\n    },\r\n    \"canvas_data\": {\r\n      \"left\": 117.33333333333334,\r\n      \"top\": 0,\r\n      \"width\": 333.3333333333333,\r\n      \"height\": 500,\r\n      \"naturalWidth\": 300,\r\n      \"naturalHeight\": 450\r\n    },\r\n    \"crop_box_data\": {\r\n      \"left\": 150.66666666666666,\r\n      \"top\": 17,\r\n      \"width\": 264.6666666666667,\r\n      \"height\": 397\r\n    },\r\n    \"container_data\": {\r\n      \"width\": 568,\r\n      \"height\": 500\r\n    },\r\n    \"data\": {\r\n      \"x\": 29.99999999999999,\r\n      \"y\": 15.300000000000002,\r\n      \"width\": 238.20000000000005,\r\n      \"height\": 357.30000000000007,\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1\r\n    }\r\n  }\r\n}',NULL,NULL,4),(5,'1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_znhg7aZsCtnfWh4ko38UQLbJDSh0An','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','Ahmet Kanbur','ahmet@ahmet.com','5432390269','oval','9x12 cm',1,'','2018-02-06 18:13:04','jpg','{\r\n  \"img_data\": {\r\n    \"width\": \"243.313px\",\r\n    \"height\": \"365px\",\r\n    \"left\": \"-3px\",\r\n    \"top\": \"-4px\",\r\n    \"def_height\": \"345\",\r\n    \"def_width\": \"230\",\r\n    \"tas_donuk_flag\": false,\r\n    \"tas_bg_color\": \"rgb(255, 0, 0)\",\r\n    \"tas_aci\": 0\r\n  },\r\n  \"cropper_data\": {\r\n    \"image_data\": {\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1,\r\n      \"naturalWidth\": 300,\r\n      \"naturalHeight\": 450,\r\n      \"aspectRatio\": 0.6666666666666666,\r\n      \"width\": 333.33333333333326,\r\n      \"height\": 500,\r\n      \"left\": 2.842170943040401e-14,\r\n      \"top\": 0\r\n    },\r\n    \"canvas_data\": {\r\n      \"left\": 117.33333333333334,\r\n      \"top\": 0,\r\n      \"width\": 333.3333333333333,\r\n      \"height\": 500,\r\n      \"naturalWidth\": 300,\r\n      \"naturalHeight\": 450\r\n    },\r\n    \"crop_box_data\": {\r\n      \"left\": 146.66666666666666,\r\n      \"top\": 9,\r\n      \"width\": 266.6666666666667,\r\n      \"height\": 400\r\n    },\r\n    \"container_data\": {\r\n      \"width\": 568,\r\n      \"height\": 500\r\n    },\r\n    \"data\": {\r\n      \"x\": 26.399999999999988,\r\n      \"y\": 8.100000000000001,\r\n      \"width\": 240.00000000000006,\r\n      \"height\": 360.00000000000006,\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1\r\n    }\r\n  }\r\n}','1517937015NPDq9y3wHnMC3Y8agBZaYXG3eg3PFe','POR0',1);
/*!40000 ALTER TABLE `porselen_siparisleri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_uploads`
--

DROP TABLE IF EXISTS `temp_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` text NOT NULL,
  `ext` varchar(10) NOT NULL,
  `tarih` datetime NOT NULL,
  `type` varchar(50) NOT NULL,
  `parent_gid` text NOT NULL,
  `item_id` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_uploads`
--

LOCK TABLES `temp_uploads` WRITE;
/*!40000 ALTER TABLE `temp_uploads` DISABLE KEYS */;
INSERT INTO `temp_uploads` VALUES (1,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_CTBz9XFWokaEbVIoSfopjgNpPq0BhH','png','2018-02-11 15:04:41','cropped','1518357870WadaVqEdki0FwhmLkjje5RXgDVTAlW','POR0'),(2,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_EIZAMYP1157urgHWFfWSLfGfkYewtF','jpg','2018-02-11 15:04:41','orjinal','1518357870WadaVqEdki0FwhmLkjje5RXgDVTAlW','POR0'),(3,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_tFM0K9lfSWK6dw6LBQZZoovYp7fq1u','png','2018-02-11 15:04:50','cropped','1518357870WadaVqEdki0FwhmLkjje5RXgDVTAlW','ENG0'),(4,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_jB3vibSAgpiKQZGr78RCGBcLDywRxL','jpg','2018-02-11 15:04:50','orjinal','1518357870WadaVqEdki0FwhmLkjje5RXgDVTAlW','ENG0'),(5,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_6ApnhamERfjRoABt0m3thi2ijDoWG4','png','2018-02-11 15:05:38','cropped','1518357899xcITxwaHC0sICB9DUMlHixED9j8Di5','POR0'),(6,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_rRvQ31mEyUlINt4M8cB2o3xdUuZxyu','jpg','2018-02-11 15:05:38','orjinal','1518357899xcITxwaHC0sICB9DUMlHixED9j8Di5','POR0'),(9,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_kMfLoySW8cGNTbKxwtESmyv3fnTLxq','png','2018-02-11 17:46:48','cropped','1518367399aUwCkVwH4qEUn2DzJQHx4ry9SUqg7R','POR1'),(10,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_Uf4E9dbwISI1cX1CGGXhLLQtxqw9An','png','2018-02-11 17:46:48','orjinal','1518367399aUwCkVwH4qEUn2DzJQHx4ry9SUqg7R','POR1'),(15,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_tSoFlZ8yn4gXn6nBJwxGfknWiYYAHq','png','2018-02-11 17:53:55','cropped','1518367399aUwCkVwH4qEUn2DzJQHx4ry9SUqg7R','POR4'),(16,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_UlP9iqu8Ix3PgVmdxiLKDS5p8mFF9Z','jpg','2018-02-11 17:53:55','orjinal','1518367399aUwCkVwH4qEUn2DzJQHx4ry9SUqg7R','POR4'),(17,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_DqQd5n7gfUaPGKnmu5AOhE7G9GPVFS','png','2018-02-11 18:02:33','cropped','1518368188ntgtxjz20aEp7tDMJd4SaR5VhngEqe','POR0'),(18,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_30WsETz9X3EaOtKezCZy4qXREpJm9v','jpg','2018-02-11 18:02:33','orjinal','1518368188ntgtxjz20aEp7tDMJd4SaR5VhngEqe','POR0'),(19,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_kwdDlCQYMNWvACcxddQXF9A4pxFKoX','png','2018-02-11 18:08:58','cropped','15183689062cgnAOh3OsDZVXjLEFLucrXLiBnE90','POR0'),(20,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_Nj5vbCtMy00S7kFoCVUofDJvJNzOig','png','2018-02-11 18:08:58','orjinal','15183689062cgnAOh3OsDZVXjLEFLucrXLiBnE90','POR0'),(21,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_UZWajVryRwWiF1klk7UaV2yJ4vAwPJ','png','2018-02-11 18:22:19','cropped','1518369620KGovXOO1VkBmfX5X0U8ONU5oIaLEnq','POR1'),(22,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_RvPrJ89R1omH4JBaK8q0n4XpPvL6pU','jpg','2018-02-11 18:22:19','orjinal','1518369620KGovXOO1VkBmfX5X0U8ONU5oIaLEnq','POR1');
/*!40000 ALTER TABLE `temp_uploads` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-12  0:26:07
