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

if (isset($_GET["deleteimg"])) {
    // Retrieve the ID from the form
    $id = $_GET["deleteimg"];

    // Retrieve the image imfilename from the database
    $getimfilenameQuery = "SELECT imfilename FROM res_image_db WHERE imid = '$id'";
    $getimfilenameResult = mysqli_query($conn, $getimfilenameQuery);

    if ($getimfilenameResult && mysqli_num_rows($getimfilenameResult) > 0) {
        $row = mysqli_fetch_assoc($getimfilenameResult);
        $imageimfilename = $row["imfilename"];

        // Construct the path to the image file
        $imagePath = "Images/" . $imageimfilename;

        // Perform the deletion query for the record
        $deleteRecordQuery = "DELETE FROM res_image_db WHERE imid = '$id'";
        $deleteRecordResult = mysqli_query($conn, $deleteRecordQuery);

        if ($deleteRecordResult) {
            // Deletion of record successful, now delete the image file
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image file
            }

            // Redirect after successful deletion
            header("Location: http://localhost/FCMS/FCMSystem/buprojectimg.php");
            exit();
        } else {
            // Handle deletion failure for the record
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        // Handle the case where no record is found for the given ID
        echo "Image not found for the given ID.";
    }
}

// Close the database connection
mysqli_close($conn);
?>
