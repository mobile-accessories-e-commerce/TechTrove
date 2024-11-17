<?php
include "../connect.php";
session_start();

if (!isset($_SESSION['userid'])) {
    header("location:../authentication/loging.php");
    exit;
}

$user_id = $_SESSION['userid'];

// Query to get seller_id for the logged-in user
$seller_query = "SELECT seller_id FROM sellers WHERE user_id = '$user_id'";
$seller_result = mysqli_query($con, $seller_query);
$seller_data = mysqli_fetch_assoc($seller_result);
$seller_id = $seller_data['seller_id'] ?? 0;

// Fetch Total Product Listings
$total_products_query = "SELECT COUNT(*) as total_products FROM products WHERE seller_id = '$seller_id'";
$total_products_result = mysqli_query($con, $total_products_query);
$total_products = mysqli_fetch_assoc($total_products_result)['total_products'] ?? 0;

// Fetch Out-of-Stock Product Count
$out_of_stock_query = "SELECT COUNT(*) as out_of_stock FROM products WHERE seller_id = '$seller_id' AND stock_quantity = 0";
$out_of_stock_result = mysqli_query($con, $out_of_stock_query);
$out_of_stock = mysqli_fetch_assoc($out_of_stock_result)['out_of_stock'] ?? 0;

// Fetch Total Pending Orders
$pending_orders_query = "SELECT COUNT(*) as pending_orders FROM order_items oi
JOIN products p ON oi.product_id = p.product_id
WHERE p.seller_id = '$seller_id' AND oi.order_status = 'pending'";
$pending_orders_result = mysqli_query($con, $pending_orders_query);
$pending_orders = mysqli_fetch_assoc($pending_orders_result)['pending_orders'] ?? 0;

// Fetch Total Completed Orders
$completed_orders_query = "SELECT COUNT(*) as completed_orders FROM order_items oi
JOIN products p ON oi.product_id = p.product_id
WHERE p.seller_id = '$seller_id' AND oi.order_status = 'complete'";
$completed_orders_result = mysqli_query($con, $completed_orders_query);
$completed_orders = mysqli_fetch_assoc($completed_orders_result)['completed_orders'] ?? 0;



// Fetch the shop name
$seller_query = "SELECT store_name FROM sellers WHERE user_id = '$user_id'";
$result = mysqli_query($con, $seller_query);

$shop_name = "Your Shop"; // Default name if not found
if ($row = mysqli_fetch_assoc($result)) {
    $shop_name = $row['store_name'];
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
    <link rel="stylesheet" href="../style/sellerdashbord.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<style>

    .container{
        position: absolute;
        left: 35%;
    }
    .statistics-container {
        display: grid;
        grid-template-columns: repeat(2, minmax(250px, 1fr));
        gap: 50px;
        padding: 20px;
    }

    @media screen and (max-width: 768px) {
        .statistics-container {
            grid-template-columns: 1fr;
            /* 1 column on small screens */
            left: 50%;
            top: 0%;
        }
    }

    .stat-card {
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 150%;
        height: 150%;
        background: rgba(255, 255, 255, 0.15);
        transform: rotate(45deg);
        transition: opacity 0.3s;
    }

    .stat-card:hover::before {
        opacity: 0.5;
    }

    .stat-card i {
        font-size: 50px;
        margin-bottom: 10px;
    }

    .stat-card h2 {
        font-size: 20px;
        margin: 10px 0;
    }

    .stat-card p {
        font-size: 28px;
        font-weight: bold;
        margin: 0;
    }

    /* Individual Colors */
    .stat-card:nth-child(1) {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
    }

    .stat-card:nth-child(2) {
        background: linear-gradient(135deg, #ff6a00, #ee0979);
    }

    .stat-card:nth-child(3) {
        background: linear-gradient(135deg, #12c2e9, #c471ed, #f64f59);
    }

    .stat-card:nth-child(4) {
        background: linear-gradient(135deg, #11998e, #38ef7d);
    }



    /*wellcome text */

    .welcome-message {
    text-align: center;
    margin-bottom: 40px;
}

    @media screen and (max-width: 768px) {
        .welcome-section {
            display: none;
        }
    }



.welcome-message h1 {
    font-size: 2.5rem;
    color: #333;
    font-weight: bold;
    margin-top: 0;
}

.welcome-message h1 span {
    color: #007bff;
    font-style: italic;
}

</style>

<body>

    <!-- Left Sidebar Navigation -->
    <div class="sidebar">
        <nav>
            <ul class="nav-links">
                <li><a href="sellerdashbord.php">Home</a></li>
                <li><a href="productlisting.php">Add Product</a></li>
                <li><a href="#" onclick="loadContent('all_products')">All Products</a></li>
                <li><a href="#" onclick="loadContent('product_status')">Product Status</a></li>
                <li><a href="#" onclick="loadContent('ordered_products')">Ordered Products</a></li>
                <li><a href="#" onclick="loadContent('reports')">Reports</a></li>
                <li><a href="../Home/dashbord.php">Back to Home</a></li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <div class="container">


            <div class="welcome-message">
                <h1>Welcome,<span><?php echo htmlspecialchars($shop_name); ?></span></h1>
            </div>

            <div class="statistics-container">
                <div class="stat-card">
                    <i class="fas fa-box"></i>
                    <h2>Total Product Listings</h2>
                    <p><?php echo $total_products; ?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h2>Out-of-Stock Products</h2>
                    <p><?php echo $out_of_stock; ?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-clock"></i>
                    <h2>Total Pending Orders</h2>
                    <p><?php echo $pending_orders; ?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-check-circle"></i>
                    <h2>Total Completed Orders</h2>
                    <p><?php echo $completed_orders; ?></p>
                </div>
            </div>

        </div>
    </div>

    <script src="../script/sellerdashbord.js"></script>

</body>

</html>