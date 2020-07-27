<?php
class Roles extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function getAll($status = '') {
            $this->db->select("*"); 
            $this->db->from('NXX_USER_ROLE');
            if($status != '') {
                $this->db->where('NXX_USER_ROLE.STATUS', $status);
            }
            
            $query = $this->db->get();
            return $query->result();
        }
}