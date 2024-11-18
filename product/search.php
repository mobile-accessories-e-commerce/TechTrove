<?php
include "../connect.php";

if (isset($_GET['query'])) {
    $searchTerm = $_GET['query'];
    $productList = array();


    $query = "SELECT p.product_name,p.price,p.image_link,p.product_id,p.stock_quantity,pro.discount,pro.price_after_discount FROM products p 
     LEFT JOIN promotions pro ON p.product_id = pro.product_id
      WHERE p.product_name LIKE ?";
    $stmt = mysqli_prepare($con, $query);


    $searchTerm = '%' . $searchTerm . '%';
    mysqli_stmt_bind_param($stmt, 's', $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);


    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($productList, $row);
        }
    } else {
        array_push($productList,"false");
    }
    echo json_encode($productList);

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>