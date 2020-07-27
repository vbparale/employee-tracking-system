/*
SQLyog Community v12.4.3 (64 bit)
MySQL - 10.4.11-MariaDB : Database - ets_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ets_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `ets_db`;

/*Table structure for table `nets_emp_act_participants` */

DROP TABLE IF EXISTS `nets_emp_act_participants`;

CREATE TABLE `nets_emp_act_participants` (
  `PRTCPNT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACTIVITY_ID` int(11) NOT NULL,
  `EMP_CODE` varchar(10) NOT NULL,
  `STATUS` varchar(11) DEFAULT NULL,
  `STATUS_DATE` date DEFAULT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`PRTCPNT_ID`),
  KEY `ACTIVITY_ID` (`ACTIVITY_ID`),
  KEY `EMP_CODE` (`EMP_CODE`),
  CONSTRAINT `nets_emp_act_participants_ibfk_1` FOREIGN KEY (`ACTIVITY_ID`) REFERENCES `nets_emp_activity` (`ACTIVITY_ID`),
  CONSTRAINT `nets_emp_act_participants_ibfk_2` FOREIGN KEY (`EMP_CODE`) REFERENCES `nets_emp_info` (`EMP_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nets_emp_act_participants` */

/*Table structure for table `nets_emp_activity` */

DROP TABLE IF EXISTS `nets_emp_activity`;

CREATE TABLE `nets_emp_activity` (
  `ACTIVITY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `EMP_CODE` varchar(10) NOT NULL,
  `ACTIVITY_DATE` date NOT NULL,
  `TIME_FROM` time NOT NULL,
  `TIME_TO` time NOT NULL,
  `ACTIVITY_TYPE` varchar(50) NOT NULL,
  `LOCATION` varchar(50) NOT NULL,
  `HOST_EMP` varchar(10) DEFAULT NULL,
  `VISITOR_ID` int(11) DEFAULT NULL,
  `STATUS` varchar(11) NOT NULL,
  `STATUS_DATE` date DEFAULT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`ACTIVITY_ID`),
  KEY `EMP_CODE` (`EMP_CODE`),
  KEY `VISITOR_ID` (`VISITOR_ID`),
  CONSTRAINT `nets_emp_activity_ibfk_1` FOREIGN KEY (`EMP_CODE`) REFERENCES `nets_emp_info` (`EMP_CODE`),
  CONSTRAINT `nets_emp_activity_ibfk_2` FOREIGN KEY (`VISITOR_ID`) REFERENCES `nets_visit_log` (`VISITOR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nets_emp_activity` */

/*Table structure for table `nets_emp_ehc` */

DROP TABLE IF EXISTS `nets_emp_ehc`;

CREATE TABLE `nets_emp_ehc` (
  `EHC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `EMP_CODE` varchar(10) NOT NULL,
  `EHC_DATE` date NOT NULL,
  `COMPLETION_DATE` datetime NOT NULL,
  `Q1` int(11) NOT NULL,
  `A1` varchar(10) NOT NULL,
  `Q2` int(11) NOT NULL,
  `A2` text NOT NULL,
  `A2WHEN` date DEFAULT NULL,
  `Q3` int(11) NOT NULL,
  `A3` text NOT NULL,
  `Q4` int(11) NOT NULL,
  `A4` varchar(1) NOT NULL,
  `A4WHERE` varchar(50) DEFAULT NULL,
  `A4WHEN` date DEFAULT NULL,
  `Q5` int(11) NOT NULL,
  `A5` varchar(1) NOT NULL,
  `A5WHEN` date DEFAULT NULL,
  `RUSHNO` varchar(11) DEFAULT NULL,
  `REASON` varchar(50) DEFAULT NULL,
  `STATUS` varchar(11) DEFAULT NULL,
  `STATUS_DATE` datetime DEFAULT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  `LAST_CHECKED` datetime DEFAULT NULL,
  PRIMARY KEY (`EHC_ID`),
  KEY `Q1` (`Q1`),
  KEY `Q2` (`Q2`),
  KEY `Q3` (`Q3`),
  KEY `Q4` (`Q4`),
  KEY `Q5` (`Q5`),
  CONSTRAINT `nets_emp_ehc_ibfk_10` FOREIGN KEY (`Q5`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_emp_ehc_ibfk_6` FOREIGN KEY (`Q1`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_emp_ehc_ibfk_7` FOREIGN KEY (`Q2`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_emp_ehc_ibfk_8` FOREIGN KEY (`Q3`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_emp_ehc_ibfk_9` FOREIGN KEY (`Q4`) REFERENCES `nxx_questionnaire` (`QCODE`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nets_emp_ehc` */

insert  into `nets_emp_ehc`(`EHC_ID`,`EMP_CODE`,`EHC_DATE`,`COMPLETION_DATE`,`Q1`,`A1`,`Q2`,`A2`,`A2WHEN`,`Q3`,`A3`,`Q4`,`A4`,`A4WHERE`,`A4WHEN`,`Q5`,`A5`,`A5WHEN`,`RUSHNO`,`REASON`,`STATUS`,`STATUS_DATE`,`UPDATE_USER`,`UPDATE_DATE`,`LAST_CHECKED`) values 
(1,'123','2020-05-04','2020-05-04 08:48:43',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','IT00','2020-05-06','2020-05-06 02:00:52'),
(2,'123','2020-05-04','2020-05-04 08:49:50',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(3,'123','2020-05-04','2020-05-04 08:50:42',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(4,'123','2020-05-04','2020-05-04 08:52:27',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(5,'123','2020-05-04','2020-05-04 08:53:21',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(6,'123','2020-05-04','2020-05-04 02:55:52',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(7,'123','2020-05-04','2020-05-04 02:58:33',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(8,'123','2020-05-04','2020-05-04 03:00:20',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(9,'123','2020-05-04','2020-05-04 03:10:42',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(10,'123','2020-05-04','2020-05-04 03:13:29',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(11,'123','2020-05-04','2020-05-04 03:15:26',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(12,'123','2020-05-04','2020-05-04 03:16:43',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(13,'123','2020-05-04','2020-05-04 03:17:30',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(14,'123','2020-05-04','2020-05-04 03:20:22',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(15,'123','2020-05-04','2020-05-04 03:22:19',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(16,'123','2020-05-04','2020-05-04 03:23:44',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(17,'123','2020-05-04','2020-05-04 03:26:12',1,'2',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(18,'123','2020-05-04','2020-05-04 03:27:07',1,'3',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(19,'123','2020-05-04','2020-05-04 03:28:50',1,'2',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(20,'123','2020-05-04','2020-05-04 03:31:33',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(21,'123','2020-05-04','2020-05-04 03:35:19',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(22,'123','2020-05-04','2020-05-04 03:43:11',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(23,'123','2020-05-04','2020-05-04 03:48:46',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(24,'123','2020-05-04','2020-05-04 04:31:51',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(25,'123','2020-05-04','2020-05-04 04:32:30',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(26,'123','2020-05-04','2020-05-04 04:39:09',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,'20042440713',NULL,NULL,'2020-05-04 07:54:28','','0000-00-00','2020-05-04 07:54:28'),
(27,'123','2020-05-04','2020-05-04 04:41:07',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,'20042440714',NULL,NULL,'2020-05-04 07:54:28','','0000-00-00','2020-05-04 07:54:28'),
(28,'123','2020-05-04','2020-05-04 04:41:47',1,'2',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,'20042440715',NULL,NULL,'2020-05-04 07:54:29','','0000-00-00','2020-05-04 07:54:29'),
(29,'123','2020-05-04','2020-05-04 04:42:54',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,'20042440716',NULL,NULL,'2020-05-04 07:54:29','','0000-00-00','2020-05-04 07:54:29'),
(30,'123','2020-05-04','2020-05-04 06:56:38',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(31,'123','2020-05-04','2020-05-04 06:57:40',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,'20042440717',NULL,NULL,'2020-05-05 01:03:30','','0000-00-00','2020-05-05 01:03:30'),
(32,'123','2020-05-04','2020-05-04 06:58:48',1,'1',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,'20042440718',NULL,NULL,'2020-05-04 07:54:28','','0000-00-00','2020-05-04 07:54:28'),
(33,'123','2020-05-05','2020-05-05 02:56:53',1,'123',2,'Y','2020-05-05',3,'[\"None\"]',4,'Y','qwe','2020-05-05',5,'Y','2020-05-05',NULL,'qwe',NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(34,'123','2020-05-05','2020-05-05 03:12:21',1,'123',2,'Y','2020-05-05',3,'[\"None\"]',4,'Y','qwe','2020-05-05',5,'Y','2020-05-05','20052440719','2323','\r\n\r\n  \r\n   ','2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(35,'123','2020-05-06','2020-05-06 11:31:10',1,'121',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N','0000-00-00',NULL,NULL,NULL,'2020-05-06 02:00:52','','0000-00-00','2020-05-06 02:00:52'),
(36,'123','2020-05-06','2020-05-06 02:21:31',1,'01',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,NULL,'IT00','2020-05-06',NULL),
(37,'123','2020-05-06','2020-05-06 02:25:02',1,'36',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N','0000-00-00','20062440720','test','I',NULL,'','0000-00-00',NULL),
(38,'123','2020-05-06','2020-05-06 02:28:34',1,'36',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N','0000-00-00','20062440721','test','I',NULL,'','0000-00-00',NULL),
(39,'123','2020-05-06','2020-05-06 03:34:34',1,'35',2,'N','0000-00-00',3,'[\"test\"]',4,'Y','test','2020-05-06',5,'Y','2020-05-06','20062440722','hehe','I',NULL,'IT00','2020-05-06',NULL),
(40,'TEST','2020-05-06','2020-05-06 05:25:55',1,'35',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,'','','',NULL,'IT00','2020-05-06',NULL),
(41,'TEST','2020-05-07','2020-05-07 02:08:36',1,'36',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,'20072440728','test','I',NULL,'','0000-00-00',NULL),
(42,'TEST','2020-05-07','2020-05-07 05:29:48',1,'35',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,'20072440729','test','I',NULL,'','0000-00-00',NULL),
(43,'TEST','2020-05-08','2020-05-08 09:02:14',1,'37',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(44,'TEST','2020-05-08','2020-05-08 06:32:57',1,'37',2,'Y','2020-05-08',3,'[\"Decreased ability to smell\",\"Decreased ability to taste\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,'test','I',NULL,'','0000-00-00',NULL),
(45,'TEST','2020-05-11','2020-05-11 11:34:48',1,'36',2,'N',NULL,3,'[\"None\"]',4,'Y','SHOPWISE MAKATI','2020-05-11',5,'N',NULL,NULL,NULL,'I',NULL,'','0000-00-00',NULL),
(46,'TEST','2020-05-11','2020-05-11 03:15:21',1,'36.',2,'N',NULL,3,'[\"None\"]',4,'N',NULL,NULL,5,'N',NULL,NULL,'test','I',NULL,'','0000-00-00',NULL);

/*Table structure for table `nets_emp_hdf` */

DROP TABLE IF EXISTS `nets_emp_hdf`;

CREATE TABLE `nets_emp_hdf` (
  `HDF_ID` int(11) NOT NULL AUTO_INCREMENT,
  `EMP_CODE` varchar(10) NOT NULL,
  `HDF_DATE` date NOT NULL,
  `COMPLETION_DATE` datetime NOT NULL,
  `HEALTH_DEC` int(11) NOT NULL,
  `REASON` varchar(50) DEFAULT NULL,
  `RUSHNO` varchar(20) DEFAULT NULL,
  `STATUS` varchar(11) DEFAULT NULL,
  `STATUS_DATE` datetime DEFAULT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  `LAST_CHECKED` datetime DEFAULT NULL,
  PRIMARY KEY (`HDF_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nets_emp_hdf` */

insert  into `nets_emp_hdf`(`HDF_ID`,`EMP_CODE`,`HDF_DATE`,`COMPLETION_DATE`,`HEALTH_DEC`,`REASON`,`RUSHNO`,`STATUS`,`STATUS_DATE`,`UPDATE_USER`,`UPDATE_DATE`,`LAST_CHECKED`) values 
(1,'TEST','2020-05-10','2020-05-10 04:31:09',0,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(2,'TEST','2020-05-10','2020-05-10 04:38:11',0,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(3,'TEST','2020-05-10','2020-05-10 04:40:02',0,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(4,'TEST','2020-05-10','2020-05-10 04:44:37',0,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(5,'TEST','2020-05-10','2020-05-10 04:50:09',0,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(6,'TEST','2020-05-10','2020-05-10 04:57:43',0,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(7,'TEST','2020-05-10','2020-05-10 05:02:32',0,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(8,'TEST','2020-05-10','2020-05-10 05:09:45',1,'',NULL,NULL,NULL,'','0000-00-00',NULL),
(9,'TEST','2020-05-10','2020-05-10 05:18:57',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(10,'TEST','2020-05-10','2020-05-10 05:23:13',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(11,'TEST','2020-05-10','2020-05-10 05:27:23',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(12,'TEST','2020-05-10','2020-05-10 05:30:50',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(13,'TEST','2020-05-10','2020-05-10 05:40:56',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(14,'TEST','2020-05-10','2020-05-10 05:43:56',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(15,'TEST','2020-05-10','2020-05-10 05:48:21',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(16,'TEST','2020-05-10','2020-05-10 05:54:18',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(17,'TEST','2020-05-10','2020-05-10 05:56:15',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(18,'TEST','2020-05-10','2020-05-10 05:58:57',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(19,'TEST','2020-05-10','2020-05-10 06:03:45',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(20,'TEST','2020-05-10','2020-05-10 06:06:12',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(21,'TEST','2020-05-10','2020-05-10 06:09:42',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(22,'TEST','2020-05-10','2020-05-10 06:13:46',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(23,'TEST','2020-05-10','2020-05-10 06:16:02',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(24,'TEST','2020-05-10','2020-05-10 06:19:48',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(25,'TEST','2020-05-10','2020-05-10 06:22:38',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(26,'TEST','2020-05-10','2020-05-10 06:25:27',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(27,'TEST','2020-05-10','2020-05-10 06:49:38',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(28,'TEST','2020-05-10','2020-05-10 07:23:18',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(29,'TEST','2020-05-10','2020-05-10 07:26:53',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(30,'TEST','2020-05-10','2020-05-10 07:30:28',1,NULL,NULL,NULL,NULL,'','0000-00-00',NULL),
(31,'TEST','2020-05-10','2020-05-10 07:34:41',1,NULL,NULL,NULL,NULL,'TEST','2020-05-11',NULL),
(32,'TEST','2020-05-10','2020-05-10 07:39:20',1,NULL,NULL,NULL,NULL,'TEST','2020-05-11',NULL),
(33,'TEST','2020-05-11','2020-05-11 11:11:25',1,NULL,NULL,NULL,NULL,'TEST','2020-05-11',NULL);

/*Table structure for table `nets_emp_info` */

DROP TABLE IF EXISTS `nets_emp_info`;

CREATE TABLE `nets_emp_info` (
  `EMP_CODE` varchar(10) NOT NULL,
  `CARD_NO` varchar(8) NOT NULL,
  `RUSH_ID` varchar(8) NOT NULL,
  `EMP_LNAME` varchar(50) NOT NULL,
  `EMP_MNAME` varchar(50) NOT NULL,
  `EMP_FNAME` varchar(50) NOT NULL,
  `DATE_HIRED` date NOT NULL,
  `DATE_EOC` date NOT NULL,
  `EMP_STAT` varchar(10) NOT NULL,
  `POS_CODE` varchar(15) NOT NULL,
  `EMP_LEVEL` varchar(10) NOT NULL,
  `COMP_CODE` varchar(20) NOT NULL,
  `LOC_CODE` varchar(20) NOT NULL,
  `GRP_CODE` varchar(15) NOT NULL,
  `DEPT_CODE` varchar(15) NOT NULL,
  `APVL_LVL` int(11) NOT NULL,
  `PRESENT_ADDR1` varchar(50) DEFAULT NULL,
  `PRESENT_ADDR2` varchar(50) DEFAULT NULL,
  `PRESENT_CITY` varchar(50) DEFAULT NULL,
  `PRESENT_PROV` varchar(50) NOT NULL,
  `PERM_CITY` varchar(50) DEFAULT NULL,
  `PERM_PROV` varchar(50) NOT NULL,
  `MOBILE_NO` varchar(20) NOT NULL,
  `TEL_NO` varchar(10) DEFAULT NULL,
  `CIVIL_STAT` varchar(15) DEFAULT NULL,
  `AGE` int(11) NOT NULL,
  `BIRTHDATE` date NOT NULL,
  `GENDER` varchar(10) NOT NULL,
  `TEAM` varchar(5) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`EMP_CODE`),
  KEY `EMP_STAT` (`EMP_STAT`),
  KEY `POS_CODE` (`POS_CODE`),
  KEY `EMP_LEVEL` (`EMP_LEVEL`),
  KEY `COMP_CODE` (`COMP_CODE`),
  KEY `LOC_CODE` (`LOC_CODE`),
  KEY `GRP_CODE` (`GRP_CODE`),
  KEY `DEPT_CODE` (`DEPT_CODE`),
  KEY `TEAM` (`TEAM`),
  CONSTRAINT `nets_emp_info_ibfk_1` FOREIGN KEY (`EMP_STAT`) REFERENCES `nxx_empstat` (`EMPSTAT_CODE`),
  CONSTRAINT `nets_emp_info_ibfk_2` FOREIGN KEY (`POS_CODE`) REFERENCES `nxx_position` (`POS_CODE`),
  CONSTRAINT `nets_emp_info_ibfk_3` FOREIGN KEY (`EMP_LEVEL`) REFERENCES `nxx_rank` (`RNK_CODE`),
  CONSTRAINT `nets_emp_info_ibfk_4` FOREIGN KEY (`COMP_CODE`) REFERENCES `nxx_company` (`COMP_CODE`),
  CONSTRAINT `nets_emp_info_ibfk_5` FOREIGN KEY (`LOC_CODE`) REFERENCES `nxx_location` (`LOC_CODE`),
  CONSTRAINT `nets_emp_info_ibfk_6` FOREIGN KEY (`GRP_CODE`) REFERENCES `nxx_group` (`GRP_CODE`),
  CONSTRAINT `nets_emp_info_ibfk_7` FOREIGN KEY (`DEPT_CODE`) REFERENCES `nxx_department` (`DEPT_CODE`),
  CONSTRAINT `nets_emp_info_ibfk_8` FOREIGN KEY (`TEAM`) REFERENCES `nxx_teamsched` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nets_emp_info` */

insert  into `nets_emp_info`(`EMP_CODE`,`CARD_NO`,`RUSH_ID`,`EMP_LNAME`,`EMP_MNAME`,`EMP_FNAME`,`DATE_HIRED`,`DATE_EOC`,`EMP_STAT`,`POS_CODE`,`EMP_LEVEL`,`COMP_CODE`,`LOC_CODE`,`GRP_CODE`,`DEPT_CODE`,`APVL_LVL`,`PRESENT_ADDR1`,`PRESENT_ADDR2`,`PRESENT_CITY`,`PRESENT_PROV`,`PERM_CITY`,`PERM_PROV`,`MOBILE_NO`,`TEL_NO`,`CIVIL_STAT`,`AGE`,`BIRTHDATE`,`GENDER`,`TEAM`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
('TEST','TEST','IT00','BACAY','ADRIAN','RAMIL','0000-00-00','0000-00-00','TEST','TEST','TEST','FLI','TEST','IT','TEST',0,'221B Baker Street','Test Town','Update City','Update Province','Queens','New York','09272821411','12345678','PARTNER',23,'0000-00-00','MALE','TEST','','0000-00-00','TEST','2020-05-11'),
('TEST2','TEST2','IT01','TEST','TEST','TEST','0000-00-00','0000-00-00','TEST','TEST','TEST','TEST','TEST','TEST','TEST',40,NULL,NULL,NULL,'',NULL,'','09272821411',NULL,NULL,0,'0000-00-00','FEMALE','TEST','','0000-00-00','','0000-00-00');

/*Table structure for table `nets_emp_user` */

DROP TABLE IF EXISTS `nets_emp_user`;

CREATE TABLE `nets_emp_user` (
  `USER_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `EMP_CODE` varchar(10) NOT NULL,
  `LOGIN_ID` varchar(8) NOT NULL,
  `EMAIL_ADDRESS` varchar(50) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `ACCESSGRPID` int(11) NOT NULL,
  `STATUS` int(11) NOT NULL,
  `STATUSDATE` date NOT NULL,
  `DATEPWDCHANGED` date DEFAULT NULL,
  `REMARKS` varchar(255) DEFAULT NULL,
  `LASTLOGINDATE` date DEFAULT NULL,
  `LASTLOGOUTDATE` date DEFAULT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  `SUBMITTED_EHC` int(11) NOT NULL,
  `SUBMITTED_HDF` int(11) NOT NULL,
  `SENT_NOTIF` int(11) NOT NULL,
  PRIMARY KEY (`USER_ID`),
  KEY `EMP_CODE` (`EMP_CODE`),
  KEY `ACCESSGRPID` (`ACCESSGRPID`),
  CONSTRAINT `nets_emp_user_ibfk_1` FOREIGN KEY (`EMP_CODE`) REFERENCES `nets_emp_info` (`EMP_CODE`),
  CONSTRAINT `nets_emp_user_ibfk_2` FOREIGN KEY (`ACCESSGRPID`) REFERENCES `nxx_user_role` (`ACCESSGRPID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nets_emp_user` */

insert  into `nets_emp_user`(`USER_ID`,`EMP_CODE`,`LOGIN_ID`,`EMAIL_ADDRESS`,`PASSWORD`,`ACCESSGRPID`,`STATUS`,`STATUSDATE`,`DATEPWDCHANGED`,`REMARKS`,`LASTLOGINDATE`,`LASTLOGOUTDATE`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`,`SUBMITTED_EHC`,`SUBMITTED_HDF`,`SENT_NOTIF`) values 
(3,'TEST','IT00','RAEBACAY@FEDERALLAND.PH','$2y$10$sTtA97qOwKxrHPYpeTH27Oj6II/6mfExNg.KphlcuxsBHRcQ/.4TW',1,0,'0000-00-00',NULL,NULL,'2020-05-11','2020-05-11','','0000-00-00','','0000-00-00',1,1,0),
(6,'TEST2','IT01','RAEBACAY@FEDERALLAND.PH','$2y$10$sTtA97qOwKxrHPYpeTH27Oj6II/6mfExNg.KphlcuxsBHRcQ/.4TW',1,0,'0000-00-00',NULL,NULL,'2020-05-11','2020-05-11','','0000-00-00','','0000-00-00',0,0,0);

/*Table structure for table `nets_hdf_chrnc_disease` */

DROP TABLE IF EXISTS `nets_hdf_chrnc_disease`;

CREATE TABLE `nets_hdf_chrnc_disease` (
  `HDFC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ANSKEY` int(11) NOT NULL,
  `EMP_CODE` varchar(10) NOT NULL,
  `DISEASE` varchar(100) NOT NULL,
  `HDF_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`HDFC_ID`),
  KEY `EMP_CODE` (`EMP_CODE`),
  KEY `DISEASE` (`DISEASE`),
  CONSTRAINT `nets_hdf_chrnc_disease_ibfk_1` FOREIGN KEY (`EMP_CODE`) REFERENCES `nets_emp_user` (`EMP_CODE`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nets_hdf_chrnc_disease` */

insert  into `nets_hdf_chrnc_disease`(`HDFC_ID`,`ANSKEY`,`EMP_CODE`,`DISEASE`,`HDF_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
(6,24,'TEST','Asthma','2020-05-10','','0000-00-00'),
(7,24,'TEST','Mental illness (bipolar, cyclothymic, and depressi','2020-05-10','','0000-00-00'),
(8,24,'TEST','21321','2020-05-10','','0000-00-00'),
(9,25,'TEST','Arthritis','2020-05-10','','0000-00-00'),
(10,25,'TEST','Mental illness (bipolar, cyclothymic, and depression)','2020-05-10','','0000-00-00'),
(11,25,'TEST','test','2020-05-10','','0000-00-00'),
(12,26,'TEST','Arthritis','2020-05-10','','0000-00-00'),
(13,26,'TEST','Mental illness (bipolar, cyclothymic, and depression)','2020-05-10','','0000-00-00'),
(14,27,'TEST','Arthritis','2020-05-10','','0000-00-00'),
(15,27,'TEST','Asthma','2020-05-10','','0000-00-00'),
(16,27,'TEST','Mental illness (bipolar, cyclothymic, and depression)','2020-05-10','','0000-00-00'),
(17,27,'TEST','TEST','2020-05-10','','0000-00-00'),
(18,28,'TEST','Asthma','2020-05-10','','0000-00-00'),
(19,28,'TEST','Mental illness (bipolar, cyclothymic, and depression)','2020-05-10','','0000-00-00'),
(20,28,'TEST','TEST','2020-05-10','','0000-00-00'),
(21,29,'TEST','Asthma','2020-05-10','','0000-00-00'),
(22,29,'TEST','Mental illness (bipolar, cyclothymic, and depression)','2020-05-10','','0000-00-00'),
(23,29,'TEST','TEST','2020-05-10','','0000-00-00'),
(24,30,'TEST','Mental illness (bipolar, cyclothymic, and depression)','2020-05-10','','0000-00-00'),
(25,30,'TEST','123','2020-05-10','','0000-00-00'),
(26,31,'TEST','Mental illness (bipolar, cyclothymic, and depression)','2020-05-10','','0000-00-00'),
(27,31,'TEST','123','2020-05-10','','0000-00-00'),
(28,32,'TEST','Mental illness (bipolar, cyclothymic, and depression)','2020-05-10','','0000-00-00'),
(29,32,'TEST','213','2020-05-10','','0000-00-00'),
(47,33,'TEST','Arthritis','2020-05-11','TEST','2020-05-11'),
(48,33,'TEST','Mental illness (bipolar, cyclothymic, and depression)','2020-05-11','TEST','2020-05-11'),
(49,33,'TEST','None','2020-05-11','TEST','2020-05-11');

/*Table structure for table `nets_hdf_healthdec` */

DROP TABLE IF EXISTS `nets_hdf_healthdec`;

CREATE TABLE `nets_hdf_healthdec` (
  `HDFHD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `HDF_ID` int(11) NOT NULL,
  `Q1` int(11) NOT NULL,
  `A1` varchar(1) NOT NULL,
  `A1TEMP` float DEFAULT NULL,
  `Q2` int(11) NOT NULL,
  `A2` varchar(30) NOT NULL,
  `Q3` int(11) NOT NULL,
  `A3` text NOT NULL,
  `Q4` int(11) NOT NULL,
  `A4` varchar(1) NOT NULL,
  `A4REASON` varchar(50) DEFAULT NULL,
  `Q5` int(11) NOT NULL,
  `A5` varchar(1) NOT NULL,
  `A5SYMPTOMS` varchar(50) DEFAULT NULL,
  `A5PERIOD` varchar(50) DEFAULT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`HDFHD_ID`),
  KEY `Q1` (`Q1`),
  KEY `Q2` (`Q2`),
  KEY `Q3` (`Q3`),
  KEY `Q4` (`Q4`),
  KEY `Q5` (`Q5`),
  KEY `HDF_ID` (`HDF_ID`),
  CONSTRAINT `nets_hdf_healthdec_ibfk_2` FOREIGN KEY (`Q1`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_healthdec_ibfk_3` FOREIGN KEY (`Q2`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_healthdec_ibfk_4` FOREIGN KEY (`Q3`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_healthdec_ibfk_5` FOREIGN KEY (`Q4`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_healthdec_ibfk_6` FOREIGN KEY (`Q5`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_healthdec_ibfk_7` FOREIGN KEY (`HDF_ID`) REFERENCES `nets_emp_hdf` (`HDF_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nets_hdf_healthdec` */

insert  into `nets_hdf_healthdec`(`HDFHD_ID`,`HDF_ID`,`Q1`,`A1`,`A1TEMP`,`Q2`,`A2`,`Q3`,`A3`,`Q4`,`A4`,`A4REASON`,`Q5`,`A5`,`A5SYMPTOMS`,`A5PERIOD`,`UPDATE_USER`,`UPDATE_DATE`) values 
(1,26,1,'Y',12,2,'12',3,'[\"Kidney, bladder, or urinary disorder\\/infection, Sexual Transmitted Disease, reproductive organ or prostate disorder?\",\"Asthma, chronic cough, pneumonia, tuberculosis, emphysema, or any other respiratory or lung disorder?\"]',4,'Y','12',5,'Y','12','12','','0000-00-00'),
(2,27,1,'Y',12,2,'TEST',3,'[\"Kidney, bladder, or urinary disorder\\/infection, Sexual Transmitted Disease, reproductive organ or prostate disorder?\",\"Asthma, chronic cough, pneumonia, tuberculosis, emphysema, or any other respiratory or lung disorder?\"]',4,'Y','TEST',5,'Y','TEST','TEST','','0000-00-00'),
(3,28,1,'Y',12,2,'123',3,'[\"Kidney, bladder, or urinary disorder\\/infection, Sexual Transmitted Disease, reproductive organ or prostate disorder?\",\"Asthma, chronic cough, pneumonia, tuberculosis, emphysema, or any other respiratory or lung disorder?\",\"TEST\"]',4,'Y','TEST',5,'Y','TEST','TEST','','0000-00-00'),
(4,29,1,'Y',12,2,'213',3,'[\"Kidney, bladder, or urinary disorder\\/infection, Sexual Transmitted Disease, reproductive organ or prostate disorder?\",\"Asthma, chronic cough, pneumonia, tuberculosis, emphysema, or any other respiratory or lung disorder?\",\"TEST\"]',4,'Y','QWE',5,'Y','QWE','QWE','','0000-00-00'),
(5,30,1,'Y',123,2,'123',3,'[\"Kidney, bladder, or urinary disorder\\/infection, Sexual Transmitted Disease, reproductive organ or prostate disorder?\",\"Asthma, chronic cough, pneumonia, tuberculosis, emphysema, or any other respiratory or lung disorder?\",\"123\"]',4,'Y','123',5,'Y','12','12','','0000-00-00'),
(6,31,1,'Y',123,2,'132',3,'[\"Kidney, bladder, or urinary disorder\\/infection, Sexual Transmitted Disease, reproductive organ or prostate disorder?\",\"Asthma, chronic cough, pneumonia, tuberculosis, emphysema, or any other respiratory or lung disorder?\",\"123\"]',4,'Y','13',5,'Y','123','12','','0000-00-00'),
(7,32,1,'Y',123,2,'213',3,'[\"Kidney, bladder, or urinary disorder\\/infection, Sexual Transmitted Disease, reproductive organ or prostate disorder?\",\"Asthma, chronic cough, pneumonia, tuberculosis, emphysema, or any other respiratory or lung disorder?\",\"213\"]',4,'Y','213',5,'Y','213','213','','0000-00-00'),
(8,33,1,'Y',36.5,2,'n/a',3,'[\"Kidney, bladder, or urinary disorder\\/infection, Sexual Transmitted Disease, reproductive organ or prostate disorder?\",\"Asthma, chronic cough, pneumonia, tuberculosis, emphysema, or any other respiratory or lung disorder?\"]',4,'N',NULL,5,'N',NULL,NULL,'TEST','2020-05-11');

/*Table structure for table `nets_hdf_hhold` */

DROP TABLE IF EXISTS `nets_hdf_hhold`;

CREATE TABLE `nets_hdf_hhold` (
  `HDFHH_ID` int(11) NOT NULL AUTO_INCREMENT,
  `HDF_ID` int(11) NOT NULL,
  `Q1` int(11) NOT NULL,
  `A1` varchar(30) NOT NULL,
  `Q2` int(11) NOT NULL,
  `A2` varchar(30) DEFAULT NULL,
  `Q3` int(11) NOT NULL,
  `A3` int(11) NOT NULL,
  `Q4` int(11) NOT NULL,
  `A4` int(11) NOT NULL,
  `Q5` int(11) NOT NULL,
  `A5` int(11) DEFAULT NULL,
  `Q6` int(11) NOT NULL,
  `A6` varchar(1) NOT NULL,
  `A6HOWMANY` int(11) DEFAULT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`HDFHH_ID`),
  KEY `Q1` (`Q1`),
  KEY `Q2` (`Q2`),
  KEY `Q3` (`Q3`),
  KEY `Q4` (`Q4`),
  KEY `Q5` (`Q5`),
  KEY `HDF_ID` (`HDF_ID`),
  CONSTRAINT `nets_hdf_hhold_ibfk_2` FOREIGN KEY (`Q1`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_hhold_ibfk_3` FOREIGN KEY (`Q2`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_hhold_ibfk_4` FOREIGN KEY (`Q3`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_hhold_ibfk_5` FOREIGN KEY (`Q4`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_hhold_ibfk_6` FOREIGN KEY (`Q5`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_hhold_ibfk_8` FOREIGN KEY (`HDF_ID`) REFERENCES `nets_emp_hdf` (`HDF_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nets_hdf_hhold` */

insert  into `nets_hdf_hhold`(`HDFHH_ID`,`HDF_ID`,`Q1`,`A1`,`Q2`,`A2`,`Q3`,`A3`,`Q4`,`A4`,`Q5`,`A5`,`Q6`,`A6`,`A6HOWMANY`,`UPDATE_USER`,`UPDATE_DATE`) values 
(1,1,1,'qwe',2,'qwe',3,0,4,0,5,0,6,'q',NULL,'','0000-00-00'),
(2,1,1,'qwe',2,'qwe',3,0,4,0,5,0,6,'q',NULL,'','0000-00-00'),
(3,18,1,'Residential House',2,'213',3,213,4,123,5,2,6,'Y',21321,'','0000-00-00'),
(4,20,1,'Residential House',2,'123',3,123,4,123,5,20,6,'Y',3213,'','0000-00-00'),
(5,21,1,'Residential House',2,'213',3,213,4,213,5,21,6,'Y',2131,'','0000-00-00'),
(6,23,1,'Residential House',2,'123',3,123,4,123,5,23,6,'Y',21312,'','0000-00-00'),
(7,24,1,'Residential House',2,'123',3,213,4,213,5,24,6,'Y',111,'','0000-00-00'),
(8,25,1,'Residential House',2,'123',3,123,4,123,5,25,6,'Y',2,'','0000-00-00'),
(9,26,1,'Residential House',2,'123',3,123,4,123,5,26,6,'Y',123,'','0000-00-00'),
(10,27,1,'Residential House',2,'123',3,123,4,123,5,27,6,'Y',123,'','0000-00-00'),
(11,28,1,'Residential House',2,'TEST',3,123,4,123,5,28,6,'Y',2,'','0000-00-00'),
(12,29,1,'Residential House',2,'123',3,123,4,123,5,29,6,'Y',123,'','0000-00-00'),
(13,30,1,'Residential House',2,'123',3,123,4,123,5,30,6,'Y',123,'','0000-00-00'),
(14,31,1,'Residential House',2,'132',3,123,4,123,5,31,6,'Y',13,'','0000-00-00'),
(15,32,1,'Residential House',2,'213',3,123,4,123,5,32,6,'Y',123,'','0000-00-00'),
(16,33,1,'Residential House',2,'n/a',3,3,4,1,5,33,6,'Y',2,'TEST','2020-05-11');

/*Table structure for table `nets_hdf_otherinfo` */

DROP TABLE IF EXISTS `nets_hdf_otherinfo`;

CREATE TABLE `nets_hdf_otherinfo` (
  `HDFOI_ID` int(11) NOT NULL AUTO_INCREMENT,
  `HDF_ID` int(11) NOT NULL,
  `Q1` int(11) NOT NULL,
  `A1` varchar(1) NOT NULL,
  `A1DETAILS` varchar(50) DEFAULT NULL,
  `Q2` int(11) NOT NULL,
  `A2` varchar(1) NOT NULL,
  `A2EXPOSURE_DATE` date DEFAULT NULL,
  `Q3` int(11) NOT NULL,
  `A3` text NOT NULL,
  `Q4` int(11) NOT NULL,
  `A4` varchar(30) NOT NULL,
  `A4PLACE` varchar(50) DEFAULT NULL,
  `Q5` int(11) NOT NULL,
  `A5` varchar(30) NOT NULL,
  `A5FRONTLINER` text DEFAULT NULL,
  `Q6` int(11) NOT NULL,
  `A6` varchar(30) NOT NULL,
  `Q7` int(11) NOT NULL,
  `A7` varchar(30) DEFAULT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`HDFOI_ID`),
  KEY `HDF_ID` (`HDF_ID`),
  KEY `Q1` (`Q1`),
  KEY `Q2` (`Q2`),
  KEY `Q3` (`Q3`),
  KEY `Q4` (`Q4`),
  KEY `Q5` (`Q5`),
  CONSTRAINT `nets_hdf_otherinfo_ibfk_1` FOREIGN KEY (`HDF_ID`) REFERENCES `nets_emp_hdf` (`HDF_ID`),
  CONSTRAINT `nets_hdf_otherinfo_ibfk_2` FOREIGN KEY (`Q1`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_otherinfo_ibfk_3` FOREIGN KEY (`Q2`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_otherinfo_ibfk_4` FOREIGN KEY (`Q3`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_otherinfo_ibfk_5` FOREIGN KEY (`Q4`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_otherinfo_ibfk_6` FOREIGN KEY (`Q5`) REFERENCES `nxx_questionnaire` (`QCODE`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nets_hdf_otherinfo` */

insert  into `nets_hdf_otherinfo`(`HDFOI_ID`,`HDF_ID`,`Q1`,`A1`,`A1DETAILS`,`Q2`,`A2`,`A2EXPOSURE_DATE`,`Q3`,`A3`,`Q4`,`A4`,`A4PLACE`,`Q5`,`A5`,`A5FRONTLINER`,`Q6`,`A6`,`Q7`,`A7`,`UPDATE_USER`,`UPDATE_DATE`) values 
(1,32,1,'Y','213',2,'Y','2020-05-10',3,'[\"Decreased ability to smell\",\"3123\"]',4,'Yes','123',5,'Yes','[\"Back Office Support(IT, Payroll, etc.)\",\"2131\"]',6,'Everyday',7,'21312','','0000-00-00'),
(2,33,1,'N',NULL,2,'N',NULL,3,'[\"None\"]',4,'No',NULL,5,'No','null',6,'Once a week',7,'me','TEST','2020-05-11');

/*Table structure for table `nets_hdf_travelhistory` */

DROP TABLE IF EXISTS `nets_hdf_travelhistory`;

CREATE TABLE `nets_hdf_travelhistory` (
  `HDFTH_ID` int(11) NOT NULL AUTO_INCREMENT,
  `HDF_ID` int(11) NOT NULL,
  `Q1` int(11) NOT NULL,
  `A1` varchar(1) NOT NULL,
  `A1TRAVEL_DATES` varchar(30) DEFAULT NULL,
  `A1PLACE` varchar(30) DEFAULT NULL,
  `A1RETURN_DATE` date DEFAULT NULL,
  `Q2` int(11) NOT NULL,
  `A2` varchar(1) NOT NULL,
  `A2TRAVEL_DATES` varchar(30) DEFAULT NULL,
  `A2PLACE` varchar(30) DEFAULT NULL,
  `A2RETURN_DATE` date DEFAULT NULL,
  `Q3` int(11) NOT NULL,
  `A3` varchar(1) NOT NULL,
  `A3CONTACT_DATE` varchar(50) DEFAULT NULL,
  `Q4` int(11) NOT NULL,
  `A4` varchar(1) NOT NULL,
  `A4NAME` varchar(50) DEFAULT NULL,
  `A4VISIT_DATE` date DEFAULT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`HDFTH_ID`),
  KEY `HDF_ID` (`HDF_ID`),
  KEY `Q1` (`Q1`),
  KEY `Q2` (`Q2`),
  KEY `Q3` (`Q3`),
  KEY `Q5` (`Q4`),
  CONSTRAINT `nets_hdf_travelhistory_ibfk_1` FOREIGN KEY (`HDF_ID`) REFERENCES `nets_emp_hdf` (`HDF_ID`),
  CONSTRAINT `nets_hdf_travelhistory_ibfk_2` FOREIGN KEY (`Q1`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_travelhistory_ibfk_3` FOREIGN KEY (`Q2`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_travelhistory_ibfk_4` FOREIGN KEY (`Q3`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_hdf_travelhistory_ibfk_6` FOREIGN KEY (`Q4`) REFERENCES `nxx_questionnaire` (`QCODE`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nets_hdf_travelhistory` */

insert  into `nets_hdf_travelhistory`(`HDFTH_ID`,`HDF_ID`,`Q1`,`A1`,`A1TRAVEL_DATES`,`A1PLACE`,`A1RETURN_DATE`,`Q2`,`A2`,`A2TRAVEL_DATES`,`A2PLACE`,`A2RETURN_DATE`,`Q3`,`A3`,`A3CONTACT_DATE`,`Q4`,`A4`,`A4NAME`,`A4VISIT_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
(1,1,1,'Y','','TEST','0000-00-00',2,'Y','','TEST','0000-00-00',3,'Y','0000-00-00',4,'Y','','0000-00-00','','0000-00-00'),
(2,28,1,'Y','TEST','TEST','2020-05-10',2,'Y','TEST','TEST','2020-05-10',3,'Y','0000-00-00',4,'Y','TEST','2020-05-10','','0000-00-00'),
(3,29,1,'Y','QWE','QWE','2020-05-10',2,'Y','QWE','WQE','2020-05-10',3,'Y','0000-00-00',4,'Y','QWE','2020-05-10','','0000-00-00'),
(4,30,1,'Y','213','123','2020-05-10',2,'Y','213','213','2020-05-10',3,'Y','0000-00-00',4,'Y','123','2020-05-10','','0000-00-00'),
(5,31,1,'Y','123','123','2020-05-10',2,'Y','123','123','2020-05-10',3,'Y','0000-00-00',4,'Y','3213','2020-05-10','','0000-00-00'),
(6,32,1,'Y','213','213','2020-05-10',2,'Y','213','123','2020-05-10',3,'Y','0000-00-00',4,'Y','213','2020-05-10','','0000-00-00'),
(7,33,1,'N',NULL,NULL,NULL,2,'N',NULL,NULL,NULL,3,'N',NULL,4,'N',NULL,NULL,'TEST','2020-05-11');

/*Table structure for table `nets_visit_log` */

DROP TABLE IF EXISTS `nets_visit_log`;

CREATE TABLE `nets_visit_log` (
  `VISITOR_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MEETING_ID` varchar(10) DEFAULT NULL,
  `VISIT_LNAME` varchar(50) NOT NULL,
  `VISIT_FNAME` varchar(50) NOT NULL,
  `VISIT_MNAME` varchar(50) DEFAULT NULL,
  `COMP_NAME` varchar(50) NOT NULL,
  `COMP_ADDRESS` varchar(50) NOT NULL,
  `EMAIL_ADDRESS` varchar(30) NOT NULL,
  `MOBILE_NO` int(11) NOT NULL,
  `TEL_NO` varchar(10) DEFAULT NULL,
  `RES_ADDRESS` varchar(50) NOT NULL,
  `VISIT_DATE` date NOT NULL,
  `CHECKIN_TIME` varchar(10) DEFAULT NULL,
  `CHECKOUT_TIME_HOST` varchar(10) DEFAULT NULL,
  `CHECKOUT_TIME` varchar(10) DEFAULT NULL,
  `VISIT_PURP` varchar(50) NOT NULL,
  `PERS_TOVISIT` varchar(10) NOT NULL,
  `Q1` int(11) NOT NULL,
  `A1` varchar(10) NOT NULL,
  `Q2` int(11) NOT NULL,
  `A2` text NOT NULL,
  `A2DATES` varchar(50) DEFAULT NULL,
  `Q3` int(11) NOT NULL,
  `A3` varchar(1) NOT NULL,
  `A3TRAVEL_DATES` varchar(30) DEFAULT NULL,
  `A3PLACE` varchar(30) DEFAULT NULL,
  `A3RETURN_DATE` date DEFAULT NULL,
  `STATUS` varchar(11) NOT NULL,
  `STATUS_DATE` date DEFAULT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`VISITOR_ID`),
  KEY `Q1` (`Q1`),
  KEY `Q2` (`Q2`),
  KEY `Q3` (`Q3`),
  CONSTRAINT `nets_visit_log_ibfk_1` FOREIGN KEY (`Q1`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_visit_log_ibfk_2` FOREIGN KEY (`Q2`) REFERENCES `nxx_questionnaire` (`QCODE`),
  CONSTRAINT `nets_visit_log_ibfk_3` FOREIGN KEY (`Q3`) REFERENCES `nxx_questionnaire` (`QCODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nets_visit_log` */

/*Table structure for table `nxx_company` */

DROP TABLE IF EXISTS `nxx_company`;

CREATE TABLE `nxx_company` (
  `COMP_CODE` varchar(20) NOT NULL,
  `COMP_NAME` varchar(35) NOT NULL,
  `ADDRESS` varchar(50) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`COMP_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_company` */

insert  into `nxx_company`(`COMP_CODE`,`COMP_NAME`,`ADDRESS`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
('FLI','FLI','','','0000-00-00','','0000-00-00'),
('TEST','TEST','','','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_department` */

DROP TABLE IF EXISTS `nxx_department`;

CREATE TABLE `nxx_department` (
  `DEPT_CODE` varchar(15) NOT NULL,
  `DEPT_NAME` varchar(50) NOT NULL,
  `GRP_CODE` varchar(15) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`DEPT_CODE`),
  KEY `GRP_CODE` (`GRP_CODE`),
  CONSTRAINT `nxx_department_ibfk_1` FOREIGN KEY (`GRP_CODE`) REFERENCES `nxx_group` (`GRP_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_department` */

insert  into `nxx_department`(`DEPT_CODE`,`DEPT_NAME`,`GRP_CODE`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
('TEST','TEST','TEST','','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_empstat` */

DROP TABLE IF EXISTS `nxx_empstat`;

CREATE TABLE `nxx_empstat` (
  `EMPSTAT_CODE` varchar(10) NOT NULL,
  `EMPSTAT_DESC` varchar(50) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`EMPSTAT_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_empstat` */

insert  into `nxx_empstat`(`EMPSTAT_CODE`,`EMPSTAT_DESC`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
('TEST','TEST','','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_group` */

DROP TABLE IF EXISTS `nxx_group`;

CREATE TABLE `nxx_group` (
  `GRP_CODE` varchar(15) NOT NULL,
  `GRP_NAME` varchar(50) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`GRP_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_group` */

insert  into `nxx_group`(`GRP_CODE`,`GRP_NAME`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
('IT','Information Technology','','0000-00-00','','0000-00-00'),
('TEST','TEST','','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_hdf_ctemp` */

DROP TABLE IF EXISTS `nxx_hdf_ctemp`;

CREATE TABLE `nxx_hdf_ctemp` (
  `CTEMP_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CUTOFF_ID` int(11) NOT NULL,
  `EMP_CODE` varchar(10) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`CTEMP_ID`),
  KEY `CUTOFF_ID` (`CUTOFF_ID`),
  CONSTRAINT `nxx_hdf_ctemp_ibfk_1` FOREIGN KEY (`CUTOFF_ID`) REFERENCES `nxx_hdf_cutoff` (`CUTOFFID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_hdf_ctemp` */

insert  into `nxx_hdf_ctemp`(`CTEMP_ID`,`CUTOFF_ID`,`EMP_CODE`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
(1,2,'IT00','','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_hdf_cutoff` */

DROP TABLE IF EXISTS `nxx_hdf_cutoff`;

CREATE TABLE `nxx_hdf_cutoff` (
  `CUTOFFID` int(11) NOT NULL AUTO_INCREMENT,
  `EMP_FLAG` int(11) NOT NULL,
  `SUBMISSION_DATE` date NOT NULL,
  `CUTOFF_TIME` time NOT NULL,
  `ANS_FLAG` int(11) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`CUTOFFID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_hdf_cutoff` */

insert  into `nxx_hdf_cutoff`(`CUTOFFID`,`EMP_FLAG`,`SUBMISSION_DATE`,`CUTOFF_TIME`,`ANS_FLAG`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
(1,1,'2020-05-11','13:00:00',0,'','0000-00-00','','0000-00-00'),
(2,2,'2020-05-11','13:00:00',0,'','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_location` */

DROP TABLE IF EXISTS `nxx_location`;

CREATE TABLE `nxx_location` (
  `LOC_CODE` varchar(20) NOT NULL,
  `LOCATION_NAME` varchar(35) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`LOC_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_location` */

insert  into `nxx_location`(`LOC_CODE`,`LOCATION_NAME`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
('TEST','TEST','','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_position` */

DROP TABLE IF EXISTS `nxx_position`;

CREATE TABLE `nxx_position` (
  `POS_CODE` varchar(15) NOT NULL,
  `POS_DESC` varchar(50) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`POS_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_position` */

insert  into `nxx_position`(`POS_CODE`,`POS_DESC`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
('TEST','TEST','','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_questionnaire` */

DROP TABLE IF EXISTS `nxx_questionnaire`;

CREATE TABLE `nxx_questionnaire` (
  `QCODE` int(11) NOT NULL AUTO_INCREMENT,
  `TRANSACTION` varchar(10) NOT NULL,
  `SEQUENCE` int(5) NOT NULL,
  `PARENT_ID` int(11) DEFAULT NULL,
  `QUESTION` varchar(200) NOT NULL,
  `POSS_ANSWER` text NOT NULL,
  `TYPE` int(11) NOT NULL,
  `STATUS` varchar(1) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`QCODE`),
  UNIQUE KEY `QUESTION` (`QUESTION`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_questionnaire` */

insert  into `nxx_questionnaire`(`QCODE`,`TRANSACTION`,`SEQUENCE`,`PARENT_ID`,`QUESTION`,`POSS_ANSWER`,`TYPE`,`STATUS`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
(1,'EHC',1,NULL,'What is your body temperature? (i.e. 37.5)','',1,'A','','0000-00-00','','0000-00-00'),
(2,'EHC',2,NULL,'Are you feeling sick today?','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(3,'EHC',3,NULL,'Do you have the following  sickness/symptoms?','{\r\n  \"1\": \"Dry Cough\",\r\n  \"2\": \"Sore throat\",\r\n  \"3\": \"Colds\",\r\n  \"4\": \"Shortness of breath\",\r\n  \"5\": \"Diarrhea\",\r\n  \"6\": \"Nausea or vomiting\",\r\n  \"7\": \"Headache\",\r\n  \"8\": \"Muscle pain and weakness\",\r\n  \"9\": \"Decreased ability to smell\",\r\n  \"10\": \"Decreased ability to taste\",\r\n  \"11\": \"None\",\r\n  \"12\": \"Others\"\r\n}',3,'A','','0000-00-00','','0000-00-00'),
(4,'EHC',4,NULL,'Did you travel outside of your home?','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(5,'EHC',5,NULL,'Did you have any close contact with positive CoViD?','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(6,'HDFHH',1,NULL,'Type of current residence','{\r\n  \"1\": \"Residential House\",\r\n  \"2\": \"Townhouse\",\r\n  \"3\": \"Bed space\",\r\n  \"4\": \"Apartment/Condo\",\r\n  \"5\": \"Boarding House\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(7,'HDFHH',2,NULL,'If renting, please specify how often do you go home to your permanent address','',1,'A','','0000-00-00','','0000-00-00'),
(8,'HDFHH',3,NULL,'Total number of person in your household (number in figures) ex. 8\r\n','',2,'A','','0000-00-00','','0000-00-00'),
(9,'HDFHH',4,NULL,'Number of person in your household  with ages 51 and above (number in figures)\r\n','',2,'A','','0000-00-00','','0000-00-00'),
(30,'HDFHH',6,NULL,'Do you share room with others?\r\n','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(31,'HDFHD',1,NULL,'Have you experienced having a fever in the last 14 days? \r\n','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(33,'HDFTH',1,NULL,'Travelled from a geographic location/country with documented cases of COVID19? \r\n','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(34,'HDFTH',2,NULL,'Do you have a scheduled trip abroad or local for the next 3 months?\r\n','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(35,'HDFTH',3,NULL,'Close contact to a PUI or confirmed case of the disease (COVID 19)? \r\n','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(36,'HDFTH',4,NULL,'History of visit to a HEALTHCARE facility in a geographic location/country where documented cases of COVID19 have been reported? \r\n','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(37,'HDFOI',1,NULL,'Exposure with patients who are Probable COVID-19 patients who are awaiting results.\r\n','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(38,'HDFOI',2,NULL,'Exposure from Relatives or Friends with recent travel to location/country with documented cases of COVID19 and/or had direct exposure with confirmed COVID19 case? \r\n','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(39,'HDFOI',3,NULL,'Any Signs/Symptoms experienced by the person/s?','{\r\n  \"1\": \"Dry Cough\",\r\n  \"2\": \"Sore throat\",\r\n  \"3\": \"Colds\",\r\n  \"4\": \"Shortness of breath\",\r\n  \"5\": \"Diarrhea\",\r\n  \"6\": \"Nausea or vomiting\",\r\n  \"7\": \"Headache\",\r\n  \"8\": \"Muscle pain and weakness\",\r\n  \"9\": \"Decreased ability to smell\",\r\n  \"10\": \"Decreased ability to taste\",\r\n  \"11\": \"None\",\r\n  \"12\": \"Others\"\r\n}',3,'A','','0000-00-00','','0000-00-00'),
(40,'HDFOI',4,NULL,'Have you recently traveled to an area with known local spread of Covid-19  (e.g. hospital, supermarket, drug store, bank, market and etc)\r\n','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(41,'HDFOI',5,NULL,'Are there any frontliners in your household?\r\n','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(42,'HDFOI',6,NULL,'How often do you or your family member go out for i.e. for grocery shopping etc.\r\n','{\r\n  \"1\": \"Everyday\",\r\n  \"2\": \"Twice a week\",\r\n  \"3\": \"Once a week\",\r\n  \"4\": \"Others\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(43,'HDFOI',7,NULL,'Who often goes out of the house?\r\n','',1,'A','','0000-00-00','','0000-00-00'),
(44,'HDFHD',2,NULL,'What medications did you take?\r\n','',1,'A','','0000-00-00','','0000-00-00'),
(45,'HDFHD',3,NULL,'Many people during their lifetime will experience or be treated for medical conditions. Please let us know which of the following you have had, or been told you had, or sought advice or treatment for:','{\r\n  \"1\": \"High blood pressure, chest pain/discomfort, heart murmur, rheumatic fever, stroke, aneurysm, circulatory or heart disorder?\",\r\n  \"2\": \"Diabetes, sugar in the urine, thyroid or other glandular (endocrine) disorder?\",\r\n  \"3\": \"Kidney, bladder, or urinary disorder/infection, Sexual Transmitted Disease, reproductive organ or prostate disorder?\",\r\n  \"4\": \"Disorders of the skin pigmentation, enlarged glands or lymph nodes, nodules, polyps, cysts, lumps, tumor, mass, abdominal growth, cancer, malignancy or any related conditions?\",\r\n  \"5\": \"Asthma, chronic cough, pneumonia, tuberculosis, emphysema, or any other respiratory or lung disorder?\",\r\n  \"6\": \"Gross obesity greater than 30\",\r\n  \"7\": \"Diagnosed with immunodeficiency disorder\",\r\n  \"8\": \"None\",\r\n  \"9\": \"Other\"\r\n}\r\n',3,'A','','0000-00-00','','0000-00-00'),
(46,'HDFHD',4,NULL,'For the past 6 months, have you consulted a medical doctor or been referred for tests or investigation or had any medical test?\r\n','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(47,'HDFHD',5,NULL,'Do you have any health symptoms, recurring or persistent pains, or complaints for which physician has not been consulted or treatment has not been received?','{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}',4,'A','','0000-00-00','','0000-00-00'),
(48,'HDFHH',5,NULL,'Do you live with someone diagnosed with chronic diseases? Please choose on the following:\r\n','{\r\n  \"1\": \"Alzheimer disease and dementia\",\r\n  \"2\": \"Arthritis\",\r\n  \"3\": \"Asthma\",\r\n  \"4\": \"Cancer\",\r\n  \"5\": \"Chronic obstructive pulmonary disease(COPD)\",\r\n  \"6\": \"Crohn disease\",\r\n  \"7\": \"Cystic fibrosis\",\r\n  \"8\": \"Diabetes\",\r\n  \"9\": \"Epilepsy\",\r\n  \"10\": \"Heart disease\",\r\n  \"11\": \"HIV/AIDS\",\r\n  \"12\": \"Mental illness (bipolar, cyclothymic, and depression)\",\r\n  \"13\": \"Multiple sclerosis\",\r\n  \"14\": \"Parkinson disease\",\r\n  \"15\": \"None\",\r\n  \"16\": \"Other\"\r\n}',3,'A','','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_rank` */

DROP TABLE IF EXISTS `nxx_rank`;

CREATE TABLE `nxx_rank` (
  `RNK_CODE` varchar(10) NOT NULL,
  `RANK_DESC` varchar(50) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`RNK_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_rank` */

insert  into `nxx_rank`(`RNK_CODE`,`RANK_DESC`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
('TEST','TEST','','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_section` */

DROP TABLE IF EXISTS `nxx_section`;

CREATE TABLE `nxx_section` (
  `SECT_CODE` varchar(15) NOT NULL,
  `SECTION_NAME` varchar(50) NOT NULL,
  `DEPT_CODE` varchar(15) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`SECT_CODE`),
  KEY `DEPT_CODE` (`DEPT_CODE`),
  CONSTRAINT `nxx_section_ibfk_1` FOREIGN KEY (`DEPT_CODE`) REFERENCES `nxx_department` (`DEPT_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_section` */

insert  into `nxx_section`(`SECT_CODE`,`SECTION_NAME`,`DEPT_CODE`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
('TEST','TEST','TEST','','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_teamsched` */

DROP TABLE IF EXISTS `nxx_teamsched`;

CREATE TABLE `nxx_teamsched` (
  `ID` varchar(10) NOT NULL,
  `SCHEDULE` varchar(50) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_teamsched` */

insert  into `nxx_teamsched`(`ID`,`SCHEDULE`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
('TEST','TEST','','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_unit` */

DROP TABLE IF EXISTS `nxx_unit`;

CREATE TABLE `nxx_unit` (
  `UNIT_CODE` varchar(15) NOT NULL,
  `UNIT_NAME` varchar(50) NOT NULL,
  `SECT_CODE` varchar(15) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`UNIT_CODE`),
  KEY `SECT_CODE` (`SECT_CODE`),
  CONSTRAINT `nxx_unit_ibfk_1` FOREIGN KEY (`SECT_CODE`) REFERENCES `nxx_section` (`SECT_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_unit` */

insert  into `nxx_unit`(`UNIT_CODE`,`UNIT_NAME`,`SECT_CODE`,`CREATE_USER`,`CREATE_DATE`,`UPDATE_USER`,`UPDATE_DATE`) values 
('TEST','TEST','TEST','','0000-00-00','','0000-00-00');

/*Table structure for table `nxx_user_role` */

DROP TABLE IF EXISTS `nxx_user_role`;

CREATE TABLE `nxx_user_role` (
  `ACCESSGRPID` int(11) NOT NULL AUTO_INCREMENT,
  `ACCESS_DESC` varchar(10) NOT NULL,
  PRIMARY KEY (`ACCESSGRPID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nxx_user_role` */

insert  into `nxx_user_role`(`ACCESSGRPID`,`ACCESS_DESC`) values 
(1,'TEST');

/*Table structure for table `test_tbl` */

DROP TABLE IF EXISTS `test_tbl`;

CREATE TABLE `test_tbl` (
  `test` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `test_tbl` */

insert  into `test_tbl`(`test`) values 
('test'),
('123');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
