<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
    	parent::__construct();

    	$this->load->model('LoginTracking_model');
    	$this->load->model('SharedAccountHistory_model');


        $this->load->library(array('form_validation','ion_auth'));

    	if (!$this->ion_auth->logged_in()) {//cek login ga?
    		redirect('Auth/login','refresh');
    	}else{
            if (!$this->ion_auth->in_group('admin')) {//cek admin ga?
                redirect('Auth/login','refresh');
            }
        }
	}

	function index()
	{

		$data_sidebar['menu_active'] = 'Dashboard';
		$data_sidebar['sub_menu_active'] = '';

		$this->load->view('template/navbar_view');
		$this->load->view('template/sidebar_view', $data_sidebar);
		$this->load->view('dashboard/dashboard_home_view');
		$this->load->view('template/footer_view');
	}

	function get_count_confirmation(){
		$count_need_confirmation = $this->SharedAccountHistory_model->count_all();

		echo $count_need_confirmation;
	}

	function get_count_sent(){
		$count_sent = $this->SharedAccountHistory_model->count_all_sent();

		echo $count_sent;
	}

	function get_count_failed(){
		$count_failed = $this->SharedAccountHistory_model->count_all_failed();

		echo $count_failed;
	}

	function get_count_action(){
		$count_action = $this->SharedAccountHistory_model->count_all_action();

		echo $count_action;
	}

	function get_data_shared_account_history_top_all(){

        $list = $this->SharedAccountHistory_model->get_shared_account_history_datatables_top_all();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $field->USERID;
            $row[] = $field->APPLICATION;
            $row[] = $field->TOTAL_HISTORY;
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->SharedAccountHistory_model->count_all_top_all(),
            "recordsFiltered" => $this->SharedAccountHistory_model->count_filtered_top_all(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
  }
}
