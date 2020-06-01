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
        // $data['logintracking'] = $this->LoginTracking_model->get_logintracking();

        $data_sidebar['menu_active'] = 'Login Tracking';
        $data_sidebar['sub_menu_active'] = 'Login Tracking Data';

		$this->load->view('template/navbar_view');
		$this->load->view('template/sidebar_view', $data_sidebar);
		$this->load->view('login_tracking/login_tracking_view', $data);
		$this->load->view('template/footer_view');

	} 

	function get_data_logintracking()
    {
        $list = $this->LoginTracking_model->get_logintracking_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->ATTEMPTDATE;
            $row[] = $field->ATTEMPTRESULT;
            $row[] = $field->NAME;
            $row[] = $field->USERID;
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->LoginTracking_model->count_all(),
            "recordsFiltered" => $this->LoginTracking_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

	function detail($id = NULL)
	{
        $data['logintracking_detail'] = $this->LoginTracking_model->get_logintracking($id);

		$this->load->view('template/navbar_view');
		$this->load->view('template/sidebar_view');
		$this->load->view('login_tracking/login_tracking_detail_view', $data);
		$this->load->view('template/footer_view');
	} 

	function add()
	{
	    $this->load->helper('form');
	    $this->load->library('form_validation');

	    $data['title'] = SITE_NAME;

        $data_sidebar['menu_active'] = 'Login Tracking';
        $data_sidebar['sub_menu_active'] = 'Login Tracking Data';

	    $this->form_validation->set_rules('attemptdate', 'Attempt Date', 'required');
	    $this->form_validation->set_rules('attemptresult', 'Attemp Result', 'required');
	    $this->form_validation->set_rules('name', 'Name', 'required');
	    $this->form_validation->set_rules('userid', 'User id', 'required');
	    $this->form_validation->set_rules('logintrackingid', 'Login Tracking ID', 'required');
	    $this->form_validation->set_rules('rowstamp', 'Row Stamp', 'required');

	    if ($this->form_validation->run() === FALSE)
	    {

			$this->load->view('template/navbar_view');
			$this->load->view('template/sidebar_view', $data_sidebar);
	        $this->load->view('login_tracking/login_tracking_add_view', $data);
			$this->load->view('template/footer_view');
	    }
	    else
	    {
	        $data['insert_id'] = $this->LoginTracking_model->add_logintracking();

			$this->load->view('template/navbar_view');
			$this->load->view('template/sidebar_view', $data_sidebar);
	        $this->load->view('login_tracking/login_tracking_success_view', $data);
			$this->load->view('template/footer_view');
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


			$this->load->view('template/navbar_view');
			$this->load->view('template/sidebar_view');
	        $this->load->view('login_tracking/edit_product_view',$data);
			$this->load->view('template/footer_view');
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

				$this->load->view('template/navbar_view');
				$this->load->view('template/sidebar_view');		        
		        $this->load->view('login_tracking/login_tracking_edit_view',$data);
				$this->load->view('template/footer_view');
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
