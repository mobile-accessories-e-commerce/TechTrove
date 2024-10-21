<?php
include "../connect.php";
session_start();

if(!isset($_SESSION['userid'])){
    header("location:../authentication/loging.php");
}else{
    $user_id = $_SESSION['userid'];
}

$order_list = array();
$quary = "SELECT * FROM order_items AS oi
JOIN orders AS o ON oi.order_id = o.order_id
JOIN products AS p ON oi.product_id = p.product_id
WHERE user_id = '$user_id' and (order_status='pending' or order_status='shiped')";

$result = mysqli_query($con,$quary);
if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
        array_push($order_list,$row);
    }
    echo json_encode($order_list); 
}else{
    echo json_encode($order_list);
}






?>