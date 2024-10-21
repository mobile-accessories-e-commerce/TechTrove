<?php
include "../connect.php";

if($_SERVER['REQUEST_METHOD']==='GET'){
    $order_item_id = $_GET['order_item_id'];
    $quary = "SELECT order_status FROM order_items WHERE item_id='$order_item_id'";
    $result = mysqli_query($con,$quary);
    $row = mysqli_fetch_assoc($result);

    $status = $row['order_status'];

    echo json_encode($status);
}




?>