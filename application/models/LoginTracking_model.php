<?php
class LoginTracking_model extends CI_Model {

    public function __construct(){
            $this->load->database();
    }

    public function get_logintracking($logintrackingid = FALSE) {
    	if ($logintrackingid === FALSE){
       		 $query = $this->db->get('logintracking');
   		     return $query->result_array();
	    }

		$query = $this->db->get_where('logintracking', array('logintrackingid' => $logintrackingid));
	    return $query->row_array();
	}
}