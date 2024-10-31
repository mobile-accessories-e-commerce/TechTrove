<?php

session_start();
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $report_type = $_GET['report_type'];


    $seller_id = $_SESSION['seller_id'];
    $report_type = $_GET['report_type'];

    if (!isset($seller_id)) {
        echo json_encode(['error' => 'Seller not logged in']);
        exit();
    }

    if ($report_type == 'sales_reports') {
        $query = "SELECT 
                SUM(oi.quantity) AS total_sales, 
                SUM(oi.price * oi.quantity) AS total_revenue, 
                COUNT(DISTINCT o.order_id) AS total_orders, 
                AVG(oi.price * oi.quantity) AS avg_order_value
              FROM order_items oi
              JOIN orders o ON oi.order_id = o.order_id
              JOIN products p ON oi.product_id = p.product_id
              WHERE p.seller_id = ?";

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
        $query = "SELECT 
                COUNT(DISTINCT u.user_id) AS total_customers,
                COUNT(o.order_id) AS total_orders,
                SUM(oi.price * oi.quantity) AS total_revenue
              FROM users u
              LEFT JOIN carts c ON c.user_id = u.user_id
              LEFT JOIN orders o ON c.cart_id = o.cart_id
              LEFT JOIN order_items oi ON o.order_id = oi.order_id
            LEFT JOIN products p ON oi.product_id = p.product_id
              WHERE p.seller_id = ?";

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
        $query = "SELECT p.product_name, 
                   SUM(oi.quantity) AS total_quantity_sold, 
                   SUM(oi.price * oi.quantity) AS total_revenue
              FROM order_items oi
              JOIN products p ON oi.product_id = p.product_id
              WHERE p.seller_id = ?
              GROUP BY p.product_id
              ORDER BY total_quantity_sold DESC
              LIMIT 10";

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
    <title>Sales Report</title>

    <?php if ($report_type == 'sales_reports' || 'customer_reports'): ?>
        <style>
            /* General reset for all elements */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Arial', sans-serif;
            }

            body {
                background-color: #f4f4f9;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            /* Container for the report cards */
            .container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
                padding: 20px;
                max-width: 1000px;
                width: 100%;
            }

            /* Individual report card styling */
            .report-card {
                background-color: #fff;
                border-radius: 15px;
                padding: 30px;
                text-align: center;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .report-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2);
            }

            /* Title and value for each report item */
            .report-card h2 {
                font-size: 1.5rem;
                color: #333;
                margin-bottom: 20px;
                font-weight: 600;
            }

            .report-card p {
                font-size: 2.5rem;
                color: #27ae60;
                font-weight: bold;
                margin-bottom: 10px;
            }

            /* Responsive behavior */
            @media (max-width: 600px) {
                .report-card {
                    padding: 20px;
                }

                .report-card h2 {
                    font-size: 1.25rem;
                }

                .report-card p {
                    font-size: 2rem;
                }
            }
        </style>
    <?php endif; ?>

    <?php if ($report_type == 'product_reports'): ?>
        <style>
            /* General reset for all elements */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Arial', sans-serif;
            }

            body {
                background-color: #f4f4f9;
                display: flex;
                justify-content: center;
                align-items: flex-start;
                flex-direction: column;
                padding: 20px;
            }

            /* Container for the product reports */
            .products-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                padding: 20px;
                max-width: 1200px;
                width: 100%;
                margin-top: 20px;
            }

            /* Individual report card styling */
            .report-card {
                background-color: #ffffff;
                border-radius: 15px;
                padding: 10px;
                text-align: center;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .report-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2);
            }

            /* Title and value for each report item */
            .report-card h2 {
                font-size: 1rem;
                color: #333;
                margin-bottom: 10px;
                font-weight: 600;
            }

            .report-card p {
                font-size: 1rem;
                color: #27ae60;
                font-weight: bold;
                margin-bottom: 5px;
            }

            /* Responsive behavior */
            @media (max-width: 600px) {
                .report-card {
                    padding: 15px;
                }

                .report-card h2 {
                    font-size: 1rem;
                }

                .report-card p {
                    font-size: 1.2rem;
                }
            }
        </style>
    <?php endif; ?>

    <?php if ($report_type == 'top_selling_products'): ?>
        <style>
            /* General reset for all elements */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Arial', sans-serif;
            }

            body {
                background-color: #f4f4f9;
                display: flex;
                justify-content: center;
                align-items: flex-start;
                flex-direction: column;
                padding: 20px;
            }

            /* Container for the product reports */
            .container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
                padding: 20px;
                max-width: 1200px;
                width: 100%;
            }

            /* Individual report card styling */
            .report-card {
                background-color: #ffffff;
                border-radius: 15px;
                padding: 20px;
                text-align: center;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .report-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2);
            }

            /* Title and value for each report item */
            .report-card h2 {
                font-size: 1.5rem;
                color: #333;
                margin-bottom: 15px;
                font-weight: 600;
            }

            .report-card p {
                font-size: 1.2rem;
                color: #27ae60;
                font-weight: bold;
                margin-bottom: 5px;
            }

            /* Responsive behavior */
            @media (max-width: 600px) {
                .report-card {
                    padding: 15px;
                }

                .report-card h2 {
                    font-size: 1.25rem;
                }

                .report-card p {
                    font-size: 1rem;
                }
            }
        </style>
    <?php endif; ?>
</head>

<body>
    <?php if ($report_type == 'sales_reports'): ?>

        <div class="container">
            <div class="report-card">
                <h2>Total Sales</h2>
                <p><?php echo $report['total_sales']; ?></p>
            </div>
            <div class="report-card">
                <h2>Total Revenue</h2>
                <p>$<?php echo $report['total_revenue']; ?></p>
            </div>
            <div class="report-card">
                <h2>Total Orders</h2>
                <p><?php echo $report['total_orders']; ?></p>
            </div>
            <div class="report-card">
                <h2>Average Order Value</h2>
                <p>$<?php echo $report['avg_order_value']; ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($report_type == 'product_reports'): ?>
        <div class="products-container">
            <?php foreach ($product_report as $report): ?>
                <div class="report-card">
                    <h2>Product Name</h2>
                    <p><?php echo $report['product_name']; ?></p>
                </div>
                <div class="report-card">
                    <h2>View Count</h2>
                    <p><?php echo $report['view_count']; ?></p>
                </div>
                <div class="report-card">
                    <h2>Stock Quantity</h2>
                    <p><?php echo $report['stock_quantity']; ?></p>
                </div>
                <div class="report-card">
                    <h2>Total orders</h2>
                    <p><?php echo $report['total_orders'] ?></p>
                </div>
                <div class="report-card">
                    <h2>Total Revenue</h2>
                    <p>$<?php echo $report['total_revenue']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>


    <?php if ($report_type == 'customer_reports'): ?>
        <div class="container">
            <div class="report-card">
                <h2>Total Customers</h2>
                <p><?php echo isset($customer_report['total_customers']) ? $customer_report['total_customers'] : 0; ?></p>
            </div>
            <div class="report-card">
                <h2>Total Orders</h2>
                <p><?php echo isset($customer_report['total_orders']) ? $customer_report['total_orders'] : 0; ?></p>
            </div>
            <div class="report-card">
                <h2>Total Revenue</h2>
                <p>$<?php echo isset($customer_report['total_revenue']) ? $customer_report['total_revenue'] : 0; ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($report_type == 'top_selling_products'): ?>

        <div class="container">

            <?php foreach ($top_selling_products as $product): ?>
                <div class="report-card">
                    <h2><?php echo $product['product_name']; ?></h2>
                    <p>Quantity Sold: <?php echo $product['total_quantity_sold']; ?></p>
                    <p>Total Revenue: $<?php echo $product['total_revenue']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>

</html>