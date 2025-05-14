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
  <title>File & Content Management System | View Project Details</title>

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
    $GLOBALS['value'] = "User_Management";
    include("bunavbar.php");
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Project Details</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="./buprojectmanagement.php"><h5><u><< Back</u></h5></a></li>
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
                <?php
                include("connect.php");

                if (isset($_GET['viewproject'])) {
                  $id = $_GET["viewproject"];

                  // Fetch data from the database based on the project ID
                  $query = "SELECT * FROM res_project_db WHERE prid = '$id'";
                  $result = mysqli_query($conn, $query);

                  $query2 = "SELECT buid FROM cus_assigned_users WHERE prid = '$id'";
                  $result2 = mysqli_query($conn, $query2);

                  if ($result) {
                    $userData = mysqli_fetch_array($result);

                    echo "<form id='quickForm' action='#' method='POST'>
                  <div class='card-body'>
                    <div class='row'>
                      <div class='col-md-6'>
                        <label for='exampleInputbuname'>Project Name</label>
                        <input type='text' name='prname' class='form-control' id='exampleInputbuname' placeholder='Enter project name' value='" . $userData['prname'] . "' disabled>
                      </div>
                    </div><br/>";

                    if (mysqli_num_rows($result2) > 0) {
                      echo "<div class='row'>
                      <div class='col-md-6'>
                        <label for='exampleInputbuname'>Staff Assigned</label>";

                      while ($userData2 = mysqli_fetch_array($result2)) {
                        $buid = $userData2['buid'];

                        $query3 = "SELECT buname FROM cus_business_users WHERE buid = $buid";
                        $result3 = mysqli_query($conn, $query3);

                        if ($result3) {
                          while ($userData3 = mysqli_fetch_array($result3)) {
                            echo "<input type='text' name='subuid' class='form-control' id='exampleInputbuname'  value='" . $userData3['buname'] . "' disabled>";
                          }
                        }
                      }
                      echo "</div>
                    </div>";
                    }

                    echo "</div>
              <!-- /.card-body -->
              <div class='form-group'>
              </div>
              </form>";
                  }
                }
                ?>
              </div>
              <!-- /.card -->
            </div>
           
