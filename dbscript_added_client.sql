/*
SQLyog Community v11.4 (32 bit)
MySQL - 5.0.27-community-nt : Database - papertask
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`papertask` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `papertask`;

/*Table structure for table `cattool` */

DROP TABLE IF EXISTS `cattool`;

CREATE TABLE `cattool` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `telephone` varchar(255) collate utf8_unicode_ci NOT NULL,
  `fax` varchar(255) collate utf8_unicode_ci NOT NULL,
  `address` varchar(255) collate utf8_unicode_ci NOT NULL,
  `city` varchar(255) collate utf8_unicode_ci NOT NULL,
  `country` varchar(2) collate utf8_unicode_ci NOT NULL,
  `website` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `desktopsoftware` */

DROP TABLE IF EXISTS `desktopsoftware`;

CREATE TABLE `desktopsoftware` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(50) collate utf8_unicode_ci NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `emailtemplates` */

DROP TABLE IF EXISTS `emailtemplates`;

CREATE TABLE `emailtemplates` (
  `id` int(11) NOT NULL auto_increment,
  `type_id` int(11) default NULL,
  `content` longtext collate utf8_unicode_ci NOT NULL,
  `subject` varchar(255) collate utf8_unicode_ci NOT NULL,
  `language` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_51BDDDCC54C8C93` (`type_id`),
  CONSTRAINT `FK_51BDDDCC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `templatetype` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `employer` */

DROP TABLE IF EXISTS `employer`;

CREATE TABLE `employer` (
  `id` int(11) NOT NULL auto_increment,
  `company_id` int(11) default NULL,
  `position` varchar(255) collate utf8_unicode_ci NOT NULL,
  `defaultServiceLevel` int(11) NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_273A9230979B1AD6` (`company_id`),
  CONSTRAINT `FK_273A9230979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `engineeringcategory` */

DROP TABLE IF EXISTS `engineeringcategory`;

CREATE TABLE `engineeringcategory` (
  `id` int(11) NOT NULL auto_increment,
  `category` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `field` */

DROP TABLE IF EXISTS `field`;

CREATE TABLE `field` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `file` */

DROP TABLE IF EXISTS `file`;

CREATE TABLE `file` (
  `id` int(11) NOT NULL auto_increment,
  `project_id` int(11) default NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `path` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_2CAD992E166D1F9C` (`project_id`),
  CONSTRAINT `FK_2CAD992E166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `freelancer` */

DROP TABLE IF EXISTS `freelancer`;

CREATE TABLE `freelancer` (
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `freelancer_resource` */

DROP TABLE IF EXISTS `freelancer_resource`;

CREATE TABLE `freelancer_resource` (
  `freelancer_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  PRIMARY KEY  (`freelancer_id`,`resource_id`),
  KEY `IDX_3E106CD18545BDF5` (`freelancer_id`),
  KEY `IDX_3E106CD189329D25` (`resource_id`),
  CONSTRAINT `FK_3E106CD18545BDF5` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_3E106CD189329D25` FOREIGN KEY (`resource_id`) REFERENCES `resource` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `interpretingservice` */

DROP TABLE IF EXISTS `interpretingservice`;

CREATE TABLE `interpretingservice` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `iterm` */

DROP TABLE IF EXISTS `iterm`;

CREATE TABLE `iterm` (
  `id` int(11) NOT NULL auto_increment,
  `file_id` int(11) default NULL,
  `language_id` int(11) default NULL,
  `rate` decimal(10,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_178AF5B493CB796C` (`file_id`),
  KEY `IDX_178AF5B482F1BAF4` (`language_id`),
  CONSTRAINT `FK_178AF5B482F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  CONSTRAINT `FK_178AF5B493CB796C` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `language` */

DROP TABLE IF EXISTS `language`;

CREATE TABLE `language` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(2) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `languagegroup` */

DROP TABLE IF EXISTS `languagegroup`;

CREATE TABLE `languagegroup` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `operatingsystem` */

DROP TABLE IF EXISTS `operatingsystem`;

CREATE TABLE `operatingsystem` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `profileservicedesktoppublishing` */

DROP TABLE IF EXISTS `profileservicedesktoppublishing`;

CREATE TABLE `profileservicedesktoppublishing` (
  `id` int(11) NOT NULL auto_increment,
  `priceApplePerPage` decimal(19,2) NOT NULL,
  `priceWindowPerPage` decimal(19,2) NOT NULL,
  `priceApplePerHour` decimal(19,2) NOT NULL,
  `priceWindowPerHour` decimal(19,2) NOT NULL,
  `languageGroup_id` int(11) default NULL,
  `desktopSoftware_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_2805D4BCD7A78D38` (`languageGroup_id`),
  KEY `IDX_2805D4BCA20324D4` (`desktopSoftware_id`),
  CONSTRAINT `FK_2805D4BCA20324D4` FOREIGN KEY (`desktopSoftware_id`) REFERENCES `desktopsoftware` (`id`),
  CONSTRAINT `FK_2805D4BCD7A78D38` FOREIGN KEY (`languageGroup_id`) REFERENCES `languagegroup` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `profileserviceengineering` */

DROP TABLE IF EXISTS `profileserviceengineering`;

CREATE TABLE `profileserviceengineering` (
  `id` int(11) NOT NULL auto_increment,
  `unit_id` int(11) default NULL,
  `price` decimal(19,2) NOT NULL,
  `engineeringCategory_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_238BA388B7E18FC` (`engineeringCategory_id`),
  KEY `IDX_238BA38F8BD700D` (`unit_id`),
  CONSTRAINT `FK_238BA388B7E18FC` FOREIGN KEY (`engineeringCategory_id`) REFERENCES `engineeringcategory` (`id`),
  CONSTRAINT `FK_238BA38F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `profileserviceinterpreting` */

DROP TABLE IF EXISTS `profileserviceinterpreting`;

CREATE TABLE `profileserviceinterpreting` (
  `id` int(11) NOT NULL auto_increment,
  `pricePerDay` decimal(19,2) NOT NULL,
  `pricePerHalfDay` decimal(19,2) NOT NULL,
  `sourceLanguage_id` int(11) default NULL,
  `targetLanguage_id` int(11) default NULL,
  `interpretingService_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_A26CD31E1B92B47F` (`sourceLanguage_id`),
  KEY `IDX_A26CD31E55CA1DCA` (`targetLanguage_id`),
  KEY `IDX_A26CD31E2289CFF5` (`interpretingService_id`),
  CONSTRAINT `FK_A26CD31E1B92B47F` FOREIGN KEY (`sourceLanguage_id`) REFERENCES `language` (`id`),
  CONSTRAINT `FK_A26CD31E2289CFF5` FOREIGN KEY (`interpretingService_id`) REFERENCES `interpretingservice` (`id`),
  CONSTRAINT `FK_A26CD31E55CA1DCA` FOREIGN KEY (`targetLanguage_id`) REFERENCES `language` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `profileservicetranslation` */

DROP TABLE IF EXISTS `profileservicetranslation`;

CREATE TABLE `profileservicetranslation` (
  `id` int(11) NOT NULL auto_increment,
  `professionalPrice` decimal(19,2) NOT NULL,
  `businessPrice` decimal(19,2) NOT NULL,
  `premiumPrice` decimal(19,2) NOT NULL,
  `sourceLanguage_id` int(11) default NULL,
  `targetLanguage_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_B8276CF91B92B47F` (`sourceLanguage_id`),
  KEY `IDX_B8276CF955CA1DCA` (`targetLanguage_id`),
  CONSTRAINT `FK_B8276CF91B92B47F` FOREIGN KEY (`sourceLanguage_id`) REFERENCES `language` (`id`),
  CONSTRAINT `FK_B8276CF955CA1DCA` FOREIGN KEY (`targetLanguage_id`) REFERENCES `language` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `profileservicetranslationtm` */

DROP TABLE IF EXISTS `profileservicetranslationtm`;

CREATE TABLE `profileservicetranslationtm` (
  `id` int(11) NOT NULL auto_increment,
  `template` varchar(255) collate utf8_unicode_ci NOT NULL,
  `rate` decimal(4,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `project` */

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `id` int(11) NOT NULL auto_increment,
  `field_id` int(11) default NULL,
  `sale_id` int(11) default NULL,
  `pm_id` int(11) default NULL,
  `serviceLevel` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `reference` varchar(255) collate utf8_unicode_ci NOT NULL,
  `priority` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `dueDate` date NOT NULL,
  `interpretingInfo` varchar(255) collate utf8_unicode_ci default NULL,
  `client_id` int(11) default NULL,
  `duration` int(11) NOT NULL,
  `sourceLanguage_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_E00EE972443707B0` (`field_id`),
  KEY `IDX_E00EE9724A7E4868` (`sale_id`),
  KEY `IDX_E00EE9726FBC242E` (`pm_id`),
  KEY `IDX_E00EE9721B92B47F` (`sourceLanguage_id`),
  KEY `IDX_E00EE97219EB6921` (`client_id`),
  CONSTRAINT `FK_E00EE97219EB6921` FOREIGN KEY (`client_id`) REFERENCES `employer` (`id`),
  CONSTRAINT `FK_E00EE9721B92B47F` FOREIGN KEY (`sourceLanguage_id`) REFERENCES `language` (`id`),
  CONSTRAINT `FK_E00EE972443707B0` FOREIGN KEY (`field_id`) REFERENCES `field` (`id`),
  CONSTRAINT `FK_E00EE9724A7E4868` FOREIGN KEY (`sale_id`) REFERENCES `staff` (`id`),
  CONSTRAINT `FK_E00EE9726FBC242E` FOREIGN KEY (`pm_id`) REFERENCES `staff` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `project_language` */

DROP TABLE IF EXISTS `project_language`;

CREATE TABLE `project_language` (
  `project_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  PRIMARY KEY  (`project_id`,`language_id`),
  KEY `IDX_E995FA6E166D1F9C` (`project_id`),
  KEY `IDX_E995FA6E82F1BAF4` (`language_id`),
  CONSTRAINT `FK_E995FA6E166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_E995FA6E82F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `projectdtpmaciterm` */

DROP TABLE IF EXISTS `projectdtpmaciterm`;

CREATE TABLE `projectdtpmaciterm` (
  `project_id` int(11) NOT NULL,
  `iterm_id` int(11) NOT NULL,
  PRIMARY KEY  (`project_id`,`iterm_id`),
  KEY `IDX_E42DE1FC166D1F9C` (`project_id`),
  KEY `IDX_E42DE1FC39C68E7B` (`iterm_id`),
  CONSTRAINT `FK_E42DE1FC166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_E42DE1FC39C68E7B` FOREIGN KEY (`iterm_id`) REFERENCES `iterm` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `projectdtppciterm` */

DROP TABLE IF EXISTS `projectdtppciterm`;

CREATE TABLE `projectdtppciterm` (
  `project_id` int(11) NOT NULL,
  `iterm_id` int(11) NOT NULL,
  PRIMARY KEY  (`project_id`,`iterm_id`),
  KEY `IDX_7BDA8C3F166D1F9C` (`project_id`),
  KEY `IDX_7BDA8C3F39C68E7B` (`iterm_id`),
  CONSTRAINT `FK_7BDA8C3F166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_7BDA8C3F39C68E7B` FOREIGN KEY (`iterm_id`) REFERENCES `iterm` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `projectengineeringiterm` */

DROP TABLE IF EXISTS `projectengineeringiterm`;

CREATE TABLE `projectengineeringiterm` (
  `project_id` int(11) NOT NULL,
  `iterm_id` int(11) NOT NULL,
  PRIMARY KEY  (`project_id`,`iterm_id`),
  KEY `IDX_E9A7469C166D1F9C` (`project_id`),
  KEY `IDX_E9A7469C39C68E7B` (`iterm_id`),
  CONSTRAINT `FK_E9A7469C166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_E9A7469C39C68E7B` FOREIGN KEY (`iterm_id`) REFERENCES `iterm` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `projectinterpretingiterm` */

DROP TABLE IF EXISTS `projectinterpretingiterm`;

CREATE TABLE `projectinterpretingiterm` (
  `project_id` int(11) NOT NULL,
  `iterm_id` int(11) NOT NULL,
  PRIMARY KEY  (`project_id`,`iterm_id`),
  KEY `IDX_90493213166D1F9C` (`project_id`),
  KEY `IDX_9049321339C68E7B` (`iterm_id`),
  CONSTRAINT `FK_90493213166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_9049321339C68E7B` FOREIGN KEY (`iterm_id`) REFERENCES `iterm` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `resource` */

DROP TABLE IF EXISTS `resource`;

CREATE TABLE `resource` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) default NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_45E79640FE54D947` (`group_id`),
  CONSTRAINT `FK_45E79640FE54D947` FOREIGN KEY (`group_id`) REFERENCES `resourcegroup` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `resourcegroup` */

DROP TABLE IF EXISTS `resourcegroup`;

CREATE TABLE `resourcegroup` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `specialism` */

DROP TABLE IF EXISTS `specialism`;

CREATE TABLE `specialism` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `staff` */

DROP TABLE IF EXISTS `staff`;

CREATE TABLE `staff` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `templatetype` */

DROP TABLE IF EXISTS `templatetype`;

CREATE TABLE `templatetype` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `description` varchar(255) collate utf8_unicode_ci default NULL,
  `code` varchar(50) collate utf8_unicode_ci default NULL,
  `updateTime` datetime default NULL,
  `createdTime` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `unit` */

DROP TABLE IF EXISTS `unit`;

CREATE TABLE `unit` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) default NULL,
  `freelancer_id` int(11) default NULL,
  `employer_id` int(11) default NULL,
  `firstName` varchar(255) collate utf8_unicode_ci NOT NULL,
  `lastName` varchar(255) collate utf8_unicode_ci NOT NULL,
  `email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `password` varchar(255) collate utf8_unicode_ci NOT NULL,
  `phone` varchar(255) collate utf8_unicode_ci default NULL,
  `lastLogin` datetime NOT NULL,
  `createdTime` datetime NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `profileUpdated` tinyint(1) NOT NULL,
  `token` varchar(255) collate utf8_unicode_ci default NULL,
  `country` varchar(255) collate utf8_unicode_ci default NULL,
  `city` varchar(255) collate utf8_unicode_ci default NULL,
  `gender` tinyint(1) NOT NULL,
  `currency` varchar(255) collate utf8_unicode_ci NOT NULL,
  `comments` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNIQ_2DA17977E7927C74` (`email`),
  UNIQUE KEY `UNIQ_2DA179778545BDF5` (`freelancer_id`),
  UNIQUE KEY `UNIQ_2DA1797741CD9E7A` (`employer_id`),
  KEY `IDX_2DA17977FE54D947` (`group_id`),
  CONSTRAINT `FK_2DA1797741CD9E7A` FOREIGN KEY (`employer_id`) REFERENCES `employer` (`id`),
  CONSTRAINT `FK_2DA179778545BDF5` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`id`),
  CONSTRAINT `FK_2DA17977FE54D947` FOREIGN KEY (`group_id`) REFERENCES `usergroup` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `userdesktopcattools` */

DROP TABLE IF EXISTS `userdesktopcattools`;

CREATE TABLE `userdesktopcattools` (
  `freelancer_id` int(11) NOT NULL,
  `cattool_id` int(11) NOT NULL,
  PRIMARY KEY  (`freelancer_id`,`cattool_id`),
  KEY `IDX_3961A68C8545BDF5` (`freelancer_id`),
  KEY `IDX_3961A68CA84F203A` (`cattool_id`),
  CONSTRAINT `FK_3961A68C8545BDF5` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_3961A68CA84F203A` FOREIGN KEY (`cattool_id`) REFERENCES `cattool` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `userdesktopprice` */

DROP TABLE IF EXISTS `userdesktopprice`;

CREATE TABLE `userdesktopprice` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `language_id` int(11) default NULL,
  `software_id` int(11) default NULL,
  `priceMac` decimal(6,2) NOT NULL,
  `pricePc` decimal(6,2) NOT NULL,
  `priceHourMac` decimal(6,2) NOT NULL,
  `priceHourPc` decimal(6,2) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_D90F0509A76ED395` (`user_id`),
  KEY `IDX_D90F050982F1BAF4` (`language_id`),
  KEY `IDX_D90F0509D7452741` (`software_id`),
  CONSTRAINT `FK_D90F050982F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  CONSTRAINT `FK_D90F0509A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_D90F0509D7452741` FOREIGN KEY (`software_id`) REFERENCES `desktopsoftware` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `userengineeringprice` */

DROP TABLE IF EXISTS `userengineeringprice`;

CREATE TABLE `userengineeringprice` (
  `id` int(11) NOT NULL auto_increment,
  `engineeringCategory_id` int(11) default NULL,
  `unit_id` int(11) default NULL,
  `price` int(11) default NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_ECP_EC_ID` (`engineeringCategory_id`),
  KEY `FK_ECP_UNIT_ID` (`unit_id`),
  KEY `FK_ECP_USER_ID` (`user_id`),
  CONSTRAINT `FK_ECP_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_ECP_EC_ID` FOREIGN KEY (`engineeringCategory_id`) REFERENCES `engineeringcategory` (`id`),
  CONSTRAINT `FK_ECP_UNIT_ID` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `usergroup` */

DROP TABLE IF EXISTS `usergroup`;

CREATE TABLE `usergroup` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `firstLoginUrl` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `userinterpretingprice` */

DROP TABLE IF EXISTS `userinterpretingprice`;

CREATE TABLE `userinterpretingprice` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `service_id` int(11) default NULL,
  `priceDay` decimal(6,2) NOT NULL,
  `priceHalfDay` decimal(6,2) NOT NULL,
  `sourceLanguage_id` int(11) default NULL,
  `targetLanguage_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_2544906CA76ED395` (`user_id`),
  KEY `IDX_2544906C1B92B47F` (`sourceLanguage_id`),
  KEY `IDX_2544906C55CA1DCA` (`targetLanguage_id`),
  KEY `IDX_2544906CED5CA9E6` (`service_id`),
  CONSTRAINT `FK_2544906C1B92B47F` FOREIGN KEY (`sourceLanguage_id`) REFERENCES `language` (`id`),
  CONSTRAINT `FK_2544906C55CA1DCA` FOREIGN KEY (`targetLanguage_id`) REFERENCES `language` (`id`),
  CONSTRAINT `FK_2544906CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_2544906CED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `interpretingservice` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `userinterpretingspecialisms` */

DROP TABLE IF EXISTS `userinterpretingspecialisms`;

CREATE TABLE `userinterpretingspecialisms` (
  `freelancer_id` int(11) NOT NULL,
  `specialism_id` int(11) NOT NULL,
  PRIMARY KEY  (`freelancer_id`,`specialism_id`),
  KEY `IDX_1F2D30F08545BDF5` (`freelancer_id`),
  KEY `IDX_1F2D30F05601140F` (`specialism_id`),
  CONSTRAINT `FK_1F2D30F05601140F` FOREIGN KEY (`specialism_id`) REFERENCES `specialism` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_1F2D30F08545BDF5` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `useroperatingsystem` */

DROP TABLE IF EXISTS `useroperatingsystem`;

CREATE TABLE `useroperatingsystem` (
  `freelancer_id` int(11) NOT NULL,
  `operatingsystem_id` int(11) NOT NULL,
  PRIMARY KEY  (`freelancer_id`,`operatingsystem_id`),
  KEY `IDX_8371A4BF8545BDF5` (`freelancer_id`),
  KEY `IDX_8371A4BF26B8E142` (`operatingsystem_id`),
  CONSTRAINT `FK_8371A4BF26B8E142` FOREIGN KEY (`operatingsystem_id`) REFERENCES `operatingsystem` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_8371A4BF8545BDF5` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `usertmratio` */

DROP TABLE IF EXISTS `usertmratio`;

CREATE TABLE `usertmratio` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `repetitions` int(11) default NULL,
  `yibai` int(11) default NULL,
  `jiuwu` int(11) default NULL,
  `bawu` int(11) default NULL,
  `qiwu` int(11) default NULL,
  `wushi` int(11) default NULL,
  `nomatch` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_TMR_USER_ID` (`user_id`),
  CONSTRAINT `FK_TMR_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `usertranslationcattools` */

DROP TABLE IF EXISTS `usertranslationcattools`;

CREATE TABLE `usertranslationcattools` (
  `freelancer_id` int(11) NOT NULL,
  `cattool_id` int(11) NOT NULL,
  PRIMARY KEY  (`freelancer_id`,`cattool_id`),
  KEY `IDX_6FFCD7B98545BDF5` (`freelancer_id`),
  KEY `IDX_6FFCD7B9A84F203A` (`cattool_id`),
  CONSTRAINT `FK_6FFCD7B98545BDF5` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_6FFCD7B9A84F203A` FOREIGN KEY (`cattool_id`) REFERENCES `cattool` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `usertranslationprice` */

DROP TABLE IF EXISTS `usertranslationprice`;

CREATE TABLE `usertranslationprice` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `price` decimal(6,2) NOT NULL,
  `sourceLanguage_id` int(11) default NULL,
  `targetLanguage_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_19CA7E48A76ED395` (`user_id`),
  KEY `IDX_19CA7E481B92B47F` (`sourceLanguage_id`),
  KEY `IDX_19CA7E4855CA1DCA` (`targetLanguage_id`),
  CONSTRAINT `FK_19CA7E481B92B47F` FOREIGN KEY (`sourceLanguage_id`) REFERENCES `language` (`id`),
  CONSTRAINT `FK_19CA7E4855CA1DCA` FOREIGN KEY (`targetLanguage_id`) REFERENCES `language` (`id`),
  CONSTRAINT `FK_19CA7E48A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `usertranslationspecialisms` */

DROP TABLE IF EXISTS `usertranslationspecialisms`;

CREATE TABLE `usertranslationspecialisms` (
  `freelancer_id` int(11) NOT NULL,
  `specialism_id` int(11) NOT NULL,
  PRIMARY KEY  (`freelancer_id`,`specialism_id`),
  KEY `IDX_3403D3928545BDF5` (`freelancer_id`),
  KEY `IDX_3403D3925601140F` (`specialism_id`),
  CONSTRAINT `FK_3403D3925601140F` FOREIGN KEY (`specialism_id`) REFERENCES `specialism` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_3403D3928545BDF5` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
