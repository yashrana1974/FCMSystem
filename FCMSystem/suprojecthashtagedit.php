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
    header("Location: http://localhost/FCMS/FCMSystem/businesslogin.php?");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

if (!isset($_SESSION["suid"]) || 
    !isset($_SESSION["suname"]) || 
    !isset($_SESSION["supassword"]) || 
    !isset($_SESSION["sumobile"])) {
    header("Location: http://localhost/FCMS/FCMSystem/businesslogin.php?");
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
  <title>File & Content Management System | Edit Hashtag Details</title>

  <!-- Favicons -->
  <link href="dist/img/content-management.png" rel="icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">


    <?php
    $GLOBALS['value'] = "HASHTAGS";
    include("sunavbar.php");
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Edit Hashtag Content</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="./suprojecthashtag.php">
                    <h5><u> &lt;&lt; Back</u></h5>
                  </a></li>
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
            <!-- left column -->
            <div class="col-md-12">
              <!-- jquery validation -->
              <div class="card card-secondary">
                <!-- ... Your existing card content ... -->

                <?php
                $buid = $_SESSION['suid'];
                include("connect.php");
                if (isset($_GET["edithashtag"])) {
                  $id = $_GET["edithashtag"];
                  // Fetch data from the database based on the user ID
                  $query = "SELECT * FROM res_hashtag_db WHERE htid = '$id'";
                  $result = mysqli_query($conn, $query);
                  if ($result) {
                    $userData = mysqli_fetch_array($result);
                ?>
                    <form id="quickForm" action="suprojecthashtageditdb.php" method="POST">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="exampleInputbuname">Hashtag Title</label>
                              <input type="text" name="httitle" class="form-control" id="exampleInputbuname" placeholder="Enter Title" value="<?php echo $userData['httitle']; ?>" required>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <label for="exampleInputbuname">Select Project</label><br>
                              <select class="form-control" name="htprid" required>
                                <?php
                                $query2 = "SELECT prid FROM cus_assigned_users WHERE buid = '$buid'";
                                $data = mysqli_query($conn, $query2);


                                // Check if htid is assigned to prid in res_hashtag_db
                                $htid = $userData['htid'];
                                $htprid = $userData['prid'];
                                $assignedPridQuery = "SELECT prid, prname FROM res_project_db WHERE prid = '$htprid'";
                                $assignedPridData = mysqli_query($conn, $assignedPridQuery);
                                $assignedPridRow = mysqli_fetch_array($assignedPridData);

                                if ($assignedPridRow) {
                                  // Display the assigned project first
                                  echo "<option value='" . $assignedPridRow['prid'] . "' selected>" . $assignedPridRow['prname'] . "</option>";
                                }

                                // Display other projects from res_project_db
                                while ($row = mysqli_fetch_array($data)) {
                                  // Skip the assigned project if it's already displayed
                                  $query3 = "SELECT prname FROM res_project_db WHERE prid = $row[prid]";
                                  $data2 = mysqli_query($conn, $query3);
                                  $row2 = mysqli_fetch_array($data2);
                                  if ($row['prid'] != $htprid) {
                                    echo "<option value='" . $row['prid'] . "'>" . $row2['prname'] . "</option>";
                                  }
                                }
                                ?>

                              </select>
                            </div>

                          </div>
                          <div class="col-md-12">
                            <label for="exampleInputbuname">Hashtag Content</label>
                            <textarea type="text" class="form-control" id="exampleInputbuname" placeholder="Enter Content" name="htcontent" rows="8" required><?php echo $userData['htcontent']; ?></textarea>
                          </div>
                        </div><br>
                      </div>
                      <div>
                      </div>
                  <?php
                  }
                }
                  ?>
                  <!--/.col (left) -->
                  <!-- right column -->
                  <div class="col-md-6">
                    <!-- ... Your existing right column content ... -->
                  </div>
                  <!--/.col (right) -->
              </div>
              <div style="text-align:center;">
                <input type="submit" class="btn btn-primary btn-lg" id="submit">
                <input type="hidden" value="<?php echo $userData['htid']; ?>" name="edithashtag">
              </div>
              <!-- /.row -->
              </form>

            </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
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