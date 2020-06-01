<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Login Tracking Data</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>Dashboard">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>LoginTracking">Login Tracking</a></li>
              <li class="breadcrumb-item active">Add Tracking Data</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Tracking Data</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            <?php echo validation_errors(); ?>
            <?php echo form_open('LoginTracking/add'); ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="attemptdate">Attempt Date</label>
                    <input name="attemptdate" type="input" class="form-control" id="exampleattemptdate" placeholder="Enter Attempt Date">
                  </div>
                  <div class="form-group">
                    <label for="attemptresult">Attempt Result</label>
                    <input name="attemptresult" type="input" class="form-control" id="exampleattemptresult" placeholder="Attempt Result">
                  </div>

                  <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" type="input" class="form-control" id="exampleName" placeholder="Name">
                  </div>
                  <div class="form-group">
                    <label for="userid">User Id</label>
                    <input name="userid" type="input" class="form-control" id="exampleuserid" placeholder="User ID">
                  </div>
                  <div class="form-group">
                    <label for="logintrackingid">Login Tracking ID</label>
                    <input name="logintrackingid" type="input" class="form-control" id="examplelogintrackingid" placeholder="Login Tracking ID">
                  </div>
                  <div class="form-group">
                    <label for="rowstamp">Row Stamp</label>
                    <input name="rowstamp" type="input" class="form-control" id="examplerowstamp" placeholder="Row Stamp">
                  </div>


                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add Login Tracking</button>
                </div>        
            </div>
            <!-- /.card -->
          </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
