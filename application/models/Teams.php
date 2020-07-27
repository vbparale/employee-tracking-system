<?php
class Teams extends MY_Model {

    public $table = 'nxx_teamsched';
    public $primary_key = 'ID';

    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();
    }
}