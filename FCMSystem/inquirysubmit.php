<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include('connect.php');
  //rpdate, rpsubject, rpdescription
  $inqdate = $_POST['timeanddate'];
  $inqname = $_POST['name'];
  $inqemail = $_POST['email'];
  $inqmobile = $_POST['mobile'];
  echo $inqmobile;
  $inqsubject = $_POST['subject']; // Add '#' prefix to the title
  $inqmessage = $_POST['message'];

  // Escape user inputs for security
  $inqname = mysqli_real_escape_string($conn, $inqname);
  $inqemail = mysqli_real_escape_string($conn, $inqemail);
  $inqmobile = mysqli_real_escape_string($conn, $inqmobile);
  $inqsubject = mysqli_real_escape_string($conn, $inqsubject);
  $inqmessage = mysqli_real_escape_string($conn, $inqmessage);

  $query = "INSERT INTO res_inquiry_db (inqdate, inqname, inqemail, inqmobile, inqsubject, inqmessage) VALUES('$inqdate', '$inqname', '$inqemail',  '$inqmobile', '$inqsubject', '$inqmessage')";
  $data = mysqli_query($conn, $query);

  if($data){
    //redirect to the bureports.php page
    header('Location: http://localhost/FCMS/FCMSystem/index.html');
    exit();
  }
  else {
    echo "Inquiry not submited".mysqli_error($conn);
  }
}
