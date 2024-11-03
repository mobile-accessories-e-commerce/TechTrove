<?php
include "../connect.php";
if($_SERVER['REQUEST_METHOD']=='GET'){
    $service_request_id = $_GET['service_request_id'];
$accept =1;
    $sql = "UPDATE service_requests SET accept='$accept' WHERE id='$service_request_id'";
    $result = mysqli_query($con,$sql);
    header("location:servicedashbord.php");
}


?>