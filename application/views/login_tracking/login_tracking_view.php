<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Login Tracking Data</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>Dashboard">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Login Tracking</a></li>
              <li class="breadcrumb-item active">Login Tracking Data</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
       <div class="container-fluid">
        <div class="row">

          <div class="col-6">
              <div class="card col-6">
                  <!-- <form action="<?php echo base_url();?>LoginTracking/analyticProcessing" method="post"> -->
                  <!-- select -->
                    <div class="form-group">
                        <label>Tanggal Login</label>
                        <select class="form-control" name='processed_attempt_date' id='processed_attempt_date'>
                          <?php 
                            $i = 0;
                            foreach ($option_date as $option_date_item): ?>
                            <option value='<?php echo ($option_date_item['attemptdate']) ?>'><?php echo ($option_date_item['attemptdate']) ?></option>
                          <?php 
                              $i++;
                              endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Aplikasi</label>
                        <select class="form-control" name='application' id='processed_application'>
                            <option value='NOSSA'>NOSSA</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-sm btn-success" id='processing-analytic'>Processing Sharing Account Analytics</button>
                    </div>
                  <!-- </form> -->
              </div>
          </div>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Login Tracking Data</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Attempt Date</th>
                            <th>Attempt Result</th>
                            <th>Name</th>
                            <th>User ID</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
         
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Attempt Date</th>
                            <th>Attempt Result</th>
                            <th>Name</th>
                            <th>User ID</th>
                        </tr>
                    </tfoot>
                </table>

              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
   <!--MODAL Create-->
  <div class="modal fade" id="modal-processing-analytic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Do Sharing Account Analytic</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
              </div>
              <form class="form-horizontal">
              <div class="modal-body">
                                     
                      <div class="alert alert-primary"><p>Apakah Anda yakin untuk melakukan proses sharing account analytic (saat ini berlaku untuk data H-1 pada tanggal saat ini)?</p></div>
                                   
              </div>
              <div class="modal-footer">
                  <input type="button" class="btn btn-default" data-dismiss="modal" value="Tutup">
                  <input class="btn-processing-analytic btn btn-primary" id="btn-processing-analytic" value="Do Sharing Account Analytic">
              </div>
              </form>
          </div>
      </div>
  </div>

    <!--MODAL Create-->
  <div class="modal fade" id="loading-processing-analytic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Processing Analytic Data</h4>
              </div>
              <form class="form-horizontal">
              <div class="modal-body">
                                     
                      <div class="alert alert-success" id="loading-text-modal"><p>Sedang memproses data analytic. Harap Tunggu </p></div>
                                   
              </div>
              <div class="modal-footer"  id="result-text-modal">
              </div>
              </form>
          </div>
      </div>
  </div>
<script src="<?php echo base_url();?>assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    var table;
    $(document).ready(function() {

        var attemptdate = $('#processed_attempt_date').val();

        tampil_table();
 
        $('#processed_attempt_date').on('change', function() {
            $('#table').dataTable().fnDestroy();
            attemptdate = $('#processed_attempt_date').val();
            tampil_table();
        });


        function tampil_table(){

            //datatables
            table = $('#table').DataTable({ 
     
                "processing": true, 
                "serverSide": true, 
                "order": [], 
                 
                "ajax": {
                    "url": "<?php echo site_url('LoginTracking/get_data_logintracking')?>",
                    "type": "POST",
                    "data":{attemptdate: attemptdate},
                },
     
                 
                "columnDefs": [
                { 
                    "targets": [ 0 ], 
                    "orderable": false, 
                },
                ],
     
            });
        }
 

      $('#processing-analytic').click(function(){
            $('#modal-processing-analytic').modal('show');
      });


      $('#btn-processing-analytic').click(function(){
          running_processing_analytic();
      });

      function get_day_min_1(){
          today = new Date();
          var dd = today.getDate()-1;
          var mm = today.getMonth()+1; //As January is 0.
          var yyyy = today.getFullYear();

          if(dd<10) dd='0'+dd;
          if(mm<10) mm='0'+mm;

          return yyyy + '-' + mm + '-' + dd;
      }

      function running_processing_analytic(){

          $('#loading-processing-analytic').modal('show');

          // jika bisa pilih
          //attemptdate = $('#processed_attempt_date').val();

          // default h-1
          var attemptdate = get_day_min_1();
          var application = $('#processed_application').val();

          var request = $.ajax(  {
              type : "POST",
              url  : "<?php echo base_url('LoginTracking/do_sharing_account_analytic')?>",
              //dataType : "JSON",,
              data : {attemptdate:attemptdate, application:application},
              success: function(data){
                alert(data)

                finish_modal();
              },
              error: function(data){
                alert("get data gagal : " + data);

                finish_modal();
              }
          });

          // var inputs = $('.checkbox-grid:checked');
          // var totalProses = $('.checkbox-grid:checked').length;
          // var jumlahProsesSukses = 0;
          // var jumlahProsesFailed = 0;
          // var promises = [];

          // var tempValue = '';
          // var userid = '';
          // var attempdate = '';

          // for(var i = 0, l = inputs.length; i < l; ++i) {

          //   tempValue = JSON.parse(inputs[i].value);

          //   shared_account_history_id = tempValue['shared_account_history_id'];
          //   userid = tempValue['userid'];
          //   attempdate = tempValue['attempdate'];
          //   application = tempValue['application'];

          //   // alert(userid + ' '+ attempdate);

          //   var request = $.ajax(  {
          //       type : "POST",
          //       url  : "<?php echo base_url('SharedAccountHistory/send_email_confirmation')?>",
          //       dataType : "JSON",
          //       data : {userid: userid, attempdate:attempdate, application:application, shared_account_history_id:shared_account_history_id},
          //       success: function(data){
          //         // alert("sukses " + data);
          //         jumlahProsesSukses++;
          //         $('#loading-text-modal').html("Harap Tunggu. Telah mengirim email konfirmasi sebanyak " + jumlahProsesSukses + " dari " + totalProses + ". Jangan di refresh.</br> Jika proses berhenti silahkan di refresh." );

          //         if(jumlahProsesSukses + jumlahProsesFailed == totalProses ){
          //           $('#result-text-modal').html('<input type="button" class="btn btn-default" data-dismiss="modal" value="Tutup">');
          //           finish_modal();
          //         }

          //       },
          //       error: function(data){
          //         // alert("gagal " +data);
          //         jumlahProsesFailed++;
          //         $('#loading-text-modal-error').html("Error / Intermitten sebanyak : " + jumlahProsesFailed);

          //         if(jumlahProsesSukses + jumlahProsesFailed == totalProses ){
          //           $('#result-text-modal').html('<input type="button" class="btn btn-default" data-dismiss="modal" value="Tutup">');
          //           finish_modal();
          //         }

          //       }
          //   });

          //   promises.push(request);
            
          // }
  
          // $.when.apply(null, promises).done(function() {

            // alert('Pengiriman email selesai di proses');

          // })
      }

      function finish_modal(){
        // alert('Analisis Sharing Account selesai dilakukan');
        $('#loading-processing-analytic').modal('hide');
        $('#modal-processing-analytic').modal('hide');
        location.reload();
      }
    });
 
</script>
