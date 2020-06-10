<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Mobile Site Processed</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>Dashboard">Home</a></li>
              <li class="breadcrumb-item"><a href="#">CNOP</a></li>
              <li class="breadcrumb-item active">Mobile Site Migration Processed</li>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Mobile Site Data Processed</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-striped"  cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>No</th>
                            <th>NAME_OSP</th>
                            <th>STATUS</th>
                            <th>SITE_ID</th>
                            <th>SITE_NAME</th>
                            <th>ADDRESS</th>
                            <th>REGIONAL</th>
                            <th>WITEL</th>
                            <th>STO</th>
                            <th>RESPONSE</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
         
                    <tfoot>
                        <tr>
                            <th><input style="width:30px; height:30px;" type="checkbox" id="check-all" class="checkbox-all"></th>
                            <th>No</th>
                            <th>NAME_OSP</th>
                            <th>STATUS</th>
                            <th>SITE_ID</th>
                            <th>SITE_NAME</th>
                            <th>ADDRESS</th>
                            <th>REGIONAL</th>
                            <th>WITEL</th>
                            <th>STO</th>
                            <th>RESPONSE</th>
                        </tr>
                    </tfoot>
                </table>

              </div>
              <!-- /.card-body -->
            </div>

              <button type="button" class="btn btn-primary btn-sm" id='create-all'>Create Selected Mobile Site</button>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

  <div class="modal modal-loading"><!-- Place at bottom of page --></div>

  <!--MODAL Create-->
  <div class="modal fade" id="ModalCreateAll" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Create Mobile Site</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
              </div>
              <form class="form-horizontal">
              <div class="modal-body">
                                     
                      <div class="alert alert-primary"><p>Apakah Anda yakin mau membuat mobile site yang dichecklis?</p></div>
                                   
              </div>
              <div class="modal-footer">
                  <input type="button" class="btn btn-default" data-dismiss="modal" value="Tutup">
                  <input class="btn_create_all btn btn-primary" id="btn_create_all" value="Create">
              </div>
              </form>
          </div>
      </div>
  </div>
 
  <!--MODAL Create-->
  <div class="modal fade" id="loading-create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

    $(document).ready(function() {
 
        tampil_datatable();

        function tampil_datatable(){
          //datatables
          table = $('#table').DataTable({ 
   
              "processing": true, 
              "serverSide": true, 
              "order": [], 
               
              "ajax": {
                  "url": "<?php echo site_url('CNOP/get_data_mobile_site_processed')?>",
                  "type": "POST",
              },
              "lengthMenu": [10, 20, 50, 100, 200, 500,1500],
               
              "columnDefs": [
              { 
                  "targets": [ 0 ], 
                  "orderable": false, 
              },
              ],
   
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

      $('#create-all').click(function(){
            $('#ModalCreateAll').modal('show');
      });

      $('#btn_create_all').click(function(){


          $('#loading-create').modal('show');

          var inputs = $('.checkbox-grid:checked');
          var totalProses = $('.checkbox-grid:checked').length;
          var jumlahProsesSukses = 0;
          var jumlahProsesFailed = 0;
          var promises = [];
          var site_id = '';

          for(var i = 0, l = inputs.length; i < l; ++i) {

            site_id=inputs[i].value;

            var request = $.ajax(  {
                type : "POST",
                url  : "<?php echo base_url('CNOP/create_location_osp_uimax')?>",
                // dataType : "JSON",
                data : {site_id: site_id},
                success: function(data){
                  // alert(data);
                  jumlahProsesSukses++;
                  $('#loading-text-modal').html("Harap Tunggu. Telah melakukan create " + jumlahProsesSukses + " dari " + totalProses + ". Jangan di refresh.</br> Jika proses berhenti silahkan di refresh" );

                  if(jumlahProsesSukses + jumlahProsesFailed == totalProses ){
                    $('#result-text-modal').html('<input type="button" class="btn btn-default" data-dismiss="modal" value="Tutup">');
                    hide_modal();
                  }

                },
                error: function(data){
                  // alert(data);
                  jumlahProsesFailed++;
                  $('#loading-text-modal-error').html("Error / Intermitten sebanyak : " + jumlahProsesFailed);

                  if(jumlahProsesSukses + jumlahProsesFailed == totalProses ){
                    $('#result-text-modal').html('<input type="button" class="btn btn-default" data-dismiss="modal" value="Tutup">');
                    hide_modal();
                  }

                }
            });

            promises.push(request);
            
          }
  
          $.when.apply(null, promises).done(function() {
            
            hide_modal();

          })
      });

      function hide_modal(){
        alert('Data selesai di proses');
        $('#loading-create').modal('hide');
        $('#ModalCreateAll').modal('hide');
        location.reload();
      }

    });
 
       
</script>