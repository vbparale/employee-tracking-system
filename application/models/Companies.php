<?php
class Companies extends MY_Model {

    public $table = 'nxx_company';
    public $primary_key = 'COMP_CODE';

    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();

        $this->has_many['employees'] = array(

            'foreign_model' => 'Employees',
            'foreign_table' => 'nets_emp_info',
            'foreign_key' => 'COMP_CODE',
            'local_key' => 'COMP_CODE' 
        );        
    }
}