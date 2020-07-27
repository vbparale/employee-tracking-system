DELIMITER $$
DROP FUNCTION IF EXISTS `define_rush`$$
CREATE FUNCTION define_rush(rush VARCHAR(3)) RETURNS VARCHAR(10) DETERMINISTIC
	BEGIN
		RETURN CASE rush
			WHEN 'I' THEN 'In Process'
			WHEN 'O' THEN 'Open'
			WHEN 'D' THEN 'Done'
			WHEN 'C' THEN 'Closed'
			WHEN 'R' THEN 'Rejected'
			WHEN 'CAN' THEN 'Cancelled'
			WHEN 'A' THEN 'Approved'
			ELSE ''
		END;
	END $$

DROP FUNCTION IF EXISTS `define_status`$$	
CREATE FUNCTION define_status(ets_status INT(11)) RETURNS VARCHAR(16) DETERMINISTIC
	BEGIN
		
		RETURN CASE ets_status
			WHEN 1 THEN 'For Confirmation'
			WHEN 2 THEN 'Confirmed'
			WHEN 3 THEN 'On-Going'
			WHEN 4 THEN 'Denied'
			WHEN 5 THEN 'Done'
			WHEN 6 THEN 'Cancelled'
		END;
	END $$

DROP FUNCTION IF EXISTS `native_replace`$$
CREATE FUNCTION `native_replace`(ets_sickness VARCHAR(30)) RETURNS TEXT DETERMINISTIC
BEGIN

	RETURN REPLACE(REPLACE(REPLACE(ets_sickness,'"',''),'[',''),']','');
END $$

DROP FUNCTION IF EXISTS `count_CommaSeparated`$$
CREATE FUNCTION `count_CommaSeparated`(with_comma TEXT) RETURNS INT(11) DETERMINISTIC
BEGIN

	RETURN (CHAR_LENGTH(with_comma) - CHAR_LENGTH(REPLACE(with_comma, ',', '')) + 1);
END $$

DROP FUNCTION IF EXISTS `define_setSickness`$$
CREATE FUNCTION `define_setSickness`(sickness_symptoms INT(11)) RETURNS VARCHAR(30) DETERMINISTIC
BEGIN	
		RETURN CASE sickness_symptoms
			WHEN 1 THEN 'Dry Cough'
			WHEN 2 THEN 'Sore throat'
			WHEN 3 THEN 'Colds'
			WHEN 4 THEN 'Shortness of breath'
			WHEN 5 THEN 'Diarrhea'
			WHEN 6 THEN 'Nausea or vomiting'
			WHEN 7 THEN 'Headache'
			WHEN 8 THEN 'Muscle pain and weakness'
			WHEN 9 THEN 'Decreased ability to smell'
			WHEN 10 THEN 'Decreased ability to taste'
			WHEN 11 THEN 'None'
			ELSE 'undefined'
		END;
	END $$

DROP FUNCTION IF EXISTS `convert_sickness`$$
CREATE FUNCTION `convert_sickness`(sick_symptoms TEXT) RETURNS TEXT DETERMINISTIC
BEGIN
		DECLARE sickness TEXT;
		DECLARE count_length INT(11);
		DECLARE ctr INT;
		DECLARE new_value TEXT;
		
		SET sickness = native_replace(sick_symptoms);
		SET count_length = count_CommaSeparated(sickness);
		
		SET ctr = 1;
		SET new_value = "";
		WHILE ctr <= count_length DO
			
			SET new_value = CONCAT(new_value,define_setSickness(SUBSTRING_INDEX(SUBSTRING_INDEX(sickness,',',ctr),',',-1)),',');
			
			SET ctr = ctr + 1;
		END WHILE;
		
		RETURN new_value;		
		
	END $$

DELIMITER ;