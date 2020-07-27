<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportController extends CI_Controller {

    private $form_input;
    public function __construct() {

        parent::__construct();
        $this->load->model('Reports');
        $this->load->model('Employees');
        $this->load->model('Groups');
        $this->load->model('Companies');
        $this->load->library('SSP');
        $this->load->model('CutOffs');
        $this->form_input = [];

    }
    
    public function index(){

        if($this->input->is_ajax_request()){

            if ($this->input->get('type')) {
                
                $get_type = $this->input->get('type');
                
                $validation = array('success' => 'false');

                switch ($get_type) {
                    case 'health_check':
                        
                        $validation['message'] = 'Additional filter for EHC report type';
                        $validation['page'] = $this->load->view('report/filters/ehc','',true);
                        $validation['success'] = 'true';
    
                        break;
    
                    case 'health_declaration':
                        
                        
                        $data['cutOff_list'] = $this->CutOffs->group_by('SUBMISSION_DATE')->get_all();
                        
                        $validation['message'] = 'Additional filter for HDF report type. List of Cut Off dates <strong>Required Field</strong>';
                        $validation['page'] = $this->load->view('report/filters/hdf',$data,true);
                        $validation['success'] = 'true';
                        break;

                    case 'visitors':
                        
                        $validation['message'] = 'Additional filter for Visitor Logs report type';
                        $validation['page'] = $this->load->view('report/filters/visitors','',true);
                        $validation['success'] = 'true';
    
                        break;
                            
                    case 'daily_activity':
                
                        $validation['message'] = 'Additional filter for Daily Activity report type';
                        $validation['page'] = $this->load->view('report/filters/dar','',true);
                        $validation['success'] = 'true';
    
                        break;                            
                    
                    case 'n/a':
                    default:
                        
                        $validation['message'] = 'No Special Filter With this Report Type';
                        $validation['page'] = '';
                        break;
                }
                
                echo json_encode($validation);
                return;                
            }

            $data['report_list'] = array(

                '' => 'Select report type',
                'health_check' => 'Employee Health Check',
                'health_declaration' => 'Health Declaration',
                'visitors' => "Visitor's Log",
                'daily_activity' => 'Daily Activity',
                'priority' => 'Priority List'
            );

            $data['company_list'] = array('' => 'Select Company') + $this->Reports->get_list('company');

            $data['group_list'] = array('' => 'Select Group') + $this->Reports->get_list('group');

            $data['employee_list'] = array('' => 'Select Employee') + $this->Reports->get_list('employees');
            
            $this->load->view('report/main',$data);
        
        } else {

            redirect('/');
        }
    }

    public function index_show(){
        
        if ($this->input->is_ajax_request()) {
            
            $validation = array('success' => 'false','messages' => array());
            $this->form_validation->set_rules('date_start','Date Start','trim|callback_priorDate');
            $this->form_validation->set_rules('date_end','Date End','trim|callback_compareDate');
            $this->form_validation->set_rules('COMP_CODE','Company','required|trim');
            $this->form_validation->set_rules('report_type','Report Type','required|trim|in_list[health_check,health_declaration,visitors,daily_activity,priority]');
            $this->form_validation->set_rules('cut_off','Cut Off Date','trim|callback_cutOff');
            $this->form_validation->set_rules('GRP_CODE','Group','trim|callback_prior');
            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
            
            if ($this->form_validation->run() == TRUE) {
                
                $sick = ($this->input->post('sick_filter') ? $this->input->post('sick_filter') : false);
                $cut_Off = ($this->input->post('cut_off') ? $this->input->post('cut_off') : false);
                $visitor_status = ($this->input->post('visitor_status') ? $this->input->post('visitor_status') : false);
                $dar_status = ($this->input->post('dar_status') ? $this->input->post('dar_status') : false);

                $report_type = $this->input->post('report_type');
                
                $params = array(
                    'date_start' => $this->input->post('date_start'),
                    'date_end' => $this->input->post('date_end'),
                    'emp_code' => $this->input->post('EMP_CODE'),
                    'group' => $this->input->post('GRP_CODE'),
                    'company' => $this->input->post('COMP_CODE'),
                    'sick' => $sick,
                    'cut_off' => $cut_Off,
                    'visitor_status' => $visitor_status,
                    'dar_status' => $dar_status
                );
                
                $selectedEmployee = ($params['emp_code'] ? $this->Employees->fields('EMP_FNAME,EMP_LNAME')->get(array('EMP_CODE' => $params['emp_code'])) : false);
                $selectedGroup = ($params['group'] ? $this->Groups->fields('GRP_NAME')->get(array('GRP_CODE' => $params['group'])) : false);
                $selectedCompany = ($params['company'] ? $this->Companies->fields('COMP_NAME')->get(array('COMP_CODE' => $params['company'])) : false);
                
                $data['form_input'] = array(

                    'date_start' => $params['date_start'],
                    'date_end' => $params['date_end'],
                    'employee' => ($selectedEmployee ? $selectedEmployee['EMP_LNAME'].' '.$selectedEmployee['EMP_FNAME'] : $selectedEmployee),
                    'group'=> ($selectedGroup ? $selectedGroup['GRP_NAME'] : $selectedGroup),
                    'company' => ($selectedCompany ? $selectedCompany['COMP_NAME'] : $selectedCompany),
                    'employee_code' => $params['emp_code'],
                    'cut_off' => $cut_Off
                );

                switch ($report_type) {
                    case 'daily_activity':
                        $data['data_uri'] = base_url('reports/dar').'?company='.$params['company'].'&group='.$params['group'].'&emp_code='.$params['emp_code'].'&date_start='.$params['date_start'].'&date_end='.$params['date_end'].'&cut_off='.$params['cut_off'].'&dar_status='.$params['dar_status'];
                        $data['export_excel'] = base_url('reports/dar/export/excel').'?company='.$params['company'].'&group='.$params['group'].'&emp_code='.$params['emp_code'].'&date_start='.$params['date_start'].'&date_end='.$params['date_end'].'&dar_status='.$params['dar_status'].'&cut_off='.$params['cut_off'];
                        $data['export_pdf'] = base_url('reports/dar/export/pdf').'?company='.$params['company'].'&group='.$params['group'].'&emp_code='.$params['emp_code'].'&date_start='.$params['date_start'].'&date_end='.$params['date_end'].'&dar_status='.$params['dar_status'];

                        $validation['success'] = 'true';
                        $validation['view'] = $this->load->view('report/list_dar',$data,TRUE);
                        break;

                    case 'health_check':
                        $data['data_uri'] = base_url('reports/ehc').'?company='.$params['company'].'&group='.$params['group'].'&emp_code='.$params['emp_code'].'&date_start='.$params['date_start'].'&date_end='.$params['date_end'].'&sick_filter='.$params['sick'].'&cut_off='.$params['cut_off'];
                        $data['export_excel'] = base_url('export').'?report_type=ehc&company='.$params['company'].'&group='.$params['group'].'&emp_code='.$params['emp_code'].'&date_start='.$params['date_start'].'&date_end='.$params['date_end'].'&sick_filter='.$params['sick'];
                        $data['export_pdf'] = base_url('reports/ehc/export/pdf').'?company='.$params['company'].'&group='.$params['group'].'&emp_code='.$params['emp_code'].'&date_start='.$params['date_start'].'&date_end='.$params['date_end'].'&sick_filter='.$params['sick'];


                        $validation['success'] = 'true';
                        $validation['view'] = $this->load->view('report/list_ehc',$data,TRUE);                        
                        break;

                    case 'health_declaration':
                        $data['data_uri'] = base_url('reports/hdf');
                        $data['export_uri'] = base_url('export').'?report_type=hdf&company='.$params['company'].'&group='.$params['group'].'&emp_code='.$params['emp_code'].'&date_start='.$params['date_start'].'&date_end='.$params['date_end'].'&cut_off='.$params['cut_off'];

                        $this->session->set_userdata($params);

                        $validation['success'] = 'true';
                        $validation['view'] = $this->load->view('report/list_hdf',$data,TRUE);                        
                        break;
                    case 'visitors':
                        $data['data_uri'] = base_url('reports/visitors').'?company='.$params['company'].'&group='.$params['group'].'&emp_code='.$params['emp_code'].'&date_start='.$params['date_start'].'&date_end='.$params['date_end'].'&cut_off='.$params['cut_off'].'&visitor_status='.$params['visitor_status'];
                        $data['export_excel'] = base_url('reports/visitors/export/excel').'?company='.$params['company'].'&group='.$params['group'].'&emp_code='.$params['emp_code'].'&date_start='.$params['date_start'].'&date_end='.$params['date_end'].'&visitor_status='.$params['visitor_status'].'&cut_off='.$params['cut_off'];

                        $validation['success'] = 'true';
                        $validation['view'] = $this->load->view('report/list_visitors',$data,TRUE);                        
                        break;

                    case 'priority':
                        
                        $query = $this->Reports->reportBuilder($report_type,$params);
                        
                        $priority_counts = $this->Reports->custom($query);
    
                        if ($priority_counts) {
                            
                            $data['priority'] = $priority_counts;
                        }

                        $data['export_excel'] = base_url('reports/priority/export/excel').'?company='.$params['company'].'&group='.$params['group'].'&emp_code='.$params['emp_code'].'&date_start='.$params['date_start'].'&date_end='.$params['date_end'].'';
                        $data['export_pdf'] = base_url('reports/priority/export/pdf').'?company='.$params['company'].'&group='.$params['group'].'&emp_code='.$params['emp_code'].'&date_start='.$params['date_start'].'&date_end='.$params['date_end'].'';

                        $validation['success'] = 'true';
                        $validation['view'] = $this->load->view('report/list_priority',$data,TRUE);
                        break;
                    default:

                    $validation['success'] = 'error';
                    $validation['message']['messagebox'] = "Selected report type doesn't have data to show";
                    
                    break;
                }

                
                echo json_encode($validation);
                return;

            } else {

                foreach ($this->input->post() as $key => $value) {
                
                    $validation['messages'][$key] = form_error($key);
                }

                $validation['btn_val'] = 'Generate';                    
            }
            
            echo json_encode($validation);

        } else {

            return redirect('/');
        }
    }

    public function show(){

        if ($this->input->is_ajax_request()) {
            
            $report_type = $this->uri->segment(2);
            
            $table = '('.$this->Reports->ReportBuilder($report_type,$this->input->get()).') temp';
            
            switch ($report_type) {

                case 'dar':

                    $columns = array(
                        
                        array('db' => 'ACTIVITY_DATE', 'dt' => 0),
                        array('db' => 'TIME_FROM', 'dt' => 1),
                        array('db' => 'TIME_TO', 'dt' => 2),
                        array('db' => 'ACTIVITY_TYPE', 'dt' => 3),
                        array('db' => 'EMP_NAME', 'dt' => 4),
                        array('db' => 'PARTICIPANTS', 'dt' => 5),
                        array('db' => 'LOCATION', 'dt' => 6),
                        array('db' => 'STATUS', 'dt' => 7),
                        array('db' => 'VISITORS', 'dt' => 8)
                    );
                    
                    $key = $this->Reports->activities_config('pk');
                    break;
                
                case 'ehc':
                    
                    $columns = array(

                        array('db' => 'EHC_DATE', 'dt' => 0),
                        array('db' => 'COMPLETION_DATE', 'dt' => 1),
                        array('db' => 'A1', 'dt' => 2),
                        array('db' => '_A2', 'dt' => 3),
                        array('db' => 'A3', 'dt' => 4),
                        array('db' => 'A4', 'dt' => 5),
                        array('db' => 'A4WHERE', 'dt' => 6),
                        array('db' => 'A4WHEN', 'dt' => 7),
                        array('db' => 'A5', 'dt' => 8),
                        array('db' => 'A5WHEN', 'dt' => 9),
                        array('db' => 'RUSHNO', 'dt' => 10),
                        array('db' => 'REASON', 'dt' => 11),
                        array('db' => 'STATUS', 'dt' => 12),
                        
                    );

                    $key = $this->Reports->hc_config('pk');
                    break;
                
                case 'visitors':

                    $columns = array(

                        array('db' => 'VISIT_DATE', 'dt' => 0),
                        array('db' => 'CHECKIN_TIME', 'dt' => 1),
                        array('db' => 'CHECKOUT_TIME', 'dt' => 2),
                        array('db' => 'VISIT_NAME', 'dt' => 3),
                        array('db' => 'COMP_NAME', 'dt' => 4),
                        array('db' => 'COMP_ADDRESS', 'dt' => 5),
                        array('db' => 'EMAIL_ADDRESS', 'dt' => 6),
                        array('db' => 'MOBILE_NO', 'dt' => 7),
                        array('db' => 'TEL_NO', 'dt' => 8),
                        array('db' => 'RES_ADDRESS', 'dt' => 9),
                        array('db' => 'VISIT_PURP', 'dt' => 10),
                        array('db' => 'EMP_NAME','dt' => 11),
                        array('db' => 'A1', 'dt' => 12),
                        array('db' => 'A2', 'dt' => 13),
                        array('db' => 'A2DATES', 'dt' => 14),
                        array('db' => 'A3', 'dt' => 15),
                        array('db' => 'A3TRAVEL_DATES', 'dt' => 16),
                        array('db' => 'A3PLACE', 'dt' => 17),
                        array('db' => 'A3RETURN_DATE', 'dt' => 18),
                        array('db' => '_status', 'dt' => 19),

                    );
            
                    $key = $this->Reports->visitors_config('pk');
                    break;

                case 'hdf':
                    return false;
                break; 
                default:
                    # code...
                    break;
            }
            
            $ssp = $this->ssp->simple($this->input->get(),$this->Reports->db_config(),$table,$key,$columns);

            if ($ssp) {
                
                echo json_encode($ssp);
            }
            
            return;
        } else {

            return redirect('/');
        }
    }

    public function show_item(){
        /**
         * Special Controller function for hdf
         * Datatables using POST Request
         * 
         */
        if ($this->input->is_ajax_request()) {

            $sessionParams = array(
                'emp_code' => $this->session->userdata('emp_code'),
                'group' => $this->session->userdata('group'),
                'company' => $this->session->userdata('company'),
                'cut_off' => $this->session->userdata('cut_off')
             );

            $report_type = $this->uri->segment(2);
            
            $table = '('.$this->Reports->ReportBuilder($report_type,$sessionParams).') temp';
            
            $columns = array(
                array('db' => 'EMP_LNAME','dt' => 0),
                array('db' => 'EMP_FNAME','dt' => 1),
                array('db' => 'AGE','dt' => 2),
                array('db' => 'GENDER','dt' => 3),
                array('db' => 'CIVIL_STAT','dt' => 4),
                array('db' => 'PRESENT_PROV','dt' => 5),
                array('db' => 'PRESENT_ADDR1','dt' => 6),
                array('db' => 'TEL_NO','dt' => 7),
                array('db' => 'MOBILE_NO','dt' => 8),
                array('db' => 'COMP_NAME','dt' => 9),
                //
                array('db' => 'GRP_NAME','dt' => 10),
                array('db' => 'ea1','dt' => 11),
                array('db' => 'ea2','dt' => 12),
                array('db' => 'ea3','dt' => 13),
                array('db' => 'ea4','dt' => 14),
                array('db' => 'disease','dt' => 15),
                array('db' => 'ea6','dt' => 16),
                array('db' => 'howmany','dt' => 17),
                array('db' => 'fa1','dt' => 18),
                array('db' => 'ftemp','dt' => 19),
                //
                array('db' => 'ia3','dt' => 20),
                array('db' => 'period','dt' => 21),
                array('db' => 'fa2','dt' => 22),
                array('db' => 'fa3','dt' => 23),
                array('db' => 'fa4','dt' => 24),
                array('db' => 'reason','dt' => 25),
                array('db' => 'fa5','dt' => 26),
                array('db' => 'symptoms','dt' => 27),
                array('db' => 'ga1','dt' => 28),
                array('db' => 'travel_date','dt' => 29),
                //
                array('db' => 'ga1place','dt' => 30),
                array('db' => 'ga1return_date','dt' => 31),
                array('db' => 'ga2','dt' => 32),
                array('db' => 'ga2travel_date','dt' => 33),
                array('db' => 'ga2place','dt' => 34),
                array('db' => 'ga2return_date','dt' => 35),
                array('db' => 'ga3','dt' => 36),
                array('db' => 'contact_date','dt' => 37),
                array('db' => 'ga4','dt' => 38),
                array('db' => 'gname','dt' => 39),
                //
                array('db' => 'visit_date','dt' => 40),
                array('db' => 'ha1','dt' => 41),
                array('db' => 'hdetails','dt' => 42),
                array('db' => 'ha2','dt' => 43),
                array('db' => 'exposure_date','dt' => 44),
                array('db' => 'ha3','dt' => 45),
                array('db' => 'ha4','dt' => 46),
                array('db' => 'hplace','dt' => 47),
                array('db' => 'ha5','dt' => 48),
                array('db' => 'A5FRONTLINER','dt' => 49),
                //
                array('db' => 'A6','dt' => 50),
                array('db' => 'A7','dt' => 51),
            );

            $key = 'HDF_ID'; 
            
            $ssp = $this->ssp->simple($this->input->post(),$this->Reports->db_config(),$table,$key,$columns);

            if ($ssp) {
                
                echo json_encode($ssp);
            }
            
            return;

        } else {

            return redirect('/');
        }
    }

    /**
     * Added: Controller function for generating files
     * Author: Ben Zarmaynine E. Obra
     * Date: 05-26-2020
     */

    public function export(){

        $report_type = $this->uri->segment(2);
        $export_type = $this->uri->segment(4);
        $where_string ='';
        
        if ($this->input->get()) {
            
            if ($this->input->get('company')) {
                
                $where['COMP_CODE'] = $this->input->get('company');
            }

            if ($this->input->get('group')) {
                
                $where['GRP_CODE'] = $this->input->get('group');
            }

            if ($this->input->get('emp_code')) {
                
                $where['EMP_CODE'] = $this->input->get('emp_code');
            }
            
            $params = array(

                'date_start' => $this->input->get('date_start'),
                'date_end' => $this->input->get('date_end'),
                'sick' => $this->input->get('sick_filter'),
                'cut_off' => $this->input->get('cut_off'),
                'dar_status' => $this->input->get('dar_status'),
                'visitor_status' => $this->input->get('visitor_status'), 
            );
            
            switch ($report_type) {
                case 'ehc':

                    if ($params['date_start'] && $params['date_end']) {
                        
                        $where_string.= 'AND nets_emp_ehc.EHC_DATE >= "'.$params['date_start'].'" AND nets_emp_ehc.EHC_DATE <= "'.$params['date_end'].'"';
                    
                    } else if($params['date_start']){

                        $where_string.= 'AND nets_emp_ehc.EHC_DATE >= "'.$params['date_start'].'"';
                    } 

                    if ($params['sick']) {
                        
                        $where_string.= 'AND nets_emp_ehc.A2 = "'.$params['sick'].'"';
                    }
                   
                    $total_string = substr(strstr($where_string, " "),1);

                    $employees = $this->Employees
                    ->where($where)
                    ->with_healthChecks(($total_string ? 'where:'.$total_string.'|' : '').'order_inside:EHC_DATE asc')
                    ->order_by('EMP_LNAME')
                    ->get_all();
                    
                    $this->HealthChecks->$export_type($employees,$params);
                    
                    break;

                case 'dar':
                    
                    $params['group'] = $this->input->get('group');

                    $employees = $this->Employees
                    ->where($where)
                    ->with_activities()
                    ->with_company()
                    ->order_by('EMP_LNAME')
                    ->get_all();
                    
                    $this->Activities->$export_type($employees,$params);

                    break;

                case 'visitors':
                    
                    $visit_status = ($params['visitor_status'] ? ' `nets_visit_log`.`STATUS` = "'.$params['visitor_status'].'"' : '');
                    
                    if ($params['date_start'] && $params['date_end']) {
                        
                        $where_string.= 'AND nets_visit_log.VISIT_DATE >= "'.$params['date_start'].'" AND nets_visit_log.VISIT_DATE <= "'.$params['date_end'].'"';
                    
                    } else if($params['date_start']){

                        $where_string.= 'AND nets_visit_log.VISIT_DATE >= "'.$params['date_start'].'"';
                    } 

                    if ($params['visitor_status']) {
                        
                        $where_string.= 'AND nets_visit_log.STATUS = "'.$params['visitor_status'].'"';
                    }
                   
                    $total_string = substr(strstr($where_string, " "),1);

                    $employees = $this->Employees
                    ->where($where)
                    ->with_visitors(($total_string ? 'where:'.$total_string.'|' : '').'order_inside:VISIT_DATE asc')
                    ->with_company()
                    ->order_by('EMP_LNAME')
                    ->get_all();
                    
                    $this->Visitors->$export_type($employees,$params);

                    break;

                case 'priority':
                    
                    $this->Employees->$export_type($this->input->get());

                    break;
                default:
                                    
                    return redirect('rprts');
                    break;
            }

        } else {

            return redirect('rprts');
        }

    }

    /**
     * Contrller Callback function for form validation
     * Author: Ben Zarmaynine E. Obra
     */
	function compareDate(){

		$startDate = strtotime($this->input->post("date_start"));
        $endDate = strtotime($this->input->post("date_end"));
        
        if ($endDate && $startDate == false) {
            
            $this->form_validation->set_message('compareDate','Unable to filter data, Date start should be populated');
            return false;
                        
        } else if($startDate && $endDate == false){

            return true;
        }

		if ($endDate >= $startDate) {
			
			return true;

		} else {

			$this->form_validation->set_message('compareDate','Inputed Date on Date Start should be earlier or same as Date End');
			return false;
		}
    }
    
    function cutOff(){

        $report_type = $this->input->post('report_type');
        $cut_off = $this->input->post('cut_off');

        if ($report_type == 'health_declaration') {
            
            if (!$cut_off) {
                
                $this->form_validation->set_message('cutOff','Cut off Field is Required on this Report Type');
                return false;

            } else {

                return true;
            }

        }
    }

    function prior(){

        $report_type = $this->input->post('report_type');
        $group = $this->input->post('GRP_CODE');

        if ($report_type === 'priority') {
            
            if (!$group) {
                
                $this->form_validation->set_message('prior','Group Code Field is Required on this Report Type');
                return false;                

            } else {

                return true;
            }

        }
    }

    function priorDate(){

        $report_type = $this->input->post('report_type');
        $startDate = $this->input->post('date_start');

        if ($report_type === 'priority') {
            
            if (!$startDate) {
                
                $this->form_validation->set_message('priorDate','Date Start Field is Required on this Report Type');
                return false;                

            } else {

                return true;
            }

        }
    }    
}