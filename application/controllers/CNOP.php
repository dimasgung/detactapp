<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CNOP extends CI_Controller {
  private $filename = "import_data"; // Kita tentukan nama filenya
  
  public function __construct(){
    parent::__construct();
    
    $this->load->model('CNOP_model');
  }
  
  public function index(){

    // view versi 1
    // $data['mobile_site'] = $this->CNOP_model->view();
    // $this->load->view('migrasi_cnop/mobile_site_migration_view', $data);

    // view versi 2 - datatables

    $data_sidebar['menu_active'] = 'CNOP';
    $data_sidebar['sub_menu_active'] = 'Mobile Site Data Migration';

    $data['total_data'] = $this->CNOP_model->count_all();

    $this->load->view('template/navbar_view');
    $this->load->view('template/sidebar_view', $data_sidebar);
    $this->load->view('migrasi_cnop/mobile_site_migration_view', $data);
    $this->load->view('template/footer_view');
  }

    public function processed(){

    // view versi 1
    // $data['mobile_site'] = $this->CNOP_model->view();
    // $this->load->view('migrasi_cnop/mobile_site_migration_view', $data);

    // view versi 2 - datatables
    $data_sidebar['menu_active'] = 'CNOP';
    $data_sidebar['sub_menu_active'] = 'Mobile Site Data Migration Processed';


    $data['total_data'] = $this->CNOP_model->count_all_processed();

    $this->load->view('template/navbar_view');
    $this->load->view('template/sidebar_view', $data_sidebar);
    $this->load->view('migrasi_cnop/mobile_site_migration_processed_view', $data);
    $this->load->view('template/footer_view');
  }


  function create_location_osp_uimax(){

        $site_id=$this->input->post('site_id');

        $mobile_site = $this->CNOP_model->get_mobile_site($site_id);

        $params= array(
                   "name" => $mobile_site['SITE_ID'].'@'.$mobile_site['CUSTOMER'],
                   "type" => $mobile_site['TYPE'],
                   "owner" => $mobile_site['CUSTOMER'],
                   "building_name" => $mobile_site['SITE_NAME'],
                   "area_code" => '',
                   "region_code" => $mobile_site['REGIONAL'],
                   "short_code" => $mobile_site['SITE_ID'],
                   "is_node" => 'Y',
                   "legacy_id" => $mobile_site['SITE_ID'],
                   "details" => $mobile_site['ADDRESS'],
                   "status" => 'ACTIVE',
                   "geometry" => 'POINT('. $mobile_site['LONGITUDE']. ' '. $mobile_site['LATITUDE']. ')'
                );
        $url = 'https://appdev-oss:9093/api/location/create';

        $responseOrigin = $this->postCURL($url, $params);

        $response = $responseOrigin;

        $obj = json_decode($response);

        // echo $dump = var_dump($obj);

        if(isset($obj->{'status'})){
            $status = "FAILED";
        } else if(isset($obj->{'low'})){
            $status = "SUCCESS";          
        } else {
            $status = "FAILED";
        }

        $final_response = json_encode($response);

        $mobile_site = $this->CNOP_model->update_mobile_site_by_api_response($mobile_site['SITE_ID'],$status,$final_response);

        echo $final_response;
  }
  
  function get_data_mobile_site()
  {
        $list = $this->CNOP_model->get_mobile_site_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = '<input class="checkbox-grid" style="width:30px; height:30px;" type="checkbox" id="checkbox'. $field->SITE_ID. '" name="checkbox-'. $field->SITE_ID . '" value="'. $field->SITE_ID. '">';
            $row[] = $no;
            $row[] = $field->NAME_OSP;


            if($field->STATUS == 'SUCCESS'){
              $row[] = '<a href="#" class="btn btn-sm btn-success">'.$field->STATUS .'</a>';       
            } else {
              $row[] = '<a href="#" class="btn btn-sm btn-primary">'.$field->STATUS .'</a>';       
            }            

            $row[] = $field->SITE_ID;
            $row[] = $field->SITE_NAME;
            $row[] = $field->ADDRESS;
            $row[] = $field->REGIONAL;
            $row[] = $field->WITEL;
            $row[] = $field->STO;
            $row[] = $field->RESPONSE;
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->CNOP_model->count_all(),
            "recordsFiltered" => $this->CNOP_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
  }

    function get_data_mobile_site_processed()
  {
        $list = $this->CNOP_model->get_mobile_site_datatables_processed();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = '<input class="checkbox-grid" style="width:30px; height:30px;" type="checkbox" id="checkbox'. $field->SITE_ID. '" name="checkbox-'. $field->SITE_ID . '" value="'. $field->SITE_ID. '">';
            $row[] = $no;
            $row[] = $field->NAME_OSP;


            if($field->STATUS == 'SUCCESS'){
              $row[] = '<a href="#" class="btn btn-sm btn-success">'.$field->STATUS .'</a>';       
            } else if($field->STATUS == 'OPEN'){
              $row[] = '<a href="#" class="btn btn-sm btn-primary">'.$field->STATUS .'</a>';       
            } else {
              $row[] = '<a href="#" class="btn btn-sm btn-danger">'.$field->STATUS .'</a>';   
            }

            $row[] = $field->SITE_ID;
            $row[] = $field->SITE_NAME;
            $row[] = $field->ADDRESS;
            $row[] = $field->LATITUDE;
            $row[] = $field->LONGITUDE;
            $row[] = $field->REGIONAL;
            $row[] = $field->WITEL;
            $row[] = $field->STO;
            $row[] = $field->RESPONSE;
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->CNOP_model->count_all_processed(),
            "recordsFiltered" => $this->CNOP_model->count_filtered_processed(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
  }

  public function form(){
    $data = array(); // Buat variabel $data sebagai array
    
    if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
      // lakukan upload file dengan memanggil function upload yang ada di CNOP_model.php
      $upload = $this->CNOP_model->upload_file($this->filename);
      
      if($upload['result'] == "success"){ // Jika proses upload sukses
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        $csvreader = PHPExcel_IOFactory::createReader('CSV');
        $loadcsv = $csvreader->load('csv/'.$this->filename.'.csv'); // Load file yang tadi diupload ke folder csv
        $sheet = $loadcsv->getActiveSheet()->getRowIterator();
        
        // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
        // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam csv yang sudha di upload sebelumnya
        $data['sheet'] = $sheet; 
      }else{ // Jika proses upload gagal
        $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
      }
    }
    
    $this->load->view('migrasi_cnop/mobile_site_migration_form', $data);
  }
  
  public function import(){
    // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    
    $csvreader = PHPExcel_IOFactory::createReader('CSV');
    $loadcsv = $csvreader->load('csv/'.$this->filename.'.csv'); // Load file yang tadi diupload ke folder csv
    $sheet = $loadcsv->getActiveSheet()->getRowIterator();
    
    // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
    $data = array();
    
    $numrow = 1;
    foreach($sheet as $row){
      // Cek $numrow apakah lebih dari 1
      // Artinya karena baris pertama adalah nama-nama kolom
      // Jadi dilewat saja, tidak usah diimport
      if($numrow > 1){
        // START -->
        // Skrip untuk mengambil value nya
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
        
        $get = array(); // Valuenya akan di simpan kedalam array,dimulai dari index ke 0
        foreach ($cellIterator as $cell) {
          array_push($get, $cell->getValue()); // Menambahkan value ke variabel array $get
        }
        // <-- END
        
        // Ambil data value yang telah di ambil dan dimasukkan ke variabel $get
        $type 			= $get[0]; // Ambil data NIS dari kolom A di csv
        $customer 		= $get[1]; // Ambil data nama dari kolom B di csv
        $site_id 		= $get[2]; // Ambil data jenis kelamin dari kolom C di csv
        $site_name 		= $get[3]; // Ambil data alamat dari kolom D di csv
        $longitude 		= $get[4];
        $latitude 		= $get[5];
        $address 		= $get[6];
        $master_site_id = $get[7];
        $site_type 		= $get[8];
        $regional 		= $get[9];
        $witel 			= $get[10];
        $sto 			= $get[11];
        

        // Kita push (add) array data ke variabel data
        array_push($data, array(
          'TYPE'=>$type, // Insert data nis
          'CUSTOMER'=>$customer, // Insert data nama
          'SITE_ID'=>$site_id, // Insert data jenis kelamin
          'SITE_NAME'=>$site_name, // Insert data alamat
          'LONGITUDE'=>$longitude, // Insert data alamat
          'LATITUDE'=>$latitude, // Insert data alamat
          'ADDRESS'=>$address, // Insert data alamat
          'MASTER_SITE_ID'=>$master_site_id, // Insert data alamat
          'SITE_TYPE'=>$site_type, // Insert data alamat
          'REGIONAL'=>$regional, // Insert data alamat
          'WITEL'=>$witel, // Insert data alamat
          'STO'=>$sto, // Insert data alamat
          'STATUS'=>'SUCCESS', // Insert data alamat
          'NAME_OSP'=>$site_id.'@'.$customer, // Insert data alamat
        ));
      }
      
      // $this->CNOP_model->insert($data);

      $numrow++; // Tambah 1 setiap kali looping
    }
    // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
    $this->CNOP_model->insert_multiple($data);
    
    redirect("CNOP"); // Redirect ke halaman awal (ke controller CNOP fungsi index)
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