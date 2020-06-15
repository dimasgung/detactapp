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
        $data['option_date'] = $this->LoginTracking_model->get_date_from_current_logintracking_data();

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

	// function analyticProcessing(){
	// 	$data = array(
	//         'PROCESSED_ATTEMPT_DATE' => $this->input->post('processed_attempt_date'),
	//         'APPLICATION' => $this->input->post('application')
	//     );

	//    	$this->load->model('LoginTrackingHistory_model');

	//    	$result = $this->LoginTrackingHistory_model->get_logintracking_history($data['PROCESSED_ATTEMPT_DATE'], $data['PROCESSED_ATTEMPT_DATE']);

	//    	if($result == null){

	// 		$response_API = 'success';
	//    	} else {
	//    		$response_API = 'failed';
	//    	}

	// 	// cek apakah sudah ada data tanggal prosessed tersebut
	// 	// jika sudah ada, gagal

	//     //Prosess call API model analytic


	// 	if($response_API == 'success'){

	//         $data_sidebar['menu_active'] = 'Login Tracking';
	//         $data_sidebar['sub_menu_active'] = 'Login Tracking History';

	//         $data_success['message'] = "Deteksi sharing account data untuk aplikasi <b>". $data['APPLICATION'] ."</b> pada tanggal <b>". $data['PROCESSED_ATTEMPT_DATE'] . '</b> sedang diproses';

	//         $data['insert_id'] = $this->LoginTrackingHistory_model->add_logintracking_history($data);

	// 		$this->load->view('template/navbar_view');
	// 		$this->load->view('template/sidebar_view', $data_sidebar);
	// 		$this->load->view('template/success_information', $data_success);
	//         $this->load->view('login_tracking_history/login_tracking_history_view', $data);
	// 		$this->load->view('template/footer_view');
	// 	} else {

	// 		redirect('LoginTrackingHistory');
	// 	}
	// }

	function do_sharing_account_analytic(){

		$data = array(
	        'PROCESSED_ATTEMPT_DATE' => $this->input->post('attemptdate'),
	        'APPLICATION' => $this->input->post('application')
	    );

	   	$this->load->model('LoginTrackingHistory_model');

	   	$result = $this->LoginTrackingHistory_model->get_logintracking_history($data['PROCESSED_ATTEMPT_DATE'], $data['APPLICATION']);

	   	// echo var_dump($result);

	   	if($result == null){
			$response_API = 'success_because_null';
	   	} else {
	   		if($result['STATUS'] == 'FAILED'){
				$response_API = 'success_because_failed';
	   		} else {
		   		$response_API = 'failed';
		   	}
	   	}

	   	// echo $response_API;

		if($response_API == 'success_because_null' || $response_API == 'success_because_failed'){

			$urlAPISharingAccountAnalytic = 'http://10.62.175.75:8887/';

			$json = file_get_contents($urlAPISharingAccountAnalytic);
			$obj = json_decode($json);
			// echo $obj[0]->prediction;

			$data['LOGINTRACKING_HISTORY_ID'] = 0;

			if($response_API == 'success_because_null'){
		        $data['LOGINTRACKING_HISTORY_ID'] = $this->LoginTrackingHistory_model->add_logintracking_history($data);
			} else if ($response_API == 'success_because_failed') {
				$data['LOGINTRACKING_HISTORY_ID'] = $result['LOGINTRACKING_HISTORY_ID'];
			}

		   	$this->load->model('AnalyticResult_model');

			foreach ($obj as $userPrediction) {			

				$prediction_result = 'NORMAL';

				if($userPrediction->prediction == 1){
					$prediction_result = 'SHARED ACCOUNT';
				}

				$data_analytic_result =array(
		        'LOGINTRACKING_HISTORY_ID' => $data['LOGINTRACKING_HISTORY_ID'],
		        'ATTEMPTDATE' => $data['PROCESSED_ATTEMPT_DATE'],
		        'APPLICATION' => $data['APPLICATION'],
		        'USERID' => $userPrediction->user_id,
		        'PREDICTION' => $userPrediction->prediction,
		        'PREDICTION_RESULT' => $prediction_result,
		        'STATUS' => 'OPEN'
		    	);

				$insert_result = $this->AnalyticResult_model->insert_analytic_result_from_platform($data_analytic_result);
				// echo $insert_result;
			}

		   	$this->LoginTrackingHistory_model->update_status_to_done_logintracking_history_by_id($data['LOGINTRACKING_HISTORY_ID']);

	        echo json_encode('Prosesing analytic pada tanggal '. $data['PROCESSED_ATTEMPT_DATE'] .' berhasil dilakukan');

		} else {

	        echo json_encode('Prosesing analytic pada tanggal ' .$data['PROCESSED_ATTEMPT_DATE'] . ' telah dilakukan sebelumnya.');
		}


	}
}
