<?php
class Module extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function get_access_by_role_id($role_id){
        $this->db->select("NXX_MODULES.DISPLAY_TITLE AS module"); 
        $this->db->from('NXX_MODULES');
        $this->db->join('NXX_ROLE_ACCESS', 'NXX_ROLE_ACCESS.MODULE_ACCESS = NXX_MODULES.MODULE_ID');
        $this->db->where('NXX_ROLE_ACCESS.ROLE_ID', $role_id);
        $data = $this->db->get();

        return $data->result_array();
    }


}



