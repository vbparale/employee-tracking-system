<?php
class Groups extends MY_Model {

    public $table = 'nxx_group';
    public $primary_key = 'GRP_CODE';

    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();

        $this->has_many['employees'] = array(

            'foreign_model' => 'Employees',
            'foreign_table' => 'nxx_group',
            'foreign_key' => 'GRP_CODE',
            'local_key' => 'GRP_CODE'             
        );        

    }
}