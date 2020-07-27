<?php

class OtherInfos extends MY_Model{

    public $table = 'nets_hdf_otherinfo';
    public $primary_key = 'HDFOI_ID';
    private $response = false;

    public function __construct(){

        $this->return_as = 'array';

        parent::__construct();

        $this->has_one['declaration'] = array(

            'foreign_model' => 'HealthDeclarations',
            'foreign_table' => 'nets_emp_hdf',
            'foreign_key' => 'HDF_ID',
            'local_key' => 'HDF_ID'            

        );


    }    
}