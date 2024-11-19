<?php
include "../connect.php";
session_start();

if (!isset($_SESSION['userid'])) {
    header("location:../authentication/loging.php");
    exit();
}

$user_id = $_SESSION['userid'];

// Default pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$offset = ($page - 1) * $limit;

$order_list = array();

// Fetch total number of orders for the user
$totalQuery = "
    SELECT COUNT(*) AS total 
    FROM order_items AS oi
    JOIN orders AS o ON oi.order_id = o.order_id
    JOIN carts AS c ON o.cart_id = c.cart_id
    JOIN products AS p ON oi.product_id = p.product_id
    WHERE c.user_id = $user_id AND order_status = 'complete'
";
$totalResult = mysqli_query($con, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalOrders = $totalRow['total'];

// Fetch paginated orders
$query = "
    SELECT * 
    FROM order_items AS oi
    JOIN orders AS o ON oi.order_id = o.order_id
    JOIN carts AS c ON o.cart_id = c.cart_id
    JOIN products AS p ON oi.product_id = p.product_id
    WHERE c.user_id = $user_id AND order_status = 'complete'
    ORDER BY ordered_data DESC
    LIMIT $limit OFFSET $offset
";

$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($order_list, $row);
    }
}

// Return the data as JSON, including pagination info
echo json_encode([
    'orders' => $order_list,
    'total' => $totalOrders,
    'page' => $page,
    'limit' => $limit
]);
?>
