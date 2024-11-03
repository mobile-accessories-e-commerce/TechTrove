<?php
session_start();
include '../connect.php';



$product_list = array();
if (isset($_GET['query'])) {
    $searchTerm = $_GET['query'];
    $serviceList = array();

    $cat_id = $searchTerm;

    if($cat_id=="none"){
        $service_query = "
        SELECT *
        FROM services s
        JOIN service_catogory sc ON s.catogory_id = sc.service_cat_id
        
       
    ";
    }else{
    $service_query = "
    SELECT *
        FROM services s
        JOIN service_catogory sc ON s.catogory_id = sc.service_cat_id
    WHERE sc.service_cat_id = '$cat_id';
";
    }

    $services_result = $con->query($service_query);



    while ($row = mysqli_fetch_assoc($services_result)) {
        array_push($serviceList, $row);
    }

    echo json_encode($serviceList);

}
?>