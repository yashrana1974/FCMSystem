<?php
// Set secure and httponly cookies
ini_set('session.cookie_secure', 1); // Send cookies only over HTTPS
ini_set('session.cookie_httponly', 1); // Prevent access to cookies by JavaScript

// Set session cookie parameters
session_set_cookie_params(0, '/', '', true, true); // Set lifetime to 0, path to '/', domain to '', secure to true, httponly to true

// Start session
session_start();

// Set session timeout (e.g., 30 minutes)
$session_timeout = 1800; // 30 minutes
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout)) {
  session_unset();     // unset $_SESSION variable for the run-time 
  session_destroy();   // destroy session data in storage
  header("Location: http://localhost/FCMS/FCMSystem/index2.php?");
  exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

if (
  !isset($_SESSION["spid"]) ||
  !isset($_SESSION["spname"]) ||
  !isset($_SESSION["sppasswordadmin"]) ||
  !isset($_SESSION["spmobileadmin"])
) {
  header("Location: http://localhost/FCMS/FCMSystem/index2.php?");
  exit();
}

// Regenerate session ID
if (!isset($_SESSION['CREATED'])) {
  $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > 1800) {
  // Regenerate ID if session idle for more than 30 minutes
  session_regenerate_id(true);
  $_SESSION['CREATED'] = time();
}

// Additional code for your application goes here...
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>File & Content Management System | Business Users</title>

  <!-- Favicons -->
  <link href="dist/img/content-management.png" rel="icon">

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
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php
    $GLOBALS['value'] = "User_Management";
    include("spnavbar.php");
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Business Admin List</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">

              </ol>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div>&nbsp</div>
                <div>
                  &nbsp&nbsp<a href="spbusinessadd.php" class="btn btn- bg-gradient-primary"><i class="fas fa-user"></i> Add User</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="width:5%">Sr No.</th>
                        <th style="width:30%">Business Admin Name</th>
                        <th style="width:30%">Company Name</th>
                        <th style="width:10%">Staff List</th>
                        <th style="width:25%">Operations</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Here I have to create while loop for showing the list of the data -->
                      <?php
                      include("connect.php");

                      $query = "SELECT * FROM cus_business_users WHERE  buunderadmin = 0";
                      $data = mysqli_query($conn, $query);

                      $total = mysqli_num_rows($data);
                      $i = 0;

                      // Display a message if no records found
                      if ($total == 0) {
                        echo "";
                      } else {
                        while ($result = mysqli_fetch_array($data)) {
                          $buid = $result['buid'];
                          $query1 = "SELECT * FROM cus_business_users WHERE buunderadmin = '$buid'";
                          $result1 = mysqli_query($conn, $query1);

                          $total1 = mysqli_num_rows($result1);
                          echo "<tr>
              <td>" . ++$i . "</td>
              <td>" . $result['buname'] . "</td>
              <td>" . $result['bucompanyname'] . "</td>
              <td><a href ='./spbusinessstaff.php?viewstaff=$buid'><h5>$total1</h5></a></td>
              <td>

                <a href='./spbusinessview.php?viewuser=$buid' name='viewuser' class='btn btn-sm bg-gradient-info'><i class='fas fa-pencil-alt'></i> View</a>&nbsp&nbsp&nbsp&nbsp&nbsp

                <a href='./spbusinessedit.php?edituser=$buid' name='edituser' class='btn btn-sm bg-gradient-success'><i class='fas fa-edit'></i> Edit</a>&nbsp&nbsp&nbsp&nbsp&nbsp

                <a href='./spbusinessdelete.php?deleteuser=$buid' name='deleteuser' class='btn btn-sm bg-gradient-danger  ' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fas fa-trash'></i> Delete</a>&nbsp&nbsp&nbsp&nbsp&nbsp

              </td>
            </tr>";
                        }
                      }
                      ?>
                      </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="float-right d-none d-sm-inline-block">
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- jQuery -->
  <script src="./plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables & Plugins -->
  <script src="./plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="./plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="./plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="./plugins/jszip/jszip.min.js"></script>
  <script src="./plugins/pdfmake/pdfmake.min.js"></script>
  <script src="./plugins/pdfmake/vfs_fonts.js"></script>
  <script src="./plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="./plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="./plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
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
  <script src="./dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="./dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
</body>

</html>