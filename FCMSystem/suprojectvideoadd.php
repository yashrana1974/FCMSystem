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
        die("Error uploading file.");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addvideo'])) {
        // prid, vititle, vicontent
        $prid = $_POST['viprid'];
        $vititle = $_POST['vititle'];

        // Define allowed video file extensions
        $allowedExtensions = array("mp4");

        // Move the uploaded file to the specified directory
        $uploadDirectory = "Videos/"; // Change this to your desired location
        $vifilename = moveUploadedFile($_FILES["vicontent"], $uploadDirectory, $allowedExtensions);

        // Escape user inputs for security
        $prid = mysqli_real_escape_string($conn, $prid);
        $vititle = mysqli_real_escape_string($conn, $vititle);
        $vifilename = mysqli_real_escape_string($conn, $vifilename);

        // Check if file upload was successful
        if ($vifilename) {
            // Use prepared statement to prevent SQL injection
            $query = "INSERT INTO res_video_db (prid, vititle, vifilename) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);

            // Bind parameters
            mysqli_stmt_bind_param($stmt, "iss", $prid, $vititle, $vifilename);

            // Execute the statement
            $success = mysqli_stmt_execute($stmt);

            // Check if the query was successful
            if ($success) {
                // Get the ID of the last inserted record
                $viid = mysqli_insert_id($conn);

                // Get the file extension
                $fileExtension = pathinfo($vifilename, PATHINFO_EXTENSION);

                // Generate the new filename with viid appended at the end
                $newFilename = $vifilename . "_" . $viid . "." . $fileExtension;

                // Rename the file in the directory
                $sourcePath = $uploadDirectory . $vifilename;
                $targetPath = $uploadDirectory . $newFilename;

                if (rename($sourcePath, $targetPath)) {
                    // Update the filename in the database
                    $updateQuery = "UPDATE res_video_db SET vifilename = ? WHERE viid = ?";
                    $updateStmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($updateStmt, "si", $newFilename, $viid);
                    mysqli_stmt_execute($updateStmt);

                    // Check if the filename was updated successfully
                    if (mysqli_stmt_affected_rows($updateStmt) > 0) {
                        echo "Data inserted successfully!";
                        header("Location: http://localhost/FCMS/FCMSystem/suprojectvideo.php");
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
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>File & Content Management System | Add Video</title>

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
        $GLOBALS['value'] = "VIDEOS";
        include("sunavbar.php");
        include("connect.php");
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Add Video</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./suprojectvideo.php">
                                        <h5><u>&lt;&lt; Back</u></h5>
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
                                <!-- form start -->
                                <form id="quickForm" action="#" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputbuname">Video Title</label>
                                                    <input type="text" name="vititle" class="form-control" id="exampleInputbuname" placeholder="Enter Title" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Select Project</label><br>
                                                    <select class="form-control" name="viprid" required>
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
                                                <label>Video Content</label><br />
                                                <input type="file" class="btn btn-secondary btn" name="vicontent" id="fileToUpload" accept="video/*" capture="camera" required>
                                            </div>
                                        </div>
                                    </div><br>
                            </div>
                            <!-- /.card-body -->
                            <div style='text-align:center;'>
                                <button type='submit' class='btn btn-primary btn-lg' id='submit' name='addvideo'>Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
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

    <!-- jQuery -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/adminlte.min.js"></script>
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