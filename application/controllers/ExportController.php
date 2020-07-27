<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportController extends CI_Controller {

    public function __construct(){

        parent::__construct();
        $this->load->model('Reports');
        $this->load->model('Employees');
        $this->load->model('HealthChecks');
        $this->load->model('HealthDeclarations');

    }

    public function index(){

        if ($this->input->get()) {
            
            $report_type = $this->input->get('report_type');

            if ($this->input->get('emp_code')) {
                    
                $where['EMP_CODE'] = $this->input->get('emp_code');
            }
            
            if ($this->input->get('group')) {
                
                $where['GRP_CODE'] = $this->input->get('group');
                
            }

            if ($this->input->get('company')) {
                
                $where['COMP_CODE'] = $this->input->get('company');
            }          
            
            $employees = $this->Employees->where($where)
            ->with_company('fields:COMP_NAME')
            ->with_healthChecks()->get_all();

            switch ($report_type) {
                case 'ehc':
                    
                    $this->HealthChecks->excel($employees,$this->input->get());

                    break;
                
                case 'hdf':
                    
                    $this->HealthDeclarations->excel($employees,$this->input->get());
                    
                    break;
                default:
                    # code...
                    break;
            }


        }
       
    }

    public function show(){

            
    }

}