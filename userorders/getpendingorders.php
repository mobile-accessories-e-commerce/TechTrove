<?php
include "../connect.php";
session_start();

if (!isset($_SESSION['userid'])) {
    header("location:../authentication/loging.php");
    exit;
} else {
    $user_id = $_SESSION['userid'];
}

// Retrieve pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$offset = ($page - 1) * $limit;

// Array to store order data and metadata
$response = [
    'orders' => [],
    'total' => 0,
    'page' => $page,
    'limit' => $limit
];

// Get the total number of pending and shipped orders
$totalQuery = "SELECT COUNT(*) as total FROM order_items AS oi
JOIN orders AS o ON oi.order_id = o.order_id
JOIN carts AS c ON o.cart_id = c.cart_id
WHERE c.user_id = '$user_id' AND (order_status='pending' OR order_status='shiped')";
$totalResult = mysqli_query($con, $totalQuery);
if ($totalResult) {
    $totalRow = mysqli_fetch_assoc($totalResult);
    $response['total'] = $totalRow['total'];
}

// Fetch paginated order data
$query = "SELECT * FROM order_items AS oi
JOIN orders AS o ON oi.order_id = o.order_id
JOIN carts AS c ON o.cart_id = c.cart_id
JOIN products AS p ON oi.product_id = p.product_id
WHERE c.user_id = '$user_id' AND (order_status='pending' OR order_status='shiped')
ORDER BY ordered_data DESC
LIMIT $limit OFFSET $offset";

$result = mysqli_query($con, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $response['orders'][] = $row;
    }
}

// Output JSON response
echo json_encode($response);
?>
