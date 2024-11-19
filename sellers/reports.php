<?php

session_start();
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $report_type = $_GET['report_type'];
    $type = $_GET['type'];



    $seller_id = $_SESSION['seller_id'];
    $report_type = $_GET['report_type'];

    if (!isset($seller_id)) {
        echo json_encode(['error' => 'Seller not logged in']);
        exit();
    }

    if ($report_type == 'sales_reports') {

        if ($type == 'daily') {
            $query = "SELECT 
                SUM(oi.quantity) AS total_sales, 
                SUM(oi.price * oi.quantity) AS total_revenue, 
                COUNT(DISTINCT o.order_id) AS total_orders, 
                AVG(oi.price * oi.quantity) AS avg_order_value
              FROM order_items oi
              JOIN orders o ON oi.order_id = o.order_id
              JOIN products p ON oi.product_id = p.product_id
              WHERE p.seller_id = ? and DATE(oi.ordered_data) = CURDATE()";
        } elseif ($type == 'monthly') {
            $query = "SELECT 
            SUM(oi.quantity) AS total_sales, 
            SUM(oi.price * oi.quantity) AS total_revenue, 
            COUNT(DISTINCT o.order_id) AS total_orders, 
            AVG(oi.price * oi.quantity) AS avg_order_value
          FROM order_items oi
          JOIN orders o ON oi.order_id = o.order_id
          JOIN products p ON oi.product_id = p.product_id
          WHERE p.seller_id = ? and MONTH(oi.ordered_data) = MONTH(CURDATE())";
        } elseif ($type == 'yearly') {
            $query = "SELECT 
            SUM(oi.quantity) AS total_sales, 
            SUM(oi.price * oi.quantity) AS total_revenue, 
            COUNT(DISTINCT o.order_id) AS total_orders, 
            AVG(oi.price * oi.quantity) AS avg_order_value
          FROM order_items oi
          JOIN orders o ON oi.order_id = o.order_id
          JOIN products p ON oi.product_id = p.product_id
          WHERE p.seller_id = ? and YEAR(oi.ordered_data) = YEAR(CURDATE())";
        } else {
            $query = "SELECT 
            SUM(oi.quantity) AS total_sales, 
            SUM(oi.price * oi.quantity) AS total_revenue, 
            COUNT(DISTINCT o.order_id) AS total_orders, 
            AVG(oi.price * oi.quantity) AS avg_order_value
          FROM order_items oi
          JOIN orders o ON oi.order_id = o.order_id
          JOIN products p ON oi.product_id = p.product_id
          WHERE p.seller_id = ?";
        }



        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $seller_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $report = $result->fetch_assoc();

        } else {
            //error massage
        }
    }

    if ($report_type == 'product_reports') {

        if ($type == 'daily') {


            $query = "SELECT p.product_name, 
       p.view_count, 
       p.stock_quantity, 
       SUM(oi.quantity) AS total_orders, 
       SUM(oi.price * oi.quantity) AS total_revenue
FROM products p
LEFT JOIN order_items oi ON p.product_id = oi.product_id
WHERE p.seller_id = ? and DATE(oi.ordered_data) = CURDATE()
GROUP BY p.product_id
";
        } elseif ($type == 'monthly') {
            $query = "SELECT p.product_name, 
    p.view_count, 
    p.stock_quantity, 
    SUM(oi.quantity) AS total_orders, 
    SUM(oi.price * oi.quantity) AS total_revenue
FROM products p
LEFT JOIN order_items oi ON p.product_id = oi.product_id
WHERE p.seller_id = ? and MONTH(oi.ordered_data) = MONTH(CURDATE())
GROUP BY p.product_id
";
        } elseif ($type == 'yearly') {
            $query = "SELECT p.product_name, 
    p.view_count, 
    p.stock_quantity, 
    SUM(oi.quantity) AS total_orders, 
    SUM(oi.price * oi.quantity) AS total_revenue
FROM products p
LEFT JOIN order_items oi ON p.product_id = oi.product_id
WHERE p.seller_id = ? and YEAR(oi.ordered_data) = YEAR(CURDATE())
GROUP BY p.product_id
";
        } else {
            $query = "SELECT p.product_name, 
            p.view_count, 
            p.stock_quantity, 
            SUM(oi.quantity) AS total_orders, 
            SUM(oi.price * oi.quantity) AS total_revenue
        FROM products p
        LEFT JOIN order_items oi ON p.product_id = oi.product_id
        WHERE p.seller_id = ? 
        GROUP BY p.product_id
        ";
        }
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $seller_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product_report = array();

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($product_report, $row);
        }



    }

    if ($report_type == 'customer_reports') {

        if ($type == 'daily') {
            $query = "SELECT 
                COUNT(DISTINCT u.user_id) AS total_customers,
                COUNT(o.order_id) AS total_orders,
                SUM(oi.price * oi.quantity) AS total_revenue
              FROM users u
              LEFT JOIN carts c ON c.user_id = u.user_id
              LEFT JOIN orders o ON c.cart_id = o.cart_id
              LEFT JOIN order_items oi ON o.order_id = oi.order_id
            LEFT JOIN products p ON oi.product_id = p.product_id
              WHERE p.seller_id = ? and DATE(oi.ordered_data) = CURDATE()";
        } elseif ($type == 'monthly') {
            $query = "SELECT 
                COUNT(DISTINCT u.user_id) AS total_customers,
                COUNT(o.order_id) AS total_orders,
                SUM(oi.price * oi.quantity) AS total_revenue
              FROM users u
              LEFT JOIN carts c ON c.user_id = u.user_id
              LEFT JOIN orders o ON c.cart_id = o.cart_id
              LEFT JOIN order_items oi ON o.order_id = oi.order_id
            LEFT JOIN products p ON oi.product_id = p.product_id
              WHERE p.seller_id = ? and  MONTH(oi.ordered_data) = MONTH(CURDATE())";
        } elseif ($type == 'yearly') {
            $query = "SELECT 
                COUNT(DISTINCT u.user_id) AS total_customers,
                COUNT(o.order_id) AS total_orders,
                SUM(oi.price * oi.quantity) AS total_revenue
              FROM users u
              LEFT JOIN carts c ON c.user_id = u.user_id
              LEFT JOIN orders o ON c.cart_id = o.cart_id
              LEFT JOIN order_items oi ON o.order_id = oi.order_id
            LEFT JOIN products p ON oi.product_id = p.product_id
              WHERE p.seller_id = ? and  YEAR(oi.ordered_data) = YEAR(CURDATE())";
        } else {
            $query = "SELECT 
                COUNT(DISTINCT u.user_id) AS total_customers,
                COUNT(o.order_id) AS total_orders,
                SUM(oi.price * oi.quantity) AS total_revenue
              FROM users u
              LEFT JOIN carts c ON c.user_id = u.user_id
              LEFT JOIN orders o ON c.cart_id = o.cart_id
              LEFT JOIN order_items oi ON o.order_id = oi.order_id
            LEFT JOIN products p ON oi.product_id = p.product_id
              WHERE p.seller_id = ? ";
        }
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $seller_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $customer_report = $result->fetch_assoc();
        } else {
            $customer_report = [
                'total_customers' => 0,
                'total_orders' => 0,
                'total_revenue' => 0
            ];
        }
    }

    if ($report_type == 'top_selling_products') {

        if ($type == 'daily') {
            $query = "SELECT p.product_name, 
            SUM(oi.quantity) AS total_quantity_sold, 
            SUM(oi.price * oi.quantity) AS total_revenue
       FROM order_items oi
       JOIN products p ON oi.product_id = p.product_id
       WHERE p.seller_id = ? and DATE(oi.ordered_data) = CURDATE()
       GROUP BY p.product_id
       ORDER BY total_quantity_sold DESC
       LIMIT 10";
        } elseif ($type == 'monthly') {
            $query = "SELECT p.product_name, 
            SUM(oi.quantity) AS total_quantity_sold, 
            SUM(oi.price * oi.quantity) AS total_revenue
       FROM order_items oi
       JOIN products p ON oi.product_id = p.product_id
       WHERE p.seller_id = ? and MONTH(oi.ordered_data) = MONTH(CURDATE())
       GROUP BY p.product_id
       ORDER BY total_quantity_sold DESC
       LIMIT 10";
        } elseif ($type == 'yearly') {
            $query = "SELECT p.product_name, 
            SUM(oi.quantity) AS total_quantity_sold, 
            SUM(oi.price * oi.quantity) AS total_revenue
       FROM order_items oi
       JOIN products p ON oi.product_id = p.product_id
       WHERE p.seller_id = ? and YEAR(ordered_data) = YEAR(CURDATE())
       GROUP BY p.product_id
       ORDER BY total_quantity_sold DESC
       LIMIT 10";
        } else {
            $query = "SELECT p.product_name, 
        SUM(oi.quantity) AS total_quantity_sold, 
        SUM(oi.price * oi.quantity) AS total_revenue
   FROM order_items oi
   JOIN products p ON oi.product_id = p.product_id
   WHERE p.seller_id = ? 
   GROUP BY p.product_id
   ORDER BY total_quantity_sold DESC
   LIMIT 10";
        }

        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $seller_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $top_selling_products = array();

        while ($row = $result->fetch_assoc()) {
            array_push($top_selling_products, $row);
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f4f4f9;
            margin: 20px;
            padding: 0;
        }

        .report-table-container {
            margin: 50px 40px;
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        thead {
            background-color: #0275d8;
            color: #fff;
        }

        th,
        td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-size: 1rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        td:hover {
            background-color: #f1f1f1;
        }

        td {
            font-size: 0.95rem;
            color: #555;
        }

        /* Responsive design */
        @media (max-width: 768px) {

            th,
            td {
                padding: 10px;
            }
        }
        .print-btn{
            position: absolute;
            right: 20px;
            margin-top: 40px;
            padding: 15px;
            font-size: 16px;
            background-color:white;
            transition: 0.3s ease;
            cursor: pointer;
            border-style: none;
            border-radius: 5px;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 500;
        }
        .print-btn:hover{
            background-color: #0275d8 ;
        }
    </style>
</head>

<body>
    <h1>
        <?php echo ucfirst(str_replace('_', ' ', $report_type)); ?> Report
    </h1>

    <?php if ($report_type == 'sales_reports' && isset($report)): ?>
        <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Total Sales</th>
                    <th>Total Revenue</th>
                    <th>Total Orders</th>
                    <th>Average Order Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $report['total_sales']; ?></td>
                    <td><?php echo number_format($report['total_revenue'], 2); ?></td>
                    <td><?php echo $report['total_orders']; ?></td>
                    <td><?php echo number_format($report['avg_order_value'], 2); ?></td>
                </tr>
            </tbody>
        </table>
        </div>
        <button class="print-btn"  onclick="downloadAsPDF('sales report')">Print Reports</button>

    <?php elseif ($report_type == 'product_reports' && !empty($product_report)): ?>
        <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Views</th>
                    <th>Stock</th>
                    <th>Total Orders</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product_report as $row): ?>
                    <tr>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['view_count']; ?></td>
                        <td><?php echo $row['stock_quantity']; ?></td>
                        <td><?php echo $row['total_orders']; ?></td>
                        <td><?php echo number_format($row['total_revenue'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <button class="print-btn"  onclick="downloadAsPDF('product_report')">Print Reports</button>

    <?php elseif ($report_type == 'customer_reports' && isset($customer_report)): ?>
        <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Total Customers</th>
                    <th>Total Orders</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $customer_report['total_customers']; ?></td>
                    <td><?php echo $customer_report['total_orders']; ?></td>
                    <td><?php echo number_format($customer_report['total_revenue'], 2); ?></td>
                </tr>
            </tbody>
        </table>
        
        </div>
        <button class="print-btn" onclick="downloadAsPDF('customer_report')">Print Reports</button>
    <?php elseif ($report_type == 'top_selling_products' && !empty($top_selling_products)): ?>
        <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity Sold</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($top_selling_products as $row): ?>
                    <tr>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['total_quantity_sold']; ?></td>
                        <td><?php echo number_format($row['total_revenue'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <button class="print-btn"  onclick="downloadAsPDF('top_selling_product report')">Print Reports</button>

    <?php else: ?>
        <p>No data available for this report.</p>
    <?php endif; ?>



 
    <script>
    function downloadAsPDF(topic) {
        // Create a new window
        const printWindow = window.open('', '_blank');

        printWindow.document.title = 'elife.com';
        
        // Ensure the window has fully loaded before writing content
        printWindow.document.write(`
            <html>
                <head>
                    <title>Seller Report</title>
                    <style>
                        /* Custom print styles */
                        body {
                            font-family: Arial, sans-serif;
                            padding: 20px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        table th, table td {
                            border: 1px solid #000;
                            padding: 8px;
                            text-align: left;
                        }
                        table th {
                            background-color: #f2f2f2;
                        }
                    </style>
                </head>
                <body>
                    <h1>${topic}</h1>
                    ${document.querySelector('.container').outerHTML}
                </body>
            </html>
        `);

       
        printWindow.document.close();

     
        printWindow.onload = function () {
            printWindow.print();
        };
    }
</script>


</body>

</html>