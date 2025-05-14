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

// Include your database connection file
include("connect.php");

// Function to move uploaded file to the specified directory
function moveUploadedFile($file, $uploadDirectory, $allowedExtensions)
{
    $file_name = $file["name"];
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

    // Check if the uploaded file has a valid extension
    if (!in_array($file_extension, $allowedExtensions)) {
        die("Invalid file format. Only " . implode(", ", $allowedExtensions) . " files are allowed.");
    }

    $targetPath = $uploadDirectory . basename($file_name);

    if (move_uploaded_file($file["tmp_name"], $targetPath)) {
        return basename($file_name);
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['addimg'])) {
        //prid, imtitle, imfilename
        $prid = $_POST['imprid'];
        $imtitle = $_POST['imtitle'];

        // Define allowed image file extensions
        $allowedImageExtensions = array("jpg", "jpeg", "png");

        // Move the uploaded file to the specified directory
        $uploadDirectory = "Images/"; // Change this to your desired location
        $imfilename = moveUploadedFile($_FILES["imcontent"], $uploadDirectory, $allowedImageExtensions);

        // Escape user inputs for security
        $prid = mysqli_real_escape_string($conn, $prid);
        $imtitle = mysqli_real_escape_string($conn, $imtitle);
        $imfilename = mysqli_real_escape_string($conn, $imfilename);

        // Use prepared statement to prevent SQL injection
        $query = "INSERT INTO res_image_db (prid, imtitle, imfilename) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sss", $prid, $imtitle, $imfilename);

        // Execute the statement
        $success = mysqli_stmt_execute($stmt);

        // Check if the query was successful
        if ($success) {
            // Get the ID of the last inserted record
            $imid = mysqli_insert_id($conn);

            // Get the file extension
            $fileExtension = pathinfo($imfilename, PATHINFO_EXTENSION);

            // Generate the new filename with imid appended at the end
            $newFilename = $imfilename . "_" . $imid . "." . $fileExtension;

            // Rename the file in the directory
            $sourcePath = $uploadDirectory . $imfilename;
            $targetPath = $uploadDirectory . $newFilename;

            if (rename($sourcePath, $targetPath)) {
                // Update the filename in the database
                $updateQuery = "UPDATE res_image_db SET imfilename = ? WHERE imid = ?";
                $updateStmt = mysqli_prepare($conn, $updateQuery);
                mysqli_stmt_bind_param($updateStmt, "si", $newFilename, $imid);
                mysqli_stmt_execute($updateStmt);

                // Check if the filename was updated successfully
                if (mysqli_stmt_affected_rows($updateStmt) > 0) {
                    echo "Data inserted successfully!";
                    header("Location: http://localhost/FCMS/FCMSystem/buprojectimg.php");
                    exit; // It's a good practice to exit after redirection
                } else {
                    die("Error updating filename in the database: " . mysqli_error($conn));
                }
            } else {
                die("Error renaming file.");
            }
        } else {
            die("Error inserting data into database: " . mysqli_error($conn));
        }
    }
    // Close update statement
    mysqli_stmt_close($updateStmt);
    // Close statement
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>File & Content Management System | Add Image</title>

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
        $GLOBALS['value'] = "IMAGES";
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
                            <h1>Add Image</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./buprojectimg.php">
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
                                <form id="quickForm" action="#" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputbuname">Image Title</label></label>
                                                    <input type="text" name="imtitle" class="form-control" id="exampleInputbuname" placeholder="Enter Title" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Select Project</label><br>
                                                    <select class="form-control" name="imprid" required>
                                                        <?php
                                                        $buid = $_SESSION['buid'];
                                                        include("connect.php");
                                                        $query = "SELECT prid, prname FROM res_project_db WHERE buid = '$buid'";
                                                        $data = mysqli_query($conn, $query);
                                                        while ($row = mysqli_fetch_array($data)) {
                                                            echo "<option value='" . $row['prid'] . "'>" . $prname = $row['prname'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Image Content</label><br />
                                                <input type="file" class="btn btn-secondary btn" name="imcontent" id="fileToUpload" accept="image/*" capture="camera" required>
                                            </div>
                                        </div><br>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->

                            </div>
                            <div>
                                <div style='text-align:center;'>
                                    <input type='submit' class='btn btn-primary btn-lg' id='submit' name='addimg'>
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