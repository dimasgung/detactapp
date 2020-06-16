  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="container-fluid">
                <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 id="count-need-confirmation">0</h3>

                <p>Need Confirmation</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url();?>SharedAccountHistory" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="count-sent">0</h3>

                <p>Sent</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo base_url();?>SharedAccountHistory/sent" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 id="count-failed">0</h3>

                <p>Failed</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?php echo base_url();?>SharedAccountHistory/failed" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 id="count-action">0</h3>

                <p>Received</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url();?>SharedAccountHistory/action" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><b>Pengumuman</b></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                Untuk setiap akun yang terdeteksi sharing account, direkomendasikan untuk mengubah password. Jika tidak ada respon maka akun bisa disuspend.
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                Fraud Cheater Team
              </div>
              <!-- /.card-footer-->
            </div>
          </div>

          <div class="col-6">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title"><b>Top 25 Detected All Cases</b></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="table-top-25-all-detected" class="table m-0">
                    <thead>
                    <tr>
                      <th>NO</th>
                      <th>USERID</th>
                      <th>APPLICATION</th>
                      <th>TOTAL_HISTORY</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="<?php echo base_url();?>SharedAccountHistory/top_all" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-6">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title"><b>Top 25 Detected Last 7 Days</b></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="table-top-25-detected" class="table m-0">
                    <thead>
                    <tr>
                      <th>NO</th>
                      <th>USERID</th>
                      <th>APPLICATION</th>
                      <th>TOTAL_HISTORY</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="<?php echo base_url();?>SharedAccountHistory/top" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-12">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title"><b>10 Latest Confirmation Cases</b></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="table-latest-confirmation" class="table m-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>USERID</th>
                            <th>APPLICATION</th>
                            <th>ATTEMPTDATE</th>
                            <th>STATUS CONFIRMATION</th>
                            <th>DESCRIPTION</th>
                            <th>ACTION CONFIRMATION</th>
                            <th>IS SHARED CONFIRMATION</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
         
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>USERID</th>
                            <th>APPLICATION</th>
                            <th>ATTEMPTDATE</th>
                            <th>STATUS CONFIRMATION</th>
                            <th>DESCRIPTION</th>
                            <th>ACTION CONFIRMATION</th>
                            <th>IS SHARED CONFIRMATION</th>
                        </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="<?php echo base_url();?>SharedAccountHistory/action" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>

        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script src="<?php echo base_url();?>assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript">

    var tableTopAllDetected;

    $(document).ready(function() {
        
        tampil_count_need_confirmation();
        tampil_count_sent();
        tampil_count_failed();
        tampil_count_action();

        function tampil_count_need_confirmation(){

          // alert('haha');
          //datatables
            var request = $.ajax(  {
                type : "POST",
                url  : "<?php echo base_url('Dashboard/get_count_confirmation')?>",
                // dataType : "JSON",
                success: function(data){

                  $('#count-need-confirmation').html(data);
                },
                error: function(data){

                }
            });
        }

        function tampil_count_sent(){

          // alert('haha');
          //datatables
            var request = $.ajax(  {
                type : "POST",
                url  : "<?php echo base_url('Dashboard/get_count_sent')?>",
                // dataType : "JSON",
                success: function(data){

                  $('#count-sent').html(data);
                },
                error: function(data){

                }
            });
        }

        function tampil_count_failed(){

          // alert('haha');
          //datatables
            var request = $.ajax(  {
                type : "POST",
                url  : "<?php echo base_url('Dashboard/get_count_failed')?>",
                // dataType : "JSON",
                success: function(data){

                  $('#count-failed').html(data);
                },
                error: function(data){

                }
            });
        }

        function tampil_count_action(){

          // alert('haha');
          //datatables
            var request = $.ajax(  {
                type : "POST",
                url  : "<?php echo base_url('Dashboard/get_count_action')?>",
                // dataType : "JSON",
                success: function(data){

                  $('#count-action').html(data);
                },
                error: function(data){

                }
            });
        }

        tampil_datatable_top_all();

        function tampil_datatable_top_all(){
          //datatables
          tableTopAllDetected = $('#table-top-25-all-detected').DataTable({ 
   
              "processing": true, 
              "serverSide": true, 
              "order": [], 
              "ajax": {
                  "url": "<?php echo site_url('SharedAccountHistory/get_data_shared_account_history_top_all')?>",
                  "type": "POST",
                  "data": function (d) {
                      // renderedData = d.length;
                  }
              },
              "lengthMenu": [5],
               
              "columnDefs": [
              { 
                  "targets": [ 0 ], 
                  "orderable": false, 
              },
              ],
          });
        }


        tampil_datatable_top();

        function tampil_datatable_top(){
          //datatables
          tableTopDetected = $('#table-top-25-detected').DataTable({ 
   
              "processing": true, 
              "serverSide": true, 
              "order": [], 
              "ajax": {
                  "url": "<?php echo site_url('SharedAccountHistory/get_data_shared_account_history_top')?>",
                  "type": "POST",
                  "data": function (d) {
                      // renderedData = d.length;
                  }
              },
              "lengthMenu": [5],
               
              "columnDefs": [
              { 
                  "targets": [ 0 ], 
                  "orderable": false, 
              },
              ],
          });
        }


        tampil_datatable_action();

        function tampil_datatable_action(){
          //datatables
          tableTopDetected = $('#table-latest-confirmation').DataTable({ 
   
              "processing": true, 
              "serverSide": true, 
              "order": [], 
              "ajax": {
                  "url": "<?php echo site_url('SharedAccountHistory/get_data_shared_account_history_action_limit')?>",
                  "type": "POST",
                  "data": function (d) {
                      // renderedData = d.length;
                  }
              },
              "lengthMenu": [10],
               
              "columnDefs": [
              { 
                  "targets": [ 0 ], 
                  "orderable": false, 
              },
              ],
          });
        }

    });
</script>