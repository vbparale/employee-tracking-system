DELETE FROM nxx_user_role WHERE ACCESSGRPID = 1;
ALTER TABLE `nxx_user_role` CHANGE `ACCESS_DESC` `ACCESS_DESC` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

insert  into `nxx_user_role`(`ACCESSGRPID`,`ACCESS_DESC`) values 
(1,'Administrator'),
(2,'Regular User');
