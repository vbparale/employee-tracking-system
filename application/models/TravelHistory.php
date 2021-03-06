<?php

class TravelHistory extends MY_Model{

    public $table = 'nets_hdf_travelhistory';
    public $primary_key = 'HDFTH_ID';
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