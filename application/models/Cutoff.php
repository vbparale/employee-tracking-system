<?php
class Cutoff extends CI_Model {

    public function __construct()
    {
            $this->load->database();
    }

    public function get_hdf_cutoff(){
        $this->db->select('CUTOFFID, EMP_FLAG, SUBMISSION_DATE, CUTOFF_TIME');
        $this->db->from('NXX_HDF_CUTOFF');
        $data = $this->db->get();

        $rows = $data->result_array();

        foreach($rows as $key => $row){
                $row['SUBMISSION_DATE'] = date_format(date_create($row['SUBMISSION_DATE']), "m/d/Y");
                $row['CUTOFF_TIME'] = date("g:i A", strtotime($row['CUTOFF_TIME']));
                $rows[$key] = $row;

        }
        return $rows;
    }

    public function get_cutoff_details($data){
        $this->db->select('*');
        $this->db->where('CUTOFFID', $data);
        $this->db->from('NXX_HDF_CUTOFF');
        $data = $this->db->get();

        return $data->result_array();
    }

    public function add_hdf_cutoff($data){
        $this->db->insert('NXX_HDF_CUTOFF', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function add_hdf_ctemp($data){
        $this->db->insert('NXX_HDF_CTEMP', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function get_hdf_ctemp($data){
        $this->db->select('CUTOFF_ID, EMP_CODE');
        $this->db->where('CUTOFF_ID', $data);
        $this->db->from('NXX_HDF_CTEMP');
        $data = $this->db->get();

        return $data->result_array();
    }

    public function update_hdf_cutoff($id, $data){
        $this->db->where('CUTOFFID', $id);
        $this->db->update('NXX_HDF_CUTOFF', $data);
    }

    public function update_hdf_ctemp($data){
        $this->db->insert('NXX_HDF_CTEMP', $data);
        $insert_id = $this->db->insert_id();
    }

    public function delete_hdf_ctemp($id){
        $this->db->where('CUTOFF_ID', $id);
        $this->db->delete('NXX_HDF_CTEMP');
    }

    public function cutoff($data){
        $this->db->select('CUTOFFID');
        $this->db->where('SUBMISSION_DATE', $data);
        $this->db->from('NXX_HDF_CUTOFF');
        $data = $this->db->get();

        return $data->result_array();
    }

}