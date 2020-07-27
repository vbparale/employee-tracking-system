<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
        $this->load->model('Users_Model');
        $this->load->model('Cutoff');
        $this->load->model('Roles');
    }


    public function administration()
    {
        if (!isset($this->session->LOGIN_ID)) {
            redirect(base_url('login'));
        }

        if(!isset($this->session->module['HDFCO']) && !isset($this->session->module['UM'])) {
            redirect(base_url(''));
        }
        
        $this->load->helper('form');
        $data = array(
            'dhc' => "",
            'hdf' => "",
            'da' => "",
            'vl' => "",
            'rprts' => "",
            'admin' => "active",
            'title' => "Employee Tracking System | Administration",
            'users_without_info' => $this->Users_Model->get_info_without_users(),
            'companies' => $this->Users_Model->get_companies(),
            'groups' => $this->Users_Model->get_groups(),
            'access_groups' => $this->Users_Model->get_access_groups(),
            'statuses' => $this->Users_Model->get_statuses(),
            'roles' => $this->Roles->getAll('A')
        );
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/admin_module');
    }
    

    public function get_users_info_list() {
       $table = "
         (
            SELECT 
              USER.USER_ID,
              USER.EMP_CODE,
              USER.LOGIN_ID,
              USER.PASSWORD,
              USER_ROLE.ROLE_DESCRIPTION,
              USER_INFO.EMP_FNAME,
              USER_INFO.EMP_LNAME,
              USER_INFO.EMP_MNAME,
              EMP_STAT.EMPSTAT_DESC,
              COMPANY.COMP_NAME,
              GRP.GRP_NAME,
              USER.ROLE_ID
            FROM NETS_EMP_USER USER
            INNER JOIN NETS_EMP_INFO USER_INFO ON USER.EMP_CODE = USER_INFO.EMP_CODE
            INNER JOIN NXX_USER_ROLE USER_ROLE ON USER.ROLE_ID = USER_ROLE.ROLE_ID
            LEFT JOIN NXX_COMPANY COMPANY ON COMPANY.COMP_CODE = USER_INFO.COMP_CODE
            LEFT JOIN NXX_GROUP GRP ON GRP.GRP_CODE = USER_INFO.GRP_CODE
            LEFT JOIN NXX_EMPSTAT EMP_STAT ON EMP_STAT.EMPSTAT_CODE = USER_INFO.EMP_STAT
            WHERE USER.EMP_CODE IS NOT NULL ";
            

         if($this->input->get('company')) {
            $table .= " AND USER_INFO.COMP_CODE = '".$this->input->get('company')."' ";
         }

         if($this->input->get('group')) {
            $table .= " AND USER_INFO.GRP_CODE = '".$this->input->get('group')."' ";
         }

         if($this->input->get('firstname')) {
            $table .= " AND USER_INFO.EMP_FNAME LIKE '%".$this->input->get('firstname')."%' ";
         }

         if($this->input->get('lastname')) {
            $table .= " AND USER_INFO.EMP_LNAME LIKE '%".$this->input->get('lastname')."%' ";
         }

        if($this->input->get('status')) {
            $table .= " AND USER_INFO.EMP_STAT = '".$this->input->get('status')."' ";
            
         }

          if($this->input->get('access_group')) {
            $table .= " AND USER.ROLE_ID = '".$this->input->get('access_group')."' ";
         }

        $table .= ") temp"; 

        $primaryKey = 'USER_ID';

        $columns = array(
            array( 'db' => 'LOGIN_ID', 'dt' => 0, 'field' => 'LOGIN_ID' ),
            array( 'db' => 'EMP_CODE', 'dt' => 1, 'field' => 'EMP_CODE' ),
            array( 'db' => 'EMP_LNAME',  'dt' => 2, 'field' => 'EMP_LNAME' ),
            array( 'db' => 'EMP_FNAME',   'dt' => 3, 'field' => 'EMP_FNAME' ),
            array( 'db' => 'EMP_MNAME',     'dt' => 4, 'field' => 'EMP_MNAME'),
            array( 'db' => 'COMP_NAME',     'dt' => 5, 'field' => 'COMP_NAME' ),
            array( 'db' => 'GRP_NAME',     'dt' => 6, 'field' => 'GRP_NAME' ),
            array( 'db' => 'EMPSTAT_DESC',     'dt' => 7, 'field' => 'EMPSTAT_DESC' ),
            array( 'db' => 'ROLE_DESCRIPTION',     'dt' => 8, 'field' => 'ROLE_DESCRIPTION' )
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

    public function add_user_profile_ajax() {
        if($this->input->is_ajax_request()) {
            $emp_code = $this->input->get('employee_number');
            // INSERT TO NETS EMP USER - LOGIN ID, PASSSWORD, ROLE_ID, EMAIL ADRESS
            $insert_data = array(
                'EMP_CODE' => $emp_code ,
                'LOGIN_ID' => $this->input->get('login_id'),
                'PASSWORD' => password_hash($this->input->get('password'), PASSWORD_DEFAULT ),
                'EMAIL_ADDRESS' => $this->input->get('email_address'),
                'ROLE_ID' => $this->input->get('user_role')
            );

            $info  = $this->Users_Model->add_emp_user($insert_data);

            // UPDATE NETS EMP INFO - MOBILE AND TEL NO.
             $insert_data2 = array(
                'MOBILE_NO' => $this->input->get('mobile'),
                'TEL_NO' => $this->input->get('telephone')

            );
            $user  = $this->Users_Model->update_emp_info($emp_code, $insert_data2);

            if($info && $user) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
       

    }

    public function edit_user_profile() {
        $emp_code = $this->input->post('employee_number');

        // INSERT TO NETS EMP USER - LOGIN ID, PASSSWORD, ROLE_ID, EMAIL ADRESS
        if($this->input->post('password')) {
            $insert_data = array(
                'EMP_CODE' => $emp_code ,
                'LOGIN_ID' => $this->input->post('login_id'),
                'PASSWORD' => password_hash($this->input->post('password'), PASSWORD_DEFAULT ),
                'EMAIL_ADDRESS' => $this->input->post('email_address'),
                'ROLE_ID' => $this->input->post('user_role'),
                'STATUS' => $this->input->post('status')
            );
        } else {
            $insert_data = array(
                'EMP_CODE' => $emp_code ,
                'LOGIN_ID' => $this->input->post('login_id'),
                'EMAIL_ADDRESS' => $this->input->post('email_address'),
                'ROLE_ID' => $this->input->post('user_role'),
                'STATUS' => $this->input->post('status')
            );
        }
        

        $info  = $this->Users_Model->update_emp_user($emp_code, $insert_data);

        // UPDATE NETS EMP INFO - MOBILE AND TEL NO.
         $insert_data2 = array(
            'MOBILE_NO' => $this->input->post('mobile'),
            'TEL_NO' => $this->input->post('telephone')

        );
        $user  = $this->Users_Model->update_emp_info($emp_code, $insert_data2);

        if($info && $user) {
            echo "<script type='text/javascript'>alert('User Profile has been updated.');</script>";
            redirect('administration', 'refresh'); 
        } 
    }

    public function get_user_data_ajax() {
        $employee_code = $this->input->get('emp_code');
        $profile = $this->Users_Model->get_user_by_empcode($employee_code);

        echo json_encode($profile);

    }

    public function edit_user_data_part() {
        if($this->input->is_ajax_request()) {
            $employee_code = $this->input->get('emp_code');

            $data = array(
                'profile' => $this->Users_Model->get_complete_user_info_by_empcode($employee_code),
                'companies' => $this->Users_Model->get_companies(),
                'groups' => $this->Users_Model->get_groups(),
                'access_groups' => $this->Users_Model->get_access_groups(),
                'statuses' => $this->Users_Model->get_statuses(),
                'roles' => $this->Roles->getAll('A')
            );
            $this->load->view('pages/modals/edit_user_profile', $data);
        }
    }

    // RAMIL
    public function get_hdf_cutoff(){
        $data = array(
            'data' => $this->Cutoff->get_hdf_cutoff()
        );
        
        echo json_encode($data);
    }

    public function add_hdf_cutoff(){
        $emp_flag = $this->input->post('emp_flag');

        $details = $this->Cutoff->cutoff($this->input->post('submission_date'));

        if(count($details) < 1){
            $data = array(
                'EMP_FLAG' => $emp_flag,
                'SUBMISSION_DATE' => $this->input->post('submission_date'),
                'CUTOFF_TIME' => $this->input->post('cutoff_time'),
                'CREATE_USER' => $_SESSION['LOGIN_ID'],
                'CREATE_DATE' => date('Y/m/d')
            );
            $cutoffid = $this->Cutoff->add_hdf_cutoff($data);
    
            if($emp_flag == 1){
                echo true;
            }
            else{
                $emp_codes = $this->input->post('emp_code');
                for($x = 0; $x < count($emp_codes); $x++){
                    $data = array(
                        'CUTOFF_ID' => $cutoffid,
                        'EMP_CODE' => $emp_codes[$x],
                        'CREATE_USER' => $_SESSION['LOGIN_ID'],
                        'CREATE_DATE' => date('Y/m/d')
                    );
                    $this->Cutoff->add_hdf_ctemp($data);
                }
                echo true;
            }
        }
        else{
            echo false;
        }

        
    }

    public function edit_cutoff_part() {
        if($this->input->is_ajax_request()) {
            $cutoffid = $this->input->get('cutoffid');

            $data = $this->Cutoff->get_cutoff_details($cutoffid);
            echo json_encode($data);
        }
    }

    public function get_hdf_ctemp(){
        $cutoffid = $this->input->get('cutoffid');
        echo json_encode($this->Cutoff->get_hdf_ctemp($cutoffid));
    }

    public function update_hdf_cutoff(){
        $emp_flag = $this->input->post('emp_flag');

        // $details = $this->Cutoff->cutoff($this->input->post('submission_date'));

        // if(count($details) < 1){
            $data = array(
                'CUTOFFID' => $this->input->post('cutoffid'),
                'EMP_FLAG' => $emp_flag,
                'SUBMISSION_DATE' => $this->input->post('submission_date'),
                'CUTOFF_TIME' => $this->input->post('cutoff_time'),
                'UPDATE_USER' => $_SESSION['LOGIN_ID'],
                'UPDATE_DATE' => date('Y/m/d')
            );
            $this->Cutoff->update_hdf_cutoff($this->input->post('cutoffid'), $data);

            if($emp_flag == 1){
                $this->Cutoff->delete_hdf_ctemp($this->input->post('cutoffid'));
                echo true;
            }
            else{
                $emp_codes = $this->input->post('emp_code');
                $this->Cutoff->delete_hdf_ctemp($this->input->post('cutoffid'));
                for($x = 0; $x < count($emp_codes); $x++){
                    $data = array(
                        'CUTOFF_ID' => $this->input->post('cutoffid'),
                        'EMP_CODE' => $emp_codes[$x],
                        'CREATE_USER' => $_SESSION['LOGIN_ID'],
                        'CREATE_DATE' => date('Y/m/d')
                    );
                    
                    $this->Cutoff->update_hdf_ctemp($data);
                }
                echo true;
            }
        // }
        // else{
        //     echo false;
        // }
    }

    // RAMIL ^

}