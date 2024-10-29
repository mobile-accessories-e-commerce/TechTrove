<?php
include "../connect.php";
session_start();

if (!isset($_SESSION['userid'])) {
    header("location:../authentication/loging.php");
    exit();
} else {
    $user_id = $_SESSION['userid'];
}

// Initialize response data
$response = [
    "total_orders" => 0,
    "pending_orders" => 0,
    "completed_orders" => 0,
    "total_cost" => 0
];

// Get total orders
$total_orders_query = "
    SELECT COUNT(DISTINCT oi.order_id) AS total_orders, 
           SUM(p.price * oi.quantity) AS total_cost
     FROM order_items AS oi
    JOIN orders AS o ON oi.order_id = o.order_id
    JOIN carts AS c ON o.cart_id = c.cart_id
    JOIN products AS p ON oi.product_id = p.product_id
    WHERE c.user_id = '$user_id'
";
$total_result = mysqli_query($con, $total_orders_query);
if ($row = mysqli_fetch_assoc($total_result)) {
    $response["total_orders"] = $row["total_orders"];
    $response["total_cost"] = $row["total_cost"];
}

// Get completed orders count
$completed_query = "
    SELECT COUNT(DISTINCT oi.order_id) AS completed_orders
    FROM order_items AS oi
    JOIN orders AS o ON oi.order_id = o.order_id
    JOIN carts AS c ON o.cart_id = c.cart_id
    WHERE c.user_id = '$user_id' AND oi.order_status = 'complete'
";
$completed_result = mysqli_query($con, $completed_query);
if ($row = mysqli_fetch_assoc($completed_result)) {
    $response["completed_orders"] = $row["completed_orders"];
}

// Get pending orders count
$pending_query = "
    SELECT COUNT(DISTINCT oi.order_id) AS pending_orders
    FROM order_items AS oi
    JOIN orders AS o ON oi.order_id = o.order_id
    JOIN carts AS c ON o.cart_id = c.cart_id
    WHERE c.user_id = '$user_id' AND (oi.order_status = 'pending' OR oi.order_status = 'shipped')
";
$pending_result = mysqli_query($con, $pending_query);
if ($row = mysqli_fetch_assoc($pending_result)) {
    $response["pending_orders"] = $row["pending_orders"];
}

// Send the response as JSON
echo json_encode($response);
?>
