<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title;?></title>
    <!-- load bootstrap css file -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
  </head>
  <body>
 
    <div class="container">
      <h1><?php echo $content;?></h1>
      <a href="<?php echo site_url('LoginTracking/add'); ?>">Add Login Tracking</a>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">User Id</th>
            <th scope="col">Name</th>
            <th scope="col">View</th>
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
		            <td><a href="<?php echo site_url('LoginTracking/detail/'.$logintracking_item['LOGINTRACKINGID']); ?>">View detail</a></td>
		          </tr>
			<?php endforeach; ?>
        </tbody>
      </table>
 
    </div>
    <!-- load jquery js file -->
    <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
    <!-- load bootstrap js file -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
  </body>
</html>