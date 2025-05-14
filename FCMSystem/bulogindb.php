<?php
session_start();
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the ID from the form
    $id = $_POST["signin"];

    $bumobile = $_POST["bumobile"];
    $bupassword = $_POST["bupassword"];

    $bumobile = mysqli_real_escape_string($conn, $bumobile);
    $bupassword = mysqli_real_escape_string($conn, $bupassword);

    // Perform the query
    $LoginQuery = "SELECT buid, buname, bumobile, buemail, bupassword, bucompanyname, bucompanyaddress, butype, buunderadmin, bustatus FROM cus_business_users WHERE bumobile = ? AND bupassword = ?";
    $stmt = mysqli_prepare($conn, $LoginQuery);

    // Check if prepare statement succeeded
    if (!$stmt) {
        $error = mysqli_error($conn);
        header("Location: http://localhost/fCMS/FCMSystem/businesslogin.php?error=$error");
        exit();
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $bumobile, $bupassword);

    // Execute the statement
    $success = mysqli_stmt_execute($stmt);

    // Check for execution errors
    if (!$success) {
        $error = mysqli_error($conn);
        header("Location: http://localhost/fCMS/FCMSystem/businesslogin.php?error=$error");
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

        if ($bustatus == 1) {
            if ($buunderadmin != 0) {
                header("Location: http://localhost/fCMS/FCMSystem/sudashboard.php");
                // Set session variables
                $_SESSION["suid"] = $buid;
                $_SESSION["suname"] = $buname;
                $_SESSION["sumobile"] = $bumobile;
                $_SESSION["suemail"] = $buemail;
                $_SESSION["supassword"] = $bupassword;
                $_SESSION["sucompanyname"] = $bucompanyname;
                $_SESSION["sucompanyaddress"] = $bucompanyaddress;
                $_SESSION["sutype"] = $butype;
                $_SESSION["suunderadmin"] = $buunderadmin;
                $_SESSION["sustatus"] = $bustatus;
                exit();
            } else {
                header("Location: http://localhost/fCMS/FCMSystem/budashboard.php");
                // Set session variables
                $_SESSION["buid"] = $buid;
                $_SESSION["buname"] = $buname;
                $_SESSION["bumobile"] = $bumobile;
                $_SESSION["buemail"] = $buemail;
                $_SESSION["bupassword"] = $bupassword;
                $_SESSION["bucompanyname"] = $bucompanyname;
                $_SESSION["bucompanyaddress"] = $bucompanyaddress;
                $_SESSION["butype"] = $butype;
                $_SESSION["buunderadmin"] = $buunderadmin;
                $_SESSION["bustatus"] = $bustatus;
                exit();
            }
        } else {
            $error = -1;
            header("Location: http://localhost/fCMS/FCMSystem/businesslogin.php?error=$error");
            exit();
        }
    } else {
        $error = -1;
        header("Location: http://localhost/fCMS/FCMSystem/businesslogin.php?error=$error");
        exit();
    }

}
// Close statement
mysqli_stmt_close($stmt);
