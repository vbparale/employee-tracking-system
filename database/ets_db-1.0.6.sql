

ALTER TABLE `nets_emp_user` DROP FOREIGN KEY IF EXISTS `nets_emp_user_ibfk_2`;
ALTER TABLE `nets_emp_user` DROP KEY IF EXISTS `ACCESSGRPID`;

ALTER TABLE `nets_emp_user` CHANGE IF EXISTS ACCESSGRPID ROLE_ID int(11) NOT NULL;

DROP TABLE IF EXISTS `nxx_user_role`;

CREATE TABLE `nxx_user_role` (
  `ROLE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROLE_DESCRIPTION` varchar(50) NOT NULL,
  `STATUS` varchar(1) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`ROLE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

ALTER TABLE `nxx_user_role`
  ADD UNIQUE KEY `ROLE_DESCRIPTION_IDX` (`ROLE_DESCRIPTION`),
  ADD KEY `STATUS_IDX` (`STATUS`);

INSERT INTO `nxx_user_role` (`ROLE_ID`, `ROLE_DESCRIPTION`, `STATUS`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) 
VALUES (1, 'Administrator', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00'),
	   (2, 'Regular User', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00'),
	   (3, 'HR Admin', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00'),
	   (4, 'Heads', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00'),
	   (5, 'Secretary', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00'),
	   (6, 'Receptionist', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00');

DROP TABLE IF EXISTS `nxx_modules`;

CREATE TABLE `nxx_modules` (
  `MODULE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `DISPLAY_TITLE` varchar(50) NOT NULL,
  `MODULE_DESCRIPTION` varchar(100) NOT NULL,
  `MODULE_PATH` varchar(100) NOT NULL,
  `STATUS` varchar(1) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`MODULE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `nxx_modules`
  ADD UNIQUE KEY `DISPLAY_TITLE_IDX` (`DISPLAY_TITLE`),
  ADD KEY `STATUS_IDX` (`STATUS`);

INSERT INTO `nxx_modules` (`MODULE_ID`, `DISPLAY_TITLE`, `MODULE_DESCRIPTION`, `MODULE_PATH`, `STATUS`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`) 
VALUES (1, 'EHC', 'Employee Health Check','', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00'),
	   (2, 'HDF', 'Health Declaration Form','', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00'),
	   (3, 'DA', 'Daily Activity','', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00'),
	   (4, 'VL', 'Visitor\'s Log','', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00'),
	   (5, 'RP', 'Reports','', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00'),
	   (6, 'UM', 'User Maintenance','', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00'),
	   (7, 'HDFCO', 'HDF Cut-Off','', 'A', 'IT00', '0000-00-00', 'IT00', '0000-00-00');

DROP TABLE IF EXISTS `nxx_role_access`;

CREATE TABLE `nxx_role_access` (
  `ACCESS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ROLE_ID` int(11) NOT NULL,
  `MODULE_ACCESS` int(11) NOT NULL,
  `STATUS` varchar(1) NOT NULL,
  `CREATE_USER` varchar(10) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `UPDATE_USER` varchar(10) NOT NULL,
  `UPDATE_DATE` date NOT NULL,
  PRIMARY KEY (`ACCESS_ID`),
  UNIQUE KEY `unacity_role_access` (`ROLE_ID`, `MODULE_ACCESS`),
  CONSTRAINT `nxx_role_access_ibfk_1` FOREIGN KEY (`ROLE_ID`) REFERENCES `nxx_user_role` (`ROLE_ID`),
  CONSTRAINT `nxx_role_access_ibfk_2` FOREIGN KEY (`MODULE_ACCESS`) REFERENCES `nxx_modules` (`MODULE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `nxx_role_access` (`ACCESS_ID`, `ROLE_ID`, `MODULE_ACCESS`, `STATUS`, `CREATE_USER`, `CREATE_DATE`, `UPDATE_USER`, `UPDATE_DATE`)
VALUES (1, 1, 1, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (2, 1, 2, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (3, 1, 3, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (4, 1, 4, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (5, 1, 5, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (6, 1, 6, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (7, 1, 7, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (8, 2, 1, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (9, 2, 2, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (10, 2, 3, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (11, 3, 1, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (12, 3, 2, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (13, 3, 3, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (14, 3, 4, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (15, 3, 5, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (16, 3, 7, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (17, 4, 1, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (18, 4, 2, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (19, 4, 3, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (20, 4, 5, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (21, 5, 1, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (22, 5, 2, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (23, 5, 3, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (24, 5, 4, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00'),
       (25, 6, 4, 'A', 'IT00' ,'0000-00-00', 'IT00', '0000-00-00');


ALTER TABLE `nets_emp_user`
  ADD CONSTRAINT `nets_emp_user_ibfk_2` FOREIGN KEY (`ROLE_ID`) REFERENCES `nxx_user_role` (`ROLE_ID`);