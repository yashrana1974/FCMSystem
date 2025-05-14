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
<?php
include("connect.php");

if ($_POST['edituser']) {
    $buid = $_POST['buid'];
    $buname = $_POST['buname'];
    $bumobile = $_POST['bumobile'];
    $buemail = $_POST['buemail'];
    $bupassword = $_POST['bupassword'];
    $bucompanyname = $_POST['bucompanyname'];
    $bucompanyaddress = $_POST['bucompanyaddress'];
    $butype = "staff";
    $buunderadmin = $_SESSION['buid'];
    echo $bupassword;
    $query = "UPDATE cus_business_users
    SET buname = '$buname', bupassword = '$bupassword', bumobile = '$bumobile', buemail = '$buemail', bucompanyname = '$bucompanyname', bucompanyaddress = '$bucompanyaddress', butype = '$butype', buunderadmin = '$buunderadmin'
    WHERE buid = '$buid'
    ";

    $data = mysqli_query($conn, $query);

    if ($data) {
        header("Location: http://localhost/FCMS/FCMSystem/bubusiness.php");
        exit();
    } else {
        // Handle deletion failure
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
