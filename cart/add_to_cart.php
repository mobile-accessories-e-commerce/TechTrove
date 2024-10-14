<?php
session_start();
include '../connect.php'; 


if (!isset($_SESSION['userid'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}


$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['product_id'];
$user_id = $_SESSION['userid'];


$cart_query = "SELECT cart_id FROM carts WHERE user_id = ?";
$stmt = $con->prepare($cart_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    
    $cart_row = $result->fetch_assoc();
    $cart_id = $cart_row['cart_id'];
} else {
    
    $create_cart_query = "INSERT INTO carts (user_id) VALUES (?)";
    $stmt = $con->prepare($create_cart_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $con->insert_id; 
}

$check_item_query = "SELECT * FROM cart_product_items WHERE cart_id = ? AND product_id = ?";
$stmt = $con->prepare($check_item_query);
$stmt->bind_param("ii", $cart_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    
    $update_query = "UPDATE cart_product_items SET quantity = quantity+ 1 WHERE cart_id = ? AND product_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("ii", $cart_id, $product_id);
    $stmt->execute();
} else {
    
    $insert_query = "INSERT INTO cart_product_items (cart_id, product_id, quantity) VALUES (?, ?, 1)";
    $stmt = $con->prepare($insert_query);
    $stmt->bind_param("ii", $cart_id, $product_id);
    $stmt->execute();
}

echo json_encode(['success' => true]);
?>
