<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Edit LoginTracking</title>
    <!-- load bootstrap css file -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
  </head>
  <body>
 
    <div class="container">
      <h1><center>Edit LoginTracking</center></h1>
        <div class="col-md-6 offset-md-3">

        <?php echo validation_errors(); ?>
        <?php echo form_open('LoginTracking/update/'.$logintrackingid); ?>
          <div class="form-group">
            <label>Attempt Date</label>
            <input type="text" class="form-control" name="attemptdate" value="<?php echo $attempdate;?>" placeholder="Attempt Date">
          </div><div class="form-group">
            <label>Attempt Result</label>
            <input type="text" class="form-control" name="attemptresult" value="<?php echo $attempresult;?>" placeholder="Attempt Result">
          </div>
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo $name;?>" placeholder="Name">
          </div>
          <div class="form-group">
            <label>User ID</label>
            <input type="text" class="form-control" name="userid" value="<?php echo $userid;?>" placeholder="User ID">
          </div>
          <div class="form-group">
            <label>Rowstamp</label>
            <input type="text" class="form-control" name="rowstamp" value="<?php echo $rowstamp;?>" placeholder="Price" readonly>
          </div>
          <input type="hidden" name="logintrackingid" value="<?php echo $logintrackingid?>">
          <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
 
    <!-- load jquery js file -->
    <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
    <!-- load bootstrap js file -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
  </body>
</html>