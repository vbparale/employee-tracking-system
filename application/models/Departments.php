<?php
class Departments extends MY_Model {

    public $table = 'nxx_department';
    public $primary_key = 'DEPT_CODE';

    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();
    }
}