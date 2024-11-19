<?php
include "../connect.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id']; // Product ID

    // Query to calculate total orders, view count, rating, available stock, and seller info for a specific product
    $sql = "
        SELECT 
            p.product_id,
            p.product_name,
            p.view_count,
            p.rating,
            p.stock_quantity,
            s.seller_id,
            s.seller_name,
            COUNT(oi.order_id) AS total_orders
        FROM products p
        LEFT JOIN order_items oi ON p.product_id = oi.product_id
        LEFT JOIN sellers s ON p.seller_id = s.seller_id
        WHERE p.product_id = $id
        GROUP BY p.product_id, s.seller_id
    ";

    $result = mysqli_query($con, $sql);
    $report_data = mysqli_fetch_assoc($result);

    // Display report in a table format
    if ($report_data) {
        $product_name = $report_data['product_name'];
        $view_count = $report_data['view_count'];
        $rating = $report_data['rating'];
        $stock_quantity = $report_data['stock_quantity'];
        $seller_id = $report_data['seller_id'];
        $seller_name = $report_data['seller_name'];
        $total_orders = $report_data['total_orders'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #007BFF;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e2f1ff;
        }
        .action-btn {
            background-color: #007BFF;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .action-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Product Report for Product ID: <?php echo $id; ?></h2>

<!-- Table displaying the product report data -->
<table>
    <thead>
        <tr>
            <th>Metric</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Product Name</td>
            <td><?php echo $product_name; ?></td>
        </tr>
        <tr>
            <td>Total Orders</td>
            <td><?php echo $total_orders; ?></td>
        </tr>
        <tr>
            <td>View Count</td>
            <td><?php echo $view_count; ?></td>
        </tr>
        <tr>
            <td>Rating</td>
            <td><?php echo $rating; ?></td>
        </tr>
        <tr>
            <td>Available Stock</td>
            <td><?php echo $stock_quantity; ?></td>
        </tr>
        <tr>
            <td>Seller ID</td>
            <td><?php echo $seller_id; ?></td>
        </tr>
        <tr>
            <td>Seller Name</td>
            <td><?php echo $seller_name; ?></td>
        </tr>
    </tbody>
</table>

<!-- Button to trigger the download -->
<button class="action-btn" onclick="window.print()">Download Report</button>

</body>
</html>
