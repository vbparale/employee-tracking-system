<?php
class Positions extends MY_Model {

    public $table = 'nxx_position';
    public $primary_key = 'POS_CODE';

    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();
    }
}