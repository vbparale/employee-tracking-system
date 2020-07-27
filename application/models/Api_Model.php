<?php
class Api_Model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_questions($data){
                $this->db->select('*');
                $this->db->from('NXX_QUESTIONNAIRE');
                $this->db->where('TRANSACTION', $data);
                $this->db->order_by('SEQUENCE', 'ASC');
                $data = $this->db->get();

                return $data->result_array();
        }

        public function submit_ehc($data){
                $this->db->insert('NETS_EMP_EHC', $data);
                $insert_id = $this->db->insert_id();

                return  $insert_id;
        }

        public function update_ehc($id, $column, $data){
                $this->db->set($column, $data);
                $this->db->where('EHC_ID', $id);
                $this->db->update('NETS_EMP_EHC');
        }

        public function update_submitted_ehc($data){
                $this->db->set('SUBMITTED_EHC', 1);
                $this->db->where('EMP_CODE', $data);
                $this->db->update('NETS_EMP_USER');
        }

        public function get_submitted_ehc($data){
                $this->db->select('SUBMITTED_EHC');
                $this->db->from('NETS_EMP_USER');
                $this->db->where('EMP_CODE', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function login($data){
                $this->db->select('A.EMP_CODE, A.LOGIN_ID, A.PASSWORD, B.RUSH_ID, A.ROLE_ID');
                $this->db->from('NETS_EMP_USER A');
                $this->db->join('NETS_EMP_INFO B', 'A.EMP_CODE = B.EMP_CODE', 'INNER');
                $this->db->where('LOGIN_ID', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_nets_emp_info($data){
                $this->db->select('EMP_LNAME, EMP_MNAME, EMP_FNAME');
                $this->db->from('NETS_EMP_INFO');
                $this->db->where('EMP_CODE', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_all_ehc($data){
                $this->db->select('EHC_ID, EHC_DATE, COMPLETION_DATE, A1, RUSHNO, define_rush(STATUS) as STATUS');
                $this->db->from('NETS_EMP_EHC');
                $this->db->where('EMP_CODE', $data);
                $this->db->order_by('EHC_DATE', 'ASC');
                $data = $this->db->get();

                // code from sir ferds
                $rows = $data->result_array();

                foreach($rows as $key => $row){
                        $row['EHC_DATE'] = date_format(date_create($row['EHC_DATE']), "m/d/Y");
                        $row['COMPLETION_DATE'] = date_format(date_create($row['COMPLETION_DATE']), "m/d/Y h:i:s A");
                        $rows[$key] = $row;

                }
                return $rows;
                // code from sir ferds
                // return $data->result_array();
        }

        public function get_ehc_details($data){
                $this->db->select('*');
                $this->db->from('NETS_EMP_EHC');
                $this->db->where('EHC_ID', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function update_ehc_record($data, $id){
                $this->db->where('EHC_ID', $id);
                $this->db->update('NETS_EMP_EHC', $data);
        }

        public function update_nets_emp_user($data){
                $this->db->set($data['COLUMN'], $data['VALUE']);
                $this->db->where('LOGIN_ID', $data['LOGIN_ID']);
                $this->db->update('NETS_EMP_USER');
        }

        public function get_ehc_symptoms($data, $emp_code){
                $where = "EHC_DATE BETWEEN DATE_SUB('".$data."', INTERVAL 6 DAY) AND '".$data."' AND EMP_CODE = '".$emp_code."'";
                $this->db->select('EHC_DATE, A3');
                $this->db->from('NETS_EMP_EHC');
                // $this->db->where('EHC_DATE', 'DATE_SUB('.date_format(date_create($data), "m/d/Y").', INTERVAL 7 DAY)');
                // $this->db->where('EMP_CODE', 'TEST2');
                $this->db->where($where);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_emp_info($data){
                $this->db->select('*');
                $this->db->from('NETS_EMP_INFO');
                $this->db->where('EMP_CODE', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_company_desc($data){
                $this->db->select('COMP_NAME');
                $this->db->from('NXX_COMPANY');
                $this->db->where('COMP_CODE', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_group_desc($data){
                $this->db->select('GRP_NAME');
                $this->db->from('NXX_GROUP');
                $this->db->where('GRP_CODE', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function insert_emp_hdf($data){
                $this->db->insert('NETS_EMP_HDF', $data);
                $insert_id = $this->db->insert_id();

                return  $insert_id;
        }

        public function insert_hdf_other($table, $data){
                $this->db->insert($table, $data);
                $insert_id = $this->db->insert_id();

                return  $insert_id;
        }

        public function get_all_hdf($data){
                $this->db->select('A.HDF_ID, A.HDF_DATE, A.COMPLETION_DATE, B.A1 AS FEVER, 
                C.A1 AS TRAVEL_HIST, C.A1PLACE AS PLACE_FROM, 
                C.A2 AS TRAVEL_SCHED, C.A2TRAVEL_DATES AS TRAVEL_DATE, C.A2PLACE AS PLACE_TOGO, A.RUSHNO, define_rush(A.STATUS) AS STATUS');
                $this->db->from('NETS_EMP_HDF A');
                $this->db->join('NETS_HDF_HEALTHDEC B', 'A.HDF_ID = B.HDF_ID', 'INNER');
                $this->db->join('NETS_HDF_TRAVELHISTORY C', 'A.HDF_ID = C.HDF_ID', 'INNER');
                $this->db->where('A.EMP_CODE', $data);
                $data = $this->db->get();

                // code from sir ferds
                $rows = $data->result_array();

                foreach($rows as $key => $row){
                        $row['HDF_DATE'] = date_format(date_create($row['HDF_DATE']), "m/d/Y");
                        $row['COMPLETION_DATE'] = date_format(date_create($row['COMPLETION_DATE']), "m/d/Y h:i:s A");
                        $rows[$key] = $row;

                }
                return $rows;
                // code from sir ferds
                // return $data->result_array();

                // return $data->result_array();
        }

        public function update_emp_info($EMP_CODE, $data){
                $this->db->where('EMP_CODE', $EMP_CODE);
                $this->db->update('NETS_EMP_INFO', $data);
        }

        public function submitted_hdf($EMP_CODE){
                $this->db->set('SUBMITTED_HDF', 1);
                $this->db->where('EMP_CODE', $EMP_CODE);
                $this->db->update('NETS_EMP_USER');
        }

        public function get_cutoff(){
                $this->db->select('CUTOFFID, EMP_FLAG, SUBMISSION_DATE, CUTOFF_TIME');
                $this->db->from('NXX_HDF_CUTOFF');
                $this->db->where('SUBMISSION_DATE', date("Y/m/d"));
                $data = $this->db->get();

                return $data->result_array();
        }
        
        public function update_nxx_hdf_cutoff($data){
                $this->db->set('ANS_FLAG', 1);
                $this->db->where('CUTOFFID', $data);
                $this->db->update('NXX_HDF_CUTOFF');
        }

        public function get_cutoff_time($data){
                $this->db->select('CUTOFFID, EMP_FLAG, SUBMISSION_DATE, CUTOFF_TIME');
                $this->db->from('NXX_HDF_CUTOFF');
                $this->db->where('CUTOFFID', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_hh($data){
                $this->db->select('*');
                $this->db->from('NETS_HDF_HHOLD');
                $this->db->where('HDF_ID', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_hhcd($data){
                $this->db->select('*');
                $this->db->from('NETS_HDF_CHRNC_DISEASE');
                $this->db->where('ANSKEY', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_th($data){
                $this->db->select('*');
                $this->db->from('NETS_HDF_TRAVELHISTORY');
                $this->db->where('HDF_ID', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_hd($data){
                $this->db->select('*');
                $this->db->from('NETS_HDF_HEALTHDEC');
                $this->db->where('HDF_ID', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_oi($data){
                $this->db->select('*');
                $this->db->from('NETS_HDF_OTHERINFO');
                $this->db->where('HDF_ID', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_hdf($data){
                $this->db->select('*');
                $this->db->from('NETS_EMP_HDF');
                $this->db->where('HDF_ID', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function update_hdf($id, $data){
                $this->db->where('HDF_ID', $id);
                $this->db->update('NETS_EMP_HDF', $data);
        }

        public function update_hdfcd($data){
                $this->db->replace('NETS_HDF_CHRNC_DISEASE', $data);
        }

        public function delete_hdfcd($data){
                $this->db->where('ANSKEY', $data);
                $this->db->delete('NETS_HDF_CHRNC_DISEASE');
        }

        public function update_hdfhh($id, $data){
                $this->db->where('HDF_ID', $id);
                $this->db->update('NETS_HDF_HHOLD', $data);
        }

        public function update_hdfhd($id, $data){
                $this->db->where('HDF_ID', $id);
                $this->db->update('NETS_HDF_HEALTHDEC', $data);
        }

        public function update_hdfth($id, $data){
                $this->db->where('HDF_ID', $id);
                $this->db->update('NETS_HDF_TRAVELHISTORY', $data);
        }

        public function update_hdfoi($id, $data){
                $this->db->where('HDF_ID', $id);
                $this->db->update('NETS_HDF_OTHERINFO', $data);
        }

        public function get_hdf_cutoff($data){
                $this->db->select('CUTOFF_TIME');
                $this->db->from('NXX_HDF_CUTOFF');
                $this->db->where('SUBMISSION_DATE', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_hdf_cutoff_details($data){
                $this->db->select('*');
                $this->db->from('NXX_HDF_CUTOFF');
                $this->db->where('SUBMISSION_DATE', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_required_emps($data){
                $this->db->select('*');
                $this->db->from('NXX_HDF_CTEMP');
                $this->db->where('CUTOFF_ID', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function update_hdf_cutoff($id){
                $this->db->set('ANS_FLAG', 1);
                $this->db->where('CUTOFFID', $id);
                $this->db->update('NXX_HDF_CUTOFF');
        }

        public function get_submitted_hdf($data){
                $this->db->select('SUBMITTED_HDF');
                $this->db->from('NETS_EMP_USER');
                $this->db->where('EMP_CODE', $data);
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_group(){
                $this->db->select('*');
                $this->db->from('NXX_GROUP');
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_company(){
                $this->db->select('*');
                $this->db->from('NXX_COMPANY');
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_ehc_today($data){
                $this->db->select('EMP_CODE');
                $this->db->from('NETS_EMP_EHC');
                $this->db->where('EMP_CODE', $data);
                $this->db->where('EHC_DATE', date('Y-m-d'));
                $data = $this->db->get();

                return $data->result_array();
        }

        public function get_hdf_today($data){
                $this->db->select('HDF_ID');
                $this->db->from('NETS_EMP_HDF');
                $this->db->where('EMP_CODE', $data);
                $this->db->where('HDF_DATE', date('Y-m-d'));
                $data = $this->db->get();

                return $data->result_array();
        }

        // VIEL 05182020
        public function update_user_password($emp_code, $newpassword, $date_updated) {
                $this->db->set('PASSWORD', $newpassword);
                $this->db->set('DATEPWDCHANGED', $date_updated);
                $this->db->where('EMP_CODE', $emp_code);
                $this->db->update('NETS_EMP_USER');
                return true;
        }

        public function get_logged_user_data( $emp_code ) {
             $this->db->select("*"); 
             $this->db->where('EMP_CODE', $emp_code);
             $this->db->from('NETS_EMP_USER');
             $query = $this->db->get();
             return $query->row();
        }

        // END 05182020
}