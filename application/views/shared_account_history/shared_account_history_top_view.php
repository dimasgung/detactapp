<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Shared Account History Top 25</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>Dashboard">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Shared Account History</a></li>
              <li class="breadcrumb-item active">Shared Account History Top 25</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
       <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <!-- <button type="button" class="btn btn-primary btn-sm" id='send-selected'>send email confirmation to selected data</button> -->
              <!-- <button type="button" class="btn btn-warning btn-sm" id='send-all-auto'>send email confirmation to all</button> -->
              <!-- <button type="button" class="btn btn-dark btn-sm" id='manual-confirmation'>manual confirmation</button> -->
              <!-- <button type="button" class="btn btn-danger btn-sm" id='delete-confirmation'>delete zero user-id</button> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Shared Account History Data Top 25</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-striped"  cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><input style="width:30px; height:30px;" type="checkbox" id="check-all" class="checkbox-all"> ALL</th>
                            <th>NO</th>
                            <th>USERID</th>
                            <th>APPLICATION</th>
                            <th>TOTAL HISTORY</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
         
                    <tfoot>
                        <tr>
                            <th>Select</th>
                            <th>NO</th>
                            <th>USERID</th>
                            <th>APPLICATION</th>
                            <th>TOTAL HISTORY</th>
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
  <div class="modal fade" id="modal-selected-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Kirim konfirmasi email</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
              </div>
              <form class="form-horizontal">
              <div class="modal-body">
                                     
                      <div class="alert alert-primary"><p>Apakah Anda yakin mengirim konfirmasi email dari data yang dipilih?</p></div>
                                   
              </div>
              <div class="modal-footer">
                  <input type="button" class="btn btn-default" data-dismiss="modal" value="Tutup">
                  <input class="btn-selected-data btn btn-primary" id="btn-selected-data" value="Send Email Confirmation">
              </div>
              </form>
          </div>
      </div>
  </div>
 
  <!--MODAL Create-->
  <div class="modal fade" id="loading-send-email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Loading Data</h4>
              </div>
              <form class="form-horizontal">
              <div class="modal-body">
                                     
                      <div class="alert alert-success" id="loading-text-modal"><p>Sukses : 0 </p></div>
                      <div class="alert alert-danger" id="loading-text-modal-error"><p>Error / Intermitten : 0</p></div>
                                   
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

    var renderedData;
    
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    var automate = urlParams.get('automate');  

    $(document).ready(function() {
 
        tampil_datatable();

        function tampil_datatable(){
          //datatables
          table = $('#table').DataTable({ 
   
              "processing": true, 
              "serverSide": true, 
              "order": [], 
              "ajax": {
                  "url": "<?php echo site_url('SharedAccountHistory/get_data_shared_account_history_top')?>",
                  "type": "POST",
                  "data": function (d) {
                      renderedData = d.length;
                  }
              },
              "lengthMenu": [10, 20, 50, 100],
               
              "columnDefs": [
              { 
                  "targets": [ 0 ], 
                  "orderable": false, 
              },
              ],
              "initComplete":function(d){
                   // auto process
                   if(d._iRecordsTotal > 0 && automate=='yes'){
                    check_all();
                    running_process_send_email();
                  }
              },
          });
        }

       $('#check-all').click(function(){
          var inputs  = document.getElementsByClassName("checkbox-grid");
          for(var i = 0, l = inputs.length; i < l; ++i) {

            if($(this).is(":checked")){
              inputs[i].checked = true;
            }else{
              inputs[i].checked = false;
           }

          }
        })

      $('#send-selected').click(function(){
            $('#modal-selected-data').modal('show');
      });

      $('#btn-selected-data').click(function(){
          running_process_send_email();
      });

      function finish_modal(){
        // alert('Pengiriman email selesai di proses');
        $('#loading-send-email').modal('hide');
        $('#modal-selected-data').modal('hide');
        location.reload();
      }

      function check_all(){
          
          var inputs  = document.getElementsByClassName("checkbox-grid");
          for(var i = 0, l = inputs.length; i < l; ++i) {
            inputs[i].checked = true;
          }
      }

      function running_process_send_email(){


          $('#loading-send-email').modal('show');

          var inputs = $('.checkbox-grid:checked');
          var totalProses = $('.checkbox-grid:checked').length;
          var jumlahProsesSukses = 0;
          var jumlahProsesFailed = 0;
          var promises = [];

          var tempValue = '';
          var userid = '';
          var attempdate = '';

          for(var i = 0, l = inputs.length; i < l; ++i) {

            tempValue = JSON.parse(inputs[i].value);

            shared_account_history_id = tempValue['shared_account_history_id'];
            userid = tempValue['userid'];
            attempdate = tempValue['attempdate'];
            application = tempValue['application'];

            // alert(userid + ' '+ attempdate);

            var request = $.ajax(  {
                type : "POST",
                url  : "<?php echo base_url('SharedAccountHistory/send_email_confirmation')?>",
                dataType : "JSON",
                data : {userid: userid, attempdate:attempdate, application:application, shared_account_history_id:shared_account_history_id},
                success: function(data){
                  // alert("sukses " + data);
                  jumlahProsesSukses++;
                  $('#loading-text-modal').html("Harap Tunggu. Telah mengirim email konfirmasi sebanyak " + jumlahProsesSukses + " dari " + totalProses + ". Jangan di refresh.</br> Jika proses berhenti silahkan di refresh." );

                  if(jumlahProsesSukses + jumlahProsesFailed == totalProses ){
                    $('#result-text-modal').html('<input type="button" class="btn btn-default" data-dismiss="modal" value="Tutup">');
                    finish_modal();
                  }

                },
                error: function(data){
                  // alert("gagal " +data);
                  jumlahProsesFailed++;
                  $('#loading-text-modal-error').html("Error / Intermitten sebanyak : " + jumlahProsesFailed);

                  if(jumlahProsesSukses + jumlahProsesFailed == totalProses ){
                    $('#result-text-modal').html('<input type="button" class="btn btn-default" data-dismiss="modal" value="Tutup">');
                    finish_modal();
                  }

                }
            });

            promises.push(request);
            
          }
  
          $.when.apply(null, promises).done(function() {

            alert('Pengiriman email selesai di proses');
            finish_modal();

          })
      }

      $('#send-all-auto').click(function(){
          window.location.href = window.location.href + "?automate=yes";
      });

    });
 
       
</script>
