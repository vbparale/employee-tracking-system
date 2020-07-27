<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeController extends CI_Controller {

    public function __construct(){

        parent::__construct();
        $this->load->model('Employees');
    }

    public function index(){

        $employees = $this->Employees;
        $where = [];
        if ($this->input->is_ajax_request()) {
            
            if ($this->input->get('company')) {
                
                $setVal = $this->input->get('company');
                
                $where['COMP_CODE'] = $setVal;

            }

            if ($this->input->get('group')) {
                
                $setVal1 = $this->input->get('group');
                
                $where['GRP_CODE'] = $setVal1;

            }

            $data['list'] = $employees->where($where)->order_by('EMP_LNAME','ASC')->get_all();
            
            echo json_encode($data);

            return;

        } else {

            return redirect('/');
        }
    }
}