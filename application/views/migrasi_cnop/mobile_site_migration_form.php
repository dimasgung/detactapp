<html>
<head>
  <title>Form Import</title>
  <!-- Load File jquery.min.js yang ada difolder js -->
  <script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
  <script>
  $(document).ready(function(){
    // Sembunyikan alert validasi kosong
    $("#kosong").hide();
  });
  </script>
</head>
<body>
  <h3>Form Import</h3>
  <hr>
  <a href="<?php echo base_url("csv/format.csv"); ?>">Download Format</a>
  <br>
  <br>
  <!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
  <form method="post" action="<?php echo base_url("CNOP/form"); ?>" enctype="multipart/form-data">
    <!--
    -- Buat sebuah input type file
    -- class pull-left berfungsi agar file input berada di sebelah kiri
    -->
    <input type="file" name="file">
    <!--
    -- BUat sebuah tombol submit untuk melakukan preview terlebih dahulu data yang akan di import
    -->
    <input type="submit" name="preview" value="Preview">
  </form>
  <?php
  if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
    if(isset($upload_error)){ // Jika proses upload gagal
      echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
      die; // stop skrip
    }
    // Buat sebuah tag form untuk proses import data ke database
    echo "<form method='post' action='".base_url("CNOP/import")."'>";
    // Buat sebuah div untuk alert validasi kosong
    // echo "<div style='color: red;' id='kosong'>
    // Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum terisi semua.
    // </div>";
    echo "<table border='1' cellpadding='8'>
    <tr>
      <th colspan='15'>Preview Data</th>
    </tr>
    <tr>
      <th>NO</th>
      <th>OSP NAME</th>
      <th>TYPE</th>
      <th>CUSTOMER</th>
      <th>SITE_ID</th>
      <th>SITE_NAME</th>
      <th>LONGITUDE</th>
      <th>LATITUDE</th>
      <th>ADDRESS</th>
      <th>MASTER_SITE_ID</th>
      <th>SITE_TYPE</th>
      <th>REGIONAL</th>
      <th>WITEL</th>
      <th>STO</th>
      <th>STATUS</th>
    </tr>";
    $numrow = 0;
    $kosong = 0;
    // Lakukan perulangan dari data yang ada di csv
    // $sheet adalah variabel yang dikirim dari controller
    foreach($sheet as $row){
      $numrow++; // Tambah 1 setiap kali looping
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
      $NO               = $numrow-1; // Ambil data NIS
      $TYPE             = $get[0]; // Ambil data NIS
      $CUSTOMER         = $get[1]; // Ambil data nama
      $SITE_ID          = $get[2]; // Ambil data jenis kelamin
      $SITE_NAME        = $get[3]; // Ambil data alamat
      $LONGITUDE        = $get[4]; // Ambil data alamat
      $LATITUDE         = $get[5]; // Ambil data alamat
      $ADDRESS          = $get[6]; // Ambil data alamat
      $MASTER_SITE_ID   = $get[7]; // Ambil data alamat
      $SITE_TYPE        = $get[8]; // Ambil data alamat
      $REGIONAL         = $get[9]; // Ambil data alamat
      $WITEL            = $get[10]; // Ambil data alamat
      $STO              = $get[11]; // Ambil data alamat
      // Cek jika semua data tidak diisi
      // if($nis == "" && $nama == "" && $jenis_kelamin == "" && $alamat == "")
      //   continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
      // Cek $numrow apakah lebih dari 1
      // Artinya karena baris pertama adalah nama-nama kolom
      // Jadi dilewat saja, tidak usah diimport
      if($numrow > 1){

        // Call OSP Location 

        // $_params= array(
        //            "name" => $SITE_ID.'@'.$CUSTOMER,
        //            "type" => $TYPE,
        //            "owner" => $CUSTOMER,
        //            "building_name" => $SITE_NAME,
        //            "area_code" => '',
        //            "region_code" => $REGIONAL,
        //            "short_code" => $SITE_ID,
        //            "is_node" => 'Y',
        //            "legacy_id" => $SITE_ID,
        //            "details" => $ADDRESS,
        //            "status" => 'ACTIVE',
        //            "geometry" => 'POINT('. $LATITUDE. ' '. $LONGITUDE. ')'
        //         );

        // $_url = 'https://appdev-oss:9093/api/location/create';

        // $postData = '';
        // //create name value pairs seperated by &
        // foreach($_params as $k => $v) 
        // { 
        //   $postData .= $k . '='.$v.'&'; 
        // }
        // rtrim($postData, '&');

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL,$_url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // curl_setopt($ch, CURLOPT_HEADER, false); 
        // curl_setopt($ch, CURLOPT_POST, count($postData));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_CAINFO, base_url()."certificate/test.crt");

        // $output=curl_exec($ch);

        // curl_close($ch);

        // if($output){
        //     $status = "SUCCESS";
        // } else {
        //     $status = "FAILED";          
        // }


        // Validasi apakah semua data telah diisi
        // $nis_td = ($nis == "")? " style='background: #E07171;'" : ""; // Jika NIS kosong, beri warna merah
        // $nama_td = ($nama == "")? " style='background: #E07171;'" : ""; // Jika Nama kosong, beri warna merah
        // $jk_td = ($jenis_kelamin == "")? " style='background: #E07171;'" : ""; // Jika Jenis Kelamin kosong, beri warna merah
        // $alamat_td = ($alamat == "")? " style='background: #E07171;'" : ""; // Jika Alamat kosong, beri warna merah
        // // Jika salah satu data ada yang kosong
        // if($nis == "" or $nama == "" or $jenis_kelamin == "" or $alamat == ""){
        //   $kosong++; // Tambah 1 variabel $kosong
        // }

        echo "<tr>";
        echo "<td>".$NO."</td>";
        echo "<td>".$SITE_ID.'@'.$CUSTOMER."</td>";
        echo "<td>".$TYPE."</td>";
        echo "<td>".$CUSTOMER."</td>";
        echo "<td>".$SITE_ID."</td>";
        echo "<td>".$SITE_NAME."</td>";
        echo "<td>".$LONGITUDE."</td>";
        echo "<td>".$LATITUDE."</td>";
        echo "<td>".$ADDRESS."</td>";
        echo "<td>".$MASTER_SITE_ID."</td>";
        echo "<td>".$SITE_TYPE."</td>";
        echo "<td>".$REGIONAL."</td>";
        echo "<td>".$WITEL."</td>";
        echo "<td>".$STO."</td>";
        echo "<td>".'OPEN'."</td>";
        echo "</tr>";
      }
    }
    echo "</table>";
    // Cek apakah variabel kosong lebih dari 1
    // Jika lebih dari 1, berarti ada data yang masih kosong
    if($kosong > 1){
    ?>
      <script>
      $(document).ready(function(){
        // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
        $("#jumlah_kosong").html('<?php echo $kosong; ?>');
        $("#kosong").show(); // Munculkan alert validasi kosong
      });
      </script>
    <?php
    }else{ // Jika semua data sudah diisi
      echo "<hr>";
      // Buat sebuah tombol untuk mengimport data ke database
      echo "<button type='submit' name='import'>Import</button> ";
      echo "<a href='".base_url("CNOP")."'>Cancel</a>";
    }
    echo "</form>";
  }
  ?>
</body>
</html>