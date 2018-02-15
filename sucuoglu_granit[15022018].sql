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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baslik_siparisleri`
--

LOCK TABLES `baslik_siparisleri` WRITE;
/*!40000 ALTER TABLE `baslik_siparisleri` DISABLE KEYS */;
INSERT INTO `baslik_siparisleri` VALUES (3,'1518548882zCTcg4fQ8sIVW7MuTSpaG632zDIHeO','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','{\"tas\":\"siyah_granit\",\"w\":\"55\",\"h\":\"50\"}','{\"POR0\":{\"seri\":\"oval\",\"ebat\":\"8x10 cm\",\"varyant\":\"T\\u00fcrk Bayra\\u011f\\u0131 Oval\",\"item_index\":\"POR0\",\"rotated\":\"true\",\"top\":\"120px\",\"left\":\"20px\"},\"POR1\":{\"seri\":\"oval\",\"ebat\":\"11x15 cm\",\"item_index\":\"POR1\",\"rotated\":false,\"top\":\"258px\",\"left\":\"19px\"}}','{\"ENG0\":{\"item_index\":\"ENG0\",\"top\":\"206px\",\"left\":\"147px\",\"width\":196.21445172747,\"height\":261.344,\"ext\":\"image\\/jpeg\"}}','{\"YAZI0\":{\"item_index\":\"YAZI0\",\"prev_src\":\"http:\\/\\/localhost\\/sg_editor\\/uploads\\/ah_editor\\/imgs\\/cYVgRkfhfOO1k2nQy48BTvODPsDMkvin.png\",\"top\":\"121px\",\"left\":\"120px\",\"width\":441.30907407407,\"height\":65,\"text\":\"Mustafa Kemal Atat\\u00fcrk\",\"font\":\"24\",\"bg_color\":\"YOK\",\"text_color\":\"#ffb900\"},\"YAZI1\":{\"item_index\":\"YAZI1\",\"prev_src\":\"http:\\/\\/localhost\\/sg_editor\\/uploads\\/ah_editor\\/imgs\\/0GqVypBiOh3qKRuCQh7K45G9TqnGgQVE.png\",\"top\":\"221px\",\"left\":\"349px\",\"width\":191.10577699487,\"height\":49.0469,\"text\":\"1881 - 1938\",\"font\":\"28\",\"bg_color\":\"#ff0000\",\"text_color\":\"#ffffff\",\"color\":\"#ffffff\"}}','{\"SEK0\":{\"item_index\":\"SEK0\",\"top\":\"11px\",\"left\":\"69px\",\"data_type\":\"resim\",\"data_content\":\"Bismillah\",\"width\":411.764705882353,\"height\":80,\"varyant\":\"Altın\"}}','test',1,'Ahmet Kanbur','5432390269','ahmet@ahmet.com','2018-02-13 20:12:54',4),(4,'1518621043GGlne2DSG64DRRdo8MbkkOzcMrscnD','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','{\"tas\":\"siyah_granit\",\"w\":50,\"h\":50}','{\"POR0\":{\"seri\":\"oval\",\"ebat\":\"11x15 cm\",\"item_index\":\"POR0\",\"rotated\":false,\"top\":\"23px\",\"left\":\"187px\",\"ext\":\"image\\/jpeg\"}}','[]','[]','{}','',4,'Ahmet Kanbur','5432390269','ahmet@ahmet.com','2018-02-14 16:11:13',4),(5,'1518626511tIUlOyZcZrOAHJRBbg5Q9mXpOUtSTd','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','{\"tas\":\"siyah_granit\",\"w\":50,\"h\":50}','{\"POR0\":{\"seri\":\"oval\",\"ebat\":\"9x12 cm\",\"item_index\":\"POR0\",\"rotated\":false,\"top\":\"28px\",\"left\":\"205px\",\"ext\":\"jpg\"}}','[]','[]','{}','',1,'Ahmet Kanbur','5432390269','ahmet@ahmet.com','2018-02-14 17:42:16',4);
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
INSERT INTO `iletisim_formlari` VALUES (3,'ahmet@ahmet.com','Bir manga','test mesaj','2018-02-06 13:33:15','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX'),(4,'ahmet@ahmet.com','Test','test konuuuuuuu','2018-02-15 15:12:27','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `porselen_siparisleri`
--

LOCK TABLES `porselen_siparisleri` WRITE;
/*!40000 ALTER TABLE `porselen_siparisleri` DISABLE KEYS */;
INSERT INTO `porselen_siparisleri` VALUES (1,'1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_ddrfTFhXmTM9I8KLx7zhV33GuEzpi8','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','Ahmet Kanbur','ahmet@ahmet.com','5432390269','oval','11x15 cm',2,'test 1 düzenleme','2018-02-13 20:17:41','jpg','{\r\n  \"img_data\": {\r\n    \"width\": \"265.266px\",\r\n    \"height\": \"376.063px\",\r\n    \"left\": \"28px\",\r\n    \"top\": \"-16px\",\r\n    \"def_height\": \"326.0883448642895\",\r\n    \"def_width\": \"230\",\r\n    \"tas_donuk_flag\": true,\r\n    \"tas_bg_color\": \"rgb(130, 38, 38)\",\r\n    \"tas_aci\": 90\r\n  },\r\n  \"cropper_data\": {\r\n    \"image_data\": {\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1,\r\n      \"naturalWidth\": 300,\r\n      \"naturalHeight\": 450,\r\n      \"aspectRatio\": 0.6666666666666666,\r\n      \"width\": 333.33333333333326,\r\n      \"height\": 500,\r\n      \"left\": 2.842170943040401e-14,\r\n      \"top\": 0\r\n    },\r\n    \"canvas_data\": {\r\n      \"left\": 117.33333333333334,\r\n      \"top\": 0,\r\n      \"width\": 333.3333333333333,\r\n      \"height\": 500,\r\n      \"naturalWidth\": 300,\r\n      \"naturalHeight\": 450\r\n    },\r\n    \"crop_box_data\": {\r\n      \"left\": 123.5,\r\n      \"top\": 4,\r\n      \"width\": 313.16666666666663,\r\n      \"height\": 444\r\n    },\r\n    \"container_data\": {\r\n      \"width\": 568,\r\n      \"height\": 500\r\n    },\r\n    \"data\": {\r\n      \"x\": 5.549999999999993,\r\n      \"y\": 3.6000000000000005,\r\n      \"width\": 281.85,\r\n      \"height\": 399.6000000000001,\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1\r\n    }\r\n  }\r\n}',NULL,NULL,4),(5,'1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_fSRZA5jM9CbEbkqanyvrX9o4Esy9Fj','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','Ahmet Kanbur','ahmet@ahmet.com','5432390269','oval','9x12 cm',1,'','2018-02-15 15:00:39','jpg','{\r\n  \"img_data\": {\r\n    \"width\": \"332.438px\",\r\n    \"height\": \"340.688px\",\r\n    \"left\": \"-39px\",\r\n    \"top\": \"-11px\",\r\n    \"def_height\": \"235.68972746331238\",\r\n    \"def_width\": \"230\",\r\n    \"tas_donuk_flag\": false,\r\n    \"tas_bg_color\": \"rgb(255, 0, 0)\",\r\n    \"tas_aci\": 0\r\n  },\r\n  \"cropper_data\": {\r\n    \"image_data\": {\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1,\r\n      \"naturalWidth\": 2385,\r\n      \"naturalHeight\": 2444,\r\n      \"aspectRatio\": 0.9758592471358429,\r\n      \"width\": 487.92962356792145,\r\n      \"height\": 500,\r\n      \"left\": 0,\r\n      \"top\": 0\r\n    },\r\n    \"canvas_data\": {\r\n      \"left\": 40.03518821603927,\r\n      \"top\": 0,\r\n      \"width\": 487.92962356792145,\r\n      \"height\": 500,\r\n      \"naturalWidth\": 2385,\r\n      \"naturalHeight\": 2444\r\n    },\r\n    \"crop_box_data\": {\r\n      \"left\": 88.82815057283142,\r\n      \"top\": 50,\r\n      \"width\": 390.34369885433716,\r\n      \"height\": 400\r\n    },\r\n    \"container_data\": {\r\n      \"width\": 568,\r\n      \"height\": 500\r\n    },\r\n    \"data\": {\r\n      \"x\": 238.5,\r\n      \"y\": 244.4,\r\n      \"width\": 1908,\r\n      \"height\": 1955.2,\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1\r\n    }\r\n  }\r\n}',NULL,NULL,4),(6,'1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_YfJ47u3zVsm9UeRE0qiqH8RkWViGdV','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','Ahmet Kanbur','ahmet@ahmet.com','5432390269','oval','8x10 cm',1,'','2018-02-15 15:02:51','jpg','{\r\n  \"img_data\": {\r\n    \"width\": \"230px\",\r\n    \"height\": \"172.625px\",\r\n    \"left\": \"0px\",\r\n    \"top\": \"0px\",\r\n    \"def_height\": \"172.6327944572748\",\r\n    \"def_width\": \"230\",\r\n    \"tas_donuk_flag\": false,\r\n    \"tas_bg_color\": \"rgb(255, 0, 0)\",\r\n    \"tas_aci\": 0\r\n  },\r\n  \"cropper_data\": {\r\n    \"image_data\": {\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1,\r\n      \"naturalWidth\": 866,\r\n      \"naturalHeight\": 650,\r\n      \"aspectRatio\": 1.3323076923076924,\r\n      \"width\": 568,\r\n      \"height\": 426.32794457274815,\r\n      \"left\": 0,\r\n      \"top\": 2.842170943040401e-14\r\n    },\r\n    \"canvas_data\": {\r\n      \"left\": 0,\r\n      \"top\": 36.836027713625896,\r\n      \"width\": 568,\r\n      \"height\": 426.3279445727482,\r\n      \"naturalWidth\": 866,\r\n      \"naturalHeight\": 650\r\n    },\r\n    \"crop_box_data\": {\r\n      \"left\": 56.79999999999998,\r\n      \"top\": 79.4688221709007,\r\n      \"width\": 454.40000000000003,\r\n      \"height\": 341.0623556581986\r\n    },\r\n    \"container_data\": {\r\n      \"width\": 568,\r\n      \"height\": 500\r\n    },\r\n    \"data\": {\r\n      \"x\": 86.59999999999998,\r\n      \"y\": 64.99999999999996,\r\n      \"width\": 692.8000000000001,\r\n      \"height\": 520,\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1\r\n    }\r\n  }\r\n}',NULL,NULL,4),(7,'1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_4iZReT4ckjdgYhKyf1w2JeSay9FVht','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','Ahmet Kanbur','ahmet@ahmet.com','5432390269','oval','8x10 cm',1,'','2018-02-15 15:03:34','jpg','{\r\n  \"img_data\": {\r\n    \"width\": \"314.891px\",\r\n    \"height\": \"322.688px\",\r\n    \"left\": \"-19px\",\r\n    \"top\": \"-2px\",\r\n    \"def_height\": \"235.68972746331238\",\r\n    \"def_width\": \"230\",\r\n    \"tas_donuk_flag\": false,\r\n    \"tas_bg_color\": \"rgb(255, 0, 0)\",\r\n    \"tas_aci\": 0\r\n  },\r\n  \"cropper_data\": {\r\n    \"image_data\": {\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1,\r\n      \"naturalWidth\": 2385,\r\n      \"naturalHeight\": 2444,\r\n      \"aspectRatio\": 0.9758592471358429,\r\n      \"width\": 487.92962356792145,\r\n      \"height\": 500,\r\n      \"left\": 0,\r\n      \"top\": 0\r\n    },\r\n    \"canvas_data\": {\r\n      \"left\": 40.03518821603927,\r\n      \"top\": 0,\r\n      \"width\": 487.92962356792145,\r\n      \"height\": 500,\r\n      \"naturalWidth\": 2385,\r\n      \"naturalHeight\": 2444\r\n    },\r\n    \"crop_box_data\": {\r\n      \"left\": 88.82815057283142,\r\n      \"top\": 50,\r\n      \"width\": 390.34369885433716,\r\n      \"height\": 400\r\n    },\r\n    \"container_data\": {\r\n      \"width\": 568,\r\n      \"height\": 500\r\n    },\r\n    \"data\": {\r\n      \"x\": 238.5,\r\n      \"y\": 244.4,\r\n      \"width\": 1908,\r\n      \"height\": 1955.2,\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1\r\n    }\r\n  }\r\n}',NULL,NULL,4),(8,'1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_eL0spFkMx6mGt2FTyWmBDM1y21LXDD','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX','Ahmet Kanbur','ahmet@ahmet.com','5432390269','oval','8x10 cm',1,'','2018-02-15 15:05:27','jpg','{\r\n  \"img_data\": {\r\n    \"width\": \"230px\",\r\n    \"height\": \"172.625px\",\r\n    \"left\": \"-1px\",\r\n    \"top\": \"79px\",\r\n    \"def_height\": \"172.6327944572748\",\r\n    \"def_width\": \"230\",\r\n    \"tas_donuk_flag\": false,\r\n    \"tas_bg_color\": \"rgb(255, 0, 0)\",\r\n    \"tas_aci\": 0\r\n  },\r\n  \"cropper_data\": {\r\n    \"image_data\": {\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1,\r\n      \"naturalWidth\": 866,\r\n      \"naturalHeight\": 650,\r\n      \"aspectRatio\": 1.3323076923076924,\r\n      \"width\": 568,\r\n      \"height\": 426.32794457274815,\r\n      \"left\": 0,\r\n      \"top\": 2.842170943040401e-14\r\n    },\r\n    \"canvas_data\": {\r\n      \"left\": 0,\r\n      \"top\": 36.836027713625896,\r\n      \"width\": 568,\r\n      \"height\": 426.3279445727482,\r\n      \"naturalWidth\": 866,\r\n      \"naturalHeight\": 650\r\n    },\r\n    \"crop_box_data\": {\r\n      \"left\": 56.79999999999998,\r\n      \"top\": 79.4688221709007,\r\n      \"width\": 454.40000000000003,\r\n      \"height\": 341.0623556581986\r\n    },\r\n    \"container_data\": {\r\n      \"width\": 568,\r\n      \"height\": 500\r\n    },\r\n    \"data\": {\r\n      \"x\": 86.59999999999998,\r\n      \"y\": 64.99999999999996,\r\n      \"width\": 692.8000000000001,\r\n      \"height\": 520,\r\n      \"rotate\": 0,\r\n      \"scaleX\": 1,\r\n      \"scaleY\": 1\r\n    }\r\n  }\r\n}',NULL,NULL,4);
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
INSERT INTO `temp_uploads` VALUES (11,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_eMU6BjCM2alfgEwAwD8purFOqW3m1r','png','2018-02-15 15:07:19','cropped','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_oZ69bafbOgWb6dOQrvWoC7Uy1vPxtE','PORX'),(12,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_NawPQPCpFqx3ez051kem0kWeDEmwTR','jpg','2018-02-15 15:07:19','orjinal','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_oZ69bafbOgWb6dOQrvWoC7Uy1vPxtE','PORX'),(15,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_jcFF3fRl3aVkTHc6G3xB1YglYDdf9M','png','2018-02-15 15:08:32','cropped','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_cze6FfDVvSzsUk0gBUpsPtKChouRat','PORX'),(16,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_LOEDK04UuiuPRDv5bvdWiSd4zdAJPu','jpg','2018-02-15 15:08:33','orjinal','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_cze6FfDVvSzsUk0gBUpsPtKChouRat','PORX'),(17,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_WCqanXcdssu7im9OumwN7Gr1M3gYAH','png','2018-02-15 15:08:48','cropped','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_BKf4ypH3jpgJmR9XEl56FXiYmitVdr','PORX'),(18,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_PB7jsos82jdSSOtLPSQufXojX3JUkB','jpg','2018-02-15 15:08:48','orjinal','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_BKf4ypH3jpgJmR9XEl56FXiYmitVdr','PORX'),(19,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_h4k0mmpxF85JiCbyPv4sn3yqvWZVlp','png','2018-02-15 15:09:14','cropped','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_XxbBETSuVceglaCn22SNzvl02ORW3E','PORX'),(20,'TMP1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_fVtbDSYs1MsYK50VELd34hbAQBucld','jpeg','2018-02-15 15:09:14','orjinal','1516192080Etmq2ByeIb4BDMDRgwsQAZgV4ghWFX_XxbBETSuVceglaCn22SNzvl02ORW3E','PORX');
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

-- Dump completed on 2018-02-15 17:16:12
