<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
    	parent::__construct();

    	$this->load->model('LoginTracking_model');
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
}
