<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CNOP_Model extends CI_Model {

    var $table = 'mobile_site'; //nama tabel dari database
    var $column_order = array(null, 'SITE_ID', 'SITE_NAME', 'ADDRESS','REGIONAL', 'WITEL', 'STO', 'STATUS', 'NAME_OSP'); //field yang ada di table user
    var $column_search = array('SITE_ID', 'SITE_NAME', 'ADDRESS','REGIONAL', 'WITEL', 'STO', 'STATUS', 'NAME_OSP'); //field yang diizin untuk pencarian 
    var $order = array('SITE_ID' => 'asc'); // default order 

    public function __construct(){
        $this->load->database();
    }

    public function view(){

        $this->load->database();
        return $this->db->get('mobile_site')->result(); // Tampilkan semua data yang ada di tabel mobile_site
    }
      
      // Fungsi untuk melakukan proses upload file
    public function upload_file($filename){
        $this->load->library('upload'); // Load librari upload
        
        $config['upload_path'] = './csv/';
        $config['allowed_types'] = 'csv';
        $config['max_size']  = '20480000';
        $config['overwrite'] = true;
        $config['file_name'] = $filename;
      
        $this->upload->initialize($config); // Load konfigurasi uploadnya
        if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
          // Jika berhasil :
          $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
          return $return;
        }else{
          // Jika gagal :
          $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
          return $return;
        }
    }
      
      // Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
    public function insert_multiple($data){
        $this->db->insert_batch('mobile_site', $data);
    }

    public function insert($data){
        $this->db->set($data);
        return $this->db->insert('mobile_site', $data);
    }

  private function _get_mobile_site_datatables_query()
    {
         
        $this->db->from($this->table);

        $this->db->where('STATUS', 'OPEN');
 
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
 
    function get_mobile_site_datatables()
    {
        $this->_get_mobile_site_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered()
    {
        $this->_get_mobile_site_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('STATUS', 'OPEN');
        return $this->db->count_all_results();
    }

  private function _get_mobile_site_datatables_query_processed()
    {
         
        $this->db->from($this->table);

        $this->db->where('STATUS !=', 'OPEN');
 
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
 
    function get_mobile_site_datatables_processed()
    {
        $this->_get_mobile_site_datatables_query_processed();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered_processed()
    {
        $this->_get_mobile_site_datatables_query_processed();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_processed()
    {
        $this->db->from($this->table);
        $this->db->where('STATUS !=', 'OPEN');
        return $this->db->count_all_results();
    }

    public function get_mobile_site($site_id = FALSE) {
      if ($site_id === FALSE){
           $query = $this->db->get('mobile_site');
           return $query->result_array();
      }

      $query = $this->db->get_where('mobile_site', array('site_id' => $site_id));

      return $query->row_array();
    }

    function update_mobile_site_by_api_response($site_id,$status,$response){
        $hasil=$this->db->query("UPDATE mobile_site SET STATUS='$status',RESPONSE='$response' WHERE SITE_ID='$site_id'");
        return $hasil;
    }
 
}