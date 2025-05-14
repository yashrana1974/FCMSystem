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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include('connect.php');
  $id = $_POST['report'];
  //trpsubject, trpdescription
  $trpdate = $_POST['trpdate'];
  $trpsubject = $_POST['trpsubject'];
  $trpdescription = $_POST['trpdescription']; // Add '#' prefix to the title
  $buid = $_SESSION['suid'];

  // Escape user inputs for security
  $trpdate = mysqli_real_escape_string($conn, $trpdate);
  $trpsubject = mysqli_real_escape_string($conn, $trpsubject);
  $trpdescription = mysqli_real_escape_string($conn, $trpdescription);
  $buid = mysqli_real_escape_string($conn, $buid);

  $query = "INSERT INTO res_taskreport_db (trpdate, trpsubject, trpdescription, buid) VALUES('$trpdate', '$trpsubject', '$trpdescription', '$buid')";
  $data = mysqli_query($conn, $query);

  if($data){
    //redirect to the bureports.php page
    header('Location: http://localhost/FCMS/FCMSystem/sureports.php');
    exit();
  }
  else {
    echo "Report not submited".mysqli_error($conn);
  }
}
