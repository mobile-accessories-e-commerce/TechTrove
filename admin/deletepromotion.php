<?php
include "../connect.php";

if($_SERVER['REQUEST_METHOD']==='GET'){
    $product_id = $_GET['product_id'];
    $sql = "DELETE FROM promotions WHERE product_id ='$product_id'";
    $result = mysqli_query($con,$sql);
    if($result){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
}



?>