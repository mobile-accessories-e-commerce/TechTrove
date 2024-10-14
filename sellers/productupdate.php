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
    $shippingCost = (int) $_POST['shipping_cost'];
    $imageLink = $_POST['image_link']; 
    $color = htmlspecialchars(trim($_POST['color']));
    $size = htmlspecialchars(trim($_POST['size']));
    $weight = (int) $_POST['weight'];
    $isFreeShipping = isset($_POST['is_free_shiping']) ? 1 : 0; 
    $productStatus = isset($_POST['product_status']) ? 1 : 0; 
    $categoryId = (int) $_POST['catogory_id'];

    
    if (empty($productName) || empty($description) || empty($brand) || empty($categoryId)) {
        die("Error: All fields are required!");
    }

    
    if (isset($_FILES['image_link']) && $_FILES['image_link']['error'] == UPLOAD_ERR_OK) {
       
        $uploadDir = 'uploads/'; 
        $uploadFile = $uploadDir . basename($_FILES['image_link']['name']);

        
        if (!move_uploaded_file($_FILES['image_link']['tmp_name'], $uploadFile)) {
            die("Error: Could not upload the image.");
        }
    }

  
    $stmt = $con->prepare("UPDATE products SET 
                            product_name = ?, 
                            description = ?, 
                            price = ?, 
                            brand = ?, 
                            stock_quantity = ?, 
                            shipping_cost = ?, 
                            image_link = ?, 
                            color = ?, 
                            size = ?, 
                            weight = ?, 
                            is_free_shiping = ?, 
                            product_status = ?, 
                            catogory_id = ? 
                            WHERE product_id = ?"); 

    
    $productId = (int)$_POST['product_id']; 

    
    $stmt->bind_param("ssisiisssiiiii", $productName, $description, $price, $brand, $stockQuantity, $shippingCost, $imageLink, $color, $size, $weight, $isFreeShipping, $productStatus, $categoryId, $productId);
    
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
