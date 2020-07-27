<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

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
        $this->load->model('module');

        // load file helper
        // $this->load->helper('file');

        $this->load->helper('url_helper');

        

    }
    
    public function login(){
        // code for login
        // save user session
        $response['success'] = false;
        $login_id = $this->input->post('LOGIN_ID');
        $password = $this->input->post('PASSWORD');
        
        $data = $this->api_model->login($login_id);
        if(empty($data)){
            $response['success'] = false;
            echo json_encode($response);
        }
        else{
            $password_check = password_verify($password, $data[0]['PASSWORD']);
            if($password_check){
                $this->session->LOGIN_ID = $data[0]['LOGIN_ID'];
                $this->session->EMP_CODE = $data[0]['EMP_CODE'];
                $this->session->RUSH_ID = $data[0]['RUSH_ID'];
                $this->session->ROLE_ID = $data[0]['ROLE_ID'];
                $details = $this->api_model->get_nets_emp_info($data[0]['EMP_CODE']);
                $my_data = array(
                    'COLUMN' => 'LASTLOGINDATE',
                    'VALUE' => date("Y/m/d"),
                    'LOGIN_ID' => $this->session->LOGIN_ID
                );
                $this->api_model->update_nets_emp_user($my_data);
                
                $this->session->EMP_FNAME = $details[0]['EMP_FNAME'];
                $this->session->EMP_LNAME = $details[0]['EMP_LNAME'];

                $module = $this->module->get_access_by_role_id($this->session->ROLE_ID);

                $this->session->module = array_column($module,'module','module');

                $response['success'] = true;
                echo json_encode($response);
            }
            else{
                $response['success'] = false;
                echo json_encode($response);
            }
        }

    }

    public function logout(){
        // code for logout
        // destroy user session
        $my_data = array(
            'COLUMN' => 'LASTLOGOUTDATE',
            'VALUE' => date("Y/m/d"),
            'LOGIN_ID' => $this->session->LOGIN_ID
        );
        $this->api_model->update_nets_emp_user($my_data);
        session_destroy();
        redirect("/login");
    }

    public function register(){
        
    }

    public function server_time(){
        echo time();
    }

    public function server_date(){
        echo date("Y-m-d");
    }

    public function due_time(){
        echo strtotime("01:00:00pm");
    }

    public function submit_ehc(){
        $response['id'] = 0;
        $response['late'] = 0;
        $ehc_due = "01:00:00pm";

        $a3_length = count($_POST['A3']) - 1;
        if($_POST['A3'][$a3_length] == "Others"){
            $_POST['A3'][$a3_length] = $_POST['OTHER_SYMP'];
        }

        $data = array(
            'EMP_CODE' => $_SESSION['EMP_CODE'],
            'EHC_DATE' => date("Y/m/d"),
            'COMPLETION_DATE' => date("Y/m/d H:i:sa"),
            'Q1' => $this->input->post('Q1'),
            'A1' => $this->input->post('A1'),
            'Q2' => $this->input->post('Q2'),
            'A2' => $this->input->post('A2'),
            'A2WHEN' => $this->input->post('A2WHEN'),
            'Q3' => $this->input->post('Q3'),
            'A3' => json_encode($this->input->post('A3')),
            'Q4' => $this->input->post('Q4'),
            'A4' => $this->input->post('A4'),
            'A4WHERE' => $this->input->post('A4WHERE'),
            'A4WHEN' => $this->input->post('A4WHEN'),
            'Q5' => $this->input->post('Q5'),
            'A5' => $this->input->post('A5'),
            'A5WHEN' => $this->input->post('A5WHEN')
        );
        
        // code to save dhc
        $response['id'] = $this->api_model->submit_ehc($data);
        // update SUBMITTED_EHC column in user account table
        if($response['id'] > 0){
            $this->api_model->update_submitted_ehc($_SESSION['EMP_CODE']);
        }
        
        if(time() > strtotime($ehc_due)){
            $data = array(
                'EHC_ID' => $response['id'],
                'REASON' => $this->input->post('reason'),
                'PART_CD' => 'EHC'
            );
            $response['late'] = 1;
            // $response['rush_ticket'] = $this->create_rush_ticket($data);
            // $this->api_model->update_ehc($response['id'], 'RUSHNO', $response['rush_ticket']);
            // $this->api_model->update_ehc($response['id'], 'STATUS', 'I');
            $this->api_model->update_ehc($response['id'], 'REASON', $data['REASON']);
            echo json_encode($response);
        }
        else{
            echo json_encode($response);
        }
        
    }

    public function update_ehc_record(){
        $a3_length = count($_POST['A3']) - 1;
        if($_POST['A3'][$a3_length] == "Others"){
            $_POST['A3'][$a3_length] = $_POST['OTHER_SYMP'];
        }
        $data = array(
            'A1' => $this->input->post('A1'),
            'A2' => $this->input->post('A2'),
            'A2WHEN' => $this->input->post('A2WHEN'),
            'A3' => json_encode($this->input->post('A3')),
            'A4' => $this->input->post('A4'),
            'A4WHERE' => $this->input->post('A4WHERE'),
            'A4WHEN' => $this->input->post('A4WHEN'),
            'A5' => $this->input->post('A5'),
            'A5WHEN' => $this->input->post('A5WHEN')
        );
        $id = $this->input->post('ehc_id');
    
        $this->api_model->update_ehc_record($data, $id);
        $this->api_model->update_ehc($id, 'UPDATE_USER', $_SESSION['LOGIN_ID']);
        $this->api_model->update_ehc($id, 'UPDATE_DATE', date("Y/m/d"));
        
        echo true;
    }

    public function get_questions($data){
        echo json_encode($this->api_model->get_questions($data));
    }

    public function update_ehc($id, $data){
        $this->api_model->update_ehc($response['id'], 'STATUS', $data);
    }

    public function create_rush_ticket($data){
        // used the class created by Ben Zarmaynine E. Obra
        // modified the variables since the class is for another system
        $rush_id[0] = $_SESSION['RUSH_ID'];
        $this->load->library('rush', $rush_id);
        $rush =  $this->rush->rushPOST('PostRequestFormUsingXmlString',[
            'PART_CD' => $data['PART_CD'],
            'LINE_NUM' => '1',
            'EHC_RSN' => $data['REASON']
        ]);

        return $rush;
    }

    public function get_submitted_ehc(){
        echo json_encode($this->api_model->get_submitted_ehc($_SESSION['EMP_CODE']));
    }

    public function get_submitted_hdf(){
        echo json_encode($this->api_model->get_submitted_hdf($_SESSION['EMP_CODE']));
    }

    public function get_all_ehc(){
        $data = array(
            'data' => $this->api_model->get_all_ehc($_SESSION['EMP_CODE'])
        );
        
        echo json_encode($data);
    }

    public function get_ehc_details($data){
        echo json_encode($this->api_model->get_ehc_details($data));
    }

    public function get_ehc_symptoms($data){
        echo json_encode($this->api_model->get_ehc_symptoms($data, $_SESSION['EMP_CODE']));
    }
    
    public function get_emp_info($data){
        echo json_encode($this->api_model->get_emp_info($data));
    }

    public function get_company_desc($data){
        echo json_encode($this->api_model->get_company_desc($data));
    }

    public function get_group_desc($data){
        echo json_encode($this->api_model->get_group_desc($data));
    }

    public function submit_hdf(){
        $response['late'] = 0;
        $consent = $this->input->post('consent');
        if($consent == 1){
            $HEALTH_DEC = 1;
        }
        else {
            $HEALTH_DEC = 0;
        }
        $hdf = array(
            'EMP_CODE' => $_SESSION['EMP_CODE'],
            'HDF_DATE' => date("Y/m/d"),
            'COMPLETION_DATE' => date("Y/m/d H:i:sa"),
            'HEALTH_DEC' => $HEALTH_DEC,
            'REASON' => $this->input->post('REASON')
        );
        $hdf_id = $this->api_model->insert_emp_hdf($hdf);


        for($x = 0; $x < count($this->input->post('HDFHH_A5')); $x++){
            if($_POST['HDFHH_A5'][$x] == "Other"){
                $hdfcd = array(
                    'ANSKEY' => $hdf_id,
                    'EMP_CODE' => $_SESSION['EMP_CODE'],
                    'DISEASE' => $_POST['OTHER_DISEASE_HDFHH'],
                    'HDF_DATE' => date("Y/m/d")
                );
            }
            else{
                $hdfcd = array(
                    'ANSKEY' => $hdf_id,
                    'EMP_CODE' => $_SESSION['EMP_CODE'],
                    'DISEASE' => $this->input->post('HDFHH_A5')[$x],
                    'HDF_DATE' => date("Y/m/d")
                );
            }
            $this->api_model->insert_hdf_other('NETS_HDF_CHRNC_DISEASE', $hdfcd);
        
        }
        
        $residence = "";
        if($this->input->post('HDFHH_A1') == "Others"){
            $residence = $this->input->post('A1OTHERS');
        }
        else{
            $residence = $this->input->post('HDFHH_A1');
        }
        
        $hdfhh = array(
            'HDF_ID' => $hdf_id,
            'Q1' => $this->input->post('HDFHH_Q1'),
            'A1' => $residence,
            'Q2' => $this->input->post('HDFHH_Q2'),
            'A2' => $this->input->post('HDFHH_A2'),
            'Q3' => $this->input->post('HDFHH_Q3'),
            'A3' => $this->input->post('HDFHH_A3'),
            'Q4' => $this->input->post('HDFHH_Q4'),
            'A4' => $this->input->post('HDFHH_A4'),
            'Q5' => $this->input->post('HDFHH_Q5'),
            'A5' => $hdf_id,
            'Q6' => $this->input->post('HDFHH_Q6'),
            'A6' => $this->input->post('HDFHH_A6'),
            'A6HOWMANY' => $this->input->post('A6HOWMANY')
        );
        $this->api_model->insert_hdf_other('NETS_HDF_HHOLD', $hdfhh);

        $hdfhd_a3_last = count($this->input->post('HDFHD_A3')) - 1;
        if($_POST['HDFHD_A3'][$hdfhd_a3_last] == "Other"){
            $_POST['HDFHD_A3'][$hdfhd_a3_last] = $_POST['OTHER_DISEASE_HDFHD'];
        }

        $hdfhd = array(
            'HDF_ID' => $hdf_id,
            'Q1' => $this->input->post('HDFHD_Q1'),
            'A1' => $this->input->post('HDFHD_A1'),
            'A1TEMP' => $this->input->post('A1TEMP'),
            'Q2' => $this->input->post('HDFHD_Q2'),
            'A2' => $this->input->post('HDFHD_A2'),
            'Q3' => $this->input->post('HDFHD_Q3'),
            'A3' => json_encode($this->input->post('HDFHD_A3')),
            'Q4' => $this->input->post('HDFHD_Q4'),
            'A4' => $this->input->post('HDFHD_A4'),
            'A4REASON' => $this->input->post('A4REASON'),
            'Q5' => $this->input->post('HDFHD_Q5'),
            'A5' => $this->input->post('HDFHD_A5'),
            'A5SYMPTOMS' => $this->input->post('A5SYMPTOMS'),
            'A5PERIOD' => $this->input->post('A5PERIOD')
        );
        $this->api_model->insert_hdf_other('NETS_HDF_HEALTHDEC', $hdfhd);

        $hdfth = array(
            'HDF_ID' => $hdf_id,
            'Q1' => $this->input->post('HDFTH_Q1'),
            'A1' => $this->input->post('HDFTH_A1'),
            'A1TRAVEL_DATES' => $this->input->post('A1TRAVEL_DATES'),
            'A1PLACE' => $this->input->post('A1PLACE'),
            'A1RETURN_DATE' => $this->input->post('A1RETURN_DATE'),
            'Q2' => $this->input->post('HDFTH_Q2'),
            'A2' => $this->input->post('HDFTH_A2'),
            'A2TRAVEL_DATES' => $this->input->post('A2TRAVEL_DATES'),
            'A2PLACE' => $this->input->post('A2PLACE'),
            'A2RETURN_DATE' => $this->input->post('A2RETURN_DATE'),
            'Q3' => $this->input->post('HDFTH_Q3'),
            'A3' => $this->input->post('HDFTH_A3'),
            'A3CONTACT_DATE' => $this->input->post('A3CONTACT_DATE'),
            'Q4' => $this->input->post('HDFTH_Q4'),
            'A4' => $this->input->post('HDFTH_A4'),
            'A4NAME' => $this->input->post('A4NAME'),
            'A4VISIT_DATE' => $this->input->post('A4VISIT_DATE')
        );
        $this->api_model->insert_hdf_other('NETS_HDF_TRAVELHISTORY', $hdfth);

        $hdfoi_a3_length = count($_POST['HDFOI_A3']) - 1;
        if($_POST['HDFOI_A3'][$hdfoi_a3_length] == "Others"){
            $_POST['HDFOI_A3'][$hdfoi_a3_length] = $_POST['OTHER_DISEASE_HDFOI'];
        }

        if(isset($_POST['A5FRONTLINER'])){
            $frontliner_length = count($_POST['A5FRONTLINER']) - 1;
            if($_POST['A5FRONTLINER'][$frontliner_length] == "Other"){
                $_POST['A5FRONTLINER'][$frontliner_length] = $_POST['OTHER_FRONTLINER_VALUE'];
            }
        }

        if($this->input->post('HDFOI_A6') == "Others"){
            $shopping = $this->input->post('A6OTHERS');
        }
        else{
            $shopping = $this->input->post('HDFOI_A6');
        }

        $hdfoi = array(
            'HDF_ID' => $hdf_id,
            'Q1' => $this->input->post('HDFOI_Q1'),
            'A1' => $this->input->post('HDFOI_A1'),
            'A1DETAILS' => $this->input->post('A1DETAILS'),
            'Q2' => $this->input->post('HDFOI_Q2'),
            'A2' => $this->input->post('HDFOI_A2'),
            'A2EXPOSURE_DATE' => $this->input->post('A2EXPOSURE_DATE'),
            'Q3' => $this->input->post('HDFOI_Q3'),
            'A3' => json_encode($this->input->post('HDFOI_A3')),
            'Q4' => $this->input->post('HDFOI_Q4'),
            'A4' => $this->input->post('HDFOI_A4'),
            'A4PLACE' => $this->input->post('A4PLACE'),
            'Q5' => $this->input->post('HDFOI_Q5'),
            'A5' => $this->input->post('HDFOI_A5'),
            'A5FRONTLINER' => json_encode($this->input->post('A5FRONTLINER')),
            'Q6' => $this->input->post('HDFOI_Q6'),
            'A6' => $shopping,
            'Q7' => $this->input->post('HDFOI_Q7'),
            'A7' => $this->input->post('HDFOI_A7'),
        );
        $this->api_model->insert_hdf_other('NETS_HDF_OTHERINFO', $hdfoi);

        $emp_info = array(
            'CIVIL_STAT' => $this->input->post('CIVIL_STAT'),
            'PERM_CITY' => $this->input->post('PERM_CITY'),
            'PERM_PROV' => $this->input->post('PERM_PROV'),
            'PRESENT_ADDR1' => $this->input->post('PRESENT_ADDR1'),
            'PRESENT_ADDR2' => $this->input->post('PRESENT_ADDR2'),
            'PRESENT_CITY' => $this->input->post('PRESENT_CITY'),
            'PRESENT_PROV' => $this->input->post('PRESENT_PROV'),
            'TEL_NO' => $this->input->post('TEL_NO'),
            'MOBILE_NO' => $this->input->post('MOBILE_NO')
        );

        $this->api_model->update_emp_info($_SESSION['EMP_CODE'], $emp_info);

        $this->api_model->update_hdf_cutoff($this->input->post('cutoff_id'));

        $this->api_model->submitted_hdf($_SESSION['EMP_CODE']);

        $cutoff_time = $this->api_model->get_cutoff_time($this->input->post('cutoff_id'));

        if(time() > strtotime($cutoff_time[0]['CUTOFF_TIME'])){
            $data = array(
                'REASON' => $this->input->post('REASON'),
                'PART_CD' => 'HDF'
            );

            $response['late'] = 1;
            $response['rush_ticket'] = $this->create_rush_ticket($data);
            
            $rushno = array(
                'RUSHNO' => $response['rush_ticket']
            );
            $this->api_model->update_hdf($hdf_id, $rushno);

            $status = array(
                'STATUS' => 'I'
            );
            $this->api_model->update_hdf($hdf_id, $status);

            // echo json_encode($response);

        }


        echo json_encode($response);
        
        
    }

    public function get_all_hdf(){
        $data = array(
            'data' => $this->api_model->get_all_hdf($_SESSION['EMP_CODE'])
        );
        
        echo json_encode($data);
    }

    public function get_cutoff(){
        $cutoff = $this->api_model->get_cutoff();
        if(strtotime($cutoff[0]['SUBMISSION_DATE']) == strtotime(date('Y/m/d'))){
            echo $cutoff[0]['SUBMISSION_DATE'];
            echo date('Y-m-d');
        }
        if(time() > strtotime($cutoff[0]['CUTOFF_TIME'])){
            echo "\n".time();
            echo "\n".strtotime($cutoff[0]['CUTOFF_TIME']);
        }

        echo "my_time: " . strtotime("13:11");
    }

    public function get_hh($data){
        echo json_encode($this->api_model->get_hh($data));
    }

    public function get_hhcd($data){
        echo json_encode($this->api_model->get_hhcd($data));
    }

    public function get_hd($data){
        echo json_encode($this->api_model->get_hd($data));
    }

    public function get_th($data){
        echo json_encode($this->api_model->get_th($data));
    }

    public function get_oi($data){
        echo json_encode($this->api_model->get_oi($data));
    }

    public function get_hdf($data){
        echo json_encode($this->api_model->get_hdf($data));
    }

    public function update_hdf(){
        $hdf_id = $this->input->post('hdf_id');
        $consent = $this->input->post('consent');
        if($consent == 1){
            $HEALTH_DEC = 1;
        }
        else {
            $HEALTH_DEC = 0;
        }

        $hdf = array(
            'HEALTH_DEC' => $HEALTH_DEC,
            'REASON' => $this->input->post('reason'),
            'UPDATE_USER' => $_SESSION['EMP_CODE'],
            'UPDATE_DATE' => date("Y/m/d")
        );
        
        $this->api_model->update_hdf($hdf_id, $hdf);

        $this->api_model->delete_hdfcd($hdf_id);
        for($x = 0; $x < count($this->input->post('HDFHH_A5')); $x++){
            if($_POST['HDFHH_A5'][$x] == "Other"){
                $hdfcd = array(
                    'ANSKEY' => $hdf_id,
                    'EMP_CODE' => $_SESSION['EMP_CODE'],
                    'DISEASE' => $_POST['OTHER_DISEASE_HDFHH'],
                    'HDF_DATE' => date("Y/m/d"),
                    'UPDATE_USER' => $_SESSION['EMP_CODE'],
                    'UPDATE_DATE' => date("Y/m/d")
                );
            }
            else{
                $hdfcd = array(
                    'ANSKEY' => $hdf_id,
                    'EMP_CODE' => $_SESSION['EMP_CODE'],
                    'DISEASE' => $_POST['HDFHH_A5'][$x],
                    'HDF_DATE' => date("Y/m/d"),
                    'UPDATE_USER' => $_SESSION['EMP_CODE'],
                    'UPDATE_DATE' => date("Y/m/d")
                );
            }
            $this->api_model->update_hdfcd($hdfcd);
        }

        $residence = "";
        if($this->input->post('HDFHH_A1') == "Others"){
            $residence = $this->input->post('A1OTHERS');
        }
        else{
            $residence = $this->input->post('HDFHH_A1');
        }
        
        $hdfhh = array(
            'Q1' => $this->input->post('HDFHH_Q1'),
            'A1' => $residence,
            'Q2' => $this->input->post('HDFHH_Q2'),
            'A2' => $this->input->post('HDFHH_A2'),
            'Q3' => $this->input->post('HDFHH_Q3'),
            'A3' => $this->input->post('HDFHH_A3'),
            'Q4' => $this->input->post('HDFHH_Q4'),
            'A4' => $this->input->post('HDFHH_A4'),
            'Q5' => $this->input->post('HDFHH_Q5'),
            'A5' => $hdf_id,
            'Q6' => $this->input->post('HDFHH_Q6'),
            'A6' => $this->input->post('HDFHH_A6'),
            'A6HOWMANY' => $this->input->post('A6HOWMANY'),
            'UPDATE_USER' => $_SESSION['EMP_CODE'],
            'UPDATE_DATE' => date("Y/m/d")
        );
        $this->api_model->update_hdfhh($hdf_id, $hdfhh);

        $hdfhd_a3_last = count($this->input->post('HDFHD_A3')) - 1;
        if($_POST['HDFHD_A3'][$hdfhd_a3_last] == "Other"){
            $_POST['HDFHD_A3'][$hdfhd_a3_last] = $_POST['OTHER_DISEASE_HDFHD'];
        }
        
        $hdfhd = array(
            'Q1' => $this->input->post('HDFHD_Q1'),
            'A1' => $this->input->post('HDFHD_A1'),
            'A1TEMP' => $this->input->post('A1TEMP'),
            'Q2' => $this->input->post('HDFHD_Q2'),
            'A2' => $this->input->post('HDFHD_A2'),
            'Q3' => $this->input->post('HDFHD_Q3'),
            'A3' => json_encode($this->input->post('HDFHD_A3')),
            'Q4' => $this->input->post('HDFHD_Q4'),
            'A4' => $this->input->post('HDFHD_A4'),
            'A4REASON' => $this->input->post('A4REASON'),
            'Q5' => $this->input->post('HDFHD_Q5'),
            'A5' => $this->input->post('HDFHD_A5'),
            'A5SYMPTOMS' => $this->input->post('A5SYMPTOMS'),
            'A5PERIOD' => $this->input->post('A5PERIOD'),
            'UPDATE_USER' => $_SESSION['EMP_CODE'],
            'UPDATE_DATE' => date("Y/m/d")
        );
        $this->api_model->update_hdfhd($hdf_id, $hdfhd);

        $hdfth = array(
            'Q1' => $this->input->post('HDFTH_Q1'),
            'A1' => $this->input->post('HDFTH_A1'),
            'A1TRAVEL_DATES' => $this->input->post('A1TRAVEL_DATES'),
            'A1PLACE' => $this->input->post('A1PLACE'),
            'A1RETURN_DATE' => $this->input->post('A1RETURN_DATE'),
            'Q2' => $this->input->post('HDFTH_Q2'),
            'A2' => $this->input->post('HDFTH_A2'),
            'A2TRAVEL_DATES' => $this->input->post('A2TRAVEL_DATES'),
            'A2PLACE' => $this->input->post('A2PLACE'),
            'A2RETURN_DATE' => $this->input->post('A2RETURN_DATE'),
            'Q3' => $this->input->post('HDFTH_Q3'),
            'A3' => $this->input->post('HDFTH_A3'),
            'A3CONTACT_DATE' => $this->input->post('A3CONTACT_DATE'),
            'Q4' => $this->input->post('HDFTH_Q4'),
            'A4' => $this->input->post('HDFTH_A4'),
            'A4NAME' => $this->input->post('A4NAME'),
            'A4VISIT_DATE' => $this->input->post('A4VISIT_DATE'),
            'UPDATE_USER' => $_SESSION['EMP_CODE'],
            'UPDATE_DATE' => date("Y/m/d")
        );
        $this->api_model->update_hdfth($hdf_id, $hdfth);

        $hdfoi_a3_length = count($_POST['HDFOI_A3']) - 1;
        if($_POST['HDFOI_A3'][$hdfoi_a3_length] == "Others"){
            $_POST['HDFOI_A3'][$hdfoi_a3_length] = $_POST['OTHER_DISEASE_HDFOI'];
        }

        if(isset($_POST['A5FRONTLINER'])){
            $frontliner_length = count($_POST['A5FRONTLINER']) - 1;
            if($_POST['A5FRONTLINER'][$frontliner_length] == "Other"){
                $_POST['A5FRONTLINER'][$frontliner_length] = $_POST['OTHER_FRONTLINER_VALUE'];
            }
        }

        if($this->input->post('HDFOI_A6') == "Others"){
            $shopping = $this->input->post('A6OTHERS');
        }
        else{
            $shopping = $this->input->post('HDFOI_A6');
        }

        $hdfoi = array(
            'Q1' => $this->input->post('HDFOI_Q1'),
            'A1' => $this->input->post('HDFOI_A1'),
            'A1DETAILS' => $this->input->post('A1DETAILS'),
            'Q2' => $this->input->post('HDFOI_Q2'),
            'A2' => $this->input->post('HDFOI_A2'),
            'A2EXPOSURE_DATE' => $this->input->post('A2EXPOSURE_DATE'),
            'Q3' => $this->input->post('HDFOI_Q3'),
            'A3' => json_encode($this->input->post('HDFOI_A3')),
            'Q4' => $this->input->post('HDFOI_Q4'),
            'A4' => $this->input->post('HDFOI_A4'),
            'A4PLACE' => $this->input->post('A4PLACE'),
            'Q5' => $this->input->post('HDFOI_Q5'),
            'A5' => $this->input->post('HDFOI_A5'),
            'A5FRONTLINER' => json_encode($this->input->post('A5FRONTLINER')),
            'Q6' => $this->input->post('HDFOI_Q6'),
            'A6' => $shopping,
            'Q7' => $this->input->post('HDFOI_Q7'),
            'A7' => $this->input->post('HDFOI_A7'),
            'UPDATE_USER' => $_SESSION['EMP_CODE'],
            'UPDATE_DATE' => date("Y/m/d")
        );
        $this->api_model->update_hdfoi($hdf_id, $hdfoi);

        $emp_info = array(
            'CIVIL_STAT' => $this->input->post('CIVIL_STAT'),
            'PERM_CITY' => $this->input->post('PERM_CITY'),
            'PERM_PROV' => $this->input->post('PERM_PROV'),
            'PRESENT_ADDR1' => $this->input->post('PRESENT_ADDR1'),
            'PRESENT_ADDR2' => $this->input->post('PRESENT_ADDR2'),
            'PRESENT_CITY' => $this->input->post('PRESENT_CITY'),
            'PRESENT_PROV' => $this->input->post('PRESENT_PROV'),
            'TEL_NO' => $this->input->post('TEL_NO'),
            'MOBILE_NO' => $this->input->post('MOBILE_NO'),
            'UPDATE_USER' => $_SESSION['EMP_CODE'],
            'UPDATE_DATE' => date("Y/m/d")
        );

        $this->api_model->update_emp_info($_SESSION['EMP_CODE'], $emp_info);

        $this->api_model->submitted_hdf($_SESSION['EMP_CODE']);

        echo true;
    }

    public function get_hdf_cutoff(){
        $sched = $this->api_model->get_hdf_cutoff(date('Y/m/d'));
        echo strtotime($sched[0]['CUTOFF_TIME']);
    }

    public function get_hdf_cutoff_details(){
        $details = $this->api_model->get_hdf_cutoff_details(date('Y/m/d'));
        echo json_encode($details);
    }

    public function get_required_emps($data){
        echo json_encode($this->api_model->get_required_emps($data));
    }

    public function get_group(){
        echo json_encode($this->api_model->get_group());
    }

    public function get_company(){
        echo json_encode($this->api_model->get_company());
    }

    public function get_ehc_today(){
        $ehc_today = $this->api_model->get_ehc_today($_SESSION['EMP_CODE']);
        echo empty($ehc_today);
    }

    public function get_hdf_today(){
        $hdf_today = $this->api_model->get_hdf_today($_SESSION['EMP_CODE']);
        echo empty($hdf_today);
    }

    // VIEL 05182020
    public function change_password() {
        $new_pass = password_hash($this->input->post('new_pass'), PASSWORD_DEFAULT);
        $update = $this->api_model->update_user_password($this->session->EMP_CODE, $new_pass, date('Y-m-d'));
        if($update) {
            echo "<script type='text/javascript'>alert('Password has been successfully updated. Please re-login.');</script>"; 
            session_destroy();
            redirect('login','refresh');
        }
    }

    public function check_password() {
        if($this->input->is_ajax_request()) {
            $password = $this->input->get('password');
            $logged_user = $this->api_model->get_logged_user_data($this->session->EMP_CODE);
            if(password_verify($password, $logged_user->PASSWORD)) {
                echo 'true';
            } else {
                echo 'false';
            }
        } 
       
    }
       
    // END 05182020
}