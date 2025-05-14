<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: http://localhost/FCMS/FCMSystem/businesslogin.php");
exit;
?>
