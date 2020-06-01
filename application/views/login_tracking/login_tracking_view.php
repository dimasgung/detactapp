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
      <a href="<?php echo site_url('LoginTracking/add'); ?>" class="btn btn-sm btn-success">Add Login Tracking</a>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">User Id</th>
            <th scope="col">Name</th>
            <th scope="col">View</th>
            <th width="200">Action</th>
          </tr>
        </thead>
        <tbody>
			<?php 
				$row = 0;
				foreach ($logintracking as $logintracking_item): 
					$row++ ?>
		          <tr>
		            <th scope="row"><?php echo $row?></th>
		            <td><?php echo $logintracking_item['USERID']?></td>
		            <td><?php echo $logintracking_item['NAME']?></td>
		            <td>
		            	<a href="<?php echo site_url('LoginTracking/detail/'.$logintracking_item['LOGINTRACKINGID']); ?>">View detail</a>
		            </td>
		            <td>
		            	<a href="<?php echo site_url('LoginTracking/delete/'.$logintracking_item['LOGINTRACKINGID']);?>" class="btn btn-sm btn-danger">Delete</a>
		            	<a href="<?php echo site_url('LoginTracking/update/'.$logintracking_item['LOGINTRACKINGID']);?>" class="btn btn-sm btn-info">Update</a>
                 	<td>
		          </tr>
			<?php endforeach; ?>
        </tbody>
      </table>
 
    </section>
    <!-- /.content -->
  </div>

