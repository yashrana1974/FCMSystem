<?php
session_start();
?>

<?php
include("connect.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the ID from the form
    $id = $_POST["signin"];

    $spmobile = $_POST["spmobile"];
    $sppassword = $_POST["sppassword"];

    $spmobile = mysqli_real_escape_string($conn, $spmobile);
    $sppassword = mysqli_real_escape_string($conn, $sppassword);

    // Perform the query
    $LoginQuery = "SELECT spid, spmobileadmin, sppasswordadmin, spname FROM res_super_admin WHERE spmobileadmin = (?) AND sppasswordadmin = (?)";
    $stmt = mysqli_prepare($conn, $LoginQuery);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $spmobile, $sppassword);

    // Execute the statement
    $success = mysqli_stmt_execute($stmt);

    // Check if the query returned any results
    mysqli_stmt_store_result($stmt);
    
    // Check if the query returned any results
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $spid, $spmobileadmin, $sppasswordadmin, $spname);

        // Fetch the result
        mysqli_stmt_fetch($stmt);

        // Set session variables
        $_SESSION["spid"] = $spid;
        $_SESSION["spname"] = $spname;
        $_SESSION["spmobileadmin"] = $spmobileadmin;
        $_SESSION["sppasswordadmin"] = $sppasswordadmin;

        header("Location: http://localhost/FCMS/FCMSystem/spdashboard.php");
        exit();
    } else {
        $error = -1;
        header("Location: http://localhost/FCMS/FCMSystem/index2.php?error=$error");
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

    // if ($LoginData = mysqli_num_rows($LoginResult)) {

    //     ob_start();
    //     // This will redirect to https://www.example.com after 5 seconds
    //     echo "<meta http-equiv='refresh' content='1;url=http://localhost/FCMS/FCMSystem/spdashboard.php'>";
    //     // Flush the buffer
    //     ob_flush();
    // } else {
    //     $error = -1;
    //     ob_start();
    //     // This will redirect to https://www.example.com after 5 seconds
    //     echo "<meta http-equiv='refresh' content='1;url=http://localhost/FCMS/FCMSystem/index2.php?error=$error'>";
    //     // Flush the buffer
    //     ob_flush();
    // }

    // Close statement