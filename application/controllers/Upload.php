<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

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
        $this->load->library('form_validation');
        $this->load->model('Upload_Model');

    }

    public function masterfile() {
        if(!isset($this->session->LOGIN_ID)) {
            redirect(base_url('login'));
        }

        if($this->session->ROLE_ID != 1) {
            redirect(base_url('dhc'));
        }
        
        $this->load->helper('form');
        $data = array(
            'dhc' => "",
            'hdf' => "",
            'da' => "",
            'vl' => "",
            'rprts' => "",
            'admin' => "",
            'title' => "Employee Tracking System | Upload Masterfile"
        );
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/masterfile');
        //$this->load->view('templates/footer');
    }

    public function save_data(){
        set_time_limit(0);
        $this->load->library('PHPExcel');
        $path = './uploads/';
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['remove_spaces'] = TRUE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);       

        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data());
        }
        if(empty($error)){
          if (!empty($data['upload_data']['file_name'])) {
            $import_xls_file = $data['upload_data']['file_name'];
        } 

        $inputFileName = $path . $import_xls_file;
        
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
      
                $flag = true;
                $i=2;
                $error_lines = array();
                foreach ($allDataInSheet as $value) {
                    if ($flag){
                        $flag = false;
                        continue;
                    }


                    if(!empty($value['A'])) {

                       

                        $inserdata['EMP_CODE'] = $value['A'];
                        $inserdata['CARD_NO'] = (empty($value['B']) ? "" : $value['B']);
                        $inserdata['RUSH_ID'] = (empty($value['C']) ? "" : $value['C']);
                        $inserdata['EMP_LNAME'] = (empty($value['D']) ? "" : $value['D']);
                        $inserdata['EMP_MNAME'] = (empty($value['E']) ? "" : $value['E']);
                        $inserdata['EMP_FNAME'] = (empty($value['F']) ? "" : $value['F']);
                        $inserdata['DATE_HIRED'] = (strtotime($value['G']) != NULL) ? date('Y-m-d',strtotime($value['G'])) : '0000-00-00';
                        $inserdata['DATE_EOC'] = (strtotime($value['H']) != NULL) ? date('Y-m-d',strtotime($value['H'])) : '0000-00-00';
                        $inserdata['EMP_STAT'] = (empty($value['I']) ? "" : $value['I']);
                        $inserdata['POS_CODE'] = (empty($value['J']) ? NULL : $value['J']);
                        $inserdata['EMP_LEVEL'] = (empty($value['K']) ? "" : $value['K']);
                        $inserdata['COMP_CODE'] = (empty($value['L']) ? "" : $value['L']);
                        $inserdata['LOC_CODE'] = (empty($value['M']) ? NULL : $value['M']);
                        $inserdata['GRP_CODE'] = (empty($value['N']) ? NULL : $value['N']);
                        $inserdata['DEPT_CODE'] = (empty($value['O']) ? NULL : $value['O']);
                        $inserdata['PRESENT_ADDR1'] = (empty($value['P']) ? NULL : $value['P']);
                        $inserdata['PRESENT_ADDR2'] = (empty($value['Q']) ? NULL : $value['Q']);
                        $inserdata['PRESENT_CITY'] = (empty($value['R']) ? "" : $value['R']);
                        $inserdata['PRESENT_PROV'] = (empty($value['S']) ? "" : $value['S']);
                        $inserdata['PERM_CITY'] = (empty($value['T']) ? "" : $value['T']);
                        $inserdata['PERM_PROV'] = (empty($value['U']) ? "" : $value['U']);
                        $inserdata['MOBILE_NO'] = (empty($value['V']) ? NULL : $value['V']);
                        $inserdata['TEL_NO'] = (empty($value['W']) ? NULL : $value['W']);
                        $inserdata['AGE'] = (empty($value['X']) ? "0" : $value['X']);
                        $inserdata['BIRTHDATE'] = (strtotime($value['Y']) != NULL) ? date('Y-m-d',strtotime($value['Y'])) : '0000-00-00';
                        $inserdata['GENDER'] = (empty($value['Z']) ? "" : $value['Z']);
                        $inserdata['TEAM'] = (empty($value['AA']) ? NULL : $value['AA']);
                        $inserdata['APVL_LVL'] = (empty($value['AB']) ? "0" : $value['AB']);

                        $insert_user['EMP_CODE'] = $value['A'];
                        $insert_user['LOGIN_ID'] = (empty($value['C']) ? "" : $value['C']);
                        $insert_user['EMAIL_ADDRESS'] = (empty($value['AC']) ? "" : $value['AC']);
                        $insert_user['PASSWORD'] = password_hash("password", PASSWORD_DEFAULT);
                        $insert_user['ROLE_ID'] = 2; // 1 = admin, 2 = regular
                        $insert_user['UPDATE_DATE'] = date("Y-m-d");
                        $insert_user['UPDATE_USER'] = $this->session->userdata('EMP_CODE');
                        $insert_user['CREATE_DATE'] = date("Y-m-d");
                        $insert_user['CREATE_USER'] = $this->session->userdata('EMP_CODE');
                        $insert_user['STATUSDATE'] = date("Y-m-d");

                        
                        

                        $is_existing = $this->Upload_Model->get_emp_info_by_empcode($value['A']);
                        if($is_existing) {
                            $update_user['EMP_CODE'] = $value['A'];
                            $update_user['LOGIN_ID'] = (empty($value['C']) ? "" : $value['C']);
                            $update_user['EMAIL_ADDRESS'] = (empty($value['AC']) ? "" : $value['AC']);
                            $update_user['UPDATE_DATE'] = date("Y-m-d");
                            $update_user['UPDATE_USER'] = $this->session->userdata('EMP_CODE');
                            $update_user['STATUSDATE'] = date("Y-m-d");
                            $result = $this->Upload_Model->update_users_info($inserdata, $value['A']);
                            $this->Upload_Model->update_users_login_data($update_user, $value['A']);

                            if(!$result) {
                                array_push($error_lines, $i);
                            }
                        } else {
                            $inserdata['CREATE_DATE'] = date("Y-m-d");
                            $inserdata['UPDATE_DATE'] = date("Y-m-d");
                            $inserdata['UPDATE_USER'] = $this->session->userdata('EMP_CODE');
                            $inserdata['CREATE_USER'] = $this->session->userdata('EMP_CODE');
                            $result = $this->Upload_Model->insert_users_data($inserdata);
                            $this->Upload_Model->insert_users_login_data($insert_user);

                            if(!$result) {
                                array_push($error_lines, $i);
                            }
                        }

                        $i++;
                    }
                   
                    
                }               
                //$result = $this->Upload_Model->import_data($inserdata);  
                $this->Upload_Model->turn_on_checking_constraints();
                if(empty($error_lines)){
                    echo "<script type='text/javascript'>alert('Imported Successfully.');</script>";
                    redirect('upload_masterfile', 'refresh');   

                } else {
                    echo "<script type='text/javascript'>alert('An error has been encountered on the following ROWS: ".implode(" , ", $error_lines) .". Please check the data.');</script>";
                    redirect('upload_masterfile', 'refresh'); 
                }             
     
            } catch (Exception $e) {
               die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' .$e->getMessage());
            }

        }else{
          echo $error['error'];
        }
            
            
        set_time_limit(120);
  }




}
 
