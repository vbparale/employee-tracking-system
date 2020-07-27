<?php
class visitor_model extends CI_Model {

    public function __construct()
    {
            $this->load->database();
    }

    public function getCheckInCheckOutVisitor(){
        $date_now = date("Y-m-d");

        $this->db->select('NETS_VISIT_LOG.MEETING_ID as MEETING_ID , CONCAT(VISIT_LNAME , "," , VISIT_FNAME , " " , VISIT_MNAME) as FULNAME , CONCAT(NETS_EMP_INFO.EMP_LNAME  , "," , NETS_EMP_INFO.EMP_FNAME , " "  , NETS_EMP_INFO.EMP_MNAME) as PERSON_VISIT , NETS_VISIT_LOG.*');
        $this->db->join('NETS_EMP_INFO' , 'NETS_VISIT_LOG.PERS_TOVISIT = NETS_EMP_INFO.EMP_CODE');
        $this->db->where('MEETING_ID is NOT NULL' ,  NULL, FALSE);
        $this->db->where('VISIT_DATE =', $date_now);
        $this->db->where('CHECKOUT_TIME =', NULL);
        $this->db->where('STATUS !=', 'CANCELLED');
        $this->db->where('STATUS !=', 'DENIED');
        $this->db->from('NETS_VISIT_LOG');
        $data = $this->db->get();
        return $data->result_array();
    }

    public function validateUserStatus($id){
        $this->db->select('NETS_VISIT_LOG.MEETING_ID as MEETING_ID , CONCAT(VISIT_LNAME , "," , VISIT_FNAME , " " , VISIT_MNAME) as FULNAME , CONCAT(NETS_EMP_INFO.EMP_LNAME  , "," , NETS_EMP_INFO.EMP_FNAME , " "  , NETS_EMP_INFO.EMP_MNAME) as PERSON_VISIT , NETS_VISIT_LOG.*');
        $this->db->join('NETS_EMP_INFO' , 'NETS_VISIT_LOG.PERS_TOVISIT = NETS_EMP_INFO.EMP_CODE');
        $this->db->where('VISITOR_ID', $id);
        $this->db->from('NETS_VISIT_LOG');
        $data = $this->db->get();

        return $data->row();
    }    

    public function updateCheckinCheckout($fields , $id , $value , $update_user , $update_date){ 
        $this->db->set($fields, $value);
        $this->db->set('UPDATE_USER', $update_user);
        $this->db->set('UPDATE_DATE', $update_date);
        $this->db->where('VISITOR_ID', $id);
        $this->db->update('NETS_VISIT_LOG');
    }

    public function updateStatus($id , $value){ 
        $this->db->set('STATUS', $value);
        $this->db->where('VISITOR_ID', $id);
        $this->db->update('NETS_VISIT_LOG');
    }

    public function get_curent_time_db(){
        $this->db->select('CURRENT_TIME() as time');
        $data = $this->db->get();

        return $data->row();
    }

    public function getVisitorLogs(){
        $this->db->select('NETS_VISIT_LOG.MEETING_ID as MEETING_ID , CONCAT(VISIT_LNAME , "," , VISIT_FNAME , " " , VISIT_MNAME) as FULNAME , CONCAT(NETS_EMP_INFO.EMP_LNAME  , "," , NETS_EMP_INFO.EMP_FNAME , " "  , NETS_EMP_INFO.EMP_MNAME) as PERSON_VISIT , NETS_EMP_ACTIVITY.STATUS as STATUS_DENIED  , NETS_EMP_ACTIVITY.LOCATION as LOCATION , NETS_VISIT_LOG.*');
        $this->db->join('NETS_EMP_INFO' , 'NETS_VISIT_LOG.PERS_TOVISIT = NETS_EMP_INFO.EMP_CODE');
        $this->db->join('NETS_EMP_ACTIVITY' , 'NETS_VISIT_LOG.ACTIVITY_ID = NETS_EMP_ACTIVITY.ACTIVITY_ID');
        $this->db->from('NETS_VISIT_LOG');
        $data = $this->db->get();
        return $data->result_array();
    }

    public function getVisitorLogsbyID($id){
        $this->db->select('NETS_VISIT_LOG.MEETING_ID as MEETING_ID , CONCAT(VISIT_LNAME , "," , VISIT_FNAME , " " , VISIT_MNAME) as FULNAME , CONCAT(NETS_EMP_INFO.EMP_LNAME  , "," , NETS_EMP_INFO.EMP_FNAME , " "  , NETS_EMP_INFO.EMP_MNAME) as PERSON_VISIT , NETS_EMP_ACTIVITY.TIME_FROM as  TIME_FROM , NETS_EMP_ACTIVITY.TIME_TO as TIME_TO , NETS_EMP_ACTIVITY.STATUS As Act_status, NETS_EMP_ACTIVITY.LOCATION as Location , NETS_VISIT_LOG.*');
        $this->db->join('NETS_EMP_INFO' , 'NETS_VISIT_LOG.PERS_TOVISIT = NETS_EMP_INFO.EMP_CODE');
        $this->db->join('NETS_EMP_ACTIVITY' , 'NETS_VISIT_LOG.ACTIVITY_ID = NETS_EMP_ACTIVITY.ACTIVITY_ID');
        $this->db->where('NETS_VISIT_LOG.VISITOR_ID', $id);
        $this->db->from('NETS_VISIT_LOG');
        $data = $this->db->get();

        return $data->row();
    }

    public function getEmployee(){
        $this->db->select('CONCAT(NETS_EMP_INFO.EMP_LNAME  , "," , NETS_EMP_INFO.EMP_FNAME , " "  , NETS_EMP_INFO.EMP_MNAME) as EMP_FULLNAME , NETS_EMP_INFO.*');
        $this->db->from('NETS_EMP_INFO');
        $data = $this->db->get();
        
        return $data->result();
    }

    public function getQuestionaire($transaction , $qcode){
        $this->db->select('*');
        $this->db->where('TRANSACTION', $transaction);
        $this->db->where('QCODE', $qcode);
        $this->db->from('NXX_QUESTIONNAIRE');
        $data = $this->db->get();

        return $data->row();
    }

    public function addVisitorLog($data){
        $this->db->insert('NETS_VISIT_LOG', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function add_activity($data){
        $this->db->insert('NETS_EMP_ACTIVITY', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function add_participants($data){
        $this->db->insert('NETS_EMP_ACT_PARTICIPANTS', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function get_visitor_q1_answer($id){
        $this->db->select('*');
        $this->db->where('VISITOR_ID', $id);
        $this->db->from('NETS_VISIT_LOG');
        $data = $this->db->get();

        return $data->result();
    }

    //Comment by emil June 08, 2020
  /*   public function get_visitor_part($id){
        $this->db->select('NETS_EMP_INFO.EMP_CODE as EMP_CODE , CONCAT(NETS_EMP_INFO.EMP_LNAME  , "," , NETS_EMP_INFO.EMP_FNAME , " "  , NETS_EMP_INFO.EMP_LNAME) as EMP_FULLNAME');
        $this->db->join('NETS_EMP_ACTIVITY' , 'NETS_EMP_INFO.EMP_CODE = NETS_EMP_ACTIVITY.EMP_CODE');
        $this->db->join('NETS_VISIT_LOG' , 'NETS_EMP_ACTIVITY.ACTIVITY_ID = NETS_VISIT_LOG.ACTIVITY_ID');
        $this->db->where('VISITOR_ID', $id);
        $this->db->from('NETS_EMP_INFO');
        $data = $this->db->get();

        return $data->result();
    } */
    
    //Update by emil June 8 , 2020
    public function get_visitor_part($id){
        $this->db->select('NETS_EMP_INFO.EMP_CODE as EMP_CODE , CONCAT(NETS_EMP_INFO.EMP_LNAME  , "," , NETS_EMP_INFO.EMP_FNAME , " "  , NETS_EMP_INFO.EMP_LNAME) as EMP_FULLNAME');
        $this->db->join('NETS_EMP_ACT_PARTICIPANTS' , 'NETS_VISIT_LOG.ACTIVITY_ID = NETS_EMP_ACT_PARTICIPANTS.ACTIVITY_ID');
        $this->db->join('NETS_EMP_INFO' , 'NETS_EMP_ACT_PARTICIPANTS.EMP_CODE = NETS_EMP_INFO.EMP_CODE');
        $this->db->where('VISITOR_ID', $id);
        $this->db->from('NETS_VISIT_LOG');
        $data = $this->db->get();

        return $data->result();
    }

    public function get_visitor_part_id_only($id){
        $this->db->select('NETS_EMP_INFO.EMP_CODE as EMP_CODE');
        $this->db->join('NETS_EMP_ACT_PARTICIPANTS' , 'NETS_VISIT_LOG.ACTIVITY_ID = NETS_EMP_ACT_PARTICIPANTS.ACTIVITY_ID');
        $this->db->join('NETS_EMP_INFO' , 'NETS_EMP_ACT_PARTICIPANTS.EMP_CODE = NETS_EMP_INFO.EMP_CODE');
        $this->db->where('VISITOR_ID', $id);
        $this->db->from('NETS_VISIT_LOG');
        $data = $this->db->get();

        return $data->result();
    }

    public function update_visitor_logs($visit_lname, $visit_fname , $visit_mname , $comp_name , $comp_add , $email_add , $mobile_no , $tel_no , $res_address , $visit_date , $visit_purp , $pers_tovisit, $a1,
            $a2 , $a2Date2 , $a3 , $a3travel_date , $a3palce , $a3return_date ,$update_user , $update_date , $visitor_id){

        $this->db->set('VISIT_LNAME', $visit_lname);
        $this->db->set('VISIT_FNAME', $visit_fname);
        $this->db->set('VISIT_MNAME', $visit_mname);
        $this->db->set('COMP_NAME', $comp_name);
        $this->db->set('COMP_ADDRESS', $comp_add);
        $this->db->set('EMAIL_ADDRESS', $email_add);
        $this->db->set('MOBILE_NO', $mobile_no);
        $this->db->set('TEL_NO', $tel_no);
        $this->db->set('RES_ADDRESS', $res_address);
        $this->db->set('VISIT_DATE', $visit_date);
        $this->db->set('VISIT_PURP', $visit_purp);
        $this->db->set('PERS_TOVISIT', $pers_tovisit);
        $this->db->set('A1', $a1);
        $this->db->set('A2', $a2);
        $this->db->set('A2DATES', $a2Date2);
        $this->db->set('A3', $a3);
        $this->db->set('A3TRAVEL_DATES', $a3travel_date);
        $this->db->set('A3PLACE', $a3palce);
        $this->db->set('A3RETURN_DATE', $a3return_date);
        $this->db->set('UPDATE_USER', $update_user);
        $this->db->set('UPDATE_DATE', $update_date);
        $this->db->where('VISITOR_ID', $visitor_id);
        $this->db->update('NETS_VISIT_LOG');
        return $this->db->affected_rows();
        }   

        public function update_activity($id , $time_from , $time_in , $location){
        $this->db->set('TIME_FROM', $time_from);
        $this->db->set('TIME_TO', $time_in);
        $this->db->set('LOCATION', $location);
        $this->db->where('ACTIVITY_ID', $id);
        $this->db->update('NETS_EMP_ACTIVITY');
        return $this->db->affected_rows();
        }

        public function delete_part($id){
        $this->db->delete('NETS_EMP_ACT_PARTICIPANTS', array('ACTIVITY_ID' => $id));
        return true;
        }

        public function searchForCheckInOut($fields , $value){
        $this->db->select('NETS_EMP_INFO.EMP_CODE as EMP_CODE , CONCAT(NETS_EMP_INFO.EMP_LNAME  , "," , NETS_EMP_INFO.EMP_FNAME , " "  , NETS_EMP_INFO.EMP_LNAME) as EMP_FULLNAME');
        $this->db->join('NETS_EMP_INFO' , 'NETS_EMP_ACTIVITY.EMP_CODE = NETS_EMP_INFO.EMP_CODE');
        $this->db->where('VISITOR_ID', $id);
        $this->db->from('NETS_EMP_ACTIVITY');
        $data = $this->db->get();

        return $data->result();
        }

        public function searchForVisitorLogs($visitor_name , $status , $meeting_id , $peson_visit , $perid1 , $period2){
        $this->db->select('NETS_VISIT_LOG.MEETING_ID as MEETING_ID , CONCAT(VISIT_LNAME , "," , VISIT_FNAME , " " , VISIT_MNAME) as FULNAME , NETS_VISIT_LOG.*');
        $this->db->like('VISIT_LNAME' , $visitor_name , 'both');
        $this->db->like('VISIT_FNAME' , $visitor_name , 'both');
        $this->db->like('VISIT_MNAME' , $visitor_name , 'both');
        $this->db->or_where('STATUS' , $status);
        $this->db->or_where('MEETING_ID' , $meeting_id);
        $this->db->or_where('PERS_TOVISIT' , $peson_visit);
        $this->db->or_where('VISIT_DATE <=' , $perid1);
        $this->db->or_where('VISIT_DATE >=', $period2);
        $this->db->from('NETS_VISIT_LOG');
        $data = $this->db->get();

        return $data->result();
        }

        public function getactivity($id){
            $this->db->select('*');
            $this->db->where('ACTIVITY_ID', $id);
            $this->db->from('NETS_EMP_ACTIVITY');
            $data = $this->db->get();

            return $data->row();
        }

        public function get_emp_info_by_empcode($emp_code){
            $this->db->select("*"); 
            $this->db->from('NETS_EMP_INFO');
            $this->db->join('NETS_EMP_USER', 'NETS_EMP_USER.EMP_CODE = NETS_EMP_INFO.EMP_CODE');
            $this->db->where('NETS_EMP_INFO.EMP_CODE', $emp_code);
            $query = $this->db->get();
            return $query->row();
        }

        public function updateStatusActivity($id , $value){
            $this->db->set('STATUS',  $value);
            $this->db->where('ACTIVITY_ID', $id);
            $this->db->update('NETS_EMP_ACTIVITY');
            return $this->db->affected_rows();
        }


        public function getActivityID($id){
            $this->db->select("ACTIVITY_ID"); 
            $this->db->from('NETS_VISIT_LOG');
            $this->db->where('VISITOR_ID', $id);
            $query = $this->db->get();
            return $query->row();
        }

        public function update_to_null($columns , $id){
            $this->db->set($columns,  '');
            $this->db->where('VISITOR_ID', $id);
            $this->db->update('NETS_VISIT_LOG');
            return $this->db->affected_rows();
        }
}

