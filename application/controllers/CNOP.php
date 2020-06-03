<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CNOP extends CI_Controller {

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

    	$this->load->model('CNOP_model');
        $this->load->library(array('form_validation','ion_auth'));

    	if (!$this->ion_auth->logged_in()) {//cek login ga?
    		redirect('Auth/login','refresh');
    	}else{
            if (!$this->ion_auth->in_group('admin')) {//cek admin ga?
                redirect('Auth/login','refresh');
            }
        }
	}

	public function index()
	{
		// Action form.
		$data['action'] = site_url('CNOP/process');

		$this->load->view('migrasi_cnop/mobile_site_migration_view', $data);
	}

	/**
	 * Memproses data yang diimport.
	 *
	 */
	public function process()
	{
		if ( isset($_POST['import'])) {

            $file = $_FILES['mobile_site']['tmp_name'];

			// Medapatkan ekstensi file csv yang akan diimport.
			$ekstensi  = explode('.', $_FILES['mobile_site']['name']);

			// Tampilkan peringatan jika submit tanpa memilih menambahkan file.
			if (empty($file)) {
				echo $_FILES['mobile_site']['tmp_name'].'test';
				echo 'File tidak boleh kosong!';
			} else {
				// Validasi apakah file yang diupload benar-benar file csv.
				if (strtolower(end($ekstensi)) === 'csv' && $_FILES["mobile_site"]["size"] > 0) {

					$i = 0;
					$handle = fopen($file, "r");
					while (($row = fgetcsv($handle, 2048))) {
						$i++;
						if ($i == 1) continue;
						
						echo $row[1];

						// Data yang akan disimpan ke dalam databse
						// $data = [
						// 	'nama' => $row[1],
						// 	'no_hp' => $row[2],
						// 	'email' => $row[3],
						// 	'alamat' => $row[4],
						// ];

						// Simpan data ke database.
						// $this->pelanggan->save($data);
					}

					fclose($handle);
					// redirect('data');

				} else {
					echo 'Format file tidak valid!';
				}
			}
        }
	}
}
