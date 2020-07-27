<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_Activity extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct() {
        parent::__construct();
        $this->load->library('SSP');
        $this->load->library('SMS');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Activity_Model');

    }

    public function daily_activity()
    {
        if (!isset($this->session->LOGIN_ID)) {
            redirect(base_url('login'));
        }

        if(!isset($this->session->module['DA'])) {
            redirect(base_url(''));
        }

        $this->load->helper('form');
        $Q1 = $this->Activity_model->get_questionnaire('EHC', 3);
        $Q2 = $this->Activity_model->get_questionnaire('HDFTH', 1);
        $data = array(
            'dhc' => "",
            'hdf' => "",
            'da' => "active",
            'vl' => "",
            'rprts' => "",
            'admin' => "",
            'title' => "Employee Tracking System | Daily Activity",
            'Q1' => $Q1,
            'Q2' => $Q2,
            'users' => $this->Activity_Model->get_emp_users()
        );
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/daily_activity');
        //$this->load->view('templates/footer');
    }
    

    public function daily_activities_list() {
       $table = "
         (
            SELECT 
            ACT.ACTIVITY_ID,
              ACT.ACTIVITY_DATE, 
              ACT.TIME_FROM, 
              ACT.TIME_TO, 
              ACT.ACTIVITY_TYPE, 
              ACT.EMP_CODE,
              CONCAT(USER.EMP_FNAME , ' ' , USER.EMP_LNAME) AS REQUESTOR, 
              ACT.LOCATION, 
             CASE 
                WHEN (ACT.STATUS <> 'DENIED' AND ACT.STATUS <> 'CANCELLED') AND (SELECT MAX(IFNULL(PP.STATUS, 'ZZZ')) FROM NETS_EMP_ACT_PARTICIPANTS PP
                WHERE ACT.ACTIVITY_ID = PP.ACTIVITY_ID AND ISNULL(PP.STATUS) GROUP BY PP.ACTIVITY_ID) = 'ZZZ' THEN 'FOR CONFIRMATION'                
                WHEN ACT.HOST_EMP = '' AND (ACT.STATUS <> 'DENIED' AND ACT.STATUS <> 'CANCELLED') AND (SUM(ISNULL(PART.STATUS)) = 0 AND SUM(PART.STATUS = 'CONFIRMED')) THEN 'CONFIRMED'    
                WHEN VISIT.MEETING_ID IS NOT NULL AND (ACT.STATUS <> 'DENIED' AND ACT.STATUS <> 'CANCELLED') AND (SUM(PART.STATUS = 'CONFIRMED') = COUNT(PART.ACTIVITY_ID)) THEN 'CONFIRMED'                
                WHEN VISIT.MEETING_ID IS NOT NULL AND (ACT.STATUS <> 'DENIED' AND ACT.STATUS <> 'CANCELLED') AND ISNULL(PART.ACTIVITY_ID) THEN 'CONFIRMED' 
                WHEN VISIT.MEETING_ID IS NOT NULL AND (ACT.STATUS <> 'DENIED' AND ACT.STATUS <> 'CANCELLED') AND (SUM(PART.STATUS = 'DENIED') = COUNT(PART.ACTIVITY_ID)) THEN 'CONFIRMED'
                ELSE ACT.STATUS
             END AS TABLE_STATUS,

              PART.EMP_CODE AS PART_EMP_CODE,
              CASE 
                WHEN ACT.HOST_EMP <> '' THEN ACT.HOST_EMP
                WHEN PART.EMP_CODE IS NOT NULL THEN PART.EMP_CODE
                ELSE 'BLANK'
           END AS WITH_PRTCPNT
            FROM NETS_EMP_ACTIVITY ACT
            INNER JOIN NETS_EMP_INFO USER ON ACT.EMP_CODE = USER.EMP_CODE
            LEFT JOIN NETS_EMP_ACT_PARTICIPANTS PART ON PART.ACTIVITY_ID = ACT.ACTIVITY_ID 
            LEFT JOIN NETS_EMP_INFO PART_USER ON PART.EMP_CODE = PART_USER.EMP_CODE 
            LEFT JOIN NETS_VISIT_LOG VISIT ON VISIT.ACTIVITY_ID = ACT.ACTIVITY_ID
            ";
        
         if($this->input->get('requestor') && !$this->input->get('participant')) {
            // if with requestor but no participant selected
            $table .= " WHERE ACT.EMP_CODE = '".$this->input->get('requestor')."' ";
            $table .= " AND (ACT.EMP_CODE = '".$this->session->userdata('EMP_CODE')."' OR ACT.HOST_EMP = '".$this->session->userdata('EMP_CODE')."' OR PART.EMP_CODE ='".$this->session->userdata('EMP_CODE')."' )";

         }  elseif(!$this->input->get('requestor') && $this->input->get('participant')) {
            // if with participant but no requestor selected
            $table .= " WHERE  PART.EMP_CODE = '".$this->input->get('participant')."' ";
            $table .= " AND (ACT.HOST_EMP = '".$this->session->userdata('EMP_CODE')."' OR ACT.EMP_CODE = '".$this->session->userdata('EMP_CODE')."' OR  PART.EMP_CODE = '".$this->session->userdata('EMP_CODE')."' )";

         }  elseif($this->input->get('requestor') && $this->input->get('participant')) {
            // if BOTH requestor and participant selected
            $table .= " WHERE ACT.EMP_CODE = '".$this->input->get('requestor')."' ";
            $table .= " AND PART.EMP_CODE ='".$this->input->get('participant')."'";
            $table .= " AND (ACT.HOST_EMP = '".$this->session->userdata('EMP_CODE')."' OR ACT.EMP_CODE = '".$this->session->userdata('EMP_CODE')."' OR PART.EMP_CODE ='".$this->session->userdata('EMP_CODE')."' )";
            
         } else {
            // DFEAULT
            $table .= " WHERE ((ACT.EMP_CODE = '".$this->session->userdata('EMP_CODE')."' "; 
            $table .= " OR ACT.HOST_EMP = '".$this->session->userdata('EMP_CODE')."' )";
            $table .= "OR ((PART.STATUS = 'CONFIRMED' OR PART.STATUS IS NULL OR PART.STATUS = 'DENIED') AND PART.EMP_CODE = '".$this->session->userdata('EMP_CODE')."')) ";
            
         }

         if($this->input->get('activity_type')) {
            $table .= " AND ACT.ACTIVITY_TYPE LIKE '%".$this->input->get('activity_type')."%' ";
         }


          if($this->input->get('start_dt')) {
            $table .= " AND ACT.ACTIVITY_DATE >= '".$this->input->get('start_dt')."' ";
         }

          if($this->input->get('end_dt')) {
            $table .= " AND ACT.ACTIVITY_DATE <= '".$this->input->get('end_dt')."' ";
         }

        if($this->input->get('status')) {

            if($this->input->get('status') == 'FOR CONFIRMATION') {
                $table .= " GROUP BY ACT.ACTIVITY_ID";
                $table .= " HAVING TABLE_STATUS = '' OR TABLE_STATUS LIKE '%FOR CONFIRMATION%' ";
            
            
            } else {
                 $table .= " GROUP BY ACT.ACTIVITY_ID";
                $table .= " HAVING TABLE_STATUS = '".$this->input->get('status')."' ";
                
            } 
            
        } else {
            $table .= " GROUP BY ACT.ACTIVITY_ID";
        }

       
        $table .= " ORDER BY ACT.ACTIVITY_DATE DESC) temp"; 
       // var_dump($table); exit;
        $primaryKey = 'ACTIVITY_ID';

        $columns = array(
            array( 'db' => 'ACTIVITY_ID', 'dt' => 0, 'field' => 'ACTIVITY_ID' ),
            array( 'db' => 'ACTIVITY_DATE', 'dt' => 1, 'field' => 'ACTIVITY_DATE' ),
            array( 'db' => 'TIME_FROM',  'dt' => 2, 'field' => 'TIME_FROM' ),
            array( 'db' => 'TIME_TO',   'dt' => 3, 'field' => 'TIME_TO' ),
            array( 'db' => 'ACTIVITY_TYPE',     'dt' => 4, 'field' => 'ACTIVITY_TYPE'),
            array( 'db' => 'REQUESTOR',     'dt' => 5, 'field' => 'REQUESTOR' ),
            array( 'db' => 'LOCATION',     'dt' => 6, 'field' => 'LOCATION' ),
            array( 'db' => 'TABLE_STATUS',     'dt' => 7, 'field' => 'TABLE_STATUS' ),
            array( 'db' => 'WITH_PRTCPNT',     'dt' => 8, 'field' => 'WITH_PRTCPNT' )
        );

        // Database connection details
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );

        // check if triggered with filter


        echo json_encode(
            $this->ssp->simple( $_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }

     public function pending_confirmation_list() {
       
        $table = "(
            SELECT 
              ACT.ACTIVITY_ID,
               ACT.ACTIVITY_DATE, 
               ACT.TIME_FROM, 
               ACT.TIME_TO, 
               ACT.ACTIVITY_TYPE, 
               ACT.EMP_CODE, 
               ACT.LOCATION, 
               ACT.STATUS,
               PART.PRTCPNT_ID,
               ACT.ACTIVITY_ID AS PRTCPNT,
               CONCAT(REQUESTOR.EMP_LNAME , ', ' , REQUESTOR.EMP_FNAME) AS REQUESTOR_NAME
            FROM NETS_EMP_ACTIVITY ACT
            INNER JOIN NETS_EMP_INFO REQUESTOR ON REQUESTOR.EMP_CODE = ACT.EMP_CODE
            LEFT JOIN NETS_EMP_ACT_PARTICIPANTS PART ON PART.ACTIVITY_ID = ACT.ACTIVITY_ID
            LEFT JOIN NETS_VISIT_LOG VISIT ON VISIT.ACTIVITY_ID = ACT.ACTIVITY_ID
            WHERE (ACT.HOST_EMP = '".$this->session->userdata('EMP_CODE')."' AND (ACT.STATUS <> 'DENIED' AND ACT.STATUS <> 'CANCELLED') AND VISIT.MEETING_ID IS NULL)  
            OR (ISNULL(PART.STATUS) AND PART.EMP_CODE = '".$this->session->userdata('EMP_CODE')."' AND VISIT.MEETING_ID IS NOT NULL AND (ACT.STATUS <> 'DENIED' AND ACT.STATUS <> 'CANCELLED'))
            OR (ISNULL(PART.STATUS) AND PART.EMP_CODE = '".$this->session->userdata('EMP_CODE')."' AND (ACT.STATUS <> 'DENIED' AND ACT.STATUS <> 'CANCELLED') AND HOST_EMP = '')
            GROUP BY ACT.ACTIVITY_ID
        ) temp";
        $primaryKey = 'ACTIVITY_ID';

        $columns = array(
            array( 'db' => 'PRTCPNT', 'dt' => 0, 'field' => 'PRTCPNT' ),
            array( 'db' => 'ACTIVITY_DATE', 'dt' => 1, 'field' => 'ACTIVITY_DATE' ),
            array( 'db' => 'TIME_FROM',  'dt' => 2, 'field' => 'TIME_FROM' ),
            array( 'db' => 'TIME_TO',   'dt' => 3, 'field' => 'TIME_TO' ),
            array( 'db' => 'ACTIVITY_TYPE',     'dt' => 4, 'field' => 'ACTIVITY_TYPE'),
            array( 'db' => 'REQUESTOR_NAME',     'dt' => 5, 'field' => 'REQUESTOR_NAME' ),
            array( 'db' => 'LOCATION',     'dt' => 6, 'field' => 'LOCATION' )
        );

        // Database connection details
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );

        echo json_encode(
            $this->ssp->simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        );

    }



    public function add_daily_activity_ajax() {
       
        $participants = $this->input->get('participants');
        $employee = $this->session->userdata('EMP_CODE');
        $status = '';
        // if($employee == $this->input->get('host_emp')) {
        //     $status = 'CONFIRMED';
        // }
        $insert_data = array(
            'EMP_CODE' => $employee,
            'ACTIVITY_DATE' => $this->input->get('activity_date'),
            'TIME_FROM' => $this->input->get('time_from'),
            'TIME_TO' => $this->input->get('time_to'),
            'ACTIVITY_TYPE' => $this->input->get('activity_type'),
            'LOCATION' => $this->input->get('location'),
            'HOST_EMP' => $this->input->get('host_emp'),
            'STATUS' => $status,
            'STATUS_DATE' => date('Y-m-d'),
            'UPDATE_USER' => $employee,
            'UPDATE_DATE' => date('Y-m-d')
        );

        $activity_id = $this->Activity_Model->add_daily_activity($insert_data);
        if($participants) {
            foreach ($participants as $participant) {
                  $data = array(
                    'ACTIVITY_ID' => $activity_id,
                    'EMP_CODE' => $participant,
                    'STATUS_DATE' => date('Y-m-d'),
                    'UPDATE_USER' => $employee,
                    'UPDATE_DATE' => date('Y-m-d')
                  );
                  $insert_id = $this->Activity_Model->add_activity_participants($data);

                  $requestor_info = $this->Activity_Model->get_emp_info_by_empcode($employee);
                  $requestor_name = $requestor_info->EMP_FNAME .' '. $requestor_info->EMP_LNAME;
                  // SEND EMAIL SMS TO PARTICIPANTS
                  $participant_info = $this->Activity_Model->get_emp_info_by_empcode($participant);
                  $participant_name = $participant_info->EMP_FNAME .' '. $participant_info->EMP_LNAME;
                  $sms_message = "Good day, ".$participant_name."! You have been listed as a participant of the activity ".$this->input->get('activity_type')." requested by ".$requestor_name." from ".$this->input->get('time_from')." to ".$this->input->get('time_to')." of ".$this->input->get('activity_date').". Please check your e-mail for further details. Please disregard this message if you already complied. Thank you!";

                  $email_message = "Dear ".$participant_name.": <br><br>
                    You have been listed as a participant of the activity  ".$this->input->get('activity_type')." requested by  ".$requestor_name." from ".$this->input->get('time_from')." to ".$this->input->get('time_to')." of ".$this->input->get('activity_date').". <br><br>
                    To confirm the Daily Activity, please copy the link below and paste it into your browser’s address bar. <br><br> ".base_url('login')." <br><br>Please disregard this message if you already complied. 

                    <br><br><br>
                    Thank you.<br><br>
                    <b>Human Resources </b>";
                    if($participant_info->MOBILE_NO <> 0) {
                        $this->sms->send( array('mobile' => $participant_info->MOBILE_NO, 'message' => $sms_message) );
                    }

                    if($participant_info->EMAIL_ADDRESS) {
                        $this->send_email($participant_info->EMAIL_ADDRESS, 'ETS – DAILY ACTIVITY PARTICIPANT CONFIRMATION', $email_message);
                    }
                    
                 
                    
                    
            }
        } elseif(!$participants && !$this->input->get('host_emp')){
            // if no participant, update ACTIVITY STATUS to DONE
            $this->Activity_Model->update_daily_activity_status($activity_id, 'DONE');
        }



        if($activity_id) {
            echo $activity_id;
        } else {
            echo 'Error on adding the Activity. Please contact IT Administrator.';
        }
       

      
    }

     public function update_daily_activity() {
        $update_id = "";
        $activity_type = $this->input->post('hidden_activity_type');
        $participants = $this->input->post('participants');
        $employee = $this->session->userdata('EMP_CODE');
        $activity_id = $this->input->post('activity_id');
        $activity_date = $this->input->post('activity_date');
        $time_from = $this->input->post('time_from');
        $time_to = $this->input->post('time_to');
        $location = $this->input->post('location');
        $host_employee = $this->input->post('hidden_host_employee');
        $current_status = $this->input->post('current_status');

        $result = $this->Activity_Model->validate_daily_activity_requestor($activity_id, $this->session->userdata('EMP_CODE'));
        if($result) {
            

            // get updated activity to compare
            $updated_activity = array(
                'ACTIVITY_DATE' => $activity_date,
                'TIME_FROM' => $time_from,
                'TIME_TO' => $time_to,
                'LOCATION' => $location
            );
            // get existing activity to compare
            $existing = $this->Activity_Model->get_daily_activities_by_activity_id($activity_id);
            $existing_activity = array(
                'ACTIVITY_DATE' => $existing->ACTIVITY_DATE,
                'TIME_FROM' => $existing->TIME_FROM,
                'TIME_TO' => $existing->TIME_TO,
                'LOCATION' => $existing->LOCATION
            );

            $array_diff = array_diff($updated_activity, $existing_activity);
            $update_data = array(
                'EMP_CODE' => $employee,
                'STATUS_DATE' => date('Y-m-d'),
                'UPDATE_USER' => $employee,
                'UPDATE_DATE' => date('Y-m-d')
            );
       
            if(!empty($array_diff)) {
                // if with changes, update daily activity details
                $to_update = array_merge($update_data, $array_diff);
                $update_id = $this->Activity_Model->update_daily_activity($to_update, $activity_id);

                // check if with participants, if yes, change status to NULL = FOR CONFIRMATION
                $exists_part = $this->Activity_Model->get_activity_participants_id($activity_id);
                if($exists_part) {
                    foreach ($exists_part as $participant) {
                        $this->Activity_Model->update_participant_status_by_activity_id($participant->EMP_CODE, $activity_id, NULL);
                        
                    } 
        
                }


                // if requestor is not host employee, change status of activity to blank = FOR CONFIRMATION
                if($employee != $host_employee) {
                    if($current_status != 'DONE') {
                        $this->Activity_Model->update_daily_activity_status($activity_id, '');
                        if($host_employee) {
                            

                           // SEND SMS/ EMAIL TO HOST EMPLOYEE ONLY                          //$this->update_activity_send_sms_email_to_host($activity_id);
                            // remove existing meeting ID
                            $update_id = $this->Activity_model->update_visit_log_meeting_id_by_activity(NULL, $activity_id);
                        }
                    }
                    

                } else {
                    // SEND SMS/ EMAIL TO VISITORS AND HOST EMPLOYEE (AUTO-CONFIRM)
                    $this->update_activity_send_sms_email_to_visitors($activity_id);

                }

                
            }
            
            // get existing participants
            $exists_part = $this->Activity_Model->get_activity_participants_id($activity_id);

            $existing_participants = array();
            if($exists_part) {
                foreach ($exists_part as $participant) {
                    array_push($existing_participants, $participant->EMP_CODE);
                } 
    
            }
           
           
           // If with participants
            if($participants) {
                if(count($existing_participants) > count($participants)) {
                    $array_diff_participants = array_diff( $existing_participants,$participants);
                } else {
                    $array_diff_participants = array_diff( $participants, $existing_participants);
                }
               
                if($array_diff_participants) {
                    $requestor_info = $this->Activity_Model->get_emp_info_by_empcode($employee);
                    $requestor_name = $requestor_info->EMP_FNAME .' '. $requestor_info->EMP_LNAME;

                    foreach ($array_diff_participants as $part_id) {
                        // check if the difference is not existing
                        $does_exist = $this->Activity_model->get_participant_by_participant_activity_id($part_id, $activity_id);

                        if($does_exist) {
                            // if already exist, delete exisiting participants
                            $update_id = $this->Activity_Model->delete_participant($activity_id, $part_id);
                        } else {
                            // if additional, add participants

                            $data = array(
                            'ACTIVITY_ID' => $activity_id,
                            'EMP_CODE' => $part_id,
                            'STATUS_DATE' => date('Y-m-d'),
                            'UPDATE_USER' => $employee,
                            'UPDATE_DATE' => date('Y-m-d')
                            );
                            $update_id = $this->Activity_Model->add_activity_participants($data);
                            // change all existing participants status  to FOR CONFIRMATION
                            $update_id = $this->Activity_Model->update_participant_status_by_activity_id($part_id, $activity_id, NULL);
                             // SEND EMAIL SMS TO PARTICIPANTS
                              $participant_info = $this->Activity_Model->get_emp_info_by_empcode($part_id);
                              $participant_name = $participant_info->EMP_FNAME .' '. $participant_info->EMP_LNAME;
                              $sms_message = "Good day, ".$participant_name."! You have been listed as a participant of the activity ".$activity_type." requested by ".$requestor_name." from ".$time_from." to ".$time_to." of ".$activity_date.". Please check your e-mail for further details. Please disregard this message if you already complied. Thank you!";

                              $email_message = "Dear ".$participant_name.": <br><br>
                                You have been listed as a participant of the activity  ".$activity_type." requested by  ".$requestor_name." from ".$time_from." to ".$time_to." of ".$activity_date.". <br><br>
                                To confirm the Daily Activity, please copy the link below and paste it into your browser’s address bar. <br><br> ".base_url('login')." <br><br>Please disregard this message if you already complied. 

                                <br><br><br>
                                Thank you.<br><br>
                                <b>Human Resources </b>";
                                if($participant_info->MOBILE_NO <> 0) {
                                    $this->sms->send( array('mobile' => $participant_info->MOBILE_NO, 'message' => $sms_message) );
                                }

                                if($participant_info->EMAIL_ADDRESS) {
                                    $this->send_email($participant_info->EMAIL_ADDRESS, 'ETS – DAILY ACTIVITY PARTICIPANT CONFIRMATION', $email_message);
                                }

                            

                        }
                       
                    }
                    // if requestor is not host employee, change status of activity to blank = FOR CONFIRMATION
                    if($employee != $host_employee) {
                        if($current_status != 'DONE') {
                            $this->Activity_Model->update_daily_activity_status($activity_id, '');
                        }
                        
                    }

                   
                }

            } else {
                // check if with existing participnts
                if(count($existing_participants) > 0) {
                    // delete exisiting participants
                    $update_id = $this->Activity_Model->delete_activity_participants($activity_id);
                    // If participants has been removed - update activity status to DONE
                    if(!isset($host_employee)) {
                        $this->Activity_Model->update_daily_activity_status($activity_id, 'DONE');
                    }
                }
               

            }
           


            $exisiting_visitors = $this->Activity_Model->get_activity_visitors_by_activity_id($activity_id);
            if($exisiting_visitors) {
                // update visitors date
                $update_data = array(
                    'VISIT_DATE' => $this->input->post('activity_date')
                );
                $this->Activity_model->update_visitors_date($update_data, $activity_id);
            }

            if($update_id) {
            	echo "<script type='text/javascript'>alert('Activity has been updated.');</script>";
            	redirect('da', 'refresh');  
            } else {
            	echo "<script type='text/javascript'>alert('No changes has been made.');</script>";
            	redirect('da', 'refresh');
            }
           
           
        } else {
            echo "<script type='text/javascript'>alert('Activity date & time already passed, This cannot be updated.');</script>";
            redirect('da', 'refresh');
        }

    }

    function update_activity_send_sms_email_to_visitors($activity_id) {
        // get all visitors by activity id
        // , auto-generate meeting_ID
        $date = date('Ymd');

        $visitors = $this->Activity_model->get_activity_visitors_by_activity_id($activity_id);
        $activity_details = $this->Activity_model->get_daily_activity_by_activity_id($activity_id);

        $host_info = $this->Activity_Model->get_emp_info_by_empcode($activity_details->HOST_EMP);
        $host_name = $host_info->EMP_FNAME .' '. $host_info->EMP_LNAME;

        if($visitors) {
            foreach ($visitors as $visitor) {
                $meeting_ID = $date . str_pad($visitor->VISITOR_ID, 4, '0', STR_PAD_LEFT);
                $this->Activity_Model->update_visit_log_meeting_id($meeting_ID, $visitor->VISITOR_ID);

                $visitors_name = $visitor->VISIT_FNAME .' '. $visitor->VISIT_LNAME;
                $sms_message = "Good day, ".$visitors_name."! Please be advised that your meeting with ".$host_name." on ".$activity_details->ACTIVITY_DATE." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION." has already been confirmed. Your meeting ID is ".$meeting_ID.". Please check your e-mail for further details. Thank you!";

                $email_message = "Dear ".$visitors_name.": <br><br> Good Day! <br><br>
                    Please be advised that your meeting with ".$host_name." on ".$activity_details->ACTIVITY_DATE." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION." has already been confirmed. <br><br>
                    Your meeting ID is ".$meeting_ID.". <br><br>
                    If you encountered any technical problems, please contact ".$host_name." at ".$host_info->EMAIL_ADDRESS." or ".$host_info->MOBILE_NO.".

                <br><br><br>
                Thank you.<br><br>
                <b>Human Resources </b>";
                $this->sms->send( array('mobile' => $visitor->MOBILE_NO, 'message' => $sms_message) );
                $this->send_email($visitor->EMAIL_ADDRESS, 'ETS – '.$visitor->MEETING_ID.' - MEETING UPDATE', $email_message);

                // SMS EMAIL TO HOST_EMPLOYEE FOR MEETING ID
                $sms_message = "Good day, ".$host_name."! Please be informed that you have a meeting with ".$visitors_name." on".$activity_details->ACTIVITY_DATE." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION.". Please check your e-mail for the meeting confirmation. Please disregard this message if you already complied. Thank you!";

                $email_message = "Dear ".$host_name.": <br><br> Good Day! <br><br>
                    Please be informed that you have a meeting with ".$visitors_name."  on ".$activity_details->ACTIVITY_DATE." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION.". <br><br>
                    To confirm the meeting, please copy the link below and paste it into your browser’s address bar. <br><br>".base_url('login')." <br><br>Please disregard this message if you already complied.

                <br><br><br>
                Thank you.<br><br>
                <b>Human Resources </b>";

                if($host_info->MOBILE_NO <> 0) {
                    $this->sms->send( array('mobile' => $host_info->MOBILE_NO, 'message' => $sms_message) );
                }

                if($host_info->EMAIL_ADDRESS) {
                    $this->send_email($host_info->EMAIL_ADDRESS, 'ETS – VISITOR’S MEETING  CONFIRMATION', $email_message);
                }

            }
        }


      
    }


    function update_activity_send_sms_email_to_host($activity_id) {
        // get all visitors by activity id
        // , auto-generate meeting_ID
        $date = date('Ymd');

        $visitors = $this->Activity_model->get_activity_visitors_by_activity_id($activity_id);
        $activity_details = $this->Activity_model->get_daily_activity_by_activity_id($activity_id);

        $host_info = $this->Activity_Model->get_emp_info_by_empcode($activity_details->HOST_EMP);
        $host_name = $host_info->EMP_FNAME .' '. $host_info->EMP_LNAME;

        if($visitors) {
            foreach ($visitors as $visitor) {
                $visitors_name = $visitor->VISIT_FNAME .' '. $visitor->VISIT_LNAME;
                
                // SMS EMAIL TO HOST_EMPLOYEE FOR MEETING ID
                $sms_message = "Good day, ".$host_name."! Please be informed that you have a meeting with ".$visitors_name." on ".$activity_details->ACTIVITY_DATE." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION.". Please check your e-mail for the meeting confirmation. Please disregard this message if you already complied. Thank you!";

                $email_message = "Dear ".$host_name.": <br><br> Good Day! <br><br>
                    Please be informed that you have a meeting with ".$visitors_name." on ".$activity_details->ACTIVITY_DATE." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION.". <br><br>
                    To confirm the meeting, please copy the link below and paste it into your browser’s address bar. <br><br>".base_url('login')." <br><br>Please disregard this message if you already complied.

                <br><br><br>
                Thank you.<br><br>
                <b>Human Resources </b>";
                if($host_info->MOBILE_NO <> 0) {
                    $this->sms->send( array('mobile' => $host_info->MOBILE_NO, 'message' => $sms_message) );
                }

                if($host_info->EMAIL_ADDRESS) {
                    $this->send_email($host_info->EMAIL_ADDRESS, 'ETS – VISITOR’S MEETING  CONFIRMATION', $email_message);
                }
            }
        }



      
    }


    public function add_visitors_log_ajax() {
        if($this->input->is_ajax_request()) {
            $mobile = '09' . $this->input->get('mobile');
            $insert_data = array(
                'VISIT_LNAME' => $this->input->get('visitor_lname'),
                'VISIT_FNAME' => $this->input->get('visitor_fname'),
                'VISIT_MNAME' => $this->input->get('visitor_mname'),
                'COMP_NAME' => $this->input->get('company'),
                'COMP_ADDRESS' => $this->input->get('company_address'),
                'EMAIL_ADDRESS' => $this->input->get('email'),
                'MOBILE_NO' => $mobile,
                'TEL_NO' => $this->input->get('landline'),
                'RES_ADDRESS' => $this->input->get('residential_address'),
                'VISIT_DATE' => $this->input->get('date_visit'),
                'CHECKIN_TIME' => $this->input->get('checkin_time'),
                'CHECKOUT_TIME' => $this->input->get('checkout_time'),
                'VISIT_PURP' => $this->input->get('purpose'),
                'PERS_TOVISIT' => $this->input->get('person_visiting'),
                //body temp question not included
                'Q2' => $this->input->get('q1_id'),
                'A2' => json_encode($this->input->get('q1_answer')),
                'A2DATES' => $this->input->get('inputStartEndDate'),
                'Q3' => $this->input->get('q2_id'),
                'A3' => $this->input->get('q2_answer'),
                'A3TRAVEL_DATES' => $this->input->get('inputTravelDate'),
                'A3PLACE' => $this->input->get('inputTravelLoc'),
                'A3RETURN_DATE' => $this->input->get('inputDatOfReturn'),
                'ACTIVITY_ID' => $this->input->get('v_activity_id')

            );

            $visit_id  = $this->Activity_Model->add_visitors_log($insert_data);

            $activity = $this->Activity_Model->get_daily_activity_by_activity_id($this->input->get('v_activity_id'));

            if($activity->EMP_CODE == $activity->HOST_EMP) {
                // if EMP_CODE matches HOST_EMP, auto-generate meeting_ID
                $date = date('Ymd');
                $meeting_ID = $date . str_pad($visit_id, 4, '0', STR_PAD_LEFT);
                $this->Activity_Model->update_visit_log_meeting_id($meeting_ID, $visit_id);

                $activity_details = $this->Activity_Model->get_daily_activities_by_activity_id($this->input->get('v_activity_id'));
                $host_info = $this->Activity_Model->get_emp_info_by_empcode($activity_details->HOST_EMP);
                $host_name = $host_info->EMP_FNAME .' '. $host_info->EMP_LNAME;

                // SMS EMAIL TO HOST_EMPLOYEE FOR MEETING ID
                $visitors_name = $this->input->get('visitor_fname') .' '. $this->input->get('visitor_lname');
                $activity_details = $this->Activity_Model->get_daily_activities_by_activity_id($this->input->get('v_activity_id'));
                $host_info = $this->Activity_Model->get_emp_info_by_empcode($activity_details->HOST_EMP);
                $host_name = $host_info->EMP_FNAME .' '. $host_info->EMP_LNAME;
                $sms_message = "Good day, ".$host_name."! Please be informed that you have a meeting with ".$this->input->get('visitor_fname')." ".$this->input->get('visitor_lname')." on ".$this->input->get('date_visit')." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION.". Please check your e-mail for the meeting confirmation. Please disregard this message if you already complied. Thank you!";

                $email_message = "Dear ".$host_name.": <br><br> Good Day! <br><br>
                    Please be informed that you have a meeting with ".$this->input->get('visitor_fname')." ".$this->input->get('visitor_lname')."  on ".$this->input->get('date_visit')." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION.". <br><br>
                    To confirm the meeting, please copy the link below and paste it into your browser’s address bar. <br><br>".base_url('login')." <br><br>Please disregard this message if you already complied.

                <br><br><br>
                Thank you.<br><br>
                <b>Human Resources </b>";
                if($host_info->MOBILE_NO <> 0) {
                    $this->sms->send( array('mobile' => $host_info->MOBILE_NO, 'message' => $sms_message) );
                }

                if($host_info->EMAIL_ADDRESS) {
                    $this->send_email($host_info->EMAIL_ADDRESS, 'ETS – VISITOR’S MEETING  CONFIRMATION', $email_message);
                }


                // SMS EMAIL TO VISITORS FOR MEETING ID
                
                $sms_message = "Good day, ".$visitors_name."! Please be advised that your meeting with ".$host_name." on ".$this->input->get('date_visit')." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION." has already been confirmed. Your meeting ID is ".$meeting_ID.". Please check your e-mail for further details. Thank you!";

                $email_message = "Dear ".$visitors_name.": <br><br> Good Day! <br><br>
                    Please be advised that your meeting with ".$host_name." on ".$this->input->get('date_visit')." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION." has already been confirmed. <br><br>
                    Your meeting ID is ".$meeting_ID.". <br><br>
                    If you encountered any technical problems, please contact ".$host_name." at ".$host_info->EMAIL_ADDRESS." or ".$host_info->MOBILE_NO.".

                <br><br><br>
                Thank you.<br><br>
                <b>Human Resources </b>";

                $this->sms->send( array('mobile' => $mobile, 'message' => $sms_message) );
                $this->send_email($this->input->get('email'), 'ETS – '.$meeting_ID.' - MEETING CONFIRMATION', $email_message);
                

            } else {
                // SEND SMS EMAIL TO HOST EMPLOYEE FOR CONFIRMATION
                $activity_details = $this->Activity_Model->get_daily_activities_by_activity_id($this->input->get('v_activity_id'));
                $host_info = $this->Activity_Model->get_emp_info_by_empcode($activity_details->HOST_EMP);
                $host_name = $host_info->EMP_FNAME .' '. $host_info->EMP_LNAME;
                $sms_message = "Good day, ".$host_name."! Please be informed that you have a meeting with ".$this->input->get('visitor_fname')." ".$this->input->get('visitor_lname')." on ".$this->input->get('date_visit')." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION.". Please check your e-mail for the meeting confirmation. Please disregard this message if you already complied. Thank you!";

                $email_message = "Dear ".$host_name.": <br><br> Good Day! <br><br>
                    Please be informed that you have a meeting with ".$this->input->get('visitor_fname')." ".$this->input->get('visitor_lname')."  on ".$this->input->get('date_visit')." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION.". <br><br>
                    To confirm the meeting, please copy the link below and paste it into your browser’s address bar. <br><br>".base_url('login')."<br><br>Please disregard this message if you already complied.

                <br><br><br>
                Thank you.<br><br>
                <b>Human Resources </b>";
                if($host_info->MOBILE_NO <> 0) {
                    $this->sms->send( array('mobile' => $host_info->MOBILE_NO, 'message' => $sms_message) );
                }

                if($host_info->EMAIL_ADDRESS) {
                    $this->send_email($host_info->EMAIL_ADDRESS, 'ETS – VISITOR’S MEETING  CONFIRMATION', $email_message);
                }

            }


            if($visit_id) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
       

    }

    public function confirm_pending_activities() {
        if($this->input->is_ajax_request()) {
            $participant_ids = $this->input->get('participant_ids');
            $update_id= "";
            $activity_id ="";
            $message = "";
            foreach ($participant_ids as $participant_id) {
               
                // check if host
                $is_host = $this->Activity_Model->get_daily_activity_by_hostemployee($participant_id, $this->session->userdata('EMP_CODE'));
                    if($is_host) {
                        $activity_id =  $participant_id;

                        // check if shcedule overlaps
                        $act_details = $this->Activity_Model->get_daily_activity_by_activity_id($activity_id);
                        $validate = $this->Activity_Model->validate_activity_schedule_on_confirm_except($this->session->userdata('EMP_CODE'), $act_details->ACTIVITY_DATE, $act_details->TIME_FROM, $act_details->TIME_TO, $activity_id);
                 
                        if(!$validate) {
                            //check if ACTIVITY has a VISITOR
                            $checker = $this->Activity_Model->get_activity_visitor_by_activity_id($activity_id);
                            if($checker) {
                                foreach ($checker as $activity_visitor) {
                                    $date = date('Ymd');
                                    $meeting_ID = $date . str_pad($activity_visitor->VISITOR_ID, 4, '0', STR_PAD_LEFT);
                                    $update_id = $this->Activity_Model->update_visit_log_meeting_id_by_id($meeting_ID, $activity_visitor->VISITOR_ID);

                                    // SMS EMAIL TO VISITORS FOR MEETING ID
                                    $activity_details = $this->Activity_Model->get_daily_activities_by_activity_id($activity_id);
                                    $host_info = $this->Activity_Model->get_emp_info_by_empcode($activity_details->HOST_EMP);
                                    $host_name = $host_info->EMP_FNAME .' '. $host_info->EMP_LNAME;

                                    $visitors_name = $activity_visitor->VISIT_FNAME.' '. $activity_visitor->VISIT_LNAME;
                                    $sms_message = "Good day, ".$visitors_name."! Please be advised that your meeting with ".$host_name." on ".$activity_details->ACTIVITY_DATE." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION." has already been confirmed. Your meeting ID is ".$meeting_ID.". Please check your e-mail for further details. Thank you!";

                                    $email_message = "Dear ".$visitors_name.": <br><br> Good Day! <br><br>
                                        Please be advised that your meeting with ".$host_name." on ".$activity_details->ACTIVITY_DATE." from ".$activity_details->TIME_FROM." to ".$activity_details->TIME_TO." at ".$activity_details->LOCATION." has already been confirmed. <br><br>
                                        Your meeting ID is ".$meeting_ID.". <br><br>
                                        If you encountered any technical problems, please contact ".$host_name." at ".$host_info->EMAIL_ADDRESS." or ".$host_info->MOBILE_NO.".

                                    <br><br><br>
                                    Thank you.<br><br>
                                    <b>Human Resources </b>";

                                    $this->sms->send( array('mobile' => $activity_visitor->MOBILE_NO, 'message' => $sms_message) );
                                    $this->send_email($activity_visitor->EMAIL_ADDRESS, 'ETS – '.$meeting_ID.' - MEETING CONFIRMATION', $email_message);
                                     $message = "Selected row(s) has been successfully confirmed.";
                            
                                }

                            }

                        } else {
                            $message = "You have already an activity within the specified date and time range.";
                        }
                                   

                    } else {
                        $activity_id = $this->Activity_Model->get_activity_participants_id($participant_id);
                         // check if shcedule overlaps
                        $act_details = $this->Activity_Model->get_daily_activity_by_activity_id($activity_id[0]->ACTIVITY_ID);

                        $validate = $this->Activity_Model->validate_activity_schedule_on_confirm_except($this->session->userdata('EMP_CODE'), $act_details->ACTIVITY_DATE, $act_details->TIME_FROM, $act_details->TIME_TO, $activity_id[0]->ACTIVITY_ID);
                     
                        if(!$validate) {
                            // update NETS_EMP_ACT_PARTICIPANTS - STATUS & STATUS_DATE
                            $data = array(
                                'STATUS' => 'CONFIRMED',
                                'STATUS_DATE' => date('Y-m-d'),
                                'UPDATE_USER' => $this->session->userdata('EMP_CODE'),
                                'UPDATE_DATE' => date('Y-m-d')
                            );
                            $row_id = $this->Activity_Model->update_participant_status_by_activity_empcode($data, $participant_id, $this->session->userdata('EMP_CODE'));
                            // update status of NETS_EMP_ACTIVITY to CONFIRMED (atleast one confirmed & no blanks)
                            $blank_checker = $this->Activity_Model->get_activity_not_confirmed_participants($participant_id);
                            if(count($blank_checker) == 0) {
                                $update_id = $this->Activity_Model->update_daily_activity_status($participant_id, 'CONFIRMED');
                            }

                            $message = "Selected row(s) has been successfully confirmed.";
                        } else {
                            $message = "You have already an activity within the specified date and time range.";
                        }
                        
                    }

               

                  
            } 

            echo $message;

        }

    }

    public function deny_pending_activities() {
        if($this->input->is_ajax_request()) {
            $participants = $this->input->get('participant_ids');
            $update_id= "";
            $activity_id = "";
            $message = "";
            foreach ($participants as $participant_id) {
                // check if host
                $is_host = $this->Activity_Model->get_daily_activity_by_hostemployee($participant_id, $this->session->userdata('EMP_CODE'));
                if($is_host) {
                    $activity_id =  $participant_id;
                   
                     //MEETING ID will be the Validation for the status of Confirmation of HOST_EMPLOYEE. No Meeting ID means not confirmed activity.
                    $update_id = $this->Activity_Model->update_daily_activity_status($activity_id, 'DENIED');
                    $message = "Selected row(s) has been successfully denied.";
                       
                } else {
                     // update NETS_EMP_ACT_PARTICIPANTS - STATUS & STATUS_DATE
                    $data = array(
                        'STATUS' => 'DENIED',
                        'STATUS_DATE' => date('Y-m-d'),
                        'UPDATE_USER' => $this->session->userdata('EMP_CODE'),
                        'UPDATE_DATE' => date('Y-m-d')
                    );
                    $row_id = $this->Activity_Model->update_participant_status_by_activity_empcode($data, $participant_id, $this->session->userdata('EMP_CODE'));
                    //update status of NETS_EMP_ACTIVITY to DENIED (if all participants denied)
                    $check_not_denied = $this->Activity_Model->get_not_denied_activity_by_activity_id($participant_id);
                    // check if WITHOUT HOST EMPLOYEE
                    $check_with_host = $this->Activity_model->get_daily_activities_by_activity_id($participant_id);
                    if(!$check_not_denied) {
                        if($check_with_host->HOST_EMP == "") {
                            $update_id = $this->Activity_Model->update_daily_activity_status($participant_id, 'DENIED');
                        }
                       
                    }
                
                    $message = "Selected row(s) has been successfully denied.";
                }
              
                
            }

            echo $message;
            
        }

    }

    public function edit_activity_part() {
        if($this->input->is_ajax_request()) {
            $participants = array();
            $act_participants = $this->Activity_Model->get_activity_participants_by_activity_id($this->input->get('activity_id'));
            if($act_participants) {
                foreach ($act_participants as $part) {
                   array_push($participants, $part->EMP_CODE);
                }
            }

            $data = array(
                'activity' => $this->Activity_Model->get_daily_activities_by_activity_id($this->input->get('activity_id')),
                'participants' =>  $participants,
                'users' => $this->Activity_Model->get_emp_users()
            );
            $this->load->view('pages/modals/edit_daily_activity', $data);
        }
    }

    public function cancel_activity_part() {
        if($this->input->is_ajax_request()) {
            $data = array(
                'activity' =>  $this->Activity_Model->get_daily_activities_by_activity_id($this->input->get('activity_id'))
            );
            $this->load->view('pages/modals/cancel_daily_activity', $data);
        }
    }

    public function cancel_daily_activity() {
        $activity_id = $this->input->post('cancel_activity_id');
        $update_id = "";
        // check if HOST_EMP and not passed the ACTIVITY DATE + TIME_FROM
        $result = $this->Activity_Model->validate_daily_activity_requestor($activity_id, $this->session->userdata('EMP_CODE'));

        if($result) {
            $update_id = $this->Activity_Model->update_daily_activity_status($activity_id, 'CANCELLED');
        }
       

        if($update_id) {
            echo "<script type='text/javascript'>alert('Activity has been cancelled.');</script>";
            redirect('da', 'refresh');    
        } else {
            echo "<script type='text/javascript'>alert('Activity date & time already passed, This cannot be cancelled.');</script>";
            redirect('da', 'refresh');
        }

    }

    public function view_participants() {
        if($this->input->is_ajax_request()) {
            $data = array(
                'participants' => $this->Activity_Model->get_activity_participants_by_activity_id($this->input->get('activity_id')),
                'visitors' => $this->Activity_Model->get_activity_visitors_by_activity_id($this->input->get('activity_id')),
                'activity_details' => $this->Activity_Model->get_daily_activities_by_activity_id($this->input->get('activity_id'))
            );
            $this->load->view('pages/modals/view_participants', $data);
        }
    }

    public function delete_activity() {
        $activity_id = $this->input->post('delete_activity_id');

        // delete participants
        $this->Activity_Model->delete_activity_participants($activity_id);
        
        // delete visitors if any
        $this->Activity_Model->delete_activity_visitors($activity_id);

        // delete activity
        $result = $this->Activity_Model->delete_activity($activity_id);
        

        if($result) {
            redirect('da', 'refresh');    
        }
    }

    public function validate_if_requestor() {
        $activity_id = $this->input->get('activity_id');
        // check if past dated from date today and is the requestor
        $result = $this->Activity_Model->validate_daily_activity_requestor($activity_id, $this->session->userdata('EMP_CODE'));
        if($result) {
            echo 'true';
        } else {
            echo 'false';
        }

    }

    public function validate_activity_schedule() {
        $activity_date = $this->input->get('activity_date');
        $time_from = $this->input->get('time_from');
        $time_to = $this->input->get('time_to');
        $emp_code = $this->session->userdata('EMP_CODE');
        $host_emp = $this->input->get('host_emp');

        $requestor = '';
        $host_emp_res = '';

        if(!$host_emp) {
            // if no host employee, check if with overlapping activity as requestor
            $requestor = $this->Activity_Model->validate_activity_schedule_by_user($emp_code, $activity_date, $time_from, $time_to);
        } else {
            // check if with overlapping activity as host employee
            $host_emp_res = $this->Activity_Model->validate_activity_schedule_by_user($host_emp, $activity_date, $time_from, $time_to);
        }


        if($requestor) {
            echo 'requestor';
        } elseif($host_emp_res) {
            echo 'host';
        } else {
            echo 'false';
        }

    }

     public function validate_edit_activity_schedule() {
        $activity_date = $this->input->get('activity_date');
        $time_from = $this->input->get('time_from');
        $time_to = $this->input->get('time_to');
        $emp_code = $this->session->userdata('EMP_CODE');
        $host_emp = $this->input->get('hidden_host_employee');
        $activity_id = $this->input->get('activity_id');

        $requestor = '';
        $host_emp_res = '';
     

        if($host_emp == NULL) {
            // if no host employee, check if with overlapping activity as requestor
            $requestor = $this->Activity_Model->validate_activity_schedule_by_user_except($emp_code, $activity_date, $time_from, $time_to, $activity_id);
        } else {
            // check if with overlapping activity as host employee
            $host_emp_res = $this->Activity_Model->validate_activity_schedule_by_user_except($host_emp, $activity_date, $time_from, $time_to, $activity_id);
        }



        if($requestor) {
            echo 'requestor';
        } elseif($host_emp_res) {
            echo 'host';
        } else {
            echo 'false';
        }

    }


    public function send_email($email, $subject, $message){

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From:  <no-reply@ets.com>"; 

        // add disclaimer
        $message .= "<br><br><br><br><small>Disclaimer: This communication is intended solely for the individual to whom it is addressed. If you are not the intended recipient of this communication, you may not disseminate, distribute, copy or otherwise disclose or use the contents of this communication without the written authority of Federal Land, Inc (FLI). If you have received this communication in error, please delete and destroy all copies and kindly notify the sender by return email or telephone immediately. Thank you! </small>";

        $result = mail($email,$subject,$message, $headers);
        return true;
         // if($result == true) {   
         //   return true;
         // } else {
         //    return false;
         // }  

    }



}