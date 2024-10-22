<?php
include "../connect.php";

if($_SERVER['REQUEST_METHOD']==='GET'){
    $product_id = $_GET['product_id'];

    $quary = "DELETE  FROM products WHERE product_id='$product_id'";
    $result = mysqli_query($con,$quary);
    if($result){
        header("location:sellerdashbord.php");
    }
}






?>