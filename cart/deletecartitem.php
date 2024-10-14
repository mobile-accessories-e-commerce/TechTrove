<?php
include "../connect.php";

if($_SERVER['REQUEST_METHOD']==="GET"){
    $item_id = $_GET['item_id'];

    $quary = "DELETE FROM cart_product_items WHERE item_id='$item_id'";
    $result = mysqli_query($con,$quary);
    if($result){
        header("location:cartlandingpage.php");
    }
    else{
        die("erro when deleting product");
    }
}



?>