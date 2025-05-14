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

if (isset($_GET["deleteproject"])) {
    // Retrieve the ID from the form
    $id = $_GET["deleteproject"];

    // Perform the deletion query
    // $deleteQuery = "DELETE FROM res_project_db WHERE prid = '$id'";
    // $deleteResult = mysqli_query($conn, $deleteQuery);
    // $deleteQuery2 = "DELETE FROM cus_assigned_users WHERE prid = '$id'";
    // $deleteResult2 = mysqli_query($conn, $deleteQuery2);
    // $deleteQuery3 = "DELETE FROM res_text_db WHERE prid = '$id'";
    // $deleteResult3 = mysqli_query($conn, $deleteQuery3);

    $deleteQuery = "DELETE res_project_db, cus_assigned_users, res_text_db, res_hashtag_db FROM res_project_db
    LEFT JOIN cus_assigned_users ON res_project_db.prid = cus_assigned_users.prid
    LEFT JOIN res_text_db ON res_project_db.prid = res_text_db.prid
    LEFT JOIN res_hashtag_db ON res_project_db.prid = res_hashtag_db.prid
    WHERE res_project_db.prid = '$id'";
    $deleteResult = mysqli_query($conn, $deleteQuery);


    if ($deleteResult) {
        if (isset($_GET["deleteimg"])) {
            // Retrieve the ID from the form
            $id = $_GET["deleteimg"];

            // Retrieve the image imfilename from the database
            $getimfilenameQuery = "SELECT imfilename FROM res_image_db WHERE prid = '$id'";
            $getimfilenameResult = mysqli_query($conn, $getimfilenameQuery);

            if ($getimfilenameResult && mysqli_num_rows($getimfilenameResult) > 0) {
                $row = mysqli_fetch_assoc($getimfilenameResult);
                $imageimfilename = $row["imfilename"];

                // Construct the path to the image file
                $imagePath = "Images/" . $imageimfilename;

                // Perform the deletion query for the image record
                $deleteImageRecordQuery = "DELETE FROM res_image_db WHERE prid = '$id'";
                $deleteImageRecordResult = mysqli_query($conn, $deleteImageRecordQuery);

                if ($deleteImageRecordResult) {
                    // Deletion of image record successful, now delete the image file
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Delete the image file
                    } else {
                        // Handle the case where the image file is not found
                        echo "Image file not found for the given ID.";
                    }
                } else {
                    // Handle deletion failure for the image record
                    echo "Error deleting image record: " . mysqli_error($conn);
                }
            } else {
                // Handle the case where no record is found for the given ID
                echo "Image not found for the given ID.";
            }

            // Retrieve the video vifilename from the database
            $getvifilenameQuery = "SELECT vifilename FROM res_video_db WHERE prid = '$id'";
            $getvifilenameResult = mysqli_query($conn, $getvifilenameQuery);

            if ($getvifilenameResult && mysqli_num_rows($getvifilenameResult) > 0) {
                $row = mysqli_fetch_assoc($getvifilenameResult);
                $videovifilename = $row["vifilename"];

                // Construct the path to the video file
                $videoPath = "Videos/" . $videovifilename;

                // Perform the deletion query for the video record
                $deletevideoRecordQuery = "DELETE FROM res_video_db WHERE prid = '$id'";
                $deletevideoRecordResult = mysqli_query($conn, $deletevideoRecordQuery);

                if ($deletevideoRecordResult) {
                    // Deletion of video record successful, now delete the video file
                    if (file_exists($videoPath)) {
                        unlink($videoPath); // Delete the video file
                    } else {
                        // Handle the case where the video file is not found
                        echo "video file not found for the given ID.";
                    }
                } else {
                    // Handle deletion failure for the video record
                    echo "Error deleting video record: " . mysqli_error($conn);
                }
            } else {
                // Handle the case where no record is found for the given ID
                echo "video not found for the given ID.";
            }
        }

        // Deletion successful
        header("Location: http://localhost/FCMS/FCMSystem/buprojectmanagement.php");
        exit();
    } else {
        // Handle deletion failure
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
// Close the database connection
mysqli_close($conn);
?>