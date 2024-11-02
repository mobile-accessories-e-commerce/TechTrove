<?php
session_start();
include '../connect.php';



$product_list = array();
if (isset($_GET['query'])) {
    $searchTerm = $_GET['query'];
    $productList = array();

    $cat_id = $searchTerm;

    if($cat_id=="none"){
        $products_query = "
        SELECT p.product_id, p.seller_id, p.product_name, p.description, p.price, p.image_link, pc.name AS category_name,pro.discount,pro.price_after_discount
        FROM products p
        JOIN product_catogory pc ON p.catogory_id = pc.product_cat_id
         LEFT JOIN promotions pro ON p.product_id = pro.product_id
       
    ";
    }else{
    $products_query = "
    SELECT p.product_id, p.seller_id, p.product_name, p.description, p.price, p.image_link, pc.name AS category_name,pro.discount,pro.price_after_discount
    FROM products p
    JOIN product_catogory pc ON p.catogory_id = pc.product_cat_id
     LEFT JOIN promotions pro ON p.product_id = pro.product_id
    WHERE pc.product_cat_id = '$cat_id';
";
    }

    $products_result = $con->query($products_query);



    while ($row = mysqli_fetch_assoc($products_result)) {
        array_push($product_list, $row);
    }

    echo json_encode($product_list);

}
?>