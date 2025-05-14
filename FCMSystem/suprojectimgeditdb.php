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
include "connect.php";

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

if (isset($_POST['editimg'])) {
    $id = $_POST['editimg'];
    $prid = $_POST['imprid'];
    $imtitle = $_POST['imtitle'];
    $oldimfilename = $_POST['oldimfilename'];

    // UPDATE table_name SET column1=value1, column2=value2 WHERE condition
    $query = "UPDATE res_image_db SET prid = '$prid', imtitle = '$imtitle' WHERE imid = '$id'";
    $data = mysqli_query($conn, $query);

    // Check if a file was uploaded
    if ($_FILES['imcontent']['size'] > 0) {
        // Define allowed image file extensions
        $allowedImageExtensions = array("jpg", "jpeg", "png");

        // Move the uploaded file to the specified directory
        $uploadDirectory = "Images/"; // Change this to your desired location
        $imfilename = moveUploadedFile($_FILES["imcontent"], $uploadDirectory, $allowedImageExtensions);

        if ($imfilename !== false) {
            // Update the database with the new image filename
            $updateFilenameQuery = "UPDATE res_image_db SET imfilename = '$imfilename' WHERE imid = '$id'";
            mysqli_query($conn, $updateFilenameQuery);
            header("Location: http://localhost/FCMS/FCMSystem/suprojectimg.php");
            echo "Image uploaded and updated successfully.";
        } else {
            echo "Error uploading the image.".mysqli_error($conn);;
        }
    } else {
        header("Location: http://localhost/FCMS/FCMSystem/suprojectimg.php");
        // No file uploaded, only update title and project name
        echo "No file uploaded. Title and project name updated successfully.";
    }
}

