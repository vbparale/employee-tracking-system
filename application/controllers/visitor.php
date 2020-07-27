<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class visitor extends CI_Controller {

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

        $this->load->library('session');

        // load model
		$this->load->model('api_model');
		
		// load model
		$this->load->model('visitor_model');

        // load file helper
        // $this->load->helper('file');

        $this->load->helper('url_helper');

		$this->load->helper('form');
		$this->load->library('SMS');
		$this->load->helper('url');
		$this->load->library('SSP');
		$this->load->library('form_validation');
        $this->load->library('session');
	
    }
    
	public function index(){

		if (!isset($this->session->LOGIN_ID)) {
            redirect(base_url('login'));
        }

		if(!isset($this->session->module['VL'])) {
            redirect(base_url(''));
        }
		$this->load->model('visitor_model');
        $this->load->helper('form');
		$Q1 = $this->visitor_model->getQuestionaire('EHC', 3);
		$Q2 = $this->visitor_model->getQuestionaire('EHC', 5);
		$employee = $this->visitor_model->getEmployee();
        $data = array(
            'dhc' => "",
            'hdf' => "",
            'da' => "",
            'vl' => "active",
			'rprts' => "",
			'admin' => "",
			'title' => "Employee Tracking System | Visitor's Log",
			"employee" => $employee,
			'Q1' => $Q1,
			'Q2' => $Q2
        );
        $this->load->view('templates/navbar' , $data);
        $this->load->view('pages/vl');
        /* $this->load->view('templates/footer'); */
    }
	
	public function getCheckInCheckOut(){
		if($this->input->is_ajax_request()){
			$data = array();
			
			$data_db = $this->visitor_model->getCheckInCheckOutVisitor();
			
			if($data_db){
				echo json_encode($data_db);
			}else{
				$data['reponse_code'] = '500';
				echo json_encode($data);
			}
		}
	}

	public function tagCheckInCheckOut(){
		if($this->input->is_ajax_request()) {
			date_default_timezone_set('Asia/Manila');
			$id = $this->input->get('id');
			$data = array();
			$validate = $this->visitor_model->validateUserStatus($id);
			$date_now = date("H:i:s");
			$user = $_SESSION['EMP_CODE'];
			$time_form_server = $this->visitor_model->get_curent_time_db();


			if($validate){
				if($validate->CHECKIN_TIME == null && $validate->CHECKOUT_TIME_HOST == null){
					$this->visitor_model->updateCheckinCheckout('CHECKIN_TIME', $id , $time_form_server->time , $user , $date_now);
					$this->visitor_model->updateCheckinCheckout('CHECKOUT_TIME_HOST', $id , $date_now , $user , $date_now);
					$this->visitor_model->updateStatus($id , 'On-going');
					$this->visitor_model->updateStatusActivity($validate->ACTIVITY_ID , 'On-going');
					$data['action'] = 'Checkin';
					$data['success'] = true;
				}else if ($validate->CHECKIN_TIME != null && $validate->CHECKOUT_TIME_HOST != null){
					$this->visitor_model->updateCheckinCheckout('CHECKOUT_TIME', $id , $time_form_server->time , $user , $date_now);
					$this->visitor_model->updateStatus($id , 'DONE');
					$this->visitor_model->updateStatusActivity($validate->ACTIVITY_ID , 'DONE');
					$data['action'] = 'Checkout';
					$data['success'] = true;
				}else{
					$data['action'] = 'Ngix';
					$data['success'] = false;
				}
			}
		}

		echo json_encode($data);
	}

	public function getVisitorLog(){
		if($this->input->is_ajax_request()){
			$data = array();
			
			$data_db = $this->visitor_model->getVisitorLogs();
			
			if($data_db){
				echo json_encode($data_db);
			}else{
				$data['reponse_code'] = '500';
				echo json_encode($data);
			}
		}
	}

	public function getVisitorLogID(){
		if($this->input->is_ajax_request()){
			$data = array();
			$id = $this->input->get('id');

			$data_db = $this->visitor_model->getVisitorLogsbyID($id);

			$emp = $this->visitor_model->getEmployee();
			
			if($data_db){
				$data['data_db'] = $data_db;
				$data['get_employee'] = $emp;

				echo json_encode($data);

				$this->load->view('pages/modals/vl_add_view', $data);
			}else{
				$data['reponse_code'] = '500';
				echo json_encode($data);
			}
		}
	}

	public function getEmployee(){
		if($this->input->is_ajax_request()){
			$data = array();
			$data_db = $this->visitor_model->getEmployee();
			
			if($data_db){
				echo json_encode($data_db);
			}else{
				$data['reponse_code'] = '500';
				echo json_encode($data);
			}
		}
	}

	public function getQuestionaire(){
		if($this->input->is_ajax_request()){
			$data = array();

			$data_db = $this->visitor_model->getEmployee();
			
			if($data_db){
				echo json_encode($data_db);
			}else{
				$data['reponse_code'] = '500';
				echo json_encode($data);
			}
		}
	}

	public function add_visitor_log(){

		$validation = array('success' => 'false','messages' => array());
	
		if($this->input->is_ajax_request() && $this->input->post()){
			$this->form_validation->set_rules('inputVisitorNameLN','Visitor Last Name','required|trim|alpha');
			$this->form_validation->set_rules('inputVisitorNameFN','Visitor First Name','required|trim|alpha');
			$this->form_validation->set_rules('inputCompany','Company Name','required|trim');
			$this->form_validation->set_rules('inputCompanyAdd','Company Address','required|trim');
			$this->form_validation->set_rules('inputMobile','Mobile Number','trim|required|min_length[11]|max_length[11]|numeric');
			$this->form_validation->set_rules('inputResAdd','Residential Adddress','required|trim');

			if($this->input->post('inputLandline')){
				$this->form_validation->set_rules('inputLandline','Landline','required|trim|min_length[8]|max_length[10]|numeric');
			}

			if($this->input->post('inputVisitorNameMN')){
				$this->form_validation->set_rules('inputVisitorNameMN','Visitor Middle Name','required|trim|alpha');
			}

			$this->form_validation->set_rules('inputEmail','Email Address','required|trim|valid_emails');
			$this->form_validation->set_rules('inputTimeFrom','Time From','required|trim');
			$this->form_validation->set_rules('inputTimeTo','Time To','required|trim' );
			$this->form_validation->set_rules('inputPurposeVisit','Purpose of Visit','required|trim');
			$this->form_validation->set_rules('inputBodyTemp','Body temperature','required|trim|numeric');
		/* 	$this->form_validation->set_rules('inputHost','Person/Group Visiting','required|trim'); */
			$this->form_validation->set_rules('InputMeetingLocation','Meeting location','required|trim');
			
			/* $this->form_validation->set_rules('inputPart','Person Participants','required|trim'); */
			/* $this->form_validation->set_rules('controlSelectStatusQ1','sickness/symptoms','required|trim'); */
			$this->form_validation->set_rules('controlSelectStatusQ2','Answer travelled on the document cases of CoVid 19','required|trim');
			

			if($this->input->post('controlSelectStatusQ1')){
				if(in_array("12", $this->input->post('controlSelectStatusQ1'))){
					$this->form_validation->set_rules('inputOtherSickness','other sickness ','required|trim');
					$this->form_validation->set_rules('inputStartEndDate','started and ended','required|trim');
				}else if (!in_array("11", $this->input->post('controlSelectStatusQ1'))){
					$this->form_validation->set_rules('inputStartEndDate','started and ended','required|trim');
				}
			}else{
				$this->form_validation->set_rules('controlSelectStatusQ1','sickness/symptoms','required|trim');
			}
			


			if($this->input->post('controlSelectStatusQ2') == 1){
				$this->form_validation->set_rules('inputTravelDate','Travel Date','required|trim');
				$this->form_validation->set_rules('inputTravelLoc','Travel Location','required|trim');
				$this->form_validation->set_rules('inputDatOfReturn','Date of return','required|trim'); 
			}

		
		 	if(strtotime( $this->input->post('inputTimeFrom')) > strtotime( $this->input->post('inputTimeTo'))){
				$this->form_validation->set_rules('inputTimeTo','Time To is greater than Time from','required|trim' );
			} 

			if($this->form_validation->run() == TRUE){

				/* For inserting employee activity */
					$insert_employee_activity = array(
						'EMP_CODE' => $this->session->userdata('EMP_CODE'),
						'ACTIVITY_DATE' => date('Y-m-d'),
						'TIME_FROM' =>  $this->input->post('inputTimeFrom'),
						'TIME_TO' => $this->input->post('inputTimeTo'),
						'ACTIVITY_TYPE' => 'Meeting with Visitor/s',
						'LOCATION' => $this->input->post('InputMeetingLocation'), 
						'HOST_EMP' => $this->input->post('inputHost'),
						'STATUS_DATE' => date('Y-m-d'),
						'UPDATE_USER' => $this->session->userdata('EMP_CODE'),
						'UPDATE_DATE' => date('Y-m-d')
					);
					$insert_employee_activity_id = $this->visitor_model->add_activity($insert_employee_activity);
				/* End For inserting employee activity */

				$sicknes = $this->input->post('controlSelectStatusQ1');
				$other_sickness = array_push($sicknes, $this->input->post('inputOtherSickness'));

				/* For Visitory log inserting */
					$insert_visitor = array(
						'VISIT_LNAME' => ucwords($this->input->post('inputVisitorNameLN')),
						'VISIT_FNAME' => ucwords($this->input->post('inputVisitorNameFN')),
						'VISIT_MNAME' => ucwords($this->input->post('inputVisitorNameMN')),
						'COMP_NAME' => $this->input->post('inputCompany'),
						'COMP_ADDRESS' => $this->input->post('inputCompanyAdd'),
						'EMAIL_ADDRESS' => $this->input->post('inputEmail'),
						'MOBILE_NO' => $this->input->post('inputMobile'),
						'TEL_NO' => $this->input->post('inputLandline'),
						'RES_ADDRESS' => $this->input->post('inputResAdd'),
						'VISIT_DATE' => $this->input->post('dateOfVisit'),
						'VISIT_PURP' => $this->input->post('inputPurposeVisit'),
						'PERS_TOVISIT' => $this->input->post('inputHost'),
						'Q1' => 1,
						'A1' => $this->input->post('inputBodyTemp'),
						'Q2' => 3,
						'A2' => json_encode($sicknes),
						'A2DATES' => $this->input->post('inputStartEndDate'),
						'Q3' => 4,
						'A3' => $this->input->post('controlSelectStatusQ2'),
						'A3TRAVEL_DATES' => $this->input->post('inputTravelDate'),
						'A3PLACE' => $this->input->post('inputTravelLoc'),
						'A3RETURN_DATE' => $this->input->post('inputDatOfReturn'),
						/* 'STATUS' => 'FOR CONFIRMATION', */
						'STATUS_DATE' => date('Y-m-d'),
						'UPDATE_USER' => $this->session->userdata('EMP_CODE'),
						'UPDATE_DATE' => date('Y-m-d'),
						'ACTIVITY_ID' => $insert_employee_activity_id
					);
					$visitor_id = $this->visitor_model->addVisitorLog($insert_visitor);
				/* End For Visitory log inserting */


				/* Insert participant employee */

					if($this->input->post('inputPart')){
						foreach ($this->input->post('inputPart') as $value) {
							$act_part = array(
								'ACTIVITY_ID' => $insert_employee_activity_id,
								'EMP_CODE' => $value,
								'STATUS' => NULL, 
								'STATUS_DATE' => date('Y-m-d'),
								'UPDATE_USER' => $this->session->userdata('EMP_CODE'),
								'UPDATE_DATE' => date('Y-m-d')
							);
							$insert_part = $this->visitor_model->add_participants($act_part); 
						}
					}
				/* End Insert participant employee */
				

				// SEND EMAIL SMS TO HOST EMPLOYEE
		 	 	$host_employee = $this->visitor_model->get_emp_info_by_empcode($this->input->post('inputHost'));
				$host_employee_name = $host_employee->EMP_LNAME .', '. $host_employee->EMP_FNAME;
				$sms_message = "Good day, ".$host_employee_name."!  Please be informed that you have a meeting with ". ucwords($this->input->post('inputVisitorNameLN')) . " , " . ucwords($this->input->post('inputVisitorNameFN')) . " " . ucwords($this->input->post('inputVisitorNameMN')) . " on " . $this->input->post('dateOfVisit') . " from " . $this->input->post('inputTimeFrom'). " to " . $this->input->post('inputTimeTo') . " at " .  $this->input->post('InputMeetingLocation') . ". Please check your e-mail for the meeting confirmation. Please disregard this message if you already complied.Thank you!";

				$email_message = "Dear ".$host_employee_name.": <br><br>
				Good day!
				<br><br>
				Please be informed that you have a meeting with ".ucwords($this->input->post('inputVisitorNameLN')) . " , " . ucwords($this->input->post('inputVisitorNameFN')) . " " . ucwords($this->input->post('inputVisitorNameMN'))." on  ".$this->input->post('dateOfVisit')." from ". $this->input->post('inputTimeFrom')." to ".$this->input->post('inputTimeTo')." at ".  $this->input->post('InputMeetingLocation') .". <br><br>
				To confirm the meeting, please copy the link below and paste it into your browser’s address bar. <br><br>".base_url('login')."
				<br><br>
				Please disregard this message if you already complied.
				<br><br><br>
				Thank you.<br><br>
				<b>Human Resources </b>
				<br><br>
				<small><b>Disclaimer:</b> This communication is intended solely for the individual to whom it is addressed. If you are not the intended recipient of this communication, you may not disseminate, distribute, copy or otherwise disclose or use the contents of this communication without the written authority of Federal Land, Inc (FLI). If you have received this communication in error, please delete and destroy all copies and kindly notify the sender by return email or telephone immediately. Thank you!<small>";

					
				$validation['success'] = true;
				$validation['csrf_hash'] = $this->security->get_csrf_hash();
				echo json_encode($validation);	

			 	//For HOST EMPLOYEE Notification
			  	if($host_employee->MOBILE_NO <> 0) {
					$this->sms->send( array('mobile' => $host_employee->MOBILE_NO, 'message' => $sms_message) );
				}

				if($host_employee->EMAIL_ADDRESS) {
					$this->send_email($host_employee->EMAIL_ADDRESS, 'ETS – VISITOR' . "'" . 's MEETING CONFIRMATION', $email_message);
				} 
				
			}else{
				$validation['success'] = false;
				$validation['csrf_hash'] = $this->security->get_csrf_hash();
				$validation['error_message'] = validation_errors();
				echo json_encode($validation);	
			}
			
		}else{
			$validation['success'] = false;
			$validation['csrf_hash'] = $this->security->get_csrf_hash();
			echo json_encode($validation);	
		}
	}
	
	public function update_visitor_logs(){
		$validation = array('success' => 'false','messages' => array());
		$id = $this->input->post('visitorid');

		if($this->input->is_ajax_request() && $this->input->post()){
			$this->form_validation->set_rules('EditinputVisitorNameLN','Visitor Last Name','required|trim|alpha');
			$this->form_validation->set_rules('EditinputVisitorNameFN','Visitor First Name','required|trim|alpha');
		
			$this->form_validation->set_rules('EditinputCompany','Company Name','required|trim');
			$this->form_validation->set_rules('EditinputCompanyAdd','Company Address','required|trim');
			$this->form_validation->set_rules('EditinputMobile','Mobile Number','trim|required|min_length[11]|max_length[11]|numeric');
			
			if($this->input->post('EditinputLandline')){
				$this->form_validation->set_rules('EditinputLandline','Landline','required|trim|min_length[8]|max_length[10]|numeric');
			}

			if($this->input->post('EditinputVisitorNameMN')){
				$this->form_validation->set_rules('EditinputVisitorNameMN','Visitor Middle Name','required|trim|alpha');
			}

			$this->form_validation->set_rules('EditinputResAdd','Residential Adddress','required|trim');
			$this->form_validation->set_rules('EditdateOfVisit','Date of Visit','required|trim');
			$this->form_validation->set_rules('EditinputEmail','Email Address','required|trim|valid_emails');
			$this->form_validation->set_rules('EditinputTimeFrom','Time From','required|trim');
			$this->form_validation->set_rules('EditinputTimeTo','Time To','required|trim' );
			$this->form_validation->set_rules('EditInputMeetingLocation','Meeting location','required|trim');
			$this->form_validation->set_rules('EditinputPurposeVisit','Purpose of Visit','required|trim');
			$this->form_validation->set_rules('EditinputBodyTemp','Body temperature','required|trim|numeric');
		/* 	$this->form_validation->set_rules('EditinputHost','Person/Group Visiting','required|trim'); */
			/* $this->form_validation->set_rules('inputPart','Person Participants','required|trim'); */
			/* $this->form_validation->set_rules('controlSelectStatusQ1','Sickness/symptoms','required|trim'); */
			$this->form_validation->set_rules('EditcontrolSelectStatusQ2','Answer travelled on the document cases of CoVid 19','required|trim');
			

			/* if(in_array("12", $this->input->post('EditcontrolSelectStatusQ1'))){
				$this->form_validation->set_rules('EditinputOtherSickness','other sickness ','required|trim');
				$this->form_validation->set_rules('EditinputStartEndDate','started and ended','required|trim');
			} */


			if($this->input->post('EditcontrolSelectStatusQ2') == 1){
				$this->form_validation->set_rules('EditinputTravelDate','Travel Date','required|trim');
				$this->form_validation->set_rules('EditinputTravelLoc','Travel Location','required|trim');
				$this->form_validation->set_rules('EditinputDatOfReturn','Date of return','required|trim'); 
			}


			if($this->input->post('EditcontrolSelectStatusQ2') == 1){
				$EditinputTravelDate = $this->input->post('EditinputTravelDate')  ;
				$EditinputTravelLoc = $this->input->post('EditinputTravelLoc') ;
				$EditinputDatOfReturn = $this->input->post('EditinputDatOfReturn') ;
			}else{
				$EditinputTravelDate = "";
				$EditinputTravelLoc = "";
				$EditinputDatOfReturn = "";
			}


			if($this->form_validation->run() == TRUE){
				
				$update_to_null = $this->visitor_model->update_to_null('A2' , $id);

				$sicknes = $this->input->post('EditcontrolSelectStatusQ1');
				$other_sickness = array_push($sicknes, $this->input->post('EditinputOtherSickness'));

				$update_visitory_logs = $this->visitor_model->update_visitor_logs($this->input->post('EditinputVisitorNameLN') , $this->input->post('EditinputVisitorNameFN') , $this->input->post('EditinputVisitorNameMN') ,
				$this->input->post('EditinputCompany') , $this->input->post('EditinputCompanyAdd') , $this->input->post('EditinputEmail') , $this->input->post('EditinputMobile') , $this->input->post('EditinputLandline') , $this->input->post('EditinputResAdd') ,
				$this->input->post('EditdateOfVisit') , $this->input->post('EditinputPurposeVisit') , $this->input->post('EditinputHost') , $this->input->post('EditinputBodyTemp') , json_encode($sicknes) , 
				$this->input->post('EditinputStartEndDate') , $this->input->post('EditcontrolSelectStatusQ2') , $EditinputTravelDate , $EditinputTravelLoc ,  $EditinputDatOfReturn , $this->session->userdata('EMP_CODE') , date('Y-m-d') , $id);

				if($update_visitory_logs){
					$activity_id = $this->visitor_model->getActivityID($id);
					$update_acitivy = $this->visitor_model->update_activity($activity_id->ACTIVITY_ID , $this->input->post('EditinputTimeFrom') , $this->input->post('EditinputTimeTo') ,  $this->input->post('EditInputMeetingLocation'));
				}

				if($update_visitory_logs){
					$visitor = $this->visitor_model->getVisitorLogsbyID($id);

					$this->visitor_model->delete_part($visitor->VISITOR_ID);

					//$visitor_activity_id = $this->visitor_model->getactivity($id);
					
					$activity_id = $this->visitor_model->getActivityID($id);

					/* Insert participant employee */
					if($this->input->post('EditinputPart')){
						foreach ($this->input->post('EditinputPart') as $value) {
							$act_part = array(
								'ACTIVITY_ID' => $activity_id->ACTIVITY_ID,
								'EMP_CODE' => $value,
								'STATUS' => 'For Confirmation',
								'STATUS_DATE' => date('Y-m-d'),
								'UPDATE_USER' => $this->session->userdata('EMP_CODE'),
								'UPDATE_DATE' => date('Y-m-d')
							);
							$insert_part = $this->visitor_model->add_participants($act_part); 
						}
					}
					/* End Insert participant employee */
				}
				$validation['success'] = true;
				$validation['csrf_hash'] = $this->security->get_csrf_hash();
				echo json_encode($validation);
			}else{
				$validation['success'] = false;
				$validation['error_message'] = validation_errors();
				$validation['csrf_hash'] = $this->security->get_csrf_hash();
				echo json_encode($validation);
			}
		}else{
			$validation['success'] = false;
			$validation['csrf_hash'] = $this->security->get_csrf_hash();
			echo json_encode($validation);
		}
	}

	public function view_visitor_logs() {
        if($this->input->is_ajax_request()) {

			$visitor =  $this->visitor_model->getVisitorLogsbyID($this->input->get('id'));
			$participants = $this->visitor_model->get_visitor_part_id_only($this->input->get('id'));
			$Q1 = $this->visitor_model->getQuestionaire('EHC', 3);
			$Q2 = $this->visitor_model->getQuestionaire('EHC', 5);
			$employee = $this->visitor_model->getEmployee();
			$arrayPart = array();

			if($participants){
				foreach($participants as $part){
					array_push($arrayPart, $part->EMP_CODE);
				}
			}

            $data = array(
				'visitor' => $visitor , 
				'employee' => $employee,
				'participants' => $arrayPart,
				'Q1' => $Q1 , 
				'Q2' => $Q2
			);
			
			$this->load->view('pages/modals/view_edit_visitor_log', $data);
			
        }
	}

	public function search_CheckOut() {

		$date_now = date("Y-m-d");

		$table = "
		  (SELECT DISTINCT CONCAT(VISIT_LNAME , ', ' , VISIT_FNAME , ' '  , VISIT_MNAME) as FULL_NAME ,
		  CONCAT(nets_emp_info.EMP_LNAME , ', ' , nets_emp_info.EMP_FNAME , ' '  , nets_emp_info.EMP_MNAME) as VISIT_FULL_NAME ,
		  nets_emp_activity.STATUS AS STATUS_DENIED , nets_visit_log.* ,
		  CONCAT(nets_emp_info.EMP_LNAME , ', ' , nets_emp_info.EMP_FNAME , ' '  , nets_emp_info.EMP_MNAME) as PERSON_VISIT 
		  FROM nets_visit_log
		  INNER JOIN nets_emp_info ON nets_visit_log.PERS_TOVISIT = nets_emp_info.EMP_CODE 
		  INNER JOIN nets_emp_activity ON nets_visit_log.ACTIVITY_ID = nets_emp_activity.ACTIVITY_ID 
		  WHERE nets_emp_activity.STATUS != 'CANCELLED' AND nets_visit_log.STATUS != 'DONE' AND nets_emp_activity.STATUS != 'DENIED' AND nets_visit_log.MEETING_ID != ''
		  AND VISIT_DATE = '$date_now'
		  ";

		  if($this->input->get('vistior_name')) {
			$table .= " AND  CONCAT(VISIT_LNAME , ', ' , VISIT_FNAME , ' '  , VISIT_MNAME) LIKE '%".$this->input->get('vistior_name')."%'";
		  }
 
		  if($this->input->get('person_to_visit')) {
			$table .= " AND PERS_TOVISIT = '".$this->input->get('person_to_visit')."'";
		  }
 
		  if($this->input->get('controlSelectStatus')) {
			if($this->input->get('controlSelectStatus') == 0){
				$table .= " AND STATUS = On-going";
			}else if($this->input->get('controlSelectStatus') == 1){
				$table .= " AND STATUS = Done";
			}

		  }

		  if($this->input->get('meeting_id')){
			$table .= " AND MEETING_ID = '".$this->input->get('meeting_id')."'";
		  }else{
			$table .= " AND MEETING_ID IS NOT NULL ";
		  }


		  if($this->input->get('date')){
			$dateRange = explode('-' , $this->input->get('date'));

			$table .= " AND VISIT_DATE >= '".$dateRange[0]."' AND VISIT_DATE <='". $dateRange[1] ."'";

		  }

		  if($this->input->get('status') != 0){
				if($this->input->get('status') == 1){
					$table .= " AND nets_emp_activity.STATUS = '' AND nets_visit_log.MEETING_ID IS NULL";
				}else if($this->input->get('status') == 2){
					$table .= " AND nets_visit_log.MEETING_ID IS NOT NULL AND nets_visit_log.CHECKIN_TIME IS NULL AND nets_emp_activity.STATUS != 'CANCELLED'";
				}else if($this->input->get('status') == 3){
					$table .= " AND nets_visit_log.STATUS = 'On-going'";
				}else if($this->input->get('status') == 4){
					$table .= " AND nets_emp_activity.STATUS = 'DENIED'";
				}else if($this->input->get('status') == 5){
					$table .= " AND nets_visit_log.STATUS = 'DONE'";
				}else if($this->input->get('status') == 6){
					$table .= " AND nets_emp_activity.STATUS = 'CANCELLED'";
				}
	  		}	
			
		 $table .= ") temp"; 
		 $primaryKey = 'VISITOR_ID';

		 $columns = array(
			 array( 'db' => 'MEETING_ID', 'dt' => 0, 'field' => 'MEETING_ID' ),
			 array( 'db' => 'VISIT_DATE', 'dt' => 1, 'field' => 'VISIT_DATE' ),
			 array( 'db' => 'CHECKIN_TIME',  'dt' => 2, 'field' => 'CHECKIN_TIME' ),
			 array( 'db' => 'CHECKOUT_TIME',   'dt' => 3, 'field' => 'CHECKOUT_TIME' ),
			 array( 'db' => 'FULL_NAME', 'dt' => 4, 'field' => 'VISIT_LNAME'),
			 array( 'db' => 'PERSON_VISIT','dt' => 5, 'field' => 'PERSON_VISIT' ),
			 array( 'db' => 'VISIT_PURP','dt' => 6, 'field' => 'VISIT_PURP' ),
			 array( 'db' => 'COMP_ADDRESS','dt' => 7, 'field' => 'COMP_ADDRESS' )
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
			$this->ssp->simple( $_GET, $sql_details, $table, $primaryKey, $columns )
		);
	}

	public function search_visitor() {
		$table = "
		  (SELECT DISTINCT CONCAT(VISIT_LNAME , ', ' , VISIT_FNAME , ' '  , VISIT_MNAME) as FULL_NAME ,
		  CONCAT(nets_emp_info.EMP_LNAME , ', ' , nets_emp_info.EMP_FNAME , ' '  , nets_emp_info.EMP_MNAME) as VISIT_FULL_NAME ,
		  nets_emp_activity.STATUS AS STATUS_DENIED , nets_emp_activity.LOCATION as LOCATION , nets_visit_log.* FROM nets_visit_log
		  INNER JOIN nets_emp_info ON nets_visit_log.PERS_TOVISIT = nets_emp_info.EMP_CODE 
		  INNER JOIN nets_emp_activity ON nets_visit_log.ACTIVITY_ID = nets_emp_activity.ACTIVITY_ID 
		  ";
		 
		  if($this->input->get('vistior_name')) {
			$table .= " AND  CONCAT(VISIT_LNAME , ', ' , VISIT_FNAME , ' '  , VISIT_MNAME) LIKE '%".$this->input->get('vistior_name')."%'";
		  }

 
		  if($this->input->get('person_to_visit')) {
			$table .= " AND PERS_TOVISIT = '".$this->input->get('person_to_visit')."' ";
		  }
 
		  if($this->input->get('controlSelectStatus')) {

			if($this->input->get('controlSelectStatus') == 0){
				$table .= " AND STATUS = On-going";
			}else if($this->input->get('controlSelectStatus') == 1){
				$table .= " AND STATUS = Done";
			}

		  }

		  if($this->input->get('meeting_id')){
			$table .= " AND MEETING_ID = '".$this->input->get('meeting_id')."'";
		  }

		  if($this->input->get('date')){
			$dateRange = explode('-' , $this->input->get('date'));
			$date_range1 = str_replace('/', '-', $dateRange[0]);
			$date_range2 = str_replace('/', '-', $dateRange[1]);

			$search_date1 = date('Y-m-d', strtotime($date_range1));
			$search_date2 = date('Y-m-d', strtotime($date_range2));

			$table .= " AND VISIT_DATE >= '".$search_date1."' AND VISIT_DATE <='". $search_date2 ."'";

		  }

		  if($this->input->get('status') != 0){
				if($this->input->get('status') == 1){
					$table .= " AND nets_emp_activity.STATUS = '' AND nets_visit_log.MEETING_ID IS NULL";
				}else if($this->input->get('status') == 2){
					$table .= " AND nets_visit_log.MEETING_ID IS NOT NULL AND nets_visit_log.CHECKIN_TIME IS NULL AND nets_emp_activity.STATUS != 'CANCELLED'";
				}else if($this->input->get('status') == 3){
					$table .= " AND nets_emp_activity.STATUS = 'On-going'";
				}else if($this->input->get('status') == 4){
					$table .= " AND nets_emp_activity.STATUS = 'DENIED'";
				}else if($this->input->get('status') == 5){
					$table .= " AND nets_emp_activity.STATUS = 'DONE'";
				}else if($this->input->get('status') == 6){
					$table .= " AND nets_emp_activity.STATUS = 'CANCELLED'";
				}
		  }
		 
		 $table .= ") temp"; 
		 $primaryKey = 'VISITOR_ID';

		 $columns = array(
			 array( 'db' => 'MEETING_ID', 'dt' => 0, 'field' => 'MEETING_ID' ),
			 array( 'db' => 'VISIT_DATE', 'dt' => 1, 'field' => 'VISIT_DATE' ),
			 array( 'db' => 'CHECKIN_TIME',  'dt' => 2, 'field' => 'CHECKIN_TIME' ),
			 array( 'db' => 'CHECKOUT_TIME',   'dt' => 3, 'field' => 'CHECKOUT_TIME' ),
			 array( 'db' => 'FULL_NAME', 'dt' => 4, 'field' => 'VISIT_LNAME'),
			 array( 'db' => 'VISIT_FULL_NAME','dt' => 5, 'field' => 'VISIT_FULL_NAME' ),
			 array( 'db' => 'VISIT_PURP','dt' => 6, 'field' => 'VISIT_PURP' ),
			 array( 'db' => 'LOCATION','dt' => 7, 'field' => 'LOCATION' ),
			 array( 'db' => 'STATUS_DENIED','dt' => 8, 'field' => 'STATUS' ),
			 array( 'db' => 'VISITOR_ID','dt' => 'VISITOR_ID', 'field' => 'VISITOR_ID' )
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
			$this->ssp->simple( $_GET, $sql_details, $table, $primaryKey, $columns )
		);
	}	

	public function send_email($email, $subject, $message){

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From:  <no-reply@ets.com>"; 

        $result = mail($email,$subject,$message, $headers);
        return true;
         // if($result == true) {   
         //   return true;
         // } else {
         //    return false;
         // }  

	}
	
}