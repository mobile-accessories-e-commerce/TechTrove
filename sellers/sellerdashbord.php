<?php
session_start();

if(!isset($_SESSION['userid'])){
    header("location:../authentication/loging.php");
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

<body>

    <!-- Left Sidebar Navigation -->
    <div class="sidebar">
        <nav>
            <ul class="nav-links">
                <li><a href="#" onclick="loadContent('home')">Home</a></li>
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
        <h1>Seller Dashboard</h1>
        <p>Welcome to your seller dashboard. Here you can manage your products, orders, and view reports.</p>
    </div>

    <script src="../script/sellerdashbord.js"></script>

</body>

</html>