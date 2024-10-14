<?php
// updateQuantity.php

include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    
    // Validate and sanitize input
    $itemId = intval($itemId);
    $quantity = intval($quantity);

    // Assuming you have a function or query to update the quantity in the database
    $query = "UPDATE cart_product_items SET quantity = ? WHERE item_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ii', $quantity, $itemId);
    
    if ($stmt->execute()) {
        echo 'Quantity updated successfully';
    } else {
        echo 'Error updating quantity';
    }
}
?>
