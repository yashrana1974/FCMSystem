<?php
session_start();
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the ID from the form
    $id = $_POST["change"];

    $bumobile = $_POST["bumobile"];
    $bupassword = $_POST["bupassword"];
    $newbupassword = $_POST["newbupassword"];
    $retypebupassword = $_POST["retypebupassword"];

    $bumobile = mysqli_real_escape_string($conn, $bumobile);
    $bupassword = mysqli_real_escape_string($conn, $bupassword);
    $newbupassword = mysqli_real_escape_string($conn, $newbupassword);
    $retypebupassword = mysqli_real_escape_string($conn, $retypebupassword);

    // Perform the query
    $LoginQuery = "SELECT buid, buname, bumobile, buemail, bupassword, bucompanyname, bucompanyaddress, butype, buunderadmin, bustatus FROM cus_business_users WHERE bumobile = ? AND bupassword = ?";
    $stmt = mysqli_prepare($conn, $LoginQuery);

    // Check if prepare statement succeeded
    if (!$stmt) {
        $error = mysqli_error($conn);
        header("Location: http://localhost/fCMS/FCMSystem/bupasswordchange.php?error=$error");
        exit();
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $bumobile, $bupassword);

    // Execute the statement
    $success = mysqli_stmt_execute($stmt);

    // Check for execution errors
    if (!$success) {
        $error = mysqli_error($conn);
        header("Location: http://localhost/fCMS/FCMSystem/bupasswordchange.php?error=$error");
        exit();
    }

    // Fetch the result
    mysqli_stmt_store_result($stmt);

    // Check if the query returned any results
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $buid, $buname, $bumobile, $buemail, $bupassword, $bucompanyname, $bucompanyaddress, $butype, $buunderadmin, $bustatus);

        // Fetch the result
        mysqli_stmt_fetch($stmt);

        if ($newbupassword == $retypebupassword) {
            // Update query
            $updateQuery = "UPDATE cus_business_users SET bupassword = ? WHERE buid = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);

            // Check if prepare statement succeeded
            if (!$updateStmt) {
                $error = mysqli_error($conn);
                header("Location: http://localhost/fCMS/FCMSystem/bupasswordchange.php?error=$error");
                exit();
            }

            // Bind parameters
            mysqli_stmt_bind_param($updateStmt, "si", $newbupassword, $buid);

            // Execute the statement
            $updateSuccess = mysqli_stmt_execute($updateStmt);

            // Check for execution errors
            if ($updateSuccess) {
                // Password updated successfully
                // Redirect to a success page or do something else
                // Unset all of the session variables
                $_SESSION = array();

                // Destroy the session
                session_destroy();
                header("Location: http://localhost/fCMS/FCMSystem/businesslogin.php");
                exit();
            } else {
                $error = mysqli_error($conn);
                header("Location: http://localhost/fCMS/FCMSystem/bupasswordchange.php?error=$error");
                exit();
            }
        } else {
            // Passwords don't match
            $error = "Passwords do not match.";
            header("Location: http://localhost/fCMS/FCMSystem/bupasswordchange.php?error=$error");
            exit();
        }
    } else {
        // Login credentials incorrect
        $error = "Invalid login credentials.";
        header("Location: http://localhost/fCMS/FCMSystem/bupasswordchange.php?error=$error");
        exit();
    }
} else {
    // Invalid request method
    $error = "Invalid request method.";
    header("Location: http://localhost/fCMS/FCMSystem/bupasswordchange.php?error=$error");
    exit();
}

// Close statement
mysqli_stmt_close($stmt);
