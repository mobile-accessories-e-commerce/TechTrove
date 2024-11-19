<?php
include "../connect.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id']; // Seller ID

    // Query to calculate total orders, total revenue, total customers, and total products sold for a specific seller
    $sql = "
        SELECT 
            COUNT(DISTINCT oi.order_id) AS total_orders,
            SUM(oi.price * oi.quantity) AS total_revenue,
            COUNT(DISTINCT oi.shipping_detail_id) AS total_customers,
            SUM(oi.quantity) AS total_products_sold
        FROM order_items oi
        JOIN products p ON oi.product_id = p.product_id
        WHERE p.seller_id = $id
    ";

    $result = mysqli_query($con, $sql);
    $report_data = mysqli_fetch_assoc($result);

    // Display report in a table format
    if ($report_data) {
        $total_orders = $report_data['total_orders'];
        $total_revenue = $report_data['total_revenue'];
        $total_customers = $report_data['total_customers'];
        $total_products_sold = $report_data['total_products_sold'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Report</title>
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

<h2>Seller Report for Seller ID: <?php echo $id; ?></h2>

<!-- Table displaying the seller report data -->
<table>
    <thead>
        <tr>
            <th>Metric</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Total Orders</td>
            <td><?php echo $total_orders; ?></td>
        </tr>
        <tr>
            <td>Total Revenue</td>
            <td><?php echo number_format($total_revenue, 2); ?> USD</td>
        </tr>
        <tr>
            <td>Total Customers</td>
            <td><?php echo $total_customers; ?></td>
        </tr>
        <tr>
            <td>Total Products Sold</td>
            <td><?php echo $total_products_sold; ?></td>
        </tr>
    </tbody>
</table>

<!-- Button to trigger the download -->
<button class="action-btn" onclick="window.print()">Download Report</button>

</body>
</html>
        