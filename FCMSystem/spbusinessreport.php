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

if (!isset($_SESSION["spid"]) || 
    !isset($_SESSION["spname"]) || 
    !isset($_SESSION["sppasswordadmin"]) || 
    !isset($_SESSION["spmobileadmin"])) {
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
    <title>File & Content Management System | All Usesr Reports</title>

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
        $GLOBALS['value'] = "User_Report";
        include("spnavbar.php");
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            <img src="Images\content-management.png" width="50px" height="50px"></i> File & Content Management System
                                            <small class="float-right" id="timeanddate">
                                                <script>
                                                    const date = Date();
                                                    document.getElementById("timeanddate").innerHTML = date;
                                                </script>

                                            </small>
                                        </h4>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-12 invoice-col">
                                        <p>
                                            This document contains sensitive information pertaining to the File & Content Management System (FCMS). Unauthorized access, disclosure, or use of this information is strictly prohibited. It is intended solely for the use of authorized personnel responsible for managing the FCMS.<br>
                                            <b>Email:</b> info@filecms.com
                                        </p>
                                    </div>
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Business User Name</th>
                                                    <th>Under Admin</th>
                                                    <th>Company Name</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            include("connect.php");

                                            $query = "SELECT * FROM cus_business_users  ";
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
                                     <td>";
                                                    if ($result['buunderadmin'] != 0) {
                                                        $adminid = $result['buunderadmin'];
                                                        $query2 = "SELECT * FROM cus_business_users WHERE buid = '$adminid'";
                                                        $data2 = mysqli_query($conn, $query2);
                                                        $result2 = mysqli_fetch_array($data2);
                                                        echo $result2['buname'];
                                                    } else {
                                                        echo "<u>Business Admin</u>";
                                                    }
                                                    echo ""
                                                        . "
                                      </td>
                                     <td>" . $result['bucompanyname'] . "</td>
                                     <td>" . $result['bumobile'] . "</td>
                                     <td>" . $result['buemail'] . "</td>
                                     <td>";
                                                    if ($result['bustatus'] == 1) {
                                                        echo "Active";
                                                    } else {
                                                        echo "Inactive";
                                                    }
                                                    echo ""

                                                        . "</td>
                                   </tr>";
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <!-- /.invoice -->
                                <!-- this row will not appear when printing -->
                                <div class="row no-print">
                                    <div class="col-12">
                                        <button class="btn btn- bg-gradient-primary float-right" id="print-button" style="margin-right: 5px;"><i class="fas fa-print"></i> Print</button>
                                    </div>
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer no-print">
            <div class="float-right d-none d-sm-block">
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <script>
        document.getElementById("print-button").addEventListener("click", function() {
            window.print();
        });
    </script>
</body>

</html>