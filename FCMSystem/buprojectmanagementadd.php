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

if (!isset($_SESSION["buid"]) || 
    !isset($_SESSION["buname"]) || 
    !isset($_SESSION["bupassword"]) || 
    !isset($_SESSION["bumobile"])) {
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
  <title>File & Content Management System | Add Project</title>

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
    $GLOBALS['value'] = "Project_Management";
    include("bunavbar.php");
    include("connect.php");
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Add User</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="./buprojectmanagement.php">
                    <h5><u>
                        << Back</u>
                    </h5>
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
                <!-- /.card-header -->
                <!-- form start -->
                <form id="quickForm" action="#" method="POST">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Project Name</label></label>
                          <input type="text" name="prname" class="form-control" placeholder="Enter name" required>
                        </div>
                        <div>
                          <label for="selectedItems">Select Staff</label><br />
                          <span>Use Ctrl to select multiple staff</span>
                          <span>
                            <select name="selectedItems[]" id="selectedItems" multiple class="form-control">
                              <?php
                              $buid = $_SESSION['buid'];
                              include("connect.php");
                              $query = "SELECT buid, buname FROM cus_business_users WHERE buunderadmin = '$buid'";
                              $data = mysqli_query($conn, $query);
                              while ($row = mysqli_fetch_array($data)) {
                                echo "<option value='" . $row['buid'] . "'>" . $row['buname'] . "</option>";
                              }
                              ?>
                            </select>
                          </span>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

              </div>
              <div>
                <div style='text-align:center;'>
                  <input type='submit' class='btn btn-primary btn-lg' id='submit' name='addproject'>
                </div>
              </div>
              </form>
              <!--/.col (left) -->
              <!-- right column -->
              <div class="col-md-6">

              </div>
              <!--/.col (right) -->
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">

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
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- DataTables  & Plugins -->
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

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addproject'])) {
  include("connect.php");

  $prname = $_POST['prname'];
  $buid = $_SESSION['buid'];
  $selectedItems = isset($_POST['selectedItems']) ? $_POST['selectedItems'] : [];

  $verify = "SELECT prname FROM res_project_db WHERE prname = '$prname' AND buid = '$buid'";
  $verifed = mysqli_query($conn, $verify) or die(mysqli_error($conn));

  if (mysqli_num_rows($verifed) == 0) {
    $query = "INSERT INTO res_project_db (prname, buid) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "ss", $prname, $buid);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
      $query2 = "SELECT prid FROM res_project_db WHERE prname = '$prname' AND buid = '$buid'";
      $data2 = mysqli_query($conn, $query2);
      $row2 = mysqli_fetch_array($data2);
      $prid = $row2['prid'];

      foreach ($selectedItems as $subuid) {
        $query3 = "INSERT INTO cus_assigned_users (prid, buid) VALUES ($prid, $subuid)";
        $data3 = mysqli_query($conn, $query3);
      }
    }
    mysqli_stmt_close($stmt);

    // Redirect or perform other actions upon success
  } elseif (mysqli_num_rows($verifed) > 0) {
    echo "<script>alert('Project exists, use a different name');</script>";
  } else {
    // Handle insertion failure
    echo "Error inserting record: " . mysqli_error($conn);
  }



  mysqli_close($conn);
}
?>