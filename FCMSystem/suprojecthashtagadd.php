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
include("connect.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['addhashtag'];
    //prid, httitle, htcontent, hthashtag
    $prid = $_POST['htprid'];
    $httitle = '#' . $_POST['httitle']; // Add '#' prefix to the title
    $htcontent = $_POST['htcontent'];

    // Escape user inputs for security
    $prid = mysqli_real_escape_string($conn, $prid);
    $httitle = mysqli_real_escape_string($conn, $httitle);
    $htcontent = mysqli_real_escape_string($conn, $htcontent);

    $query = "INSERT INTO res_hashtag_db (prid, httitle, htcontent) VALUES('$prid', '$httitle', '$htcontent')";
    $data = mysqli_query($conn, $query);

    if ($data) {
        echo "Data inserted successfully!";
        header("Location: http://localhost/FCMS/FCMSystem/suprojecthashtag.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>File & Content Management System | Add Hashtags</title>

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
        $GLOBALS['value'] = "MESSAGE";
        include("sunavbar.php");
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
                                <li class="breadcrumb-item"><a href="./suprojecthashtag.php">
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
                                                    <label for="exampleInputbuname">Hashtag Title</label></label>
                                                    <div class="input-group-text">
                                                        <span class="fas fa-hashtag"></span>&nbsp;
                                                        <input type="text" name="httitle" class="form-control" id="exampleInputbuname" placeholder="Enter Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Select Project</label><br>
                                                    <select class="form-control" name="htprid" required>
                                                        <?php
                                                        $buid = $_SESSION['suid'];
                                                        $query = "SELECT prid FROM cus_assigned_users WHERE buid = '$buid'";
                                                        $data = mysqli_query($conn, $query);
                                                        while ($row = mysqli_fetch_array($data)) {
                                                            $query2 = "SELECT prid, prname FROM res_project_db WHERE prid = $row[prid]";
                                                            $data2 = mysqli_query($conn, $query2);
                                                            $row2 = mysqli_fetch_array($data2); {
                                                                echo "<option value='" . $row2['prid'] . "'>" . $prname = $row2['prname'] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="exampleInputbuname">Hashtag Content</label>
                                                <textarea type="text" class="form-control" id="exampleInputbuname" placeholder="Enter Content" name="htcontent" rows="8" required></textarea>
                                            </div>
                                        </div><br>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->

                            </div>
                            <div>
                                <div style='text-align:center;'>
                                    <input type='submit' class='btn btn-primary btn-lg' id='submit' name='addhashtag'>
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