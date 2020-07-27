<?php

class Participants extends MY_Model {

    public $table = 'nets_emp_act_participants';
    public $primary_key = 'PRTCPNT_ID';
    public $timestamps = FALSE;

    public function __construct(){

        $this->return_as = 'array';

        parent::__construct();

        $this->has_one['activty'] = array(

            'foreign_model' => 'Activities',
            'foreign_table' => 'nets_emp_activity',
            'foreign_key' => 'ACTIVITY_ID',
            'local_key' => 'ACTIVITY_ID'
        );

        $this->has_one['employee'] = array(

            'foreign_model' => 'Employees',
            'foreign_table' => 'nets_emp_info',
            'foreign_key' => 'EMP_CODE',
            'local_key' => 'EMP_CODE'
        );
    }
}