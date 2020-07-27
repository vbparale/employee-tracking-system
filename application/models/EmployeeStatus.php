<?php
class EmployeeStatus extends MY_Model {

    public $table = 'nxx_empstat';
    public $primary_key = 'EMPSTAT_CODE';

    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();
    }
}