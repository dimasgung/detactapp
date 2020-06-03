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
                  <form action="<?php echo base_url();?>LoginTracking/analyticProcessing" method="post">
                  <!-- select -->
                    <div class="form-group">
                        <label>Tanggal Login</label>
                        <select class="form-control" name='attemptdate'>
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
                        <select class="form-control" name='aplikasi'>
                            <option value='NOSSA'>NOSSA</option>
                        </select>
                    </div>
                      <button type="submit" class="btn btn-sm btn-success">Processing Sharing Account Analytics</button>
                  </form>
              </div>
          </div>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
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
                "url": "<?php echo site_url('LoginTracking/get_data_logintracking')?>",
                "type": "POST",
            },
 
             
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
 
        });
 
    });
 
</script>
