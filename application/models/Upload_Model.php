<?php
class Upload_Model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function import_data($data) {
 			// temporarily turn-off the checking of constraints
 			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
 			
	        $res = $this->db->insert_batch('NETS_EMP_INFO',$data);
	        if($res){
	            return TRUE;
	        }else{
	            return FALSE;
	        }
	 
	    }

	    public function turn_on_checking_constraints() {
	    	$this->db->query("SET FOREIGN_KEY_CHECKS = 1");
	    	return TRUE;
	    }

	    public function insert_users_data($data) {
 			// temporarily turn-off the checking of constraints
 			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
 			
	        $res = $this->db->insert('NETS_EMP_INFO',$data);
	        if($res){
	            return TRUE;
	        }else{
	            return FALSE;
	        }
	 
	    }


	    public function update_users_info($data, $emp_code){
	    	$this->db->query("SET FOREIGN_KEY_CHECKS = 0");

            $this->db->where('EMP_CODE', $emp_code);
            $res = $this->db->update('NETS_EMP_INFO',$data);
            if($res){
	            return TRUE;
	        }else{
	            return FALSE;
	        }
        }

        public function get_emp_info_by_empcode($emp_code){
                $this->db->select("*"); 
                $this->db->from('NETS_EMP_INFO');
                $this->db->where('EMP_CODE', $emp_code);
                $query = $this->db->get();
                return $query->row();
        }

        public function insert_users_login_data($data) {
 			// temporarily turn-off the checking of constraints
 			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
 			
	        $res = $this->db->insert('NETS_EMP_USER',$data);
	        if($res){
	            return TRUE;
	        }else{
	            return FALSE;
	        }
	 
	    }

	    public function update_users_login_data($data, $emp_code){
	    	$this->db->query("SET FOREIGN_KEY_CHECKS = 0");

            $this->db->where('EMP_CODE', $emp_code);
            $res = $this->db->update('NETS_EMP_USER',$data);
            if($res){
	            return TRUE;
	        }else{
	            return FALSE;
	        }
        }

       
}