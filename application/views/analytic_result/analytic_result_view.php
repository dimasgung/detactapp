<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Shared Account Analytic Result</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>Dashboard">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Analytic Result</a></li>
              <li class="breadcrumb-item active">Shared Account</li>
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
                  <!-- select -->
                    <div class="form-group">
                        <label>Tanggal Proses</label>
                        <select class="form-control" name='processed_attempt_date' id='processed_attempt_date'>
                          <?php 
                            $i = 0;
                            foreach ($option_date as $option_date_item): ?>
                            <option value='<?php echo ($option_date_item['attemptdate']) ?>'><?php echo ($option_date_item['attemptdate']) ?></option>
                          <?php 
                              $i++;
                              endforeach; ?>
                            <option value='ALL'>ALL</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Aplikasi</label>
                        <select class="form-control" name='application' id='application'>
                            <option value='NOSSA'>NOSSA</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-sm btn-primary" id='follow-up-account'>Submit Shared Account to Follow Up</button>
                    </div>
              </div>
          </div>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Analytic Result</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Attempt Date</th>
                            <th>Aplikasi</th>
                            <th>User ID</th>
                            <th>Prediction</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
         
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Attempt Date</th>
                            <th>Aplikasi</th>
                            <th>User ID</th>
                            <th>Prediction</th>
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
  <div class="modal fade" id="modal-follow-up-account" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Follow Up Detected Shared Account</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
              </div>
              <form class="form-horizontal">
              <div class="modal-body">
                                     
                      <div class="alert alert-primary"><p>Apakah Anda yakin mau mem-follow up akun? </p></div>
                                   
              </div>
              <div class="modal-footer">
                  <input type="button" class="btn btn-default" data-dismiss="modal" value="Tutup">
                  <input class="btn_create_all btn btn-primary" id="btn-follow-up" value="Submit">
              </div>
              </form>
          </div>
      </div>
  </div>

  <!--MODAL Create-->
  <div class="modal fade" id="loading-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Submitting Data</h4>
              </div>
              <form class="form-horizontal">
              <div class="modal-body">
                                     
                    <div class="alert alert-success" id="loading-text-modal"><p>Harap Tunggu</p></div>
                                   
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
 
        //datatables
      table = $('#table').DataTable({ 
 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
             
            "ajax": {
                "url": "<?php echo site_url('AnalyticResult/get_data_analytic_result')?>",
                "type": "POST",
            },
 
             
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
 
      });
 
      $('#follow-up-account').click(function(){
            $('#modal-follow-up-account').modal('show');
      });

      $('#btn-follow-up').click(function(){
          running_process_followup();
      });

      function running_process_followup(){

          $('#loading-submit').modal('show');

          var processed_attempt_date = $('#processed_attempt_date').val();
          var application = $('#application').val();

          // console.log(processed_attempt_date);

          if(processed_attempt_date == 'ALL')processed_attempt_date = null;

          var promises = [];

          var request = $.ajax( {
                type : "POST",
                url  : "<?php echo base_url('AnalyticResult/submitSharedAccountData')?>",
                // dataType : "JSON",
                data : {processed_attempt_date: processed_attempt_date,
                        application:application},
                success: function(data){
                  alert('submit data berhasil ' + data);
                },
                error: function(data){
                  alert('submit data gagal ' + data);
                  finish_modal();
                }
          });
          
          promises.push(request);
  
          $.when.apply(null, promises).done(function() {
            
             finish_modal();

          })


      }

      function finish_modal(){
        // alert('Data selesai di proses');
        $('#loading-submit').modal('hide');
        $('#modal-follow-up-account').modal('hide');
        location.reload();
      }
    });
 
</script>
