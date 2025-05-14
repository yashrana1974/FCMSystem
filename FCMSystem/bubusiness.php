<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>File & Content Management System | Staff Management</title>

    <!-- Favicons -->
    <link href="dist/img/content-management.png" rel="icon">

    <!-- External CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<!-- Wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
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

        if (
            !isset($_SESSION["buid"]) ||
            !isset($_SESSION["buname"]) ||
            !isset($_SESSION["bupassword"]) ||
            !isset($_SESSION["bumobile"])
        ) {
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
        $GLOBALS['value'] = "User_Management";
        include("bunavbar.php");
        ?>
        <!-- /.navbar -->

        <!-- Content Wrapper -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Staff List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div>&nbsp;</div>
                                <div>
                                    <!-- &nbsp;&nbsp;<button type="button" class="btn btn-primary"><i class="fas fa-user"></i><a href="./bubusinessadd.php" style="color: white;"> Add Staff</a></button> -->
                                    &nbsp;&nbsp;<a href="bubusinessadd.php" class="btn btn- bg-gradient-primary"><i class="fas fa-user"></i> Add Staff</a>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width:20%">Sr No.</th>
                                                <th style="width:50%">Business Users</th>
                                                <th style="width:30%">Operations</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- PHP While Loop for data -->
                                            <?php
                                            $buid = $_SESSION['buid'];
                                            include("connect.php");
                                            $query = "SELECT * FROM cus_business_users WHERE buunderadmin = $buid";
                                            $data = mysqli_query($conn, $query);
                                            $total = mysqli_num_rows($data);
                                            $i = 0;
                                            if ($total == 0) {
                                                echo "";
                                            } else {
                                                while ($result = mysqli_fetch_array($data)) {
                                                    $buid = $result['buid'];
                                                    echo "<tr>
                                                <td>" . ++$i . "</td>
                                                <td>" . $result['buname'] . "</td>
                                                <td>
                                                    <a href='./bubusinessview.php?viewuser=$buid' name='' class='btn btn-sm bg-gradient-info'><i class='fas fa-pencil-alt'></i> View</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    
                                                    <a href='./bubusinessedit.php?edituser=$buid' class='btn btn-sm bg-gradient-success'><i class='fas fa-edit'></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;";

                                                    if ($result['bustatus'] == 1) {
                                                        echo "
                                                        
                                                        <a href='./bubusinessblock.php?blockuser=$buid' name='blockuser' class='btn btn-sm bg-gradient-danger' onclick='return confirm(\"Are you sure you want to Block this user?\")'><i class='fas fa-ban'></i> Block</a>
                                                        
                                                        ";
                                                    } else {
                                                        echo "
                                                        
                                                        <a href='./bubusinessunblock.php?unblockuser=$buid' name='unblockuser' class='btn btn-sm bg-gradient-primary' onclick='return confirm(\"Are you sure you want to Unblock this user?\")'><i class='fas fa-ban'></i> Unblock</a>
                                                        
                                                        ";
                                                    }
                                                    echo "</td></tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>
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

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline-block">
            </div>
        </footer>
        <!-- /.footer -->

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