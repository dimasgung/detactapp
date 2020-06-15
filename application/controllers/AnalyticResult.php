<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AnalyticResult extends CI_Controller {

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

    	$this->load->model('AnalyticResult_model');
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
        $data['content'] = "Login Tracking History";
        // $data['logintracking'] = $this->LoginTracking_model->get_logintracking();
        $data['option_date'] = $this->AnalyticResult_model->get_date_from_current_analytic_result_data();

        $data_sidebar['menu_active'] = 'Analytic Result';
        $data_sidebar['sub_menu_active'] = 'Shared Account';

		$this->load->view('template/navbar_view');
		$this->load->view('template/sidebar_view', $data_sidebar);
		$this->load->view('analytic_result/analytic_result_view', $data);
		$this->load->view('template/footer_view');

	} 

	function get_data_analytic_result()
    {
        $list = $this->AnalyticResult_model->get_analytic_result_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->ATTEMPTDATE;
            $row[] = $field->APPLICATION;
            $row[] = $field->USERID;

            if($field->PREDICTION == 0){
                $row[] = '<a href="#" class="btn btn-sm btn-primary">'.$field->PREDICTION_RESULT.'</a>';                   
            }

            if($field->PREDICTION == 1){
                $row[] = '<a href="#" class="btn btn-sm btn-danger">'.$field->PREDICTION_RESULT.'</a>';       
            }

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AnalyticResult_model->count_all(),
            "recordsFiltered" => $this->AnalyticResult_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function submitSharedAccountData(){
        $attemptdate = $this->input->post('processed_attempt_date');
        $application = $this->input->post('application');

        $sharedAccountData = $this->AnalyticResult_model->getSharedAccountData($application, $attemptdate);

        $this->load->model('SharedAccountHistory_model');

        $result='';

        foreach ($sharedAccountData as $data){  
            $detected_shared_account = array(
                'LOGINTRACKING_HISTORY_ID' => $data['LOGINTRACKING_HISTORY_ID'],
                'USERID' => $data['USERID'],
                'ATTEMPTDATE' => $data['ATTEMPTDATE'],
                'APPLICATION' => $data['APPLICATION'],
                'STATUS_CONFIRMATION' => 'OPEN',
                'IS_SHARED_CONFIRMATION' => 'OPEN',
                'ACTION_CONFIRMATION' => 'OPEN',
                'DESCRIPTION' => '',
            );

            $result = $this->SharedAccountHistory_model->insert_shared_account_history($detected_shared_account);

        } 

        $this->load->model('LoginTrackingHistory_model');
        $logintracking_history_id = $this->LoginTrackingHistory_model->get_logintracking_history_id_by_attemptdate_and_application($attemptdate, $application);
        $this->LoginTrackingHistory_model->update_status_to_done_logintracking_history_by_id($logintracking_history_id->LOGINTRACKING_HISTORY_ID);

        if($attemptdate == null){
                $this->AnalyticResult_model->delete_analytic_result_all_data();
        } else {
                $this->AnalyticResult_model->delete_analytic_result_by_attemptdate($attemptdate);
        }
        
        echo $attemptdate;
        // echo json_encode($sharedAccountData);
    }

    // function followup(){

    //     $attemptdate = $this->input->post('processed_attempt_date');
    //     $application = $this->input->post('application');

    //     if ($attemptdate == 'ALL' ){
    //         $attemptdate = null;
    //     }

    //     echo $attemptdate.' ' . $application;

    //     get_analytic_result();

    //     // if single date what happen

    //     // if all date what happen
    // }
}
