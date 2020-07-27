<?php

class Diseases extends MY_Model{

    public $table = 'nets_hdf_chrnc_disease';
    public $primary_key = 'HDFC_ID';
    private $response = false;

    public function __construct(){

        $this->return_as = 'array';

        parent::__construct();

        $this->has_many['declarations'] = array(

            'foreign_model' => 'HealthDeclarations',
            'foreign_table' => 'nets_emp_hdf',
            'foreign_key' => 'HDF_ID',
            'local_key' => 'ANSKEY'            

        );


    }
}