<?php 
include "../connect.php";
session_start();

$sql = "SELECT * FROM invalid_search_quary WHERE type='product' ORDER BY date DESC LIMIT 15 ";
$result = mysqli_query($con,$sql);
$product_keyword_list = array();
while($row = mysqli_fetch_assoc($result)){
    array_push($product_keyword_list,$row);
}


$sql = "SELECT * FROM invalid_search_quary WHERE type='service'  ORDER BY date DESC LIMIT 15 ";
$result = mysqli_query($con,$sql);
$service_keyword_list = array();
while($row = mysqli_fetch_assoc($result)){
    array_push($service_keyword_list,$row);
}

$response = [
    'productKeyword' => $product_keyword_list,
    'serviceKeyword' => $service_keyword_list
];
echo json_encode($response);

?>