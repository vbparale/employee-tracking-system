<?php
class Locations extends MY_Model {

    public $table = 'nxx_location';
    public $primary_key = 'LOC_CODE';

    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();
    }


}