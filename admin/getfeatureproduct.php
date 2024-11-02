<?php 
include "../connect.php";
session_start();

$sql = "SELECT * FROM featured_products";
$result = mysqli_query($con,$sql);
$product_list = array();
while($row = mysqli_fetch_assoc($result)){
    array_push($product_list,$row);
}

echo json_encode($product_list);

?>