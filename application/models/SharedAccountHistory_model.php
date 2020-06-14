<?php
class SharedAccountHistory_model extends CI_Model {

    var $table = 'shared_account_history'; //nama tabel dari database
    var $column_order = array(null, 'ATTEMPTDATE', 'APPLICATION', 'USERID', 'STATUS_CONFIRMATION', 'ACTION_CONFIRMATION', 'IS_SHARED_CONFIRMATION'); //field yang ada di table user
    var $column_search = array('ATTEMPTDATE','APPLICATION', 'USERID', 'STATUS_CONFIRMATION', 'ACTION_CONFIRMATION', 'IS_SHARED_CONFIRMATION'); //field yang diizin untuk pencarian 
    var $order = array('ATTEMPTDATE' => 'desc'); // default order 

    public function __construct(){
            $this->load->database();
    }

    public function view(){

        $this->load->database();
        return $this->db->get('shared_account_history')->result(); // Tampilkan semua data yang ada di tabel shared_account_history
    }
      
      // Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
    public function insert_multiple($data){
        $this->db->insert_batch('shared_account_history', $data);
    }

    public function insert($data){
        $this->db->set($data);
        return $this->db->insert('shared_account_history', $data);
    }

    // OPEN
  private function _get_shared_account_history_datatables_query()
    {
         
        $this->db->from($this->table);

        $this->db->where('STATUS_CONFIRMATION', 'OPEN');
 
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
 
    function get_shared_account_history_datatables()
    {
        $this->_get_shared_account_history_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered()
    {
        $this->_get_shared_account_history_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('STATUS_CONFIRMATION', 'OPEN');
        return $this->db->count_all_results();
    }

    // FAILED
  private function _get_shared_account_history_datatables_query_failed()
    {
         
        $this->db->from($this->table);

        $this->db->where('STATUS_CONFIRMATION', 'FAILED');
 
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
 
    function get_shared_account_history_datatables_failed()
    {
        $this->_get_shared_account_history_datatables_query_failed();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered_failed()
    {
        $this->_get_shared_account_history_datatables_query_failed();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_failed()
    {
        $this->db->from($this->table);
        $this->db->where('STATUS_CONFIRMATION', 'FAILED');
        return $this->db->count_all_results();
    }

    // SENT
  private function _get_shared_account_history_datatables_query_sent()
    {
         
        $this->db->from($this->table);

        $this->db->where('STATUS_CONFIRMATION', 'SENT');
 
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
 
    function get_shared_account_history_datatables_sent()
    {
        $this->_get_shared_account_history_datatables_query_sent();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered_sent()
    {
        $this->_get_shared_account_history_datatables_query_sent();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_sent()
    {
        $this->db->from($this->table);
        $this->db->where('STATUS_CONFIRMATION', 'SENT');
        return $this->db->count_all_results();
    }

    // Action
    private function _get_shared_account_history_datatables_query_action()
    {
         
        $this->db->from($this->table);

        $this->db->where('STATUS_CONFIRMATION', 'RECEIVED');
 
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
 
    function get_shared_account_history_datatables_action()
    {
        $this->_get_shared_account_history_datatables_query_action();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered_action()
    {
        $this->_get_shared_account_history_datatables_query_action();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_action()
    {
        $this->db->from($this->table);
        $this->db->where('STATUS_CONFIRMATION', 'RECEIVED');
        return $this->db->count_all_results();
    }

    public function get_shared_account_history($shared_account_history_id = FALSE) {
      if ($shared_account_history_id === FALSE){
           $query = $this->db->get('shared_account_history');
           return $query->result_array();
      }

      $query = $this->db->get_where('shared_account_history', array('SHARED_ACCOUNT_HISTORY_ID' => $shared_account_history_id));

      return $query->row_array();
    }

    function update_status_confirmation_shared_account_history_by_id($shared_account_history_id,$status){
        $hasil=$this->db->query("UPDATE shared_account_history SET STATUS_CONFIRMATION='".$status."' WHERE SHARED_ACCOUNT_HISTORY_ID='".$shared_account_history_id."'");
        return $hasil;
    }
 
    function update_status_confirmation_shared_account_history_after_receiving_by_id($shared_account_history_id, $status_confirmation,$is_shared_confirmation, $action_confirmation){
        $hasil=$this->db->query("UPDATE shared_account_history SET STATUS_CONFIRMATION='".$status_confirmation."', IS_SHARED_CONFIRMATION='". $is_shared_confirmation ."', ACTION_CONFIRMATION='". $action_confirmation ."' WHERE SHARED_ACCOUNT_HISTORY_ID='".$shared_account_history_id."'");
        return $hasil;
    }

    public function get_confirmation_status_by_id($shared_account_history_id = FALSE) {
        $this->db->select('STATUS_CONFIRMATION');
        $this->db->from($this->table);
        $this->db->where('SHARED_ACCOUNT_HISTORY_ID', $shared_account_history_id);

        $query = $this->db->get();
        return $query->row();
    }

    function get_count_shared_account_received_done_by_user_id_and_application($userid, $application){

        $this->db->from($this->table);
        $this->db->where('USERID', $userid);
        $this->db->where('APPLICATION', $application);
        $this->db->where('STATUS_CONFIRMATION in ("RECEIVED","DONE")');
        $this->db->where('IS_SHARED_CONFIRMATION', 'YES');
        return $this->db->count_all_results();
    }

}