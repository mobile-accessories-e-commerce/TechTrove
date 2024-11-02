<?php
include "../connect.php";
if (isset($_GET['product_id']) && isset($_GET['discount'])) {
    $product_id = (int)$_GET['product_id'];
    $discount = (float)$_GET['discount'];
    $end_date = $_GET['end_date'];

    $end_date = date('Y-m-d', strtotime($end_date)); 
    
    $productCheckQuery = "SELECT * FROM products WHERE product_id = $product_id";
    $productCheckResult = mysqli_query($con, $productCheckQuery);

    if (mysqli_num_rows($productCheckResult) > 0) {
       
        $checkQuery = "SELECT * FROM promotions WHERE product_id = $product_id";
        $checkResult = mysqli_query($con, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            
            $updateQuery = "UPDATE promotions SET discount = $discount,end_date=$end_date WHERE product_id = $product_id";
            if (mysqli_query($con, $updateQuery)) {
                echo json_encode(["status" => "success", "message" => "promotions updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating promotions: " . mysqli_error($con)]);
            }
        } else {
            
            $insertQuery = "INSERT INTO promotions (product_id, discount, start_date, end_date) 
                            VALUES ($product_id, $discount, CURDATE(), $end_date)";
            if (mysqli_query($con, $insertQuery)) {
                echo json_encode(["status" => "success", "message" => "promotions inserted successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error inserting promotions: " . mysqli_error($con)]);
            }
        }
    } else {
        
        echo json_encode(["status" => "error", "message" => "Error: The product_id does not exist in the products table."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Error: product_id and discount are required."]);
}

$con->close();
?>

