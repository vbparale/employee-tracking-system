<?php
class Users_Model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_info_without_users() {
 			$this->db->select("*, NETS_EMP_INFO.EMP_CODE"); 
            $this->db->from('NETS_EMP_INFO');
            $this->db->join('NETS_EMP_USER', 'NETS_EMP_USER.EMP_CODE = NETS_EMP_INFO.EMP_CODE', 'LEFT');
            $this->db->where('NETS_EMP_USER.EMP_CODE', NULL);
            $query = $this->db->get();
            return $query->result();
	 
	    }

	     public function get_user_info_by_empcode($emp_code) {
 			$this->db->select("*"); 
            $this->db->from('NETS_EMP_INFO');
            $this->db->join('NETS_EMP_USER', 'NETS_EMP_USER.EMP_CODE = NETS_EMP_INFO.EMP_CODE', 'LEFT');

            $this->db->where('NETS_EMP_USER.EMP_CODE', NULL);
            $query = $this->db->get();
            return $query->result();	 
	    }

	    public function get_companies() {
 			$this->db->select("*"); 
            $this->db->from('NXX_COMPANY');
            $query = $this->db->get();
            return $query->result();
	    }

	    public function get_groups() {
 			$this->db->select("*"); 
            $this->db->from('NXX_GROUP');
            $query = $this->db->get();
            return $query->result();
	    }

	    public function get_access_groups() {
 			$this->db->select("*"); 
            $this->db->from('NXX_USER_ROLE');
            $query = $this->db->get();
            return $query->result();
	    }

	     public function get_statuses() {
 			$this->db->select("*"); 
            $this->db->from('NXX_EMPSTAT');
            $query = $this->db->get();
            return $query->result();
	    }

	     public function get_user_by_empcode($emp_code) {
 			$this->db->select("*"); 
            $this->db->from('NETS_EMP_INFO');
            $this->db->join('NXX_COMPANY', 'NXX_COMPANY.COMP_CODE = NETS_EMP_INFO.COMP_CODE','LEFT');
            $this->db->join('NXX_GROUP', 'NXX_GROUP.GRP_CODE = NETS_EMP_INFO.GRP_CODE','LEFT');
            $this->db->join('NXX_EMPSTAT', 'NXX_EMPSTAT.EMPSTAT_CODE = NETS_EMP_INFO.EMP_STAT','LEFT');
            $this->db->join('NXX_LOCATION', 'NXX_LOCATION.LOC_CODE = NETS_EMP_INFO.LOC_CODE','LEFT');
            $this->db->join('NXX_RANK', 'NXX_RANK.RNK_CODE = NETS_EMP_INFO.EMP_LEVEL','LEFT');
            $this->db->join('NXX_TEAMSCHED', 'NXX_TEAMSCHED.ID = NETS_EMP_INFO.TEAM','LEFT');
            $this->db->join('NXX_DEPARTMENT', 'NXX_DEPARTMENT.DEPT_CODE = NETS_EMP_INFO.DEPT_CODE','LEFT');
            $this->db->where('NETS_EMP_INFO.EMP_CODE', $emp_code);
            $query = $this->db->get();
            return $query->row();	 
	    }

        public function add_emp_user($data) {
            $this->db->insert('NETS_EMP_USER', $data);
            $insert_id = $this->db->insert_id();

            return  $insert_id;
        }

        public function update_emp_info($emp_code, $data) {
            $this->db->where('EMP_CODE', $emp_code);
            $this->db->update('NETS_EMP_INFO',$data);
            return true;
        }
       
        public function get_complete_user_info_by_empcode($emp_code) {
            $this->db->select("*"); 
            $this->db->from('NETS_EMP_INFO');
            $this->db->join('NETS_EMP_USER', 'NETS_EMP_USER.EMP_CODE = NETS_EMP_INFO.EMP_CODE');
            $this->db->join('NXX_COMPANY', 'NXX_COMPANY.COMP_CODE = NETS_EMP_INFO.COMP_CODE','LEFT');
            $this->db->join('NXX_GROUP', 'NXX_GROUP.GRP_CODE = NETS_EMP_INFO.GRP_CODE','LEFT');
            $this->db->join('NXX_EMPSTAT', 'NXX_EMPSTAT.EMPSTAT_CODE = NETS_EMP_INFO.EMP_STAT','LEFT');
            $this->db->join('NXX_LOCATION', 'NXX_LOCATION.LOC_CODE = NETS_EMP_INFO.LOC_CODE','LEFT');
            $this->db->join('NXX_RANK', 'NXX_RANK.RNK_CODE = NETS_EMP_INFO.EMP_LEVEL','LEFT');
            $this->db->join('NXX_TEAMSCHED', 'NXX_TEAMSCHED.ID = NETS_EMP_INFO.TEAM','LEFT');
            $this->db->join('NXX_DEPARTMENT', 'NXX_DEPARTMENT.DEPT_CODE = NETS_EMP_INFO.DEPT_CODE','LEFT');
            $this->db->where('NETS_EMP_INFO.EMP_CODE', $emp_code);
            $query = $this->db->get();
            return $query->row();     
        }

        public function update_emp_user($emp_code, $data) {
            $this->db->where('EMP_CODE', $emp_code);
            $this->db->update('NETS_EMP_USER',$data);
            return true;
        }
}