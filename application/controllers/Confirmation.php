<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Confirmation extends CI_Controller {
  
  public function __construct(){
    parent::__construct();
    
    $this->load->model('SharedAccountHistory_model');

  }
  
  public function index(){

    $this->load->view('confirmation/confirmation');
  }

  
  public function success(){
    
    $this->load->view('confirmation/success');
  }

  function confirmation_response(){

    $shared_account_history_id = $this->input->get('shared_account_history_id');
    $is_shared_confirmation = $this->input->get('is_shared_confirmation');
    $action_confirmation = $this->input->get('action_confirmation');

    $status = $this->SharedAccountHistory_model->get_confirmation_status_by_id($shared_account_history_id);

    if($status->STATUS_CONFIRMATION != 'RECEIVED'){
        // $total_history = $this->SharedAccountHistory_model->get_total_history_by_id($shared_account_history_id);

        // $total_history = $total_history + 1;

        $this->SharedAccountHistory_model->update_status_confirmation_shared_account_history_after_receiving_by_id($shared_account_history_id, 'RECEIVED', $is_shared_confirmation);

        redirect(base_url()."Confirmation");
    } else {
        redirect(base_url()."Confirmation/success");
    }
  }
}