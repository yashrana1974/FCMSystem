<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "fcms";

$conn = mysqli_connect($host, $username, $password, $dbname);

if ($conn) {
} else {
    echo "Connection Failed" . mysqli_connect_error();
}
