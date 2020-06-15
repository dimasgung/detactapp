<?php
class LoginTrackingHistory_model extends CI_Model {

    var $table = 'logintracking_history'; //nama tabel dari database
    var $column_order = array(null, 'PROCESSED_ATTEMPT_DATE', 'APPLICATION', 'STATUS'); //field yang ada di table user
    var $column_search = array('PROCESSED_ATTEMPT_DATE', 'APPLICATION', 'STATUS'); //field yang diizin untuk pencarian 
    var $order = array('PROCESSED_ATTEMPT_DATE' => 'desc'); // default order 

    public function __construct(){
            $this->load->database();
    }

    public function get_logintracking_history($processed_attempt_date = FALSE, $application = FALSE) {
        if ($processed_attempt_date === FALSE && $application = FALSE){

            $this->db->select('LOGINTRACKING_HISTORY_ID, STATUS');
            $this->db->from($this->table);

            $query = $this->db->get('logintracking_history');
            return $query->result_array();
        }

        $this->db->select('LOGINTRACKING_HISTORY_ID, STATUS');
        $this->db->from($this->table);
        $this->db->where('PROCESSED_ATTEMPT_DATE', $processed_attempt_date);
        $this->db->where('APPLICATION', $application);

        $query = $this->db->get();
        return $query->row_array();
    }

    public function add_logintracking_history($data_source){
        $this->load->helper('url');

        $data = array(
            'PROCESSED_ATTEMPT_DATE' => $data_source['PROCESSED_ATTEMPT_DATE'],
            'APPLICATION' => $data_source['APPLICATION'],
            'STATUS' => 'FAILED'
        );
        $this->db->insert('logintracking_history', $data);

        return $this->db->insert_id();
    }

    private function _get_logintracking_history_datatables_query()
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
 
    function get_logintracking_history_datatables()
    {
        $this->_get_logintracking_history_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

     public function count_filtered()
    {
        $this->_get_logintracking_history_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_logintracking_history_id_by_attemptdate_and_application($attemptdate, $application){
        $this->db->select('LOGINTRACKING_HISTORY_ID');
        $this->db->from($this->table);
        $this->db->where('PROCESSED_ATTEMPT_DATE', $attemptdate);
        $this->db->where('APPLICATION', $application);

        $query = $this->db->get();
        return $query->row();
    }

    public function update_status_to_done_logintracking_history_by_id($logintracking_history_id){
        $hasil=$this->db->query("UPDATE logintracking_history SET STATUS='DONE' WHERE LOGINTRACKING_HISTORY_ID='".$logintracking_history_id."'");
        return $hasil;
    }
}