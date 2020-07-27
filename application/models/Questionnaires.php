<?php
class Questionnaires extends MY_Model {

    public $table = 'nxx_questionnaire';
    public $primary_key = 'QCODE';

    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();
    }


}