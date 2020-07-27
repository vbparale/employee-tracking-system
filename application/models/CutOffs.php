<?php

class CutOffs Extends MY_Model {

    public $table = 'nxx_hdf_cutoff';
    public $primary_key = 'CUTOFFID';

    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();
        
    }    
}