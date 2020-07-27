/*
Added: ETS Stored Procedure for Priority list
Date: June 24, 2020
Author: Ben Zarmaynine E. Obra
*/
DROP PROCEDURE IF EXISTS `priority_list`;
DELIMITER $$
	
	CREATE PROCEDURE priority_list(IN company VARCHAR(20), IN group_code VARCHAR(15), IN priorDate DATE)
	BEGIN
		SELECT
		(SELECT COUNT(DISTINCT A.emp_code) FROM nets_emp_info AS A
			INNER JOIN nets_emp_ehc AS B
				ON A.EMP_CODE = B.EMP_CODE
			WHERE A.AGE > 50 AND native_replace(B.A3) != "None" AND A.COMP_CODE = company AND A.GRP_CODE = group_code AND B.EHC_DATE >= priorDate) AS `symptomatic`,
			
		(SELECT COUNT(DISTINCT A.emp_code) FROM nets_emp_info AS A
			INNER JOIN nets_emp_hdf AS B
				ON A.EMP_CODE = B.EMP_CODE
			INNER JOIN nets_hdf_healthdec AS C
				ON B.HDF_ID = C.HDF_ID
			WHERE C.A1 = "Y" AND A.COMP_CODE = company AND A.GRP_CODE = group_code AND B.COMPLETION_DATE >= priorDate) AS `with_fever`,
			
		(SELECT COUNT(DISTINCT A.emp_code) FROM nets_emp_info AS A
			INNER JOIN nets_emp_hdf AS B
				ON A.EMP_CODE = B.EMP_CODE
			INNER JOIN nets_hdf_healthdec AS C
				ON B.HDF_ID = C.HDF_ID
			WHERE A.AGE > 50 AND native_replace(C.A3) != "None" AND A.COMP_CODE = company AND A.GRP_CODE = group_code AND B.COMPLETION_DATE >= priorDate) AS `asymptomatic`,
			
		(SELECT COUNT(DISTINCT A.emp_code) FROM nets_emp_info AS A
			INNER JOIN nets_emp_hdf AS B
				ON A.EMP_CODE = B.EMP_CODE
			INNER JOIN nets_hdf_hhold AS C
				ON B.HDF_ID = C.HDF_ID
			WHERE A.AGE > 50 AND native_replace(C.A5) != "None" AND A.COMP_CODE = company AND A.GRP_CODE = group_code AND B.COMPLETION_DATE >= priorDate) AS `old_coMorbidities`,
			
		(SELECT COUNT(DISTINCT A.emp_code) FROM nets_emp_info AS A
			INNER JOIN nets_emp_hdf AS B
				ON A.EMP_CODE = B.EMP_CODE
			INNER JOIN nets_hdf_hhold AS C
				ON B.HDF_ID = C.HDF_ID
			WHERE native_replace(C.A5) != "None" AND A.COMP_CODE = company AND A.GRP_CODE = group_code AND B.COMPLETION_DATE >= priorDate) AS `coMorbidities`,
			
		(SELECT COUNT(DISTINCT A.emp_code) FROM nets_emp_info AS A
			INNER JOIN nets_emp_hdf AS B
				ON A.EMP_CODE = B.EMP_CODE
			INNER JOIN nets_hdf_otherinfo AS C
				ON B.HDF_ID = C.HDF_ID
			WHERE (C.A5 = "Yes" OR C.A5 = "Y") AND A.COMP_CODE = company AND A.GRP_CODE = group_code AND B.COMPLETION_DATE >= priorDate) AS `close_contact`,
			
		(
		SELECT COUNT(DISTINCT A.emp_code) FROM nets_emp_info AS A
			INNER JOIN nets_emp_hdf AS B
				ON A.EMP_CODE = B.EMP_CODE
			INNER JOIN nets_hdf_otherinfo AS C
				ON B.HDF_ID = C.HDF_ID
			WHERE C.A2 = "Y" AND A.COMP_CODE = company AND A.GRP_CODE = group_code AND B.COMPLETION_DATE >= priorDate) +
			
		(SELECT COUNT(DISTINCT A.emp_code) FROM nets_emp_info AS A
			INNER JOIN nets_emp_hdf AS B
				ON A.EMP_CODE = B.EMP_CODE
			INNER JOIN nets_hdf_travelhistory AS C
				ON B.HDF_ID = C.HDF_ID
			WHERE C.A3 = "Y" AND A.COMP_CODE = company AND A.GRP_CODE = group_code AND B.COMPLETION_DATE >= priorDate) +

		(SELECT COUNT(DISTINCT A.emp_code) FROM nets_emp_info AS A
			INNER JOIN nets_emp_hdf AS B
				ON A.EMP_CODE = B.EMP_CODE
			INNER JOIN nets_hdf_otherinfo AS C
				ON B.HDF_ID = C.HDF_ID
			WHERE C.A1 = "Y" AND A.COMP_CODE = company AND A.GRP_CODE = group_code AND B.COMPLETION_DATE >= priorDate) AS `with_exposure`;
			
	END $$
DELIMITER ;