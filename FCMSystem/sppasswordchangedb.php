<?php
session_start();
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the ID from the form
    $id = $_POST["change"];

    $spmobileadmin = $_POST["spmobileadmin"];
    $sppasswordadmin = $_POST["sppasswordadmin"];
    $newsppassword = $_POST["newsppassword"];
    $retypesppassword = $_POST["retypesppassword"];

    $spmobileadmin = mysqli_real_escape_string($conn, $spmobileadmin);
    $sppasswordadmin = mysqli_real_escape_string($conn, $sppasswordadmin);
    $newsppassword = mysqli_real_escape_string($conn, $newsppassword);
    $retypesppassword = mysqli_real_escape_string($conn, $retypesppassword);

    // Perform the query
    $LoginQuery = "SELECT spid, spname, spmobileadmin, sppasswordadmin FROM res_super_admin WHERE spmobileadmin = ? AND sppasswordadmin = ?";
    $stmt = mysqli_prepare($conn, $LoginQuery);

    // Check if prepare statement succeeded
    if (!$stmt) {
        $error = mysqli_error($conn);
        header("Location: http://localhost/fCMS/FCMSystem/sppasswordchange.php?error=$error");
        exit();
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $spmobileadmin, $sppasswordadmin);

    // Execute the statement
    $success = mysqli_stmt_execute($stmt);

    // Check for execution errors
    if (!$success) {
        $error = mysqli_error($conn);
        header("Location: http://localhost/fCMS/FCMSystem/sppasswordchange.php?error=$error");
        exit();
    }

    // Fetch the result
    mysqli_stmt_store_result($stmt);

    // Check if the query returned any results
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $spid, $spname, $spmobileadmin, $sppasswordadmin);

        // Fetch the result
        mysqli_stmt_fetch($stmt);

        if ($newsppassword == $retypesppassword) {
            // Update query
            $updateQuery = "UPDATE res_super_admin SET sppasswordadmin = ? WHERE spid = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);

            // Check if prepare statement succeeded
            if (!$updateStmt) {
                $error = mysqli_error($conn);
                header("Location: http://localhost/fCMS/FCMSystem/sppasswordchange.php?error=$error");
                exit();
            }

            // Bind parameters
            mysqli_stmt_bind_param($updateStmt, "si", $newsppassword, $spid);

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
                header("Location: http://localhost/fCMS/FCMSystem/index2.php");
                exit();
            } else {
                $error = mysqli_error($conn);
                header("Location: http://localhost/fCMS/FCMSystem/sppasswordchange.php?error=$error");
                exit();
            }
        } else {
            // Passwords don't match
            $error = "Passwords do not match.";
            header("Location: http://localhost/fCMS/FCMSystem/sppasswordchange.php?error=$error");
            exit();
        }
    } else {
        // Login credentials incorrect
        $error = "Invalid login credentials.";
        header("Location: http://localhost/fCMS/FCMSystem/sppasswordchange.php?error=$error");
        exit();
    }
} else {
    // Invalid request method
    $error = "Invalid request method.";
    header("Location: http://localhost/fCMS/FCMSystem/sppasswordchange.php?error=$error");
    exit();
}

// Close statement
mysqli_stmt_close($stmt);
