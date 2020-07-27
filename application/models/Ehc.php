<?php
class Ehc extends CI_Model {

    public function __construct()
    {
            $this->load->database();
    }
    
    public function submit_ehc()
    {
        $this->load->helper('url');


        $data = array(
            'test' => 'test';
        );

        return $this->db->insert('test', $data);
    }

}