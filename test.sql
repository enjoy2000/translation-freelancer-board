-- MySQL dump 10.13  Distrib 5.6.20, for osx10.9 (x86_64)
--
-- Host: localhost    Database: test
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor` int(11) DEFAULT NULL,
  `MeasurementSystem` varchar(255) DEFAULT NULL,
  `setAutoDate` varchar(255) DEFAULT NULL,
  `containerNumber` varchar(255) DEFAULT NULL,
  `Receiving` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data`
--

LOCK TABLES `data` WRITE;
/*!40000 ALTER TABLE `data` DISABLE KEYS */;
INSERT INTO `data` VALUES (1,22,'343','454','454',NULL),(2,1,'US-Imperal','09/24/2014 06:43:06 pm','asdas','10000869');
/*!40000 ALTER TABLE `data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rows`
--

DROP TABLE IF EXISTS `rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rows` (
  `STYLENUMBER` varchar(255) DEFAULT NULL,
  `UOM` varchar(255) DEFAULT NULL,
  `PREFIX` varchar(255) DEFAULT NULL,
  `SETHEIGHT` varchar(255) DEFAULT NULL,
  `SETWIDTH` varchar(255) DEFAULT NULL,
  `SETLENGTH` varchar(255) DEFAULT NULL,
  `SETWEIGHT` varchar(255) DEFAULT NULL,
  `UPC` varchar(255) DEFAULT NULL,
  `SIZEA` varchar(255) DEFAULT NULL,
  `COLORA` varchar(255) DEFAULT NULL,
  `SIZEC` varchar(255) DEFAULT NULL,
  `COLORC` varchar(255) DEFAULT NULL,
  `CARTON` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rows`
--

LOCK TABLES `rows` WRITE;
/*!40000 ALTER TABLE `rows` DISABLE KEYS */;
INSERT INTO `rows` VALUES ('23','','','','','','','','','','','',''),('23','','','','','','','','','','','',''),('23','','','','','','','','','','','',''),('23','','','','','','','','','','','',''),('23','','','','','','','','','','','',''),('23','23','','','','','','','','','','',''),('23','23','32','23','23','23','23','232323232323','23','23','23','23','23'),('23','','','','','','','','','','','',''),('23','','','','','','','','','','','',''),('23','','','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','',''),('23','23','42','','','','','','','','','','');
/*!40000 ALTER TABLE `rows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor`
--

DROP TABLE IF EXISTS `vendor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor`
--

LOCK TABLES `vendor` WRITE;
/*!40000 ALTER TABLE `vendor` DISABLE KEYS */;
INSERT INTO `vendor` VALUES (1,'vendor1'),(2,'vendor2'),(3,'vendor3'),(4,'vendorfromDB');
/*!40000 ALTER TABLE `vendor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-25  2:05:06
