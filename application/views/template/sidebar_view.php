 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url();?>assets/AdminLTE/index3.html" class="brand-link">
      <img src="<?php echo base_url();?>assets/img/logo-detact.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Detact Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
<!--       <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url();?>assets/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo base_url();?>Dashboard" class="nav-link <?php echo ($menu_active == 'Dashboard'? 'active' : ''); ?>" >
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <span class="right badge badge-danger">Home</span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?php echo ($menu_active == 'Login Tracking'? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Login Tracking
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url();?>LoginTracking" class="nav-link <?php echo ($sub_menu_active == 'Login Tracking Data'? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Login Tracking Data</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>LoginTracking/history" class="nav-link <?php echo ($sub_menu_active == 'Login Tracking History'? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Login Tracking History</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($menu_active == 'Analytic Result'? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Analytic Result
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-danger right">*</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../layout/top-nav.html" class="nav-link <?php echo ($sub_menu_active == 'Shared Account'? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Shared Account</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../layout/top-nav-sidebar.html" class="nav-link <?php echo ($sub_menu_active == 'Follow Up'? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Follow Up</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">EXTRA</li>
          <li class="nav-item has-treeview" <?php echo ($menu_active == 'CNOP'? 'menu-open' : ''); ?>>
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                CNOP
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url();?>CNOP/mobileSiteMigration" class="nav-link <?php echo ($sub_menu_active == 'Mobile Site Data Migration'? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mobile Site Data Migration</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>