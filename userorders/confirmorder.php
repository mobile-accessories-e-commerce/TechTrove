<?php 
include '../connect.php';
if($_SERVER['REQUEST_METHOD']==='GET'){
    $order_id = $_GET['order_item_id'];

    $quary = "UPDATE order_items SET order_status='complete' WHERE item_id='$order_id'";
    $result = mysqli_query($con,$quary);
    if($result){
        echo json_encode("sucsuss");
    }
}


?>