<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SharedAccountHistory extends CI_Controller {
  
  public function __construct(){
    parent::__construct();
    
    $this->load->model('SharedAccountHistory_model');
    $this->load->library(array('form_validation','ion_auth'));  
    $this->load->library('encryption');
    // $this->load->library('MCrypt');

    if (!$this->ion_auth->logged_in()) {//cek login ga?
        redirect('Auth/login','refresh');
    }else{
          if (!$this->ion_auth->in_group('admin')) {//cek admin ga?
              redirect('Auth/login','refresh');
          }
    }
  }
  
  public function index(){

    $data_sidebar['menu_active'] = 'Shared Account History';
    $data_sidebar['sub_menu_active'] = 'Need Confirmation';

    $data['total_data'] = $this->SharedAccountHistory_model->count_all();

    $this->load->view('template/navbar_view');
    $this->load->view('template/sidebar_view', $data_sidebar);
    $this->load->view('shared_account_history/shared_account_history_confirmation_view', $data);
    $this->load->view('template/footer_view');
  }

  
  public function failed(){

    $data_sidebar['menu_active'] = 'Shared Account History';
    $data_sidebar['sub_menu_active'] = 'Failed Confirmation';

    $data['total_data'] = $this->SharedAccountHistory_model->count_all_failed();

    $this->load->view('template/navbar_view');
    $this->load->view('template/sidebar_view', $data_sidebar);
    $this->load->view('shared_account_history/shared_account_history_confirmation_failed_view', $data);
    $this->load->view('template/footer_view');
  }

  public function sent(){

    $data_sidebar['menu_active'] = 'Shared Account History';
    $data_sidebar['sub_menu_active'] = 'Sent Confirmation';

    $data['total_data'] = $this->SharedAccountHistory_model->count_all_failed();

    $this->load->view('template/navbar_view');
    $this->load->view('template/sidebar_view', $data_sidebar);
    $this->load->view('shared_account_history/shared_account_history_confirmation_sent_view', $data);
    $this->load->view('template/footer_view');
  }

  public function action(){

    // view versi 1
    // $data['shared_account_history'] = $this->SharedAccountHistory_model->view();
    // $this->load->view('migrasi_SharedAccountHistory/shared_account_history_migration_view', $data);

    // view versi 2 - datatables
    $data_sidebar['menu_active'] = 'Shared Account History';
    $data_sidebar['sub_menu_active'] = 'Need Action';


    $data['total_data'] = $this->SharedAccountHistory_model->count_all_action();

    $this->load->view('template/navbar_view');
    $this->load->view('template/sidebar_view', $data_sidebar);
    $this->load->view('shared_account_history/shared_account_history_action_view', $data);
    $this->load->view('template/footer_view');
  }

  public function top(){

    // view versi 1
    // $data['shared_account_history'] = $this->SharedAccountHistory_model->view();
    // $this->load->view('migrasi_SharedAccountHistory/shared_account_history_migration_view', $data);

    // view versi 2 - datatables
    $data_sidebar['menu_active'] = 'Top 25';
    $data_sidebar['sub_menu_active'] = 'Top 25 Confirmed Case';


    // $data['total_data'] = $this->SharedAccountHistory_model->count_all();

    $this->load->view('template/navbar_view');
    $this->load->view('template/sidebar_view', $data_sidebar);
    $this->load->view('shared_account_history/shared_account_history_top_view');
    $this->load->view('template/footer_view');
  }

  public function top_all(){

    // view versi 1
    // $data['shared_account_history'] = $this->SharedAccountHistory_model->view();
    // $this->load->view('migrasi_SharedAccountHistory/shared_account_history_migration_view', $data);

    // view versi 2 - datatables
    $data_sidebar['menu_active'] = 'Top 25';
    $data_sidebar['sub_menu_active'] = 'Top 25 All Detected Case';


    // $data['total_data'] = $this->SharedAccountHistory_model->count_all();

    $this->load->view('template/navbar_view');
    $this->load->view('template/sidebar_view', $data_sidebar);
    $this->load->view('shared_account_history/shared_account_history_top_all_view');
    $this->load->view('template/footer_view');
  }

  function send_email_confirmation(){

        $shared_account_history_id = $this->input->post('shared_account_history_id');
        $userid = $this->input->post('userid');
        $attempdate = $this->input->post('attempdate');
        $application = $this->input->post('application');

        $this->load->library('email');//panggil library email codeigniter

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.telkom.co.id',
            'smtp_port' => 465,
            'smtp_user' => 'dimas.saputra@telkom.co.id',//alamat email gmail
            'smtp_pass' => rtrim($this->decrypt()),//password email
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );

        $confirmationLink = base_url().'Confirmation/confirmation_response';

        $message = 'test';

        $message = '<<!DOCTYPE html>';
        $message .= '<html>';
        $message .= '<head>';
        $message .=  '<title></title>';
        $message .= '</head>';
        $message .= '<body>';
        $message .= 'Semangat Pagi!! Salam Telkom Group <br/><br/>';
        $message .= 'Sebelumnya perkenalkan, kami dari salah satu tim <b>Hack Idea 5, AMA Batavia</b> saat ini sedang mencoba mengembangkan platform anayltic untuk mendeteksi akun yang terindikasi melakukan sharing account. Berdasarkan hasil analytic dari platform kami, akun Bapak/Ibu atau Saudara/i, yaitu <b>'. $userid .'</b> pada aplikasi <b>' . $application. '</b> terindikasi melakukan aktivitas <b>Sharing Account</b> pada tanggal <b>'. $attempdate .'</b>.<br/><br/>';
        $message .= 'Berdasarkan hal tersebut, sebagai bahan kami mengevaluasi platform analytic tersebut, mohon melakukan konfirmasi pada link berikut (<b>menggunakan intranet</b>) : <br/><br/>';

        $message .= '<a href = '.$confirmationLink.'?shared_account_history_id='.$shared_account_history_id.'&is_shared_confirmation=YES&action_confirmation=SUSPEND><b>Iya benar, account saya merupakan sharing account, sebaiknya di-suspend dulu</b></a>. <br/><br/>';
        $message .= '<a href = '.$confirmationLink.'?shared_account_history_id='.$shared_account_history_id.'&is_shared_confirmation=YES&action_confirmation=CHANGE_PASSWORD><b>Iya benar, account saya merupakan sharing account, sebaiknya ganti password</b></a>. <br/><br/>';
        $message .= '<a href = '.$confirmationLink.'?shared_account_history_id='.$shared_account_history_id.'&is_shared_confirmation=YES&action_confirmation=DO_NOTHING><b>Iya benar, account saya merupakan sharing account, biarkan saja</b></a>. <br/><br/>';
        $message .= '<a href = '.$confirmationLink.'?shared_account_history_id='.$shared_account_history_id.'&is_shared_confirmation=UNKNOWN&action_confirmation=DO_NOTHING><b>Tidak tahu, sementara biarkan saja</b></a>. <br/><br/>';
        $message .= '<a href = '.$confirmationLink.'?shared_account_history_id='.$shared_account_history_id.'&is_shared_confirmation=NO&action_confirmation=DO_NOTHING><b>Tidak, account saya bukan merupakan sharing account</b></a>. <br/><br/>';
        // $message .= '<b>Link Konfirmasi akan disediakan di sini</b>. <br/><br/>';
        $message .= 'Konfirmasi ini bersifat sebagai masukan saja buat kami dan tidak mempengaruhi status akun Bapak/Ibu atau Saudara/i pada aplikasi terkait. Jika ada pertanyaan lebih lanjut, bisa menbalas kembali email ini atau bisa hubungi ke CP: <b>081334054027 (Nur Mei - 940136@telkom.co.id)</b>. <br/br/>';
        $message .= '<b> *Pesan ini di-generate otomatis secara system</b><br/><br/>';
        $message .= 'Atas perhatiannya kami ucapkan terima kasih. <br/><br/>';
        $message .= 'Telkom Group : <b>Solid Speed Smart !! </b>';

        $message .= '</body>';
        $message .= '</html>';//ini adalah isi/body email

        $email   = $userid.'@telkom.co.id';//email penerima

        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($config['smtp_user']);
        $this->email->to($email);
        $this->email->subject('[Info Admin Aplikasi '. $application.'] Validasi User Account '. $userid);//subjek email
        $this->email->message($message);
        
        //proses kirim email
        if($this->email->send()){
          $result = $this->SharedAccountHistory_model->update_status_confirmation_shared_account_history_by_id($shared_account_history_id, 'SENT');
          echo json_encode('kirim email berhasil ' + $result);
        }
        else{
          $result = $this->SharedAccountHistory_model->update_status_confirmation_shared_account_history_by_id($shared_account_history_id, 'FAILED');
          echo json_encode('kirim email gagal ' + $result);
        }
  }
  
  function decrypt(){
    $output = '';

    $string = 'c0924fbd90a2dbb4d3f49984a3198488035099d840f23582fd3aedc072caed149bceaac9b10f7c15885f7adffdaa2f55fa3729baa376d3145292caad73c38f32WELyLtizxYo8160A7OvIBjyh+kXsEL5veaIvzBaiVck=';

    $action = 'decrypt';

    $this->encryption->initialize(
            array(
                    'cipher' => 'aes-256',
                    'mode' => 'cbc',
                    'key' => '@724!##s0vya'
            )
    );

    if ($action == 'encrypt') {
           $output = $this->encryption->encrypt($msg);
    } else {
        if ($action == 'decrypt') {
           $output = $this->encryption->decrypt($string);
        }
    }
    return $output;
  }

  function get_data_shared_account_history(){

        $list = $this->SharedAccountHistory_model->get_shared_account_history_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = '<input class="checkbox-grid" style="width:30px; height:30px;" type="checkbox" id="checkbox-'. $field->USERID. '-'.$field->ATTEMPTDATE.'" name="checkbox-'. $field->USERID . '-'.$field->ATTEMPTDATE.'" value={"userid":"'. $field->USERID. '","attempdate":"'. $field->ATTEMPTDATE. '","application":"'. $field->APPLICATION. '","shared_account_history_id":"'. $field->SHARED_ACCOUNT_HISTORY_ID. '"}>';
            $row[] = $no;
            $row[] = $field->USERID;
            $row[] = $field->APPLICATION;
            $row[] = $field->ATTEMPTDATE;

            $row[] = '<a href="#" class="btn btn-sm btn-primary">'.$field->STATUS_CONFIRMATION .'</a>';       

            $row[] = $field->DESCRIPTION;
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->SharedAccountHistory_model->count_all(),
            "recordsFiltered" => $this->SharedAccountHistory_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
  }


  function get_data_shared_account_history_failed(){

        $list = $this->SharedAccountHistory_model->get_shared_account_history_datatables_failed();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = '<input class="checkbox-grid" style="width:30px; height:30px;" type="checkbox" id="checkbox-'. $field->USERID. '-'.$field->ATTEMPTDATE.'" name="checkbox-'. $field->USERID . '-'.$field->ATTEMPTDATE.'" value={"userid":"'. $field->USERID. '","attempdate":"'. $field->ATTEMPTDATE. '","application":"'. $field->APPLICATION. '","shared_account_history_id":"'. $field->SHARED_ACCOUNT_HISTORY_ID. '"}>';
            $row[] = $no;
            $row[] = $field->USERID;
            $row[] = $field->APPLICATION;
            $row[] = $field->ATTEMPTDATE;

            $row[] = '<a href="#" class="btn btn-sm btn-danger">'.$field->STATUS_CONFIRMATION .'</a>';       
              
            $row[] = $field->DESCRIPTION;

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->SharedAccountHistory_model->count_all_failed(),
            "recordsFiltered" => $this->SharedAccountHistory_model->count_filtered_failed(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
  }


  function get_data_shared_account_history_sent(){

        $list = $this->SharedAccountHistory_model->get_shared_account_history_datatables_sent();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = '<input class="checkbox-grid" style="width:30px; height:30px;" type="checkbox" id="checkbox-'. $field->USERID. '-'.$field->ATTEMPTDATE.'" name="checkbox-'. $field->USERID . '-'.$field->ATTEMPTDATE.'" value={"userid":"'. $field->USERID. '","attempdate":"'. $field->ATTEMPTDATE. '","application":"'. $field->APPLICATION. '","shared_account_history_id":"'. $field->SHARED_ACCOUNT_HISTORY_ID. '"}>';
            $row[] = $no;
            $row[] = $field->USERID;
            $row[] = $field->APPLICATION;
            $row[] = $field->ATTEMPTDATE;
            $row[] = '<a href="#" class="btn btn-sm btn-primary">'.$field->STATUS_CONFIRMATION .'</a>';       
            
            $row[] = $field->DESCRIPTION;
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->SharedAccountHistory_model->count_all_sent(),
            "recordsFiltered" => $this->SharedAccountHistory_model->count_filtered_sent(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
  }


  function get_data_shared_account_history_action(){

        $list = $this->SharedAccountHistory_model->get_shared_account_history_datatables_action();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = '<input class="checkbox-grid" style="width:30px; height:30px;" type="checkbox" id="checkbox-'. $field->USERID. '-'.$field->ATTEMPTDATE.'" name="checkbox-'. $field->USERID . '-'.$field->ATTEMPTDATE.'" value={"userid":"'. $field->USERID. '","attempdate":"'. $field->ATTEMPTDATE. '","application":"'. $field->APPLICATION. '","shared_account_history_id":"'. $field->SHARED_ACCOUNT_HISTORY_ID. '"}>';
            $row[] = $no;
            $row[] = $field->USERID;
            $row[] = $field->APPLICATION;
            $row[] = $field->ATTEMPTDATE;
            $row[] = '<a href="#" class="btn btn-sm btn-success">'.$field->STATUS_CONFIRMATION .'</a>';       
            $row[] = $field->DESCRIPTION;
            $row[] = $field->ACTION_CONFIRMATION;
            $row[] = $field->IS_SHARED_CONFIRMATION;

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->SharedAccountHistory_model->count_all_action(),
            "recordsFiltered" => $this->SharedAccountHistory_model->count_filtered_action(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
  }

  function get_data_shared_account_history_top(){

        $list = $this->SharedAccountHistory_model->get_shared_account_history_datatables_top();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = '';
            $row[] = $no;
            $row[] = $field->USERID;
            $row[] = $field->APPLICATION;
            $row[] = $field->TOTAL_HISTORY;
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->SharedAccountHistory_model->count_all_top(),
            "recordsFiltered" => $this->SharedAccountHistory_model->count_filtered_top(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
  }

  function get_data_shared_account_history_top_all(){

        $list = $this->SharedAccountHistory_model->get_shared_account_history_datatables_top_all();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = '';
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

  public function postCURL($_url, $_param){

        $postData = '';
        //create name value pairs seperated by &
        foreach($_param as $k => $v) 
        { 
          $postData .= $k . '='.$v.'&'; 
        }
        rtrim($postData, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, false); 
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CAINFO, base_url()."certificate/test.crt");

        $output=curl_exec($ch);

        curl_close($ch);

        return $output;
    }
}