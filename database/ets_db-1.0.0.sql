-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2020 at 03:53 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ets_db`
--
CREATE DATABASE IF NOT EXISTS `ets_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ets_db`;

-- --------------------------------------------------------

--
-- Table structure for table `nets_emp_activity`
--

DROP TABLE IF EXISTS `nets_emp_activity`;
CREATE TABLE `nets_emp_activity` (
  `ACTIVITY_ID` int(11) NOT NULL,
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
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nets_emp_act_participants`
--

DROP TABLE IF EXISTS `nets_emp_act_participants`;
CREATE TABLE `nets_emp_act_participants` (
  `PRTCPNT_ID` int(11) NOT NULL,
  `ACTIVITY_ID` int(11) NOT NULL,
  `EMP_CODE` varchar(10) NOT NULL,
  `STATUS` varchar(11) DEFAULT NULL,
  `STATUS_DATE` date DEFAULT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nets_emp_ehc`
--

DROP TABLE IF EXISTS `nets_emp_ehc`;
CREATE TABLE `nets_emp_ehc` (
  `EHC_ID` int(11) NOT NULL,
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
  `LAST_CHECKED` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nets_emp_hdf`
--

DROP TABLE IF EXISTS `nets_emp_hdf`;
CREATE TABLE `nets_emp_hdf` (
  `HDF_ID` int(11) NOT NULL,
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
  `LAST_CHECKED` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nets_emp_info`
--

DROP TABLE IF EXISTS `nets_emp_info`;
CREATE TABLE `nets_emp_info` (
  `EMP_CODE` varchar(10) NOT NULL,
  `CARD_NO` varchar(8) NOT NULL,
  `RUSH_ID` varchar(8) NOT NULL,
  `EMP_LNAME` varchar(50) NOT NULL,
  `EMP_MNAME` varchar(50) NOT NULL,
  `EMP_FNAME` varchar(50) NOT NULL,
  `DATE_HIRED` date NOT NULL,
  `DATE_EOC` date DEFAULT NULL,
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
  `CIVIL_STAT` varchar(25) DEFAULT NULL,
  `AGE` int(11) NOT NULL,
  `BIRTHDATE` date NOT NULL,
  `GENDER` varchar(10) NOT NULL,
  `TEAM` varchar(5) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nets_emp_info`
--

INSERT INTO `nets_emp_info` (`EMP_CODE`, `CARD_NO`, `RUSH_ID`, `EMP_LNAME`, `EMP_MNAME`, `EMP_FNAME`, `DATE_HIRED`, `DATE_EOC`, `EMP_STAT`, `POS_CODE`, `EMP_LEVEL`, `COMP_CODE`, `LOC_CODE`, `GRP_CODE`, `DEPT_CODE`, `APVL_LVL`, `PRESENT_ADDR1`, `PRESENT_ADDR2`, `PRESENT_CITY`, `PRESENT_PROV`, `PERM_CITY`, `PERM_PROV`, `MOBILE_NO`, `TEL_NO`, `CIVIL_STAT`, `AGE`, `BIRTHDATE`, `GENDER`, `TEAM`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) VALUES
('0', '0', 'IT00', 'Admin', 'Admin', 'Admin', '0000-00-00', '0000-00-00', 'REG', 'FLI_A099', 'EMP001', 'FLI', 'GT', 'ITG', 'BSSD', 0, '221B Baker Street', 'Test Town', 'Update City', 'Update Province', 'Queens', 'New York', '09272821411', '12345678', 'PARTNER', 23, '0000-00-00', 'MALE', 'A\r\n', '', '0000-00-00', 'TEST', '2020-05-11');

-- --------------------------------------------------------

--
-- Table structure for table `nets_emp_user`
--

DROP TABLE IF EXISTS `nets_emp_user`;
CREATE TABLE `nets_emp_user` (
  `USER_ID` int(11) UNSIGNED NOT NULL,
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
  `SENT_HDF_NOTIF` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nets_emp_user`
--

INSERT INTO `nets_emp_user` (`USER_ID`, `EMP_CODE`, `LOGIN_ID`, `EMAIL_ADDRESS`, `PASSWORD`, `ACCESSGRPID`, `STATUS`, `STATUSDATE`, `DATEPWDCHANGED`, `REMARKS`, `LASTLOGINDATE`, `LASTLOGOUTDATE`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`, `SUBMITTED_EHC`, `SUBMITTED_HDF`, `SENT_NOTIF`, `SENT_HDF_NOTIF`) VALUES
(3, '0', 'IT00', 'RAEBACAY@FEDERALLAND.PH', '$2y$10$5Lv35MIeqfBumbGnibEXE.hbamY14PE1CVSKoyuPC.r1C63CDJL1u', 1, 0, '0000-00-00', '2020-05-18', NULL, '2020-05-18', '2020-05-18', '', '0000-00-00', '', '0000-00-00', 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `nets_hdf_chrnc_disease`
--

DROP TABLE IF EXISTS `nets_hdf_chrnc_disease`;
CREATE TABLE `nets_hdf_chrnc_disease` (
  `HDFC_ID` int(11) NOT NULL,
  `ANSKEY` int(11) NOT NULL,
  `EMP_CODE` varchar(10) NOT NULL,
  `DISEASE` varchar(100) NOT NULL,
  `HDF_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nets_hdf_healthdec`
--

DROP TABLE IF EXISTS `nets_hdf_healthdec`;
CREATE TABLE `nets_hdf_healthdec` (
  `HDFHD_ID` int(11) NOT NULL,
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
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nets_hdf_hhold`
--

DROP TABLE IF EXISTS `nets_hdf_hhold`;
CREATE TABLE `nets_hdf_hhold` (
  `HDFHH_ID` int(11) NOT NULL,
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
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nets_hdf_otherinfo`
--

DROP TABLE IF EXISTS `nets_hdf_otherinfo`;
CREATE TABLE `nets_hdf_otherinfo` (
  `HDFOI_ID` int(11) NOT NULL,
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
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nets_hdf_travelhistory`
--

DROP TABLE IF EXISTS `nets_hdf_travelhistory`;
CREATE TABLE `nets_hdf_travelhistory` (
  `HDFTH_ID` int(11) NOT NULL,
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
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nets_visit_log`
--

DROP TABLE IF EXISTS `nets_visit_log`;
CREATE TABLE `nets_visit_log` (
  `VISITOR_ID` int(11) NOT NULL,
  `MEETING_ID` varchar(10) DEFAULT NULL,
  `VISIT_LNAME` varchar(50) NOT NULL,
  `VISIT_FNAME` varchar(50) NOT NULL,
  `VISIT_MNAME` varchar(50) DEFAULT NULL,
  `COMP_NAME` varchar(50) NOT NULL,
  `COMP_ADDRESS` varchar(50) NOT NULL,
  `EMAIL_ADDRESS` varchar(30) NOT NULL,
  `MOBILE_NO` varchar(20) NOT NULL,
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
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nxx_company`
--

DROP TABLE IF EXISTS `nxx_company`;
CREATE TABLE `nxx_company` (
  `COMP_CODE` varchar(20) NOT NULL,
  `COMP_NAME` varchar(35) NOT NULL,
  `ADDRESS` varchar(50) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nxx_company`
--

INSERT INTO `nxx_company` (`COMP_CODE`, `COMP_NAME`, `ADDRESS`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) VALUES
('BLHMC', 'Bonifacio Landmark Hotel Management', '', '', '0000-00-00', '', '0000-00-00'),
('BLRDC', 'Bonifacio Land Realty Development I', '', '', '0000-00-00', '', '0000-00-00'),
('FBRI', 'Federal Brent Retail Inc.\r\n', '', '', '0000-00-00', '', '0000-00-00'),
('FHI', 'Federal Homes Inc. \r\n', '', '', '0000-00-00', '', '0000-00-00'),
('FIDES', 'Fides Insurance\r\n', '', '', '0000-00-00', '', '0000-00-00'),
('FLI', 'Federal Land', '', '', '0000-00-00', '', '0000-00-00'),
('FRH', 'Federal Retail Holdings\r\n', '', '', '0000-00-00', '', '0000-00-00'),
('HLPDC', 'Horizon Land Property Development C', '', '', '0000-00-00', '', '0000-00-00'),
('OOMC', 'Omni Orient Management Corp.\r\n', '', '', '0000-00-00', '', '0000-00-00'),
('SLC', 'Service Leasing Corp.\r\n', '', '', '0000-00-00', '', '0000-00-00'),
('STRC', 'ST 6747 Resources Corporation\r\n', '', '', '0000-00-00', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `nxx_config`
--

DROP TABLE IF EXISTS `nxx_config`;
CREATE TABLE `nxx_config` (
  `id` int(11) UNSIGNED NOT NULL,
  `context` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `value` text NOT NULL,
  `create_on` date NOT NULL,
  `create_by` int(11) UNSIGNED NOT NULL,
  `update_on` date NOT NULL,
  `update_by` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nxx_config`
--

INSERT INTO `nxx_config` (`id`, `context`, `name`, `value`, `create_on`, `create_by`, `update_on`, `update_by`) VALUES
(1, 'core', 'url', '', '0000-00-00', 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nxx_department`
--

DROP TABLE IF EXISTS `nxx_department`;
CREATE TABLE `nxx_department` (
  `DEPT_CODE` varchar(15) NOT NULL,
  `DEPT_NAME` varchar(50) NOT NULL,
  `GRP_CODE` varchar(15) DEFAULT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nxx_department`
--

INSERT INTO `nxx_department` (`DEPT_CODE`, `DEPT_NAME`, `GRP_CODE`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) VALUES
('ACCTG', 'Accounting and Financial Control\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('ACCTG_TAX', 'Tax\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('AUDIT_INFO', 'AUDIT-Informations Systems\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('BBGCR', 'Bay Garden Club and Residences\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('BBW', 'Blue Bay Walk\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('BMGMKTG', 'BMG-Marketing\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('BMG_OPS', 'Commercial Design and Operations\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('BSSD', 'Business Solutions\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('CMGCOMML', 'Commercial Construction\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('CMG_OPS', 'Construction Support\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('CMG_RM', 'Repairs and Maintenance\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('CPW', 'Central Park West\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('DATA', 'Data Center Operations\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('EXEC', 'Executive Office\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FABD', 'Finance and Budget\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FLI_201', 'Finance -Loans and Special Projects\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FLI_A115', 'Technical Planning\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FLI_A143', 'Operations/Compliance Audit\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FLI_A145', 'Technical Audit\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FLI_A177', 'Customer Service\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FLI_A179', 'Sales Administration & Support Services\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FLI_A228', 'Architectural\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FLI_A255', 'Commercial Development\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FLI_A272', 'Contracts Compliance\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FLI_A278', 'Property Administration\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FSE', 'Florida Sun Estates & Oriental Garden Residences\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('FSR', 'Four Season Riviera\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('GCP', 'Grand Central Park\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('GENSERV', 'General Services\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('GHR', 'Grand Hyatt Residences\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('GT', 'GT Tower\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('HO', 'Head Office\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('HR', 'Human Resources\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('IH-CMD', 'In-House Construction Management-NRE\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('iMET', 'iMET\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('INFRA', 'Infrastructure\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('IQS', 'QS and Cost Management\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('LEASE', 'Leasing\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('LEGAL', 'Legal\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('LEGDOC', 'Registration and Titling\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('MBC', 'Metrobank Corporate Tower\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('MEPF', 'MEPF\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('METLive', 'METLive\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('METPark', 'Metropolitan Park\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('MKTGBrand', 'Brand Marketing\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('MKTGComm', 'Marketing Communications\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('MKTGField', 'Field Marketing\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('MPR T1', 'Marco Polo Residences Tower 1\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('MPR T2', 'Marco Polo Residences Tower 2\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('MPR T3', 'Marco Polo Residences Tower 3\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('OGR', 'Oriental Garden Residences\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('OPSPCWR', 'Post Construction Works and Repairs\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('OWS', 'One Wilson Square\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('PBV', 'Palm Beach Villas\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('PDR', 'Paseo de Roces\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('PGMH', 'Peninsula Garden Midtown Homes\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('PLPA', 'Permits and Licenses\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('PPD', 'Product Planning', NULL, '', '0000-00-00', '', '0000-00-00'),
('PROJCONS', 'Project Construction\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('PROPMGT', 'Property Management\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('PURCH', 'Purchasing\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('PW', 'Park West\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('QCD', 'Quality Control\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('RVM', 'Riverview Mansion\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('SALESOPS', 'Sales Operations\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('SALESPLAN', 'Sales Planning\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('SALESREC', 'Sales Talent Acquisition\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('SALESTRAIN', 'Sales Training\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('SSR', 'Six Senses Residences\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('TBA', 'The Big Apple\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('TCT', 'The Capital Towers\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('TCT-Rio', 'The Capital Towers -Rio\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('TGC', 'Tropicana Garden City\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('TGMM', 'The Grand Midori Makati\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('TOP', 'The Oriental Place\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('TPD_PandC', 'TPD_PandC\r\n', NULL, '', '0000-00-00', '', '0000-00-00'),
('TREAS', 'Treasury\r\n', NULL, '', '0000-00-00', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `nxx_empstat`
--

DROP TABLE IF EXISTS `nxx_empstat`;
CREATE TABLE `nxx_empstat` (
  `EMPSTAT_CODE` varchar(10) NOT NULL,
  `EMPSTAT_DESC` varchar(50) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nxx_empstat`
--

INSERT INTO `nxx_empstat` (`EMPSTAT_CODE`, `EMPSTAT_DESC`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) VALUES
('PROBY', 'Proby\r\n', '', '0000-00-00', '', '0000-00-00'),
('PROBY2', 'Proby with Benefits\r\n', '', '0000-00-00', '', '0000-00-00'),
('PROJB', 'Project Based\r\n', '', '0000-00-00', '', '0000-00-00'),
('REG', 'Regular', '', '0000-00-00', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `nxx_group`
--

DROP TABLE IF EXISTS `nxx_group`;
CREATE TABLE `nxx_group` (
  `GRP_CODE` varchar(15) NOT NULL,
  `GRP_NAME` varchar(50) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nxx_group`
--

INSERT INTO `nxx_group` (`GRP_CODE`, `GRP_NAME`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) VALUES
('AUDIT', 'Audit', '', '0000-00-00', '', '0000-00-00'),
('BMG', 'Leasing\r\n', '', '0000-00-00', '', '0000-00-00'),
('CMG', 'Construction Management', '', '0000-00-00', '', '0000-00-00'),
('CSG', 'Purchasing', '', '0000-00-00', '', '0000-00-00'),
('CUSG', 'Customer Engagement', '', '0000-00-00', '', '0000-00-00'),
('EXEC', 'Executive Office\r\n', '', '0000-00-00', '', '0000-00-00'),
('FG', 'Finance\r\n', '', '0000-00-00', '', '0000-00-00'),
('HR', 'Human Resources\r\n', '', '0000-00-00', '', '0000-00-00'),
('IQS', 'QS and Cost Management\r\n', '', '0000-00-00', '', '0000-00-00'),
('ITG', 'Information Technology\r\n', '', '0000-00-00', '', '0000-00-00'),
('LG', 'Legal\r\n', '', '0000-00-00', '', '0000-00-00'),
('MKTG', 'Marketing\r\n', '', '0000-00-00', '', '0000-00-00'),
('OPSG', 'Operations\r\n', '', '0000-00-00', '', '0000-00-00'),
('PDG', 'Project Development\r\n', '', '0000-00-00', '', '0000-00-00'),
('PMG', 'Property Management\r\n', '', '0000-00-00', '', '0000-00-00'),
('SMG', 'Sales\r\n', '', '0000-00-00', '', '0000-00-00'),
('SPACCTG', 'Special Accounting-FHI\r\n', '', '0000-00-00', '', '0000-00-00'),
('TWNSHP', 'MetPark and GCP Township\r\n', '', '0000-00-00', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `nxx_hdf_ctemp`
--

DROP TABLE IF EXISTS `nxx_hdf_ctemp`;
CREATE TABLE `nxx_hdf_ctemp` (
  `CTEMP_ID` int(11) NOT NULL,
  `CUTOFF_ID` int(11) NOT NULL,
  `EMP_CODE` varchar(10) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nxx_hdf_cutoff`
--

DROP TABLE IF EXISTS `nxx_hdf_cutoff`;
CREATE TABLE `nxx_hdf_cutoff` (
  `CUTOFFID` int(11) NOT NULL,
  `EMP_FLAG` int(11) NOT NULL,
  `SUBMISSION_DATE` date NOT NULL,
  `CUTOFF_TIME` time NOT NULL,
  `ANS_FLAG` int(11) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nxx_location`
--

DROP TABLE IF EXISTS `nxx_location`;
CREATE TABLE `nxx_location` (
  `LOC_CODE` varchar(20) NOT NULL,
  `LOCATION_NAME` varchar(35) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nxx_location`
--

INSERT INTO `nxx_location` (`LOC_CODE`, `LOCATION_NAME`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) VALUES
('AXA', 'Phil Axa Life Center\r\n', '', '0000-00-00', '', '0000-00-00'),
('BBGCR', 'Bay Garden Club and Residences\r\n', '', '0000-00-00', '', '0000-00-00'),
('BBW', 'Blue Bay Walk\r\n', '', '0000-00-00', '', '0000-00-00'),
('CPW', 'Central Park West\r\n', '', '0000-00-00', '', '0000-00-00'),
('FSE', 'Florida Sun Estates & Oriental Gard', '', '0000-00-00', '', '0000-00-00'),
('FSR', 'Four Season Riviera\r\n', '', '0000-00-00', '', '0000-00-00'),
('GCP', 'Grand Central Park\r\n', '', '0000-00-00', '', '0000-00-00'),
('GH', 'Grand Hyatt Hotel/BGC\r\n', '', '0000-00-00', '', '0000-00-00'),
('GHR', 'Grand Hyatt Residences\r\n', '', '0000-00-00', '', '0000-00-00'),
('GT', 'GT Tower', '', '0000-00-00', '', '0000-00-00'),
('HO', 'Head Office\r\n', '', '0000-00-00', '', '0000-00-00'),
('iMET', 'iMET\r\n', '', '0000-00-00', '', '0000-00-00'),
('LPRC', 'Le Parc / Bluebay \r\n', '', '0000-00-00', '', '0000-00-00'),
('MBC', 'Metrobank Corporate Tower\r\n', '', '0000-00-00', '', '0000-00-00'),
('METLive', 'METLive\r\n', '', '0000-00-00', '', '0000-00-00'),
('METPark', 'Metropolitan Park\r\n', '', '0000-00-00', '', '0000-00-00'),
('MMPROJ', 'Metro Manila Project Site\r\n', '', '0000-00-00', '', '0000-00-00'),
('MPR', 'Marco Polo Cebu\r\n', '', '0000-00-00', '', '0000-00-00'),
('MPR T1', 'Marco Polo Residences Tower 1\r\n', '', '0000-00-00', '', '0000-00-00'),
('MPR T2', 'Marco Polo Residences Tower 2\r\n', '', '0000-00-00', '', '0000-00-00'),
('MPR T3', 'Marco Polo Residences Tower 3\r\n', '', '0000-00-00', '', '0000-00-00'),
('OGM', 'OGM\r\n', '', '0000-00-00', '', '0000-00-00'),
('OGR', 'Oriental Garden Residences\r\n', '', '0000-00-00', '', '0000-00-00'),
('OWS', 'One Wilson Square\r\n', '', '0000-00-00', '', '0000-00-00'),
('PBV', 'Palm Beach Villas\r\n', '', '0000-00-00', '', '0000-00-00'),
('PDR', 'Paseo de Roces\r\n', '', '0000-00-00', '', '0000-00-00'),
('PGMH', 'Peninsula Garden Midtown Homes\r\n', '', '0000-00-00', '', '0000-00-00'),
('PROVPROJ', 'Provincial Project Site\r\n', '', '0000-00-00', '', '0000-00-00'),
('PRW', 'Park West Office / BGC\r\n', '', '0000-00-00', '', '0000-00-00'),
('PW', 'Park West\r\n', '', '0000-00-00', '', '0000-00-00'),
('RVM', 'Riverview Mansion\r\n', '', '0000-00-00', '', '0000-00-00'),
('SSR', 'Six Senses Residences\r\n', '', '0000-00-00', '', '0000-00-00'),
('TBA', 'The Big Apple\r\n', '', '0000-00-00', '', '0000-00-00'),
('TCT', 'The Capital Towers\r\n', '', '0000-00-00', '', '0000-00-00'),
('TCT-Rio', 'The Capital Towers -Rio\r\n', '', '0000-00-00', '', '0000-00-00'),
('TGC', 'Tropicana Garden City\r\n', '', '0000-00-00', '', '0000-00-00'),
('TGMM', 'The Grand Midori Makati\r\n', '', '0000-00-00', '', '0000-00-00'),
('TOP', 'The Oriental Place\r\n', '', '0000-00-00', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `nxx_position`
--

DROP TABLE IF EXISTS `nxx_position`;
CREATE TABLE `nxx_position` (
  `POS_CODE` varchar(15) NOT NULL,
  `POS_DESC` varchar(50) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nxx_position`
--

INSERT INTO `nxx_position` (`POS_CODE`, `POS_DESC`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) VALUES
('BLHMC_001', 'BLHMC Receptionist', '', '0000-00-00', '', '0000-00-00'),
('BLHMC_002', 'BLHMC President', '', '0000-00-00', '', '0000-00-00'),
('BLHMC_003', 'BLHMC Executive Secretary', '', '0000-00-00', '', '0000-00-00'),
('BRENT019', 'Supervisor', '', '0000-00-00', '', '0000-00-00'),
('BRENT020', 'Manager', '', '0000-00-00', '', '0000-00-00'),
('BRENT021', 'Department Head', '', '0000-00-00', '', '0000-00-00'),
('BRENT022', 'Operations Head', '', '0000-00-00', '', '0000-00-00'),
('BRENT023', 'Divison Head', '', '0000-00-00', '', '0000-00-00'),
('CMG_COSA', 'Construction Operations Support Assistant', '', '0000-00-00', '', '0000-00-00'),
('FIDES035', 'Fides Escorts & Guards', '', '0000-00-00', '', '0000-00-00'),
('FLI031', 'Technical Planning Department Head - Residential', '', '0000-00-00', '', '0000-00-00'),
('FLI032', 'Business Manager, Cebu', '', '0000-00-00', '', '0000-00-00'),
('FLI033', 'Digital Marketing Officer/Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_013', 'Client Relations Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_043', 'Interior Designer', '', '0000-00-00', '', '0000-00-00'),
('FLI_120', 'Construction Management Operations Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_121', 'Construction Management Head for NRE Sunshine Fort', '', '0000-00-00', '', '0000-00-00'),
('FLI_122', 'QS Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_280', 'Marketing Services Team Lead', '', '0000-00-00', '', '0000-00-00'),
('FLI_A001', 'Accounting Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A002', 'Administrative Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A0022', 'Customer Fulfillment Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A0025', 'Customer Service Representative- Turnover', '', '0000-00-00', '', '0000-00-00'),
('FLI_A003', 'Architect', '', '0000-00-00', '', '0000-00-00'),
('FLI_A004', 'Asset Administrator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A005', 'Assistant Project Architect', '', '0000-00-00', '', '0000-00-00'),
('FLI_A006', 'Assistant Project Interior Designer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A007', 'Audit Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A008', 'Billings and Collections Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A009', 'Budget and Finance Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A010', 'Business & Finance Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A011', 'Business Development Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A012', 'Business Systems Analyst', '', '0000-00-00', '', '0000-00-00'),
('FLI_A014', 'Client Support Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A015', 'Compensation & Benefits Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A016', 'Contracts Compliance Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A017', 'Corporate Talent Acquisition Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A018', 'Cost Accountant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A019', 'Credit and Collection Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A020', 'Customer Care Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A021', 'Customer Care Representative', '', '0000-00-00', '', '0000-00-00'),
('FLI_A023', 'Customer Relations Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A024', 'Customer Service Representative', '', '0000-00-00', '', '0000-00-00'),
('FLI_A026', 'Data Control Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A027', 'Database Administrator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A028', 'Documentation Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A029', 'Documentation Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A030', 'Documentation Support', '', '0000-00-00', '', '0000-00-00'),
('FLI_A031', 'Electrical Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A032', 'Executive Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A034', 'Field Activation Specialist', '', '0000-00-00', '', '0000-00-00'),
('FLI_A035', 'Filing Clerk', '', '0000-00-00', '', '0000-00-00'),
('FLI_A036', 'Financial Analyst', '', '0000-00-00', '', '0000-00-00'),
('FLI_A037', 'Firewall and Network Security Administrator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A038', 'Fulfillment Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A039', 'General Manager / Chief Operating Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A040', 'GL Analyst', '', '0000-00-00', '', '0000-00-00'),
('FLI_A041', 'Graphic Designer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A042', 'Group Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A044', 'Inventory Administrator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A045', 'IT Helpdesk Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A047', 'Junior Architect', '', '0000-00-00', '', '0000-00-00'),
('FLI_A048', 'Junior Interior Designer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A049', 'Leasing Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A050', 'Leasing Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A051', 'Legal Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A052', 'Legal Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A053', 'Loans Management Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A055', 'Marketing Analyst', '', '0000-00-00', '', '0000-00-00'),
('FLI_A056', 'Marketing Coordinator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A057', 'Marketing Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A058', 'Mechanical Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A059', 'Non-Technical Buyer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A060', 'Office Administrator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A061', 'Paralegal', '', '0000-00-00', '', '0000-00-00'),
('FLI_A062', 'Planning & Control Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A063', 'Product Planning Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A064', 'Product Planning Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A066', 'Preventive Maintenance Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A067', 'Project Architect', '', '0000-00-00', '', '0000-00-00'),
('FLI_A069', 'Project Control Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A070', 'Project Development Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A071', 'Project Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A072', 'Project Financial Analyst', '', '0000-00-00', '', '0000-00-00'),
('FLI_A073', 'Project Intern', '', '0000-00-00', '', '0000-00-00'),
('FLI_A074', 'Project Planning and Control Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A075', 'Purchasing Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A076', 'QS Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A077', 'Quality Inspector', '', '0000-00-00', '', '0000-00-00'),
('FLI_A078', 'Quality Management Specialist', '', '0000-00-00', '', '0000-00-00'),
('FLI_A080', 'Quantity Surveyor', '', '0000-00-00', '', '0000-00-00'),
('FLI_A082', 'Safety Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A083', 'Sales Negotiation Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A084', 'Sales Offices/Showroom Administrator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A085', 'Data Research Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A086', 'Sales Reservation Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A087', 'Sales Support Services Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A088', 'Sales Talent Acquisition Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A089', 'Sales Training Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A090', 'Sales Training Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A091', 'SAP Programmer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A092', 'Secretary', '', '0000-00-00', '', '0000-00-00'),
('FLI_A093', 'Senior Graphics Designer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A095', 'Senior Project Architect', '', '0000-00-00', '', '0000-00-00'),
('FLI_A097', 'Senior Landscape Architect', '', '0000-00-00', '', '0000-00-00'),
('FLI_A098', 'Senior Process Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A099', 'Systems Administrator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A100', 'Systems Functions Analyst', '', '0000-00-00', '', '0000-00-00'),
('FLI_A101', 'Technical Buyer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A102', 'Technical Coordinator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A103', 'Training And Employee Relations Assocaite', '', '0000-00-00', '', '0000-00-00'),
('FLI_A104', 'Treasury Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A105', 'Corporate Talent Acquisition Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A106', 'Web Designer/Administrator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A107', 'Contracts and Turnover Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A108', 'Condominium Maintenance Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A110', 'Communications Specialist', '', '0000-00-00', '', '0000-00-00'),
('FLI_A114', 'Project in Charge', '', '0000-00-00', '', '0000-00-00'),
('FLI_A117', 'Junior Landscape Architect', '', '0000-00-00', '', '0000-00-00'),
('FLI_A118', 'Tax Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A119', 'Subsidiaries Accountant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A120', 'Sales Talent Acquisition and Retention Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A122', 'Data Center Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A123', 'Data Center Operations Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A124', 'Compensation and Benefits Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A126', 'Legal Documentation Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A127', 'Consolidation Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A128', 'JV Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A129', 'ABAP Programmer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A130', 'Customer Care Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A131', 'General Services Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A132', 'Project Director', '', '0000-00-00', '', '0000-00-00'),
('FLI_A133', 'Product Planning Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A134', 'Senior ABAP Programmer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A135', 'Legal Counsel', '', '0000-00-00', '', '0000-00-00'),
('FLI_A136', 'Digital Designer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A137', 'Product Planning Specialist', '', '0000-00-00', '', '0000-00-00'),
('FLI_A139', 'Senior PD Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A140', 'PD Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A141', 'Repairs and Maintenance Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A142', 'Fit Out Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A146', 'SEO and Digital Media Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A147', 'Corporate Talent Acquisition Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A148', 'Business Development Analyst', '', '0000-00-00', '', '0000-00-00'),
('FLI_A149', 'Logistics Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A150', 'Senior Finance Asst', '', '0000-00-00', '', '0000-00-00'),
('FLI_A151', 'Tax Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A152', 'Business Solutions Dept Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A153', 'Customer Care Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A154', 'Project Manager (Multiplatform)', '', '0000-00-00', '', '0000-00-00'),
('FLI_A155', 'Social Media and Content Marketing Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A156', 'Multi-Platform Programmer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A157', 'Project Manager (Specialized)', '', '0000-00-00', '', '0000-00-00'),
('FLI_A158', 'Product Development Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A159', 'Design Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A160', 'Safety Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A161', 'Product Planning And Control Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A162', 'Office Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A163', 'Project Cost Analyst', '', '0000-00-00', '', '0000-00-00'),
('FLI_A164', 'Commercial Development Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A165', 'Tax Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A166', 'Project Interior Designer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A167', 'Repairs and Maintenance Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A168', 'Document Controller', '', '0000-00-00', '', '0000-00-00'),
('FLI_A169', 'Design Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A171', 'Sales Support Services Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A172', 'Accounting Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A173', 'Quality Control Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A174', 'General Services Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A175', 'Senior QS Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A176', 'Purchasing Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A177', 'Internal Audit Group Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A178', 'Financial Controller, Head Accounting and Financia', '', '0000-00-00', '', '0000-00-00'),
('FLI_A179', 'Finance Group Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A180', 'Contracts Processing Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A181', 'Project Area Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A182', 'Audit Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A183', 'Records Management Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A184', 'Compensation and Benefits Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A185', 'Credit and Collection Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A186', 'Credit and Collection Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A187', 'Customer Engagement Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A188', 'Disbursement Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A189', 'Finance Manager- Loans and Special Projects', '', '0000-00-00', '', '0000-00-00'),
('FLI_A190', 'Financial Reporting Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A193', 'Inbound/Fulfillment Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A194', 'Internal QS Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A196', 'Loans Management Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A197', 'MEPF Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A198', 'Permits and Safety Manager- SAM', '', '0000-00-00', '', '0000-00-00'),
('FLI_A199', 'Product Planning and Control Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A200', 'Project Construction Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A201', 'Project Documentation and Coordination Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A202', 'Project Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A203', 'Property Admin Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A206', 'Quality Control Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A207', 'Repairs and Maintenance Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A208', 'Sales Administration Manager', '', '0000-00-00', '', '0000-00-00'),
('FLi_A209', 'SAP Billing Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A210', 'Senior Leasing Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A211', 'Senior Product Development Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A212', 'Special Projects- Architectural/Finishing Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A213', 'Training And Employee Relations Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A214', 'Treasury Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A215', 'Treasury Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A216', 'Senior QS', '', '0000-00-00', '', '0000-00-00'),
('FLI_A217', 'Teal Lead- QS', '', '0000-00-00', '', '0000-00-00'),
('FLI_A218', 'Social Media and Database Specialist', '', '0000-00-00', '', '0000-00-00'),
('FLI_A219', 'Senior Quantity Surveyor', '', '0000-00-00', '', '0000-00-00'),
('FLI_A220', 'Quality Management Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A221', 'Content Writer and Research Specialist', '', '0000-00-00', '', '0000-00-00'),
('FLI_A223', 'Contracts Compliance Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A225', 'Courier Service Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A226', 'Infrastructure and Support Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A227', 'Permits and Turnover Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A229', 'Legal Counsel II', '', '0000-00-00', '', '0000-00-00'),
('FLI_A230', 'Customer Support and Services Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A231', 'Senior Loans Management & Special Accounts Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A232', 'Project Documentation Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A233', 'Senior Product Marketing Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A234', 'Landscape Architect', '', '0000-00-00', '', '0000-00-00'),
('FLI_A235', 'Technical Audit Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A236', 'Project Marketing Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A237', 'Network and Communications Administrator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A238', 'Coordinator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A239', 'Customer Care Concierge', '', '0000-00-00', '', '0000-00-00'),
('FLI_A240', 'Post Construction Works and Repairs Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A241', 'Land Acquisition and Socialized Housing Compliance', '', '0000-00-00', '', '0000-00-00'),
('FLI_A242', 'Sales Administration Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A243', 'Systems and Reports Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A244', 'Senior Structural Engineer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A245', 'Punchlist Response Team Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A246', 'Punchlist Response Team Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A247', 'Systems and Methods Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A248', 'Leasing Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A249', 'Client Relations Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A250', 'Subsidiaries Accounting Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A251', 'Unit Administrator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A252', 'Inbound Customer Care Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A253', 'Senior Project Interior Designer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A254', 'Project in Charge (Project Based)', '', '0000-00-00', '', '0000-00-00'),
('FLI_A256', 'Permits, Licenses and Property Admin Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A257', 'Training and Employee Relations Specialist', '', '0000-00-00', '', '0000-00-00'),
('FLI_A259', 'Central Material Controller', '', '0000-00-00', '', '0000-00-00'),
('FLI_A260', 'Quality Control Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A261', 'Quality Assurance Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A262', 'SAP Billing Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A263', 'HLURB Permitting & Property Administration Asst.', '', '0000-00-00', '', '0000-00-00'),
('FLI_A264', 'Project Development Business Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A265', 'Training and ER Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A266', 'Lead Architect', '', '0000-00-00', '', '0000-00-00'),
('FLI_A267', 'Junior Network & Communications Administrator', '', '0000-00-00', '', '0000-00-00'),
('FLI_A268', 'Contracts Compliance Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A269', 'Technical Audit Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A270', 'Loans Associate', '', '0000-00-00', '', '0000-00-00'),
('FLI_A271', 'Loans Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A277', 'Product Marketing Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_A278', 'Asset Management Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A279', 'Tester', '', '0000-00-00', '', '0000-00-00'),
('FLI_A281', 'Site Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A282', 'Contracts Review Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A283', 'Events Planner', '', '0000-00-00', '', '0000-00-00'),
('FLI_A284', 'Township Executive Assistant', '', '0000-00-00', '', '0000-00-00'),
('FLI_A285', 'Customer Support Services Officer', '', '0000-00-00', '', '0000-00-00'),
('FLI_A286', 'Customer Payment and Collections Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_A288', 'Leasing and Marketing Manager', '', '0000-00-00', '', '0000-00-00'),
('FLI_CJO31', 'Sales Channel Head Brokers', '', '0000-00-00', '', '0000-00-00'),
('FLI_SO14_2', 'Compliance and Risk Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_SO258', 'FLI Group Property Management Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_SO259', 'External Construction Management Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_SO260', 'Sales Activation Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_SO261', 'FLI Sales Group Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_SO262', 'Brand Management Head', '', '0000-00-00', '', '0000-00-00'),
('FLI_SO31', 'Sales Channel Head FSG', '', '0000-00-00', '', '0000-00-00'),
('FPMC001', 'Facilities Manager', '', '0000-00-00', '', '0000-00-00'),
('FSELL024', 'Property Consultant', '', '0000-00-00', '', '0000-00-00'),
('FSELL025', 'Sr. Property Consultant', '', '0000-00-00', '', '0000-00-00'),
('FSELL026', 'Assistant Sales Manager', '', '0000-00-00', '', '0000-00-00'),
('FSELL027', 'Sales Manager', '', '0000-00-00', '', '0000-00-00'),
('FSELL028', 'Director of Sales Manager', '', '0000-00-00', '', '0000-00-00'),
('FSELL029', 'Sr. Director of Sales Manager', '', '0000-00-00', '', '0000-00-00'),
('FSELL030', 'Assistant Group Sales Manager', '', '0000-00-00', '', '0000-00-00'),
('FSELL031', 'Group Sales Manager', '', '0000-00-00', '', '0000-00-00'),
('FSELL032', 'Sr. Group Sales Manager', '', '0000-00-00', '', '0000-00-00'),
('FSELL033', 'Division Head', '', '0000-00-00', '', '0000-00-00'),
('FSELL034', 'Vice President', '', '0000-00-00', '', '0000-00-00'),
('HLPDC_B05', 'Broker Operations Head', '', '0000-00-00', '', '0000-00-00'),
('HLPDC_S06', 'Sales Manager', '', '0000-00-00', '', '0000-00-00'),
('HLPDC_S07', 'Sales Div Head/Group Sales Manager', '', '0000-00-00', '', '0000-00-00'),
('HLPDC_S08', 'Sr. Group Sales Manager', '', '0000-00-00', '', '0000-00-00'),
('J023', 'Corporate and FLI Group Human Resources Head', '', '0000-00-00', '', '0000-00-00'),
('JC003', 'Clerk', '', '0000-00-00', '', '0000-00-00'),
('JC004', 'Assistant 1', '', '0000-00-00', '', '0000-00-00'),
('JC005', 'Assistant 2', '', '0000-00-00', '', '0000-00-00'),
('JC006', 'Senior Assistant', '', '0000-00-00', '', '0000-00-00'),
('JC007', 'Junior Assistant Manager', '', '0000-00-00', '', '0000-00-00'),
('JC008', 'Assistant Manager', '', '0000-00-00', '', '0000-00-00'),
('JC009', 'Senior Assistant Manager', '', '0000-00-00', '', '0000-00-00'),
('JC010', 'Manager', '', '0000-00-00', '', '0000-00-00'),
('JC011', 'Senior Manager', '', '0000-00-00', '', '0000-00-00'),
('JC012', 'Assistant Vice President', '', '0000-00-00', '', '0000-00-00'),
('JC013', 'Vice President', '', '0000-00-00', '', '0000-00-00'),
('JC014', 'First Vice President', '', '0000-00-00', '', '0000-00-00'),
('JC015', 'Senior Vice President', '', '0000-00-00', '', '0000-00-00'),
('JC016', 'Executive Vice President', '', '0000-00-00', '', '0000-00-00'),
('JC017', 'Executive Vice President / General Manager', '', '0000-00-00', '', '0000-00-00'),
('JC018', 'President', '', '0000-00-00', '', '0000-00-00'),
('JC019', 'Chairman', '', '0000-00-00', '', '0000-00-00'),
('JC020', 'Secretary 1', '', '0000-00-00', '', '0000-00-00'),
('JC021', 'Secretary 2', '', '0000-00-00', '', '0000-00-00'),
('JC022', 'Secretary 3', '', '0000-00-00', '', '0000-00-00'),
('JC023', 'IT Group Head', '', '0000-00-00', '', '0000-00-00'),
('JC024', 'Executive Assistant to the Chairman', '', '0000-00-00', '', '0000-00-00'),
('JC025', 'Construction Management Group Head', '', '0000-00-00', '', '0000-00-00'),
('JC026', 'Sales and Marketing Group Head', '', '0000-00-00', '', '0000-00-00'),
('JC027', 'Operations Group Head', '', '0000-00-00', '', '0000-00-00'),
('JC028', 'Customer Service Head', '', '0000-00-00', '', '0000-00-00'),
('JC029', 'Planning and Control Head', '', '0000-00-00', '', '0000-00-00'),
('JC030', 'Product Planning Head - Horizon', '', '0000-00-00', '', '0000-00-00'),
('JC031', 'Sales Operations Head', '', '0000-00-00', '', '0000-00-00'),
('JO025', 'GM for Joint Venture Project', '', '0000-00-00', '', '0000-00-00'),
('OOMC01', 'Admin Assistant', '', '0000-00-00', '', '0000-00-00'),
('OOMC02', 'Secretary', '', '0000-00-00', '', '0000-00-00'),
('OOMC03', 'Property Engineer', '', '0000-00-00', '', '0000-00-00'),
('OOMC04', 'Property Manager', '', '0000-00-00', '', '0000-00-00'),
('OOMC05', 'Start Up Manager', '', '0000-00-00', '', '0000-00-00'),
('OOMC06', 'Finance and Accounting Sup', '', '0000-00-00', '', '0000-00-00'),
('OOMC07', 'Admin Officer', '', '0000-00-00', '', '0000-00-00'),
('OOMC08', 'Technical Head', '', '0000-00-00', '', '0000-00-00'),
('OOMC09', 'Architect', '', '0000-00-00', '', '0000-00-00'),
('OOMC10', 'Operations Assistant', '', '0000-00-00', '', '0000-00-00'),
('OOMC11', 'Sr. Tech Assistant', '', '0000-00-00', '', '0000-00-00'),
('OOMC12', 'Accounting Assistant', '', '0000-00-00', '', '0000-00-00'),
('OOMC13', 'Billing and Collections Asst', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A001', 'Accounting Associate', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A002', 'Senior Facilities Manager', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A003', 'Shift Facilities Engineer', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A004', 'Property Accountant', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A005', 'Receptionist', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A006', 'Operations Manager', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A007', 'Finance Officer', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A008', 'Technician', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A009', 'Technical Engineer', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A010', 'Mall Engineer', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A011', 'Senior Property Manager', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A012', 'Shift Engineer', '', '0000-00-00', '', '0000-00-00'),
('OOMC_A013', 'Mall Manager', '', '0000-00-00', '', '0000-00-00'),
('SLC036', 'SLC Escorts & Guards', '', '0000-00-00', '', '0000-00-00'),
('START', 'Sales Talent Acquisition Head', '', '0000-00-00', '', '0000-00-00'),
('STRC_A092', 'STRC Secretary', '', '0000-00-00', '', '0000-00-00'),
('STRC_A132', 'STRC Project Director', '', '0000-00-00', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `nxx_questionnaire`
--

DROP TABLE IF EXISTS `nxx_questionnaire`;
CREATE TABLE `nxx_questionnaire` (
  `QCODE` int(11) NOT NULL,
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
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nxx_questionnaire`
--

INSERT INTO `nxx_questionnaire` (`QCODE`, `TRANSACTION`, `SEQUENCE`, `PARENT_ID`, `QUESTION`, `POSS_ANSWER`, `TYPE`, `STATUS`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) VALUES
(1, 'EHC', 1, NULL, 'What is your body temperature? (i.e. 37.5)', '', 1, 'A', '', '0000-00-00', '', '0000-00-00'),
(2, 'EHC', 2, NULL, 'Are you feeling sick today?', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(3, 'EHC', 3, NULL, 'Do you have the following  sickness/symptoms?', '{\r\n  \"1\": \"Dry Cough\",\r\n  \"2\": \"Sore throat\",\r\n  \"3\": \"Colds\",\r\n  \"4\": \"Shortness of breath\",\r\n  \"5\": \"Diarrhea\",\r\n  \"6\": \"Nausea or vomiting\",\r\n  \"7\": \"Headache\",\r\n  \"8\": \"Muscle pain and weakness\",\r\n  \"9\": \"Decreased ability to smell\",\r\n  \"10\": \"Decreased ability to taste\",\r\n  \"11\": \"None\",\r\n  \"12\": \"Others\"\r\n}', 3, 'A', '', '0000-00-00', '', '0000-00-00'),
(4, 'EHC', 4, NULL, 'Did you travel outside of your home?', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(5, 'EHC', 5, NULL, 'Did you have any close contact with positive CoViD?', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(6, 'HDFHH', 1, NULL, 'Type of current residence', '{\r\n  \"1\": \"Residential House\",\r\n  \"2\": \"Townhouse\",\r\n  \"3\": \"Bed space\",\r\n  \"4\": \"Apartment/Condo\",\r\n  \"5\": \"Boarding House\",\r\n  \"6\": \"Others\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(7, 'HDFHH', 2, NULL, 'If renting, please specify how often do you go home to your permanent address', '', 1, 'A', '', '0000-00-00', '', '0000-00-00'),
(8, 'HDFHH', 3, NULL, 'Total number of person in your household (number in figures) ex. 8\r\n', '', 2, 'A', '', '0000-00-00', '', '0000-00-00'),
(9, 'HDFHH', 4, NULL, 'Number of person in your household  with ages 51 and above (number in figures)\r\n', '', 2, 'A', '', '0000-00-00', '', '0000-00-00'),
(30, 'HDFHH', 6, NULL, 'Do you share room with others?\r\n', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(31, 'HDFHD', 1, NULL, 'Have you experienced having a fever in the last 14 days? \r\n', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(33, 'HDFTH', 1, NULL, 'Travelled from a geographic location/country with documented cases of COVID19? \r\n', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(34, 'HDFTH', 2, NULL, 'Do you have a scheduled trip abroad or local for the next 3 months?\r\n', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(35, 'HDFTH', 3, NULL, 'Close contact to a PUI or confirmed case of the disease (COVID 19)? \r\n', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(36, 'HDFTH', 4, NULL, 'History of visit to a HEALTHCARE facility in a geographic location/country where documented cases of COVID19 have been reported? \r\n', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(37, 'HDFOI', 1, NULL, 'Exposure with patients who are Probable COVID-19 patients who are awaiting results.\r\n', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(38, 'HDFOI', 2, NULL, 'Exposure from Relatives or Friends with recent travel to location/country with documented cases of COVID19 and/or had direct exposure with confirmed COVID19 case? \r\n', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(39, 'HDFOI', 3, NULL, 'Any Signs/Symptoms experienced by the person/s?', '{\r\n  \"1\": \"Dry Cough\",\r\n  \"2\": \"Sore throat\",\r\n  \"3\": \"Colds\",\r\n  \"4\": \"Shortness of breath\",\r\n  \"5\": \"Diarrhea\",\r\n  \"6\": \"Nausea or vomiting\",\r\n  \"7\": \"Headache\",\r\n  \"8\": \"Muscle pain and weakness\",\r\n  \"9\": \"Decreased ability to smell\",\r\n  \"10\": \"Decreased ability to taste\",\r\n  \"11\": \"None\",\r\n  \"12\": \"Others\"\r\n}', 3, 'A', '', '0000-00-00', '', '0000-00-00'),
(40, 'HDFOI', 4, NULL, 'Have you recently traveled to an area with known local spread of Covid-19  (e.g. hospital, supermarket, drug store, bank, market and etc)\r\n', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(41, 'HDFOI', 5, NULL, 'Are there any frontliners in your household?\r\n', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(42, 'HDFOI', 6, NULL, 'How often do you or your family member go out for i.e. for grocery shopping etc.\r\n', '{\r\n  \"1\": \"Everyday\",\r\n  \"2\": \"Twice a week\",\r\n  \"3\": \"Once a week\",\r\n  \"4\": \"Others\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(43, 'HDFOI', 7, NULL, 'Who often goes out of the house?\r\n', '', 1, 'A', '', '0000-00-00', '', '0000-00-00'),
(44, 'HDFHD', 2, NULL, 'What medications did you take?\r\n', '', 1, 'A', '', '0000-00-00', '', '0000-00-00'),
(45, 'HDFHD', 3, NULL, 'Many people during their lifetime will experience or be treated for medical conditions. Please let us know which of the following you have had, or been told you had, or sought advice or treatment for:', '{\r\n  \"1\": \"High blood pressure, chest pain/discomfort, heart murmur, rheumatic fever, stroke, aneurysm, circulatory or heart disorder?\",\r\n  \"2\": \"Diabetes, sugar in the urine, thyroid or other glandular (endocrine) disorder?\",\r\n  \"3\": \"Kidney, bladder, or urinary disorder/infection, Sexual Transmitted Disease, reproductive organ or prostate disorder?\",\r\n  \"4\": \"Disorders of the skin pigmentation, enlarged glands or lymph nodes, nodules, polyps, cysts, lumps, tumor, mass, abdominal growth, cancer, malignancy or any related conditions?\",\r\n  \"5\": \"Asthma, chronic cough, pneumonia, tuberculosis, emphysema, or any other respiratory or lung disorder?\",\r\n  \"6\": \"Gross obesity greater than 30\",\r\n  \"7\": \"Diagnosed with immunodeficiency disorder\",\r\n  \"8\": \"None\",\r\n  \"9\": \"Other\"\r\n}\r\n', 3, 'A', '', '0000-00-00', '', '0000-00-00'),
(46, 'HDFHD', 4, NULL, 'For the past 6 months, have you consulted a medical doctor or been referred for tests or investigation or had any medical test?\r\n', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(47, 'HDFHD', 5, NULL, 'Do you have any health symptoms, recurring or persistent pains, or complaints for which physician has not been consulted or treatment has not been received?', '{\r\n  \"1\": \"Yes\",\r\n  \"2\": \"No\"\r\n}', 4, 'A', '', '0000-00-00', '', '0000-00-00'),
(48, 'HDFHH', 5, NULL, 'Do you live with someone diagnosed with chronic diseases? Please choose on the following:\r\n', '{\r\n  \"1\": \"Alzheimer disease and dementia\",\r\n  \"2\": \"Arthritis\",\r\n  \"3\": \"Asthma\",\r\n  \"4\": \"Cancer\",\r\n  \"5\": \"Chronic obstructive pulmonary disease(COPD)\",\r\n  \"6\": \"Crohn disease\",\r\n  \"7\": \"Cystic fibrosis\",\r\n  \"8\": \"Diabetes\",\r\n  \"9\": \"Epilepsy\",\r\n  \"10\": \"Heart disease\",\r\n  \"11\": \"HIV/AIDS\",\r\n  \"12\": \"Mental illness (bipolar, cyclothymic, and depression)\",\r\n  \"13\": \"Multiple sclerosis\",\r\n  \"14\": \"Parkinson disease\",\r\n  \"15\": \"None\",\r\n  \"16\": \"Other\"\r\n}', 3, 'A', '', '0000-00-00', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `nxx_rank`
--

DROP TABLE IF EXISTS `nxx_rank`;
CREATE TABLE `nxx_rank` (
  `RNK_CODE` varchar(10) NOT NULL,
  `RANK_DESC` varchar(50) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nxx_rank`
--

INSERT INTO `nxx_rank` (`RNK_CODE`, `RANK_DESC`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) VALUES
('EMP001', 'Rank and File\r\n', '', '0000-00-00', '', '0000-00-00'),
('EMP002', 'Junior Officer\r\n', '', '0000-00-00', '', '0000-00-00'),
('EMP003', 'Senior Officer\r\n', '', '0000-00-00', '', '0000-00-00'),
('EMP004', 'Consultant\r\n', '', '0000-00-00', '', '0000-00-00'),
('EMP005', 'Confi Junior Officer\r\n', '', '0000-00-00', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `nxx_section`
--

DROP TABLE IF EXISTS `nxx_section`;
CREATE TABLE `nxx_section` (
  `SECT_CODE` varchar(15) NOT NULL,
  `SECTION_NAME` varchar(50) NOT NULL,
  `DEPT_CODE` varchar(15) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nxx_section`
--

INSERT INTO `nxx_section` (`SECT_CODE`, `SECTION_NAME`, `DEPT_CODE`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) VALUES
('TEST', 'TEST', 'TEST', '', '0000-00-00', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `nxx_teamsched`
--

DROP TABLE IF EXISTS `nxx_teamsched`;
CREATE TABLE `nxx_teamsched` (
  `ID` varchar(10) NOT NULL,
  `SCHEDULE` varchar(50) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nxx_teamsched`
--

INSERT INTO `nxx_teamsched` (`ID`, `SCHEDULE`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) VALUES
('A', 'MWF Office Duty and TTH WFH\r\n', '', '0000-00-00', '', '0000-00-00'),
('B', 'TTH Office Duty , W- Sat Duty, MF- WFH\r\n', '', '0000-00-00', '', '0000-00-00'),
('C', 'Monday to Friday – GT Based\r\n', '', '0000-00-00', '', '0000-00-00'),
('D', 'Specialized Works Sched (Ex, Jusayan, DCOD)\r\n', '', '0000-00-00', '', '0000-00-00'),
('E', 'WFH (Preganant, With Chronic Disease, 60 yrs old a', '', '0000-00-00', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `nxx_unit`
--

DROP TABLE IF EXISTS `nxx_unit`;
CREATE TABLE `nxx_unit` (
  `UNIT_CODE` varchar(15) NOT NULL,
  `UNIT_NAME` varchar(50) NOT NULL,
  `SECT_CODE` varchar(15) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nxx_user_role`
--

DROP TABLE IF EXISTS `nxx_user_role`;
CREATE TABLE `nxx_user_role` (
  `ACCESSGRPID` int(11) NOT NULL,
  `ACCESS_DESC` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nxx_user_role`
--

INSERT INTO `nxx_user_role` (`ACCESSGRPID`, `ACCESS_DESC`) VALUES
(1, 'TEST');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nets_emp_activity`
--
ALTER TABLE `nets_emp_activity`
  ADD PRIMARY KEY (`ACTIVITY_ID`),
  ADD KEY `EMP_CODE` (`EMP_CODE`),
  ADD KEY `VISITOR_ID` (`VISITOR_ID`);

--
-- Indexes for table `nets_emp_act_participants`
--
ALTER TABLE `nets_emp_act_participants`
  ADD PRIMARY KEY (`PRTCPNT_ID`),
  ADD KEY `ACTIVITY_ID` (`ACTIVITY_ID`),
  ADD KEY `EMP_CODE` (`EMP_CODE`);

--
-- Indexes for table `nets_emp_ehc`
--
ALTER TABLE `nets_emp_ehc`
  ADD PRIMARY KEY (`EHC_ID`),
  ADD KEY `Q1` (`Q1`),
  ADD KEY `Q2` (`Q2`),
  ADD KEY `Q3` (`Q3`),
  ADD KEY `Q4` (`Q4`),
  ADD KEY `Q5` (`Q5`);

--
-- Indexes for table `nets_emp_hdf`
--
ALTER TABLE `nets_emp_hdf`
  ADD PRIMARY KEY (`HDF_ID`);

--
-- Indexes for table `nets_emp_info`
--
ALTER TABLE `nets_emp_info`
  ADD PRIMARY KEY (`EMP_CODE`),
  ADD UNIQUE KEY `CARD_NO` (`CARD_NO`),
  ADD UNIQUE KEY `RUSH_ID` (`RUSH_ID`),
  ADD KEY `EMP_STAT` (`EMP_STAT`),
  ADD KEY `POS_CODE` (`POS_CODE`),
  ADD KEY `EMP_LEVEL` (`EMP_LEVEL`),
  ADD KEY `COMP_CODE` (`COMP_CODE`),
  ADD KEY `LOC_CODE` (`LOC_CODE`),
  ADD KEY `GRP_CODE` (`GRP_CODE`),
  ADD KEY `DEPT_CODE` (`DEPT_CODE`),
  ADD KEY `TEAM` (`TEAM`);

--
-- Indexes for table `nets_emp_user`
--
ALTER TABLE `nets_emp_user`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `LOGIN_ID` (`LOGIN_ID`),
  ADD UNIQUE KEY `EMP_CODE` (`EMP_CODE`),
  ADD KEY `ACCESSGRPID` (`ACCESSGRPID`);

--
-- Indexes for table `nets_hdf_chrnc_disease`
--
ALTER TABLE `nets_hdf_chrnc_disease`
  ADD PRIMARY KEY (`HDFC_ID`),
  ADD KEY `EMP_CODE` (`EMP_CODE`),
  ADD KEY `DISEASE` (`DISEASE`);

--
-- Indexes for table `nets_hdf_healthdec`
--
ALTER TABLE `nets_hdf_healthdec`
  ADD PRIMARY KEY (`HDFHD_ID`),
  ADD KEY `Q1` (`Q1`),
  ADD KEY `Q2` (`Q2`),
  ADD KEY `Q3` (`Q3`),
  ADD KEY `Q4` (`Q4`),
  ADD KEY `Q5` (`Q5`),
  ADD KEY `HDF_ID` (`HDF_ID`);

--
-- Indexes for table `nets_hdf_hhold`
--
ALTER TABLE `nets_hdf_hhold`
  ADD PRIMARY KEY (`HDFHH_ID`),
  ADD KEY `Q1` (`Q1`),
  ADD KEY `Q2` (`Q2`),
  ADD KEY `Q3` (`Q3`),
  ADD KEY `Q4` (`Q4`),
  ADD KEY `Q5` (`Q5`),
  ADD KEY `HDF_ID` (`HDF_ID`);

--
-- Indexes for table `nets_hdf_otherinfo`
--
ALTER TABLE `nets_hdf_otherinfo`
  ADD PRIMARY KEY (`HDFOI_ID`),
  ADD KEY `HDF_ID` (`HDF_ID`),
  ADD KEY `Q1` (`Q1`),
  ADD KEY `Q2` (`Q2`),
  ADD KEY `Q3` (`Q3`),
  ADD KEY `Q4` (`Q4`),
  ADD KEY `Q5` (`Q5`);

--
-- Indexes for table `nets_hdf_travelhistory`
--
ALTER TABLE `nets_hdf_travelhistory`
  ADD PRIMARY KEY (`HDFTH_ID`),
  ADD KEY `HDF_ID` (`HDF_ID`),
  ADD KEY `Q1` (`Q1`),
  ADD KEY `Q2` (`Q2`),
  ADD KEY `Q3` (`Q3`),
  ADD KEY `Q5` (`Q4`);

--
-- Indexes for table `nets_visit_log`
--
ALTER TABLE `nets_visit_log`
  ADD PRIMARY KEY (`VISITOR_ID`),
  ADD KEY `Q1` (`Q1`),
  ADD KEY `Q2` (`Q2`),
  ADD KEY `Q3` (`Q3`);

--
-- Indexes for table `nxx_company`
--
ALTER TABLE `nxx_company`
  ADD PRIMARY KEY (`COMP_CODE`);

--
-- Indexes for table `nxx_config`
--
ALTER TABLE `nxx_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `context_name_idx` (`context`,`name`),
  ADD KEY `created_on` (`create_on`),
  ADD KEY `created_by` (`create_by`),
  ADD KEY `modified_on` (`update_on`),
  ADD KEY `modified_by` (`update_by`);

--
-- Indexes for table `nxx_department`
--
ALTER TABLE `nxx_department`
  ADD PRIMARY KEY (`DEPT_CODE`),
  ADD KEY `GRP_CODE` (`GRP_CODE`);

--
-- Indexes for table `nxx_empstat`
--
ALTER TABLE `nxx_empstat`
  ADD PRIMARY KEY (`EMPSTAT_CODE`);

--
-- Indexes for table `nxx_group`
--
ALTER TABLE `nxx_group`
  ADD PRIMARY KEY (`GRP_CODE`);

--
-- Indexes for table `nxx_hdf_ctemp`
--
ALTER TABLE `nxx_hdf_ctemp`
  ADD PRIMARY KEY (`CTEMP_ID`),
  ADD KEY `CUTOFF_ID` (`CUTOFF_ID`);

--
-- Indexes for table `nxx_hdf_cutoff`
--
ALTER TABLE `nxx_hdf_cutoff`
  ADD PRIMARY KEY (`CUTOFFID`);

--
-- Indexes for table `nxx_location`
--
ALTER TABLE `nxx_location`
  ADD PRIMARY KEY (`LOC_CODE`);

--
-- Indexes for table `nxx_position`
--
ALTER TABLE `nxx_position`
  ADD PRIMARY KEY (`POS_CODE`);

--
-- Indexes for table `nxx_questionnaire`
--
ALTER TABLE `nxx_questionnaire`
  ADD PRIMARY KEY (`QCODE`),
  ADD UNIQUE KEY `QUESTION` (`QUESTION`);

--
-- Indexes for table `nxx_rank`
--
ALTER TABLE `nxx_rank`
  ADD PRIMARY KEY (`RNK_CODE`);

--
-- Indexes for table `nxx_section`
--
ALTER TABLE `nxx_section`
  ADD PRIMARY KEY (`SECT_CODE`),
  ADD KEY `DEPT_CODE` (`DEPT_CODE`);

--
-- Indexes for table `nxx_teamsched`
--
ALTER TABLE `nxx_teamsched`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `nxx_unit`
--
ALTER TABLE `nxx_unit`
  ADD PRIMARY KEY (`UNIT_CODE`),
  ADD KEY `SECT_CODE` (`SECT_CODE`);

--
-- Indexes for table `nxx_user_role`
--
ALTER TABLE `nxx_user_role`
  ADD PRIMARY KEY (`ACCESSGRPID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nets_emp_activity`
--
ALTER TABLE `nets_emp_activity`
  MODIFY `ACTIVITY_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nets_emp_act_participants`
--
ALTER TABLE `nets_emp_act_participants`
  MODIFY `PRTCPNT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nets_emp_ehc`
--
ALTER TABLE `nets_emp_ehc`
  MODIFY `EHC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `nets_emp_hdf`
--
ALTER TABLE `nets_emp_hdf`
  MODIFY `HDF_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `nets_emp_user`
--
ALTER TABLE `nets_emp_user`
  MODIFY `USER_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `nets_hdf_chrnc_disease`
--
ALTER TABLE `nets_hdf_chrnc_disease`
  MODIFY `HDFC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `nets_hdf_healthdec`
--
ALTER TABLE `nets_hdf_healthdec`
  MODIFY `HDFHD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `nets_hdf_hhold`
--
ALTER TABLE `nets_hdf_hhold`
  MODIFY `HDFHH_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `nets_hdf_otherinfo`
--
ALTER TABLE `nets_hdf_otherinfo`
  MODIFY `HDFOI_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `nets_hdf_travelhistory`
--
ALTER TABLE `nets_hdf_travelhistory`
  MODIFY `HDFTH_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `nets_visit_log`
--
ALTER TABLE `nets_visit_log`
  MODIFY `VISITOR_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nxx_config`
--
ALTER TABLE `nxx_config`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nxx_hdf_ctemp`
--
ALTER TABLE `nxx_hdf_ctemp`
  MODIFY `CTEMP_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nxx_hdf_cutoff`
--
ALTER TABLE `nxx_hdf_cutoff`
  MODIFY `CUTOFFID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nxx_questionnaire`
--
ALTER TABLE `nxx_questionnaire`
  MODIFY `QCODE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `nxx_user_role`
--
ALTER TABLE `nxx_user_role`
  MODIFY `ACCESSGRPID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nets_emp_activity`
--
ALTER TABLE `nets_emp_activity`
  ADD CONSTRAINT `nets_emp_activity_ibfk_1` FOREIGN KEY (`EMP_CODE`) REFERENCES `nets_emp_info` (`EMP_CODE`),
  ADD CONSTRAINT `nets_emp_activity_ibfk_2` FOREIGN KEY (`VISITOR_ID`) REFERENCES `nets_visit_log` (`VISITOR_ID`);

--
-- Constraints for table `nets_emp_act_participants`
--
ALTER TABLE `nets_emp_act_participants`
  ADD CONSTRAINT `nets_emp_act_participants_ibfk_1` FOREIGN KEY (`ACTIVITY_ID`) REFERENCES `nets_emp_activity` (`ACTIVITY_ID`),
  ADD CONSTRAINT `nets_emp_act_participants_ibfk_2` FOREIGN KEY (`EMP_CODE`) REFERENCES `nets_emp_info` (`EMP_CODE`);

--
-- Constraints for table `nets_emp_ehc`
--
ALTER TABLE `nets_emp_ehc`
  ADD CONSTRAINT `nets_emp_ehc_ibfk_10` FOREIGN KEY (`Q5`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_emp_ehc_ibfk_6` FOREIGN KEY (`Q1`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_emp_ehc_ibfk_7` FOREIGN KEY (`Q2`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_emp_ehc_ibfk_8` FOREIGN KEY (`Q3`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_emp_ehc_ibfk_9` FOREIGN KEY (`Q4`) REFERENCES `nxx_questionnaire` (`QCODE`);

--
-- Constraints for table `nets_emp_info`
--
ALTER TABLE `nets_emp_info`
  ADD CONSTRAINT `nets_emp_info_ibfk_1` FOREIGN KEY (`EMP_STAT`) REFERENCES `nxx_empstat` (`EMPSTAT_CODE`),
  ADD CONSTRAINT `nets_emp_info_ibfk_2` FOREIGN KEY (`POS_CODE`) REFERENCES `nxx_position` (`POS_CODE`),
  ADD CONSTRAINT `nets_emp_info_ibfk_3` FOREIGN KEY (`EMP_LEVEL`) REFERENCES `nxx_rank` (`RNK_CODE`),
  ADD CONSTRAINT `nets_emp_info_ibfk_4` FOREIGN KEY (`COMP_CODE`) REFERENCES `nxx_company` (`COMP_CODE`),
  ADD CONSTRAINT `nets_emp_info_ibfk_5` FOREIGN KEY (`LOC_CODE`) REFERENCES `nxx_location` (`LOC_CODE`),
  ADD CONSTRAINT `nets_emp_info_ibfk_6` FOREIGN KEY (`GRP_CODE`) REFERENCES `nxx_group` (`GRP_CODE`),
  ADD CONSTRAINT `nets_emp_info_ibfk_7` FOREIGN KEY (`DEPT_CODE`) REFERENCES `nxx_department` (`DEPT_CODE`),
  ADD CONSTRAINT `nets_emp_info_ibfk_8` FOREIGN KEY (`TEAM`) REFERENCES `nxx_teamsched` (`ID`);

--
-- Constraints for table `nets_emp_user`
--
ALTER TABLE `nets_emp_user`
  ADD CONSTRAINT `nets_emp_user_ibfk_1` FOREIGN KEY (`EMP_CODE`) REFERENCES `nets_emp_info` (`EMP_CODE`),
  ADD CONSTRAINT `nets_emp_user_ibfk_2` FOREIGN KEY (`ACCESSGRPID`) REFERENCES `nxx_user_role` (`ACCESSGRPID`);

--
-- Constraints for table `nets_hdf_chrnc_disease`
--
ALTER TABLE `nets_hdf_chrnc_disease`
  ADD CONSTRAINT `nets_hdf_chrnc_disease_ibfk_1` FOREIGN KEY (`EMP_CODE`) REFERENCES `nets_emp_user` (`EMP_CODE`);

--
-- Constraints for table `nets_hdf_healthdec`
--
ALTER TABLE `nets_hdf_healthdec`
  ADD CONSTRAINT `nets_hdf_healthdec_ibfk_2` FOREIGN KEY (`Q1`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_healthdec_ibfk_3` FOREIGN KEY (`Q2`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_healthdec_ibfk_4` FOREIGN KEY (`Q3`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_healthdec_ibfk_5` FOREIGN KEY (`Q4`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_healthdec_ibfk_6` FOREIGN KEY (`Q5`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_healthdec_ibfk_7` FOREIGN KEY (`HDF_ID`) REFERENCES `nets_emp_hdf` (`HDF_ID`);

--
-- Constraints for table `nets_hdf_hhold`
--
ALTER TABLE `nets_hdf_hhold`
  ADD CONSTRAINT `nets_hdf_hhold_ibfk_2` FOREIGN KEY (`Q1`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_hhold_ibfk_3` FOREIGN KEY (`Q2`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_hhold_ibfk_4` FOREIGN KEY (`Q3`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_hhold_ibfk_5` FOREIGN KEY (`Q4`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_hhold_ibfk_6` FOREIGN KEY (`Q5`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_hhold_ibfk_8` FOREIGN KEY (`HDF_ID`) REFERENCES `nets_emp_hdf` (`HDF_ID`);

--
-- Constraints for table `nets_hdf_otherinfo`
--
ALTER TABLE `nets_hdf_otherinfo`
  ADD CONSTRAINT `nets_hdf_otherinfo_ibfk_1` FOREIGN KEY (`HDF_ID`) REFERENCES `nets_emp_hdf` (`HDF_ID`),
  ADD CONSTRAINT `nets_hdf_otherinfo_ibfk_2` FOREIGN KEY (`Q1`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_otherinfo_ibfk_3` FOREIGN KEY (`Q2`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_otherinfo_ibfk_4` FOREIGN KEY (`Q3`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_otherinfo_ibfk_5` FOREIGN KEY (`Q4`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_otherinfo_ibfk_6` FOREIGN KEY (`Q5`) REFERENCES `nxx_questionnaire` (`QCODE`);

--
-- Constraints for table `nets_hdf_travelhistory`
--
ALTER TABLE `nets_hdf_travelhistory`
  ADD CONSTRAINT `nets_hdf_travelhistory_ibfk_1` FOREIGN KEY (`HDF_ID`) REFERENCES `nets_emp_hdf` (`HDF_ID`),
  ADD CONSTRAINT `nets_hdf_travelhistory_ibfk_2` FOREIGN KEY (`Q1`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_travelhistory_ibfk_3` FOREIGN KEY (`Q2`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_travelhistory_ibfk_4` FOREIGN KEY (`Q3`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_hdf_travelhistory_ibfk_6` FOREIGN KEY (`Q4`) REFERENCES `nxx_questionnaire` (`QCODE`);

--
-- Constraints for table `nets_visit_log`
--
ALTER TABLE `nets_visit_log`
  ADD CONSTRAINT `nets_visit_log_ibfk_1` FOREIGN KEY (`Q1`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_visit_log_ibfk_2` FOREIGN KEY (`Q2`) REFERENCES `nxx_questionnaire` (`QCODE`),
  ADD CONSTRAINT `nets_visit_log_ibfk_3` FOREIGN KEY (`Q3`) REFERENCES `nxx_questionnaire` (`QCODE`);

--
-- Constraints for table `nxx_department`
--
ALTER TABLE `nxx_department`
  ADD CONSTRAINT `nxx_department_ibfk_1` FOREIGN KEY (`GRP_CODE`) REFERENCES `nxx_group` (`GRP_CODE`);

--
-- Constraints for table `nxx_hdf_ctemp`
--
ALTER TABLE `nxx_hdf_ctemp`
  ADD CONSTRAINT `nxx_hdf_ctemp_ibfk_1` FOREIGN KEY (`CUTOFF_ID`) REFERENCES `nxx_hdf_cutoff` (`CUTOFFID`);

--
-- Constraints for table `nxx_section`
--
ALTER TABLE `nxx_section`
  ADD CONSTRAINT `nxx_section_ibfk_1` FOREIGN KEY (`DEPT_CODE`) REFERENCES `nxx_department` (`DEPT_CODE`);

--
-- Constraints for table `nxx_unit`
--
ALTER TABLE `nxx_unit`
  ADD CONSTRAINT `nxx_unit_ibfk_1` FOREIGN KEY (`SECT_CODE`) REFERENCES `nxx_section` (`SECT_CODE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
