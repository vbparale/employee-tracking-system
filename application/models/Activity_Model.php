<?php
class Activity_Model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function add_daily_activity($data){
                $this->db->insert('NETS_EMP_ACTIVITY', $data);
                $insert_id = $this->db->insert_id();

                return  $insert_id;
        }

        public function update_daily_activity($data, $activity_id){
                $this->db->where('ACTIVITY_ID', $activity_id);
                $this->db->update('NETS_EMP_ACTIVITY',$data);
                return true;
        }

        public function get_daily_activities(){
                $this->db->select("*"); 
                $this->db->from('NETS_EMP_ACTIVITY');
                $query = $this->db->get();
                return $query->result();
        }

        public function add_activity_participants($data){
            $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
            $this->db->insert('NETS_EMP_ACT_PARTICIPANTS', $data);
            $insert_id = $this->db->insert_id();
            $this->db->query("SET FOREIGN_KEY_CHECKS = 1");

            return true;
        }

        public function delete_activity_participants($activity_id){
                $this->db->delete('NETS_EMP_ACT_PARTICIPANTS', array('ACTIVITY_ID' => $activity_id));
                return true;
        }

        public function get_emp_info_by_empcode($emp_code){
                $this->db->select("*"); 
                $this->db->from('NETS_EMP_INFO');
                $this->db->join('NETS_EMP_USER', 'NETS_EMP_USER.EMP_CODE = NETS_EMP_INFO.EMP_CODE');
                $this->db->where('NETS_EMP_INFO.EMP_CODE', $emp_code);
                $query = $this->db->get();
                return $query->row();
        }

        public function get_daily_activities_by_empcode($emp_code){
                $this->db->select("*"); 
                $this->db->from('NETS_EMP_ACTIVITY');
                $this->db->where('EMP_CODE', $emp_code);
                $query = $this->db->get();
                return $query->result();
        }

        public function get_daily_activities_by_activity_id($activity_id){
                $this->db->select("*, CONCAT(HOST.EMP_FNAME,' ',HOST.EMP_LNAME) AS HOST_NAME"); 
                $this->db->from('NETS_EMP_ACTIVITY');
                $this->db->join('NETS_EMP_INFO HOST', 'HOST.EMP_CODE = NETS_EMP_ACTIVITY.HOST_EMP', 'LEFT');
                $this->db->where('ACTIVITY_ID', $activity_id);
                $query = $this->db->get();
                return $query->row();
        }

        public function get_activity_participants_by_activity_id($activity_id){
                $this->db->select("*"); 
                $this->db->from('NETS_EMP_ACT_PARTICIPANTS');
                $this->db->join('NETS_EMP_INFO', 'NETS_EMP_INFO.EMP_CODE = NETS_EMP_ACT_PARTICIPANTS.EMP_CODE');
                $this->db->where('ACTIVITY_ID', $activity_id);
                $query = $this->db->get();
                return $query->result();
        }

        public function update_participant_status($data, $participant_id){
                $this->db->where('PRTCPNT_ID', $participant_id);
                $this->db->update('NETS_EMP_ACT_PARTICIPANTS',$data);
                return $this->db->affected_rows();
        }

        public function add_visitors_log($data){
                $this->db->insert('NETS_VISIT_LOG', $data);
                $insert_id = $this->db->insert_id();

                return  $insert_id;
        }

        public function get_questionnaire($transaction_code, $sequence){
                $this->db->select("*"); 
                $this->db->from('NXX_QUESTIONNAIRE');
                $this->db->where('TRANSACTION', $transaction_code);
                $this->db->where('SEQUENCE', $sequence);
                $query = $this->db->get();
                return $query->row();
        }

         public function get_emp_users(){
                $this->db->select("*"); 
                $this->db->from('NETS_EMP_INFO');
                $query = $this->db->get();
                return $query->result();
        }

        public function get_activity_by_participant_id($participant_id){
                $this->db->select("ACTIVITY_ID"); 
                $this->db->from('NETS_EMP_ACT_PARTICIPANTS');
                $this->db->where('PRTCPNT_ID', $participant_id);
                $query = $this->db->get();
                return $query->row();
        }


        public function get_activity_visitors_by_activity_id($activity_id){
                $this->db->select("*"); 
                $this->db->from('NETS_VISIT_LOG');
                $this->db->where('ACTIVITY_ID', $activity_id);
                $query = $this->db->get();
                return $query->result();
        }

         public function get_activity_visitor_by_activity_id($activity_id){
                $this->db->select("*"); 
                $this->db->from('NETS_VISIT_LOG');
                //$this->db->join('NETS_EMP_ACTIVITY', 'NETS_EMP_ACTIVITY.ACTIVITY_ID = NETS_VISIT_LOG.ACTIVITY_ID');
                $this->db->where('ACTIVITY_ID', $activity_id);
                $query = $this->db->get();
                return $query->result();
        }

        public function update_visit_log_meeting_id($meeting_id, $visit_id){
                $this->db->set('MEETING_ID', $meeting_id);
                $this->db->where('VISITOR_ID', $visit_id);
                $this->db->update('NETS_VISIT_LOG');
                return true;
        }

        public function update_daily_activity_status($activity_id, $status){
                $this->db->set('STATUS', $status);
                $this->db->set('STATUS_DATE', date('Y-m-d'));
                $this->db->set('UPDATE_USER', $this->session->userdata('EMP_CODE'));
                $this->db->set('UPDATE_DATE', date('Y-m-d'));
                $this->db->where('ACTIVITY_ID', $activity_id);
                $this->db->update('NETS_EMP_ACTIVITY');
                return true;
        }

        public function get_not_denied_activity_by_activity_id($activity_id){
            $sql = "SELECT * FROM NETS_EMP_ACT_PARTICIPANTS
            WHERE `ACTIVITY_ID` =  '$activity_id'
            AND (`STATUS` <> 'DENIED' OR ISNULL(`STATUS`)) ";
            $query = $this->db->query($sql);

            return $query->row();
        }

        public function update_visit_log_meeting_id_by_activity($meeting_id, $activity_id){
                $this->db->set('MEETING_ID', $meeting_id);
                $this->db->where('ACTIVITY_ID', $activity_id);
                $this->db->update('NETS_VISIT_LOG');
                return true;
        }

        public function get_daily_activity_by_activity_id($activity_id){
            $this->db->select("*, CONCAT(HOST.EMP_FNAME,' ',HOST.EMP_LNAME) AS HOST_NAME, NETS_EMP_ACTIVITY.EMP_CODE, HOST.MOBILE_NO AS HOST_MOBILE, HOST_USER.EMAIL_ADDRESS AS HOST_EMAIL, NETS_EMP_ACTIVITY.TIME_TO, NETS_EMP_ACTIVITY.TIME_FROM"); 
            $this->db->from('NETS_EMP_ACTIVITY');
            $this->db->join('NETS_EMP_INFO HOST', 'HOST.EMP_CODE = NETS_EMP_ACTIVITY.HOST_EMP', 'LEFT');
             $this->db->join('NETS_EMP_USER HOST_USER', 'HOST_USER.EMP_CODE = NETS_EMP_ACTIVITY.HOST_EMP', 'LEFT');
            $this->db->where('NETS_EMP_ACTIVITY.ACTIVITY_ID', $activity_id);
            $query = $this->db->get();
            return $query->row();
        }

        public function get_daily_activity_by_hostemployee($activity_id, $host_emp){
            $this->db->select("*"); 
            $this->db->from('NETS_EMP_ACTIVITY');
            $this->db->where('ACTIVITY_ID', $activity_id);
            $this->db->where('HOST_EMP', $host_emp);
            $query = $this->db->get();
            return $query->row();
        }

        public function update_participant_status_by_activity_empcode($data, $activity_id, $participant_id){
            $this->db->where('EMP_CODE', $participant_id);
            $this->db->where('ACTIVITY_ID', $activity_id);
            $this->db->update('NETS_EMP_ACT_PARTICIPANTS',$data);
            return $this->db->affected_rows();
        }

        public function delete_activity($activity_id) {
            $this->db->delete('NETS_EMP_ACTIVITY', array('ACTIVITY_ID' => $activity_id));
            return true;
        }

         public function validate_daily_activity_requestor($activity_id, $host_emp){
            $this->db->select("*"); 
            $this->db->from('NETS_EMP_ACTIVITY');
            $this->db->where('ACTIVITY_ID', $activity_id);
            $this->db->where('EMP_CODE', $host_emp);
            $this->db->where("CONCAT_WS(' ',ACTIVITY_DATE, TIME_FROM) >= NOW()");
            $query = $this->db->get();
            return $query->row();
        }

         public function delete_activity_visitors($activity_id){
                $this->db->delete('NETS_VISIT_LOG', array('ACTIVITY_ID' => $activity_id));
                return true;
        }

        public function update_visit_log_meeting_id_by_id($meeting_id, $visitor_id){
                $this->db->set('MEETING_ID', $meeting_id);
                $this->db->where('VISITOR_ID', $visitor_id);
                $this->db->update('NETS_VISIT_LOG');
                return true;
        }

        public function get_activity_not_confirmed_participants($activity_id){
            $this->db->select("*"); 
            $this->db->from('NETS_EMP_ACT_PARTICIPANTS');
            $this->db->where('ACTIVITY_ID', $activity_id);
            $this->db->where('STATUS');
            $query = $this->db->get();
            return $query->result();
        }

        public function update_visitors_date($data, $activity_id){
                $this->db->where('activity_id', $activity_id);
                $this->db->update('NETS_VISIT_LOG',$data);
                return $this->db->affected_rows();
        }

        public function validate_activity_schedule_by_user($user, $activity_date, $time_from, $time_to){
           $sql = "SELECT * FROM NETS_EMP_ACTIVITY
            LEFT JOIN NETS_VISIT_LOG ON `NETS_VISIT_LOG`.`ACTIVITY_ID` = `NETS_EMP_ACTIVITY`.`ACTIVITY_ID`
            WHERE  `NETS_EMP_ACTIVITY`.`ACTIVITY_DATE` =  '$activity_date'
            AND (`NETS_EMP_ACTIVITY`.`TIME_FROM` < '$time_to' AND `NETS_EMP_ACTIVITY`.`TIME_TO` > '$time_from')
            AND ((`NETS_EMP_ACTIVITY`.`EMP_CODE` = '$user' AND `NETS_EMP_ACTIVITY`.`HOST_EMP` = '')
                 OR (`NETS_EMP_ACTIVITY`.`HOST_EMP` = '$user' AND `NETS_VISIT_LOG`.`MEETING_ID` IS NOT NULL)
           )
            AND `NETS_EMP_ACTIVITY`.`STATUS` <> 'CANCELLED'
            ";
            $query = $this->db->query($sql);

            return $query->row();
        }

        public function validate_activity_schedule_by_user_except($user, $activity_date, $time_from, $time_to, $except_activity_id){
           $sql = "SELECT * FROM NETS_EMP_ACTIVITY
            LEFT JOIN NETS_VISIT_LOG ON `NETS_VISIT_LOG`.`ACTIVITY_ID` = `NETS_EMP_ACTIVITY`.`ACTIVITY_ID`
            WHERE  `NETS_EMP_ACTIVITY`.`ACTIVITY_DATE` =  '$activity_date'
            AND (`NETS_EMP_ACTIVITY`.`TIME_FROM` < '$time_to' AND `NETS_EMP_ACTIVITY`.`TIME_TO` > '$time_from')
            AND ((`NETS_EMP_ACTIVITY`.`EMP_CODE` = '$user' AND `NETS_EMP_ACTIVITY`.`HOST_EMP` = '')
                 OR (`NETS_EMP_ACTIVITY`.`HOST_EMP` = '$user' AND `NETS_VISIT_LOG`.`MEETING_ID` IS NOT NULL)
           )
            AND `NETS_EMP_ACTIVITY`.`STATUS` <> 'CANCELLED'
            AND `NETS_EMP_ACTIVITY`.`ACTIVITY_ID` <> '$except_activity_id'
            ";
        
            $query = $this->db->query($sql);

            return $query->row();
        }

        public function get_activity_participants_id($activity_id){
            $this->db->select("ACTIVITY_ID, PRTCPNT_ID, NETS_EMP_ACT_PARTICIPANTS.EMP_CODE AS EMP_CODE"); 
            $this->db->from('NETS_EMP_ACT_PARTICIPANTS');
            $this->db->join('NETS_EMP_INFO', 'NETS_EMP_INFO.EMP_CODE = NETS_EMP_ACT_PARTICIPANTS.EMP_CODE');
            $this->db->where('ACTIVITY_ID', $activity_id);
            $query = $this->db->get();
            return $query->result();
        }

        public function update_participant_status_by_activity_id($emp_code, $activity_id, $status){
            $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
            $this->db->set('STATUS', $status);
            $this->db->set('STATUS_DATE', date('Y-m-d'));
            $this->db->set('UPDATE_USER', $this->session->userdata('EMP_CODE'));
            $this->db->set('UPDATE_DATE', date('Y-m-d'));
            $this->db->where('ACTIVITY_ID', $activity_id);
            $this->db->where('EMP_CODE', $emp_code);
            $this->db->update('NETS_EMP_ACT_PARTICIPANTS');
            $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
            return true;
        }

         public function get_participant_by_participant_activity_id($participant_id, $activity_id){
                $this->db->select("ACTIVITY_ID"); 
                $this->db->from('NETS_EMP_ACT_PARTICIPANTS');
                $this->db->where('EMP_CODE', $participant_id);
                $this->db->where('ACTIVITY_ID', $activity_id);
                $query = $this->db->get();
                return $query->row();
        }

        public function delete_participant($activity_id, $participant_id){
                $this->db->delete('NETS_EMP_ACT_PARTICIPANTS', array('ACTIVITY_ID' => $activity_id, 'EMP_CODE' => $participant_id));
                return true;
        }

        public function validate_activity_schedule_on_confirm_except($user, $activity_date, $time_from, $time_to, $except_activity_id){
           $sql = "SELECT * FROM NETS_EMP_ACTIVITY
            LEFT JOIN NETS_VISIT_LOG ON `NETS_VISIT_LOG`.`ACTIVITY_ID` = `NETS_EMP_ACTIVITY`.`ACTIVITY_ID`
            LEFT JOIN NETS_EMP_ACT_PARTICIPANTS ON `NETS_EMP_ACT_PARTICIPANTS`.`ACTIVITY_ID` = `NETS_EMP_ACTIVITY`.`ACTIVITY_ID`
            WHERE  `NETS_EMP_ACTIVITY`.`ACTIVITY_DATE` =  '$activity_date'
            AND (`NETS_EMP_ACTIVITY`.`TIME_FROM` < '$time_to' AND `NETS_EMP_ACTIVITY`.`TIME_TO` > '$time_from')
            AND (
                (`NETS_EMP_ACTIVITY`.`EMP_CODE` = '$user' AND `NETS_EMP_ACTIVITY`.`HOST_EMP` = '')
                OR (`NETS_EMP_ACTIVITY`.`HOST_EMP` = '$user' AND `NETS_VISIT_LOG`.`MEETING_ID` IS NOT NULL)
                OR  (`NETS_EMP_ACT_PARTICIPANTS`.`EMP_CODE` = '$user' AND `NETS_EMP_ACT_PARTICIPANTS`.`STATUS` = 'CONFIRMED')
            )
            AND `NETS_EMP_ACTIVITY`.`STATUS` <> 'CANCELLED'
            AND `NETS_EMP_ACTIVITY`.`ACTIVITY_ID` <> '$except_activity_id'
            ";
            
            $query = $this->db->query($sql);

            return $query->row();
        }
     





       
}