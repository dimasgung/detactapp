<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginTracking extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
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
        $data['title']   = SITE_NAME;
        $data['content'] = "Hasil Login Tracking";
        $data['logintracking'] = $this->LoginTracking_model->get_logintracking();

		$this->load->view('login_tracking_view', $data);
	} 

	function detail($id = NULL)
	{
        $data['logintracking_detail'] = $this->LoginTracking_model->get_logintracking($id);

		$this->load->view('login_tracking_detail_view', $data);
	} 

	function add()
	{
	    $this->load->helper('form');
	    $this->load->library('form_validation');

	    $data['title'] = SITE_NAME;

	    $this->form_validation->set_rules('attemptdate', 'Attempt Date', 'required');
	    $this->form_validation->set_rules('attemptresult', 'Attemp Result', 'required');
	    $this->form_validation->set_rules('name', 'Name', 'required');
	    $this->form_validation->set_rules('userid', 'User id', 'required');
	    $this->form_validation->set_rules('logintrackingid', 'Login Tracking ID', 'required');
	    $this->form_validation->set_rules('rowstamp', 'Row Stamp', 'required');

	    if ($this->form_validation->run() === FALSE)
	    {
	        $this->load->view('login_tracking_add_view', $data);
	    }
	    else
	    {
	        $data['insert_id'] = $this->LoginTracking_model->add_logintracking();
	        $this->load->view('login_tracking_success_view', $data);
	    }
	}

	function delete(){
	    $logintracking_id = $this->uri->segment(3);
	    $this->LoginTracking_model->delete_logintracking($logintracking_id);
	    redirect('LoginTracking');
	}

	function edit(){
	    $logintracking_id = $this->uri->segment(3);
	    $data['logintracking_detail'] = $this->LoginTracking_model->get_logintracking($logintracking_id);

	    if(sizeof($result) > 0){
	        $logintracking_detail = $result->row_array();
	        $data = array(
	            'logintracking_id'  => $logintracking_detail['LOGINTRACKINGID'],
	            'attempdate'		=> $logintracking_detail['ATTEMPTDATE'],
	            'attempresult'     	=> $logintracking_detail['ATTEMPTRESULT'],
	            'name'				=> $logintracking_detail['NAME'],
	            'userid'     		=> $logintracking_detail['USERID'],
	            'rowstamp'		    => $logintracking_detail['ROWSTAMP']
	        );
	        $this->load->view('edit_product_view',$data);
	    }else{
	        echo "Data Was Not Found";
	    }
	}

	function update(){

	    $this->load->helper('form');
	    $this->load->library('form_validation');

	    $data['title'] = SITE_NAME;

	    $this->form_validation->set_rules('attemptdate', 'Attempt Date', 'required');
	    $this->form_validation->set_rules('attemptresult', 'Attemp Result', 'required');
	    $this->form_validation->set_rules('name', 'Name', 'required');
	    $this->form_validation->set_rules('userid', 'User id', 'required');
	    $this->form_validation->set_rules('logintrackingid', 'Login Tracking ID', 'required');
	    $this->form_validation->set_rules('rowstamp', 'Row Stamp', 'required');

	    if ($this->form_validation->run() === FALSE)
	    {
		    $logintracking_id = $this->uri->segment(3);
		    $result['logintracking_detail']= $this->LoginTracking_model->get_logintracking($logintracking_id);

		    if(sizeof($result) > 0){
		        $logintracking_detail = $result['logintracking_detail'];
		        $data = array(
		            'logintrackingid'  => $logintracking_detail['LOGINTRACKINGID'],
		            'attempdate'		=> $logintracking_detail['ATTEMPTDATE'],
		            'attempresult'     	=> $logintracking_detail['ATTEMPTRESULT'],
		            'name'				=> $logintracking_detail['NAME'],
		            'userid'     		=> $logintracking_detail['USERID'],
		            'rowstamp'		    => $logintracking_detail['ROWSTAMP']
		        );
		        $this->load->view('login_tracking_edit_view',$data);
		    }else{
		        echo "Data Was Not Found";
		    }
	    }
	    else
	    {
	        $data['insert_id'] = $this->LoginTracking_model->update_logintracking();
		    redirect('LoginTracking');
	    }
	}
}
