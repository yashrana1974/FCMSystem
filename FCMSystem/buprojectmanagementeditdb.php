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
include("connect.php");

if (isset($_POST['editproject'])) {
    $prid = $_POST['prid'];
    $prname = $_POST['prname'];

    // Update project name using prepared statement
    $updateQuery = "UPDATE res_project_db SET prname = ? WHERE prid = ?";
    $updateStmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "si", $prname, $prid);
    $data = mysqli_stmt_execute($updateStmt);
    mysqli_stmt_close($updateStmt);

    if ($data) {
        // Get the selected staff
        $selectedItems = isset($_POST['selectedItems']) ? $_POST['selectedItems'] : array();

        // Get existing assigned users using prepared statement
        $existingUsersQuery = "SELECT buid FROM cus_assigned_users WHERE prid = ?";
        $existingUsersStmt = mysqli_prepare($conn, $existingUsersQuery);
        mysqli_stmt_bind_param($existingUsersStmt, "i", $prid);
        mysqli_stmt_execute($existingUsersStmt);
        $existingUsersResult = mysqli_stmt_get_result($existingUsersStmt);

        if ($existingUsersResult) {
            $existingUsers = array();
            while ($row = mysqli_fetch_assoc($existingUsersResult)) {
                $existingUsers[] = $row['buid'];
            }

            // Remove users not selected anymore
            $usersToRemove = array_diff($existingUsers, $selectedItems);
            if (!empty($usersToRemove)) {
                $usersToRemoveString = implode(",", $usersToRemove);
                $deleteUsersQuery = "DELETE FROM cus_assigned_users WHERE prid = ? AND buid IN ($usersToRemoveString)";
                $deleteUsersStmt = mysqli_prepare($conn, $deleteUsersQuery);
                mysqli_stmt_bind_param($deleteUsersStmt, "i", $prid);
                mysqli_stmt_execute($deleteUsersStmt);
                mysqli_stmt_close($deleteUsersStmt);
            }

            // Add new users
            $newUsers = array_diff($selectedItems, $existingUsers);
            if (!empty($newUsers)) {
                foreach ($newUsers as $newUser) {
                    $insertUserQuery = "INSERT INTO cus_assigned_users (prid, buid) VALUES (?, ?)";
                    $insertUserStmt = mysqli_prepare($conn, $insertUserQuery);
                    mysqli_stmt_bind_param($insertUserStmt, "ii", $prid, $newUser);
                    mysqli_stmt_execute($insertUserStmt);
                    mysqli_stmt_close($insertUserStmt);
                }
            }

            header("Location: http://localhost/FCMS/FCMSystem/buprojectmanagement.php");
        } else {
            echo "Failed to fetch existing users!";
        }
    } else {
        echo "Failed to update project name!";
    }
} else {
    echo "Invalid request!";
}
?>
