<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Model {

    private $query;

    public function __construct(){

        parent::__construct();
        $this->load->model('Activities');
        $this->load->model('Participants');
        $this->load->model('Companies');
        $this->load->model('Groups');
        $this->load->model('HealthChecks');
        $this->load->model('Employees');
        $this->load->model('Visitors');

        $this->query = false;
    }

    public function db_config(){

        return array(

            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname            
        );
    }

    public function activities_config($params){

        if($params){

            switch ($params) {
                case ('PK' || 'pk' || 'primary_key' || 'Primary_Key'):
                    
                    return $this->Activities->primary_key;
                    break;
                case ('table' || 'Table' || 'tb'):

                    return $this->Activities->table;
                    break;
                default:
                    
                    trigger_error('Inserted paramter did not recognize',E_USER_ERROR);
                    break;
            }
        }

        return false;
    }

    public function hc_config($params){

        if($params){

            switch ($params) {
                case ('PK' || 'pk' || 'primary_key' || 'Primary_Key'):
                    
                    return $this->HealthChecks->primary_key;
                    break;
                case ('table' || 'Table' || 'tb'):

                    return $this->HealthChecks->table;
                    break;
                default:
                    
                    trigger_error('Inserted paramter did not recognize',E_USER_ERROR);
                    break;
            }
        }

        return false;
    }    

    public function participants_config($params){

        if($params){

            switch ($params) {
                case ('PK' || 'pk' || 'primary_key' || 'Primary_Key'):
                    
                    return $this->Participants->primary_key;
                    break;
                case ('table' || 'Table' || 'tb'):

                    return $this->Participants->table;
                    break;
                default:
                    
                    trigger_error('Inserted paramter did not recognize',E_USER_ERROR);
                    break;
            }
        }

        return false;
    }

    public function visitors_config($params){

        if($params){

            switch ($params) {
                case 'pk':
                    
                    return $this->Visitors->primary_key;
                    break;
                case 'table':

                    return $this->Visitors->table;
                    break;
                default:
                    
                    trigger_error('Inserted paramter did not recognize',E_USER_ERROR);
                    break;
            }
        }

        return false;
    }
        
    public function get_list($params){

        if ($params) {
            
            switch ($params) {
                case 'company':
                    return $this->Companies->as_dropdown('COMP_NAME')->get_all();
                    break;
                
                case 'group':
                    return $this->Groups->as_dropdown('GRP_NAME')->get_all();
                    break;

                case 'employees':
                    return $this->Employees->as_dropdown('CONCAT(EMP_LNAME," ",EMP_FNAME)')->order_by('EMP_LNAME','ASC')->get_all();
                    break;

                default:
                    return false;
                    break;
            }

        } else {

            return false;
        }
    }

    public function reportBuilder($report_type,$params=null){
        
        if ($report_type) {

            $where = $this->dateBuilder($report_type,[
                'date_start' => (isset($params['date_start']) ? $params['date_start'] : ''),
                'date_end' => (isset($params['date_end']) ? $params['date_end'] : ''),
                'cut_off' => $params['cut_off']
            ]);

            if ($params) {
                
                if ($params['emp_code'] && $report_type !== 'dar') {
                    
                    $where.=' WHERE B.EMP_CODE = "'.$params['emp_code'].'"';

                }
                
                if ($params['group']) {
                    
                    $where.=' WHERE B.GRP_CODE = "'.$params['group'].'"';
                }

                if ($params['company']) {
                    
                    $where.=' WHERE B.COMP_CODE = "'.$params['company'].'"';
                }

                if ($report_type == 'ehc' && $params['sick_filter']) {
                    
                    $where.=' WHERE A.A2 = "'.$params['sick_filter'].'"';
                }

                if ($report_type == 'visitors' && $params['visitor_status']) {
                    
                    $where.=' WHERE A.STATUS = "'.$params['visitor_status'].'"';
                }

                if ($report_type == 'dar' && $params['dar_status']) {
                    
                    if ($params['dar_status'] === 'x') {
                        
                        $where.=' WHERE A.STATUS = ""';

                    } else {

                        $where.=' WHERE A.STATUS = "'.$params['dar_status'].'"';
                    }
                    
                }

            }
            
            if (substr_count($where,'WHERE') > 1) {
                
                $where = str_replace('WHERE','AND',$where);
                $where = preg_replace('/AND/','WHERE',$where,1);
            }
            
            switch ($report_type) {

                case 'dar':
                    $having = ($params['emp_code'] ? ' HAVING PARTICIPANT_ID LIKE "%'.$params['emp_code'].'%" OR A.EMP_CODE = "'.$params['emp_code'].'"' : "");
                    $queryString = "SELECT A.ACTIVITY_ID,A.EMP_CODE,A.ACTIVITY_DATE,A.TIME_FROM,A.TIME_TO,A.ACTIVITY_TYPE,A.LOCATION,
                    CONCAT(UPPER(SUBSTRING(LOWER(LOWER(IF(A.STATUS = '' OR A.STATUS IS NULL,'For Confirmation',A.STATUS))),1,1)),LOWER(SUBSTRING(LOWER(LOWER(IF(A.STATUS = '' OR A.STATUS IS NULL,'For Confirmation',A.STATUS))),2))) AS `STATUS`,
                    C.PARTICIPANTS,C.PARTICIPANT_ID,D.VISITORS,
                    CAST(CONVERT(CONCAT(B.EMP_LNAME,' ',B.EMP_FNAME) USING utf8) AS BINARY) AS 'EMP_NAME',B.GRP_CODE,B.COMP_CODE
                    FROM nets_emp_activity AS A
                        INNER JOIN nets_emp_info AS B
                            ON A.EMP_CODE = B.EMP_CODE
                        LEFT JOIN v_participants AS C
                            ON C.ACTIVITY_ID = A.ACTIVITY_ID
                        LEFT JOIN (SELECT GROUP_CONCAT(CAST(CONVERT(CONCAT(VISIT_FNAME,' ',VISIT_LNAME) USING utf8) AS BINARY) SEPARATOR ', ') AS `VISITORS`, ACTIVITY_ID
                                    FROM nets_visit_log WHERE ACTIVITY_ID IS NOT NULL GROUP BY ACTIVITY_ID) AS D
                            ON D.ACTIVITY_ID = A.ACTIVITY_ID".$where." GROUP BY A.ACTIVITY_ID".$having;

                    break;

                case 'ehc':
                    $quote = '"';
                    $queryString = "SELECT A.EHC_ID,A.EHC_DATE,A.COMPLETION_DATE,A.A1,A.A2,IF(A.A2 = 'Y','Yes','No') AS `_A2`,
                    native_replace(A.A3) AS `A3`,
                    IF(A.A4 = 'Y','Yes','NO') AS `A4`,IF(A.A5 = 'Y','Yes','NO') AS `A5`,CAST(CONVERT(A.A4WHERE USING utf8) AS BINARY) as `A4WHERE`,A.A4WHEN,A.A5WHEN,A.EMP_CODE,B.COMP_CODE,B.GRP_CODE,A.RUSHNO,A.REASON,B.EMP_FNAME,B.EMP_LNAME,
                    define_rush(A.STATUS) AS 'STATUS'
                    FROM nets_emp_ehc AS A
                        INNER JOIN nets_emp_info AS B
                            ON A.EMP_CODE = B.EMP_CODE".$where;
                    break;

                case 'health_declaration':

                    break;

                case 'visitors':
                    $queryString = "SELECT A.VISITOR_ID,A.VISIT_DATE,A.CHECKIN_TIME,A.CHECKOUT_TIME,
                    CAST(CONVERT(A.COMP_NAME USING utf8) AS BINARY) AS `COMP_NAME`,A.COMP_ADDRESS,A.EMAIL_ADDRESS,A.MOBILE_NO,A.TEL_NO,
                    CAST(CONVERT(A.RES_ADDRESS USING utf8) AS BINARY) AS `RES_ADDRESS`,CAST(CONVERT(A.VISIT_PURP USING utf8) AS BINARY) AS `VISIT_PURP`,A.A1,convert_sickness(A.A2) AS `A2`,A.A2DATES,A.A3TRAVEL_DATES,
                    CAST(CONVERT(A.A3PLACE USING utf8) AS BINARY) AS `A3PLACE`,A.A3RETURN_DATE,
                    CAST(CONVERT(CONCAT(B.EMP_FNAME,' ',B.EMP_LNAME) USING utf8) AS BINARY) AS `EMP_NAME`,B.COMP_CODE,B.GRP_CODE,B.EMP_CODE,
                    CAST(CONVERT(CONCAT(A.VISIT_FNAME,' ',A.VISIT_LNAME) USING utf8) AS BINARY) AS `VISIT_NAME`,
                    IF(A.A3 = 1,'Yes','No') AS `A3`,
                    CONCAT(UPPER(SUBSTRING(LOWER(LOWER(IF(A.STATUS = '' OR A.STATUS IS NULL,'For Confirmation',A.STATUS))),1,1)),LOWER(SUBSTRING(LOWER(LOWER(IF(A.STATUS = '' OR A.STATUS IS NULL,'For Confirmation',A.STATUS))),2))) AS `_status`
                                        FROM nets_visit_log AS A
                                            INNER JOIN nets_emp_info AS B
                                          ON A.PERS_TOVISIT = B.EMP_CODE".$where;
                    break;
                
                case 'hdf':
                    $none = '["none"]';
                    $end_ehc = date("Y-m-d",strtotime('-7 days',strtotime($params['cut_off'])));

                    $queryString="SELECT 
                    CAST(CONVERT(B.EMP_FNAME USING utf8) AS BINARY) AS `EMP_FNAME`,CAST(CONVERT(B.EMP_LNAME USING utf8) AS BINARY) AS `EMP_LNAME`,B.AGE,B.GENDER,B.CIVIL_STAT,CAST(CONVERT(B.PRESENT_PROV USING utf8) AS BINARY) AS `PRESENT_PROV`,CAST(CONVERT(B.PRESENT_ADDR1 USING utf8) AS BINARY) AS `PRESENT_ADDR1`,B.TEL_NO,B.MOBILE_NO,C.COMP_NAME,
                    D.GRP_NAME,E.A1 AS `ea1`,E.A2 AS `ea2`,E.A3 AS `ea3`,E.A4 AS `ea4`,E.A5 AS `ea5`,IF(E.A6 = 'Y','Yes','No') AS `ea6`,E.A6HOWMANY AS `howmany`,IF(F.A1 = 'Y','Yes','No') AS `fa1`,F.A1TEMP AS `ftemp`,
                    CONCAT('[',I.ia3,']') AS `ia3`,F.A5PERIOD AS `period`,F.A2 AS `fa2`,F.A3 AS `fa3`,IF(F.A4 = 'Y','Yes','No') AS `fa4`,F.A4REASON AS `reason`,IF(F.A5 = 'Y','Yes','No') AS `fa5`,F.A5SYMPTOMS AS `symptoms`,IF(G.A1 = 'Y','Yes','No') AS `ga1`,G.A1TRAVEL_DATES AS `travel_date`,
                    CAST(CONVERT(G.A1PLACE USING utf8) AS BINARY) AS `ga1place`,G.A1RETURN_DATE AS `ga1return_date`,IF(G.A2 = 'Y','Yes','No') AS `ga2`,G.A2TRAVEL_DATES AS `ga2travel_date`,CAST(CONVERT(G.A2PLACE USING utf8) AS BINARY) AS `ga2place`,G.A2RETURN_DATE AS `ga2return_date`,IF(G.A3 = 'Y','Yes','No') AS `ga3`,G.A3CONTACT_DATE AS `contact_date`,IF(G.A4 = 'Y','Yes','No') AS `ga4`,CAST(CONVERT(G.A4NAME USING utf8) AS BINARY) AS `gname`,
                    G.A4VISIT_DATE AS `visit_date`,IF(H.A1 = 'Y','Yes','No') AS `ha1`,H.A1DETAILS AS `hdetails`,IF(H.A2 = 'Y','Yes','No') AS `ha2`,H.A2EXPOSURE_DATE AS `exposure_date`,H.A3 AS `ha3`,H.A4 AS `ha4`,H.A4PLACE AS `hplace`,IF(H.A5 = 'Y','Yes','No') AS `ha5`,IF(H.A5FRONTLINER = 'null','".$none."',H.A5FRONTLINER) AS 'A5FRONTLINER',
                    H.A6,H.A7,GROUP_CONCAT(J.DISEASE SEPARATOR ', ') AS `disease`,A.HDF_DATE,A.HDF_ID,A.EMP_CODE AS `EMP_CODE`,B.COMP_CODE AS `COMP_CODE`,B.GRP_CODE AS `GRP_CODE`
                    FROM nets_emp_hdf AS A
                    INNER JOIN nets_emp_info AS B
                        ON A.EMP_CODE = B.EMP_CODE
                    INNER JOIN nxx_company AS C
                        ON B.COMP_CODE = C.COMP_CODE
                    INNER JOIN nxx_group AS D
                        ON B.GRP_CODE = D.GRP_CODE
                    INNER JOIN nets_hdf_hhold AS E
                        ON A.HDF_ID = E.HDF_ID
                    INNER JOIN nets_hdf_healthdec AS F
                        ON A.HDF_ID = F.HDF_ID
                    INNER JOIN nets_hdf_travelhistory AS G
                        ON A.HDF_ID = G.HDF_ID
                    INNER JOIN nets_hdf_otherinfo AS H
                        ON A.HDF_ID = H.HDF_ID
                    LEFT JOIN (SELECT EMP_CODE, GROUP_CONCAT(A3 SEPARATOR ', ') AS `ia3` FROM nets_emp_ehc WHERE EHC_DATE >= '".$end_ehc."' AND EHC_DATE <= '".$params['cut_off']."' GROUP BY EMP_CODE) AS I
                        ON I.EMP_CODE = A.EMP_CODE
                    INNER JOIN nets_hdf_chrnc_disease AS J
                        ON J.ANSKEY = A.HDF_ID".$where." GROUP BY A.HDF_ID";

                    break;
                case 'priority':

                    $queryString = 'call priority_list("'.$params['company'].'","'.$params['group'].'","'.$params['date_start'].'")';
                    break;
                default:
                return false;
                break;
            }
         
            return $queryString;

        } else {

            return false;
        }

    }

    public function dateBuilder($report_type,$dates){
        
        if ($report_type) {

            $where = '';
            switch ($report_type) {
                case 'dar':
                    if ($dates['date_start'] && $dates['date_end']) {
                    
                        $where.=' WHERE A.ACTIVITY_DATE BETWEEN "'.$dates['date_start'].'" AND "'.$dates['date_end'].'"';
    
                    } else {
    
                        $where.=' WHERE A.ACTIVITY_DATE >= "'.$dates['date_start'].'"';
    
                    }
                    break;

                case 'ehc':
                    if ($dates['date_start'] && $dates['date_end']) {
                    
                        $where.=' WHERE A.EHC_DATE BETWEEN "'.$dates['date_start'].'" AND "'.$dates['date_end'].'"';
    
                    } else if($dates['date_start']) {
    
                        $where.=' WHERE A.EHC_DATE >= "'.$dates['date_start'].'"';
    
                    }                    
                    break;

                case 'visitors':
                    if ($dates['date_start'] && $dates['date_end']) {
                    
                        $where.=' WHERE A.VISIT_DATE BETWEEN "'.$dates['date_start'].'" AND "'.$dates['date_end'].'"';
    
                    } else if($dates['date_start']) {
    
                        $where.=' WHERE A.VISIT_DATE >= "'.$dates['date_start'].'"';
    
                    }                      
                    break;

                case 'hdf':
                    $end = date("Y-m-d",strtotime('-7 days',strtotime($dates['cut_off'])));

                    $where.=' WHERE A.HDF_DATE = "'.$dates['cut_off'].'"'; 
                                      
                    break;
                default:
                    # code...
                    break;
            }
            
            return $where;
        } else {

            return false;
        }
    }

    public function custom($string){

        $customResponse = false;

        if ($string) {
            
			$query = $this->db->query($string);

			$rowcount = $query->num_rows();
			
			if ($rowcount > 0) {
				
				$customResponse = $query->result_array();

			}             
        }
    
        return $customResponse;
    }    

}