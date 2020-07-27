<?php
class Ranks extends MY_Model {

    public $table = 'nxx_rank';
    public $primary_key = 'RNK_CODE';

    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();
    }
}