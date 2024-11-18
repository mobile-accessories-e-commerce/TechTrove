<?php


include '../connect.php';


session_start();


//Get form detail about product and update
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $productName = htmlspecialchars(trim($_POST['product_name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = (int) $_POST['price'];
    $brand = htmlspecialchars(trim($_POST['brand']));
    $stockQuantity = (int) $_POST['stock_quantity'];
    

    if (empty($productName) || empty($description) || empty($brand)) {
        die("Error: All fields are required!");
    }


    $stmt = $con->prepare("UPDATE products SET 
                            product_name = ?, 
                            description = ?, 
                            price = ?, 
                            brand = ?, 
                            stock_quantity = ?, 
                            color = ? 
                            WHERE product_id = ?");


    $productId = (int) $_POST['product_id'];


    $stmt->bind_param("ssisisi", $productName, $description, $price, $brand, $stockQuantity, $color, $productId);

    if ($stmt->execute()) {

        header("Location:sellerdashbord.php");
        exit;
    } else {
        die("Error: Could not update product. " . $stmt->error);
    }


    $stmt->close();
    $con->close();
} else {

    die("Error: Invalid request.");
}
?>