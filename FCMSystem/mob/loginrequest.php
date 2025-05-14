<?php
if(isset($_POST['mobile']) && isset($_POST['password'])) {

    require_once "connect.php";
    require_once "validate.php";
    $bumobile = validate($_POST['mobile']);
    $bupassword = validate($_POST['password']);
    $sql = "SELECT * FROM cus_business_users WHERE bumobile = '$bumobile' AND bupassword = '$bupassword'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        $response = array("message" => "success");
        echo json_encode($response);
    } else {
        $response = array("message" => "failed");
        echo json_encode($response);
    }
}
?>
