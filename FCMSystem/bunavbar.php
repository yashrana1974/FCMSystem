<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>File & Content Management System | Navbar</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="dist/img/content-management.png" alt="FCMS" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="budashboard.php" class="nav-link">Dashboard</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="http://localhost/fCMS/FCMSystem/index.html#contact" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="./budashboard.php" class="brand-link">
        <img src="dist/img/content-management.png" alt="FCMS Logo" class="brand-image img-square elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">FCMS</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <a href="buprofile.php">
            <img src="dist/img/common_profile_photo.webp" class="img-circle elevation-2" alt="User Image">
            </a>
          </div>
          <div class="info">
            <a href="buprofile.php" class="d-block"><?php echo $_SESSION['buname']; ?></a> <!--Need to take data from the database for the user name and use common photo user specific like staff , business admin, super user-->
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <?php
              if ($GLOBALS['value'] == "Dashboard") {
                echo "<a href='./budashboard.php' class='nav-link active'>";
                $GLOBALS['value'] = " ";
              } else {
                echo "<a href='./budashboard.php' class='nav-link'>";
              }
              ?>
              <i class="fas fa-user"></i>
              <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <?php
              if ($GLOBALS['value'] == "User_Management") {
                echo "<a href='./bubusiness.php' class='nav-link active'>";
                $GLOBALS['value'] = " ";
              } else {
                echo "<a href='./bubusiness.php' class='nav-link'>";
              }
              ?>
              <i class="fas fa-users"></i>
              <p>Staff Management</p>
              </a>
            </li>
            <li class="nav-item">
              <?php
              if ($GLOBALS['value'] == "Project_Management") {
                echo "<a href='./buprojectmanagement.php' class='nav-link active'>";
                $GLOBALS['value'] = "";
              } else {
                echo "<a href='./buprojectmanagement.php' class='nav-link'>";
              }
              ?>
              <i class="fas fa-edit"></i>
              <p>Project Management</p>
              </a>
            </li>
            <li class="nav-item">
              <?php
              if ($GLOBALS['value'] == "MESSAGE") {
                echo "<a href='./buprojecttext.php' class='nav-link active'>";
                $GLOBALS['value'] = "";
              } else {
                echo "<a href='./buprojecttext.php' class='nav-link'>";
              }
              ?>
              <i class="fas fa-book"></i>
              <p>MESSAGES</p>
              </a>
            </li>
            <li class="nav-item">
              <?php
              if ($GLOBALS['value'] == "IMAGES") {
                echo "<a href='./buprojectimg.php' class='nav-link active'>";
                $GLOBALS['value'] = "";
              } else {
                echo "<a href='./buprojectimg.php' class='nav-link'>";
              }
              ?>
              <i class="fas fa-image"></i>
              <p>IMAGES</p>
              </a>
            </li>
            <li class="nav-item">
              <?php
              if ($GLOBALS['value'] == "VIDEOS") {
                echo "<a href='./buprojectvideo.php' class='nav-link active'>";
                $GLOBALS['value'] = "";
              } else {
                echo "<a href='./buprojectvideo.php' class='nav-link'>";
              }
              ?>
              <i class="fas fa-video"></i>
              <p>VIDEOS</p>
              </a>
            </li>
            <li class="nav-item">
              <?php
              if ($GLOBALS['value'] == "HASHTAGS") {
                echo "<a href='./buprojecthashtag.php' class='nav-link active'>";
                $GLOBALS['value'] = "";
              } else {
                echo "<a href='./buprojecthashtag.php' class='nav-link'>";
              }
              ?>
              <i class="fab fa-slack-hash"></i>
              <p>HASHTAGS</p>
              </a>
            </li>
            <li class="nav-item">
              <?php
              if ($GLOBALS['value'] == "Reports") {
                echo "<a href='./bureports.php' class='nav-link active'>";
                $GLOBALS['value'] = "";
              } else {
                echo "<a href='./bureports.php' class='nav-link'>";
              }
              ?>
              <i class="fas fa-bug"></i>
              <p>Bug Reports</p>
              </a>
            </li>
            <li class="nav-item">
              <?php
              if ($GLOBALS['value'] == "TASKS") {
                echo "<a href='./bustaffreports.php' class='nav-link active'>";
                $GLOBALS['value'] = "";
              } else {
                echo "<a href='./bustaffreports.php' class='nav-link'>";
              }
              ?>
              <i class="fas fa-flag"></i>
              <p>Staff Reports</p>
              </a>
            </li>
            <li class="nav-item">
              <?php
              if ($GLOBALS['value'] == "Logout") {
                echo "<a href='./bulogout.php' class='nav-link active' onclick='return confirmLogout()'>";
                $GLOBALS['value'] = " ";
              } else {
                echo "<a href='./bulogout.php' class='nav-link' onclick='return confirmLogout()'>";
              }
              ?>
              <i class="fas fa-sign-out-alt"></i>
              <p>Log Out</p>
              </a>
            </li>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script>
      function confirmLogout() {
        return confirm("Are you sure you want to logout of the system?");
      }
    </script>


</body>

</html>