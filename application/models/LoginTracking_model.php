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

	public function add_logintracking(){
	    $this->load->helper('url');

	    $logintrackingid = url_title($this->input->post('logintrackingid'), 'dash', TRUE);

	    $data = array(
	        'ATTEMPTDATE' => $this->input->post('attemptdate'),
	        'LOGINTRACKINGID' => $logintrackingid,
	        'ATTEMPTRESULT' => $this->input->post('attemptresult'),
	        'LOGINTRACKINGID' => $this->input->post('logintrackingid'),
	        'ROWSTAMP' => $this->input->post('rowstamp'),
	        'NAME' => $this->input->post('name'),
	        'USERID' => $this->input->post('userid'),
	    );
		
	    return $this->db->insert('logintracking', $data);
	}

	public function delete_logintracking($logintrackingid){
	    $this->db->where('LOGINTRACKINGID', $logintrackingid);
	    $this->db->delete('logintracking');
	}

	public function update_logintracking(){
	    $this->load->helper('url');

	    $logintrackingid = url_title($this->input->post('logintrackingid'), 'dash', TRUE);

	    $data = array(
	        'ATTEMPTDATE' => $this->input->post('attemptdate'),
	        'LOGINTRACKINGID' => $logintrackingid,
	        'ATTEMPTRESULT' => $this->input->post('attemptresult'),
	        'LOGINTRACKINGID' => $this->input->post('logintrackingid'),
	        'ROWSTAMP' => $this->input->post('rowstamp'),
	        'NAME' => $this->input->post('name'),
	        'USERID' => $this->input->post('userid'),
	    );

	    $this->db->where('LOGINTRACKINGID', $logintrackingid);
	    return $this->db->update('logintracking', $data);
	}
}