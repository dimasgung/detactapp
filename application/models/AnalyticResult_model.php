<?php
class AnalyticResult_model extends CI_Model {

    var $table = 'analytic_result'; //nama tabel dari database
    var $column_order = array(null, 'ATTEMPTDATE', 'APLIKASI', 'USERID', 'PREDICTION_RESULT'); //field yang ada di table user
    var $column_search = array('ATTEMPTDATE','APLIKASI', 'USERID', 'PREDICTION_RESULT'); //field yang diizin untuk pencarian 
    var $order = array('ATTEMPTDATE' => 'desc'); // default order 

    public function __construct(){
            $this->load->database();
    }

    public function get_analytic_result($attempt_date = FALSE) {
        if ($attempt_date === FALSE){
             $query = $this->db->get('analytic_result');
             return $query->result_array();
        }

        $query = $this->db->get_where('analytic_result', array('ATTEMPTDATE' => $attempt_date));
        return $query->row_array();
    }

    private function _get_analytic_result_datatables_query()
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
 
    function get_analytic_result_datatables()
    {
        $this->_get_analytic_result_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

     public function count_filtered()
    {
        $this->_get_analytic_result_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_date_from_current_analytic_result_data(){
        // $SQL = "select distinct DATE(ATTEMPTDATE) from logintracking"
        // $query = $this->db->query($SQL);

        $query = $this->db->select("distinct DATE(ATTEMPTDATE) as attemptdate");
        $this->db->from($this->table);
        $query=$this->db->get();

        return $query->result_array();
    }
}