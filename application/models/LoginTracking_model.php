<?php
class LoginTracking_model extends CI_Model {

    var $table = 'logintracking'; //nama tabel dari database
    var $column_order = array(null, 'ATTEMPTDATE', 'ATTEMPTRESULT', 'NAME','USERID'); //field yang ada di table user
    var $column_search = array('ATTEMPTDATE', 'NAME','USERID'); //field yang diizin untuk pencarian 
    var $order = array('ATTEMPTDATE' => 'asc'); // default order 

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

	private function _get_logintracking_datatables_query()
    {
         
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_logintracking_datatables()
    {
        $this->_get_logintracking_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered()
    {
        $this->_get_logintracking_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_date_from_current_logintracking_data(){
        // $SQL = "select distinct DATE(ATTEMPTDATE) from logintracking"
        // $query = $this->db->query($SQL);

        $query = $this->db->select("distinct DATE(ATTEMPTDATE) as attemptdate");
        $this->db->from($this->table);
        $query=$this->db->get();

        return $query->result_array();
    }
}