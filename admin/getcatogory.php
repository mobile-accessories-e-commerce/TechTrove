<?php 
include "../connect.php";   

$type = $_GET['type'];

$product_category_query = "SELECT product_cat_id, name FROM product_catogory";
$product_category_result = $con->query($product_category_query);
$product_category_list = array();
while($row=mysqli_fetch_assoc($product_category_result)){
    array_push($product_category_list,$row);
}


$service_category_query = "SELECT service_cat_id, name FROM service_catogory";
$service_category_result = $con->query($service_category_query);
$service_category_list = array();
while($row=mysqli_fetch_assoc($service_category_result)){
    array_push($service_category_list,$row);
}


$response = [
    'productCategories' => $product_category_list,
    'serviceCategories' => $service_category_list
];
echo json_encode($response);

?>