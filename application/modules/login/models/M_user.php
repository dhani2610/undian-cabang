<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model{	
	
	//fungsi cek session
    function is_logged_in()
    {
        return $this->session->userdata('ta_user_id');
    }

	//fungsi check login
    function check_login($table, $field)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field);        
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }	
}