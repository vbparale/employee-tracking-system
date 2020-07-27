<?php
class Job_Model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_pending_ehc(){
        
        $cond = "( LAST_CHECKED < '" . date("Y/m/d h:i:sa") . "' OR LAST_CHECKED IS NULL) AND STATUS = 'I'";

        $this->db->select('RUSHNO');
        $this->db->from('NETS_EMP_EHC');
        $this->db->where($cond);
        $this->db->order_by('LAST_CHECKED ASC');
        $this->db->limit(25);
        $data = $this->db->get();
        return $data->result_array();
    }

    public function update_ehc($data){
        $this->db->set($data['COLUMN'], $data['VALUE']);
        $this->db->where('RUSHNO', $data['RUSHNO']);
        $this->db->update('NETS_EMP_EHC');
    }

    public function reset_user_ehc(){
        $this->db->set('SUBMITTED_EHC', 0);
        $this->db->set('SENT_NOTIF', 0);
        $this->db->update('NETS_EMP_USER');
    }

    public function reset_notif(){
        $this->db->set('SENT_NOTIF', 0);
        $this->db->where('SUBMITTED_EHC', 0);
        $this->db->update('NETS_EMP_USER');
    }

    public function get_no_ehc(){
        $cond = array('SUBMITTED_EHC' => 0, 'SENT_NOTIF' => 0);

        $this->db->select('NETS_EMP_USER.EMP_CODE, NETS_EMP_USER.EMAIL_ADDRESS, NETS_EMP_USER.LOGIN_ID, NETS_EMP_INFO.MOBILE_NO, NETS_EMP_INFO.GRP_CODE, NETS_EMP_INFO.EMP_FNAME, NETS_EMP_INFO.EMP_LNAME');
        $this->db->from('NETS_EMP_USER');
        $this->db->join('NETS_EMP_INFO', 'NETS_EMP_USER.EMP_CODE = NETS_EMP_INFO.EMP_CODE', 'inner');
        $this->db->where('SUBMITTED_EHC', 0);
        $this->db->where('SENT_NOTIF', 0);
        $this->db->limit(500);
        $data = $this->db->get();
        return $data->result_array();
    }

    public function get_group_head($data){
        $cond = array('APVL_LVL' => 40, 'GRP_CODE' => $data);

        $this->db->select('NETS_EMP_USER.EMAIL_ADDRESS, NETS_EMP_INFO.RUSH_ID, NETS_EMP_INFO.MOBILE_NO, NETS_EMP_INFO.GRP_CODE, NETS_EMP_INFO.EMP_FNAME, NETS_EMP_INFO.EMP_LNAME');
        $this->db->from('NETS_EMP_INFO');
        $this->db->join('NETS_EMP_USER', 'NETS_EMP_USER.EMP_CODE = NETS_EMP_INFO.EMP_CODE', 'inner');
        $this->db->where($cond);
        $this->db->limit(25);
        $data = $this->db->get();
        return $data->result_array();
    }

    public function get_imdt_head($data){
        $cond = array('APVL_LVL' => 10, 'GRP_CODE' => $data);

        $this->db->select('NETS_EMP_USER.EMAIL_ADDRESS, NETS_EMP_INFO.RUSH_ID, NETS_EMP_INFO.MOBILE_NO, NETS_EMP_INFO.GRP_CODE, NETS_EMP_INFO.EMP_FNAME, NETS_EMP_INFO.EMP_LNAME');
        $this->db->from('NETS_EMP_INFO');
        $this->db->join('NETS_EMP_USER', 'NETS_EMP_USER.EMP_CODE = NETS_EMP_INFO.EMP_CODE', 'inner');
        $this->db->where($cond);
        $this->db->limit(25);
        $data = $this->db->get();
        return $data->result_array();
    }

    public function reset_sent_notif($data){
        $this->db->set('SENT_NOTIF', 1);
        $this->db->where('EMP_CODE', $data);
        $this->db->update('NETS_EMP_USER');
    }
    // hdf jobs
    public function get_hdf_cutoff_details($data){
        $this->db->select('*');
        $this->db->from('NXX_HDF_CUTOFF');
        $this->db->where('SUBMISSION_DATE', $data);
        $data = $this->db->get();

        return $data->result_array();
    }

    public function get_all_emp_info(){
        $this->db->select('A.EMP_LNAME, A.EMP_FNAME, A.MOBILE_NO, A.RUSH_ID, A.EMP_CODE, B.EMAIL_ADDRESS');
        $this->db->from('NETS_EMP_USER B');
        $this->db->join('NETS_EMP_INFO A', 'B.EMP_CODE = A.EMP_CODE', 'inner');
        $this->db->where('B.SENT_HDF_NOTIF', 0);
        $this->db->limit(500);
        $data = $this->db->get();

        return $data->result_array();
    }

    public function update_sent_hdf_notif($data){
        $this->db->set('SENT_HDF_NOTIF', 1);
        $this->db->where('EMP_CODE', $data);
        $this->db->update('NETS_EMP_USER');
    }

    public function get_hdf_required_employee($data){
        $this->db->select('EMP_CODE');
        $this->db->from('NXX_HDF_CTEMP');
        $this->db->where('CUTOFF_ID', $data);
        $data = $this->db->get();

        return $data->result_array();
    }

    public function get_info_required_emps($data){
        $this->db->select('A.EMP_LNAME, A.EMP_FNAME, A.MOBILE_NO, A.RUSH_ID, A.EMP_CODE, B.EMAIL_ADDRESS');
        $this->db->from('NETS_EMP_USER B');
        $this->db->join('NETS_EMP_INFO A', 'B.EMP_CODE = A.EMP_CODE', 'inner');
        $this->db->where_in('B.EMP_CODE', $data);
        $this->db->where('B.SENT_HDF_NOTIF', 0);
        $this->db->limit(500);
        $data = $this->db->get();

        return $data->result_array();
    }

    public function reset_submitted_hdf($data){
        if($data == null){
            $this->db->set('SUBMITTED_HDF', 0);
            $this->db->update('NETS_EMP_USER');
        }
        else{
            $this->db->set('SUBMITTED_HDF', 0);
            $this->db->where('EMP_CODE', $data);
            $this->db->update('NETS_EMP_USER');
        }
    }

    public function reset_hdf_notif_late_submission($data){
        if($data == null){
            $this->db->set('SENT_HDF_NOTIF', 0);
            $this->db->where('SUBMITTED_HDF', 0);
            $this->db->update('NETS_EMP_USER');
        }
        else{
            $this->db->set('SENT_HDF_NOTIF', 0);
            $this->db->where('EMP_CODE', $data);
            $this->db->where('SUBMITTED_HDF', 0);
            $this->db->update('NETS_EMP_USER');
        }
    }

    public function reset_hdf_notif(){
        $this->db->set('SENT_HDF_NOTIF', 0);
        $this->db->update('NETS_EMP_USER');
    }

    public function get_employees_with_no_hdf(){
        $this->db->select('A.EMP_LNAME, A.EMP_FNAME, A.MOBILE_NO, A.RUSH_ID, A.EMP_CODE, B.EMAIL_ADDRESS');
        $this->db->from('NETS_EMP_USER B');
        $this->db->join('NETS_EMP_INFO A', 'B.EMP_CODE = A.EMP_CODE', 'inner');
        $this->db->where('B.SENT_HDF_NOTIF', 0);
        $this->db->where('B.SUBMITTED_HDF', 0);
        $this->db->limit(500);
        $data = $this->db->get();

        return $data->result_array();

    }

    public function get_div_heads(){
        $this->db->select('A.EMP_LNAME, A.EMP_FNAME, A.MOBILE_NO, A.RUSH_ID, B.EMAIL_ADDRESS, A.GRP_CODE');
        $this->db->from('NETS_EMP_USER B');
        $this->db->join('NETS_EMP_INFO A', 'B.EMP_CODE = A.EMP_CODE', 'inner');
        $this->db->where('A.APVL_LVL', 40);
        $data = $this->db->get();

        return $data->result_array();
    }

    public function get_employees_with_no_hdf_per_div($data){
        $this->db->select('A.EMP_LNAME, A.EMP_FNAME, A.MOBILE_NO, A.RUSH_ID, B.EMAIL_ADDRESS');
        $this->db->from('NETS_EMP_USER B');
        $this->db->join('NETS_EMP_INFO A', 'B.EMP_CODE = A.EMP_CODE', 'inner');
        $this->db->where('B.SUBMITTED_HDF', 0);
        $this->db->where('A.GRP_CODE', $data);
        $data = $this->db->get();

        return $data->result_array();

    }

    public function get_pending_hdf(){
        
        $cond = "( LAST_CHECKED < '" . date("Y/m/d h:i:sa") . "' OR LAST_CHECKED IS NULL) AND RUSHNO IS NOT NULL";

        $this->db->select('RUSHNO');
        $this->db->from('NETS_EMP_HDF');
        $this->db->where($cond);
        $this->db->order_by('LAST_CHECKED ASC');
        $this->db->limit(25);
        $data = $this->db->get();
        return $data->result_array();
    }

    public function update_hdf($data){
        $this->db->set($data['COLUMN'], $data['VALUE']);
        $this->db->where('RUSHNO', $data['RUSHNO']);
        $this->db->update('NETS_EMP_HDF');
    }

    public function get_employees_with_no_ehc(){
        $this->db->select('A.EMP_LNAME, A.EMP_FNAME, A.MOBILE_NO, A.RUSH_ID, B.EMAIL_ADDRESS');
        $this->db->from('NETS_EMP_USER B');
        $this->db->join('NETS_EMP_INFO A', 'B.EMP_CODE = A.EMP_CODE', 'inner');
        $this->db->where('B.SUBMITTED_EHC', 0);
        $this->db->where('B.SENT_NOTIF', 0);
        $this->db->limit(70);
        $data = $this->db->get();

        return $data->result_array();

    }

    public function get_employees_with_no_ehc_per_div($data){
        $this->db->select('A.EMP_LNAME, A.EMP_FNAME, A.MOBILE_NO, A.RUSH_ID, B.EMAIL_ADDRESS');
        $this->db->from('NETS_EMP_USER B');
        $this->db->join('NETS_EMP_INFO A', 'B.EMP_CODE = A.EMP_CODE', 'inner');
        $this->db->where('B.SUBMITTED_EHC', 0);
        $this->db->where('A.GRP_CODE', $data);
        $data = $this->db->get();

        return $data->result_array();

    }

    public function reset_notif_all_emps_with_no_ehc(){
        $this->db->set('SENT_NOTIF', 0);
        $this->db->where('SUBMITTED_EHC', 0);
        $this->db->update('NETS_EMP_USER');
    }
}