<?php
include '../layouts/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General page styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
           
        }
        
        .main-content{
            display: flex;
        }
        .side-bar {
            background-color: #ffffff;
            width: 200px;
            height: 100vh;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-right: 1px solid #e1e1e1;
            display: flex;
            flex-direction: column;

        }

        .side-bar-icon {
            margin: 15px 0;
        }

        .side-bar-icon a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            display: flex;
            align-items: center;
            transition: color 0.3s;
        }

        .side-bar-icon i {
            margin-right: 10px;
            color: #007bff;
        }

        .side-bar-icon a:hover {
            color: #0056b3;
        }

        /* Content area styles */
        .content {
            flex: 1;
            padding: 20px;
        }

        .content-header {
            margin-bottom: 20px;
        }

        .content-header h1 {
            font-size: 24px;
            color: #333;
        }
        .orders-list{
            display: grid;
            grid-template-rows: repeat(3, 1fr);
            gap: 20px; 
        }
        .order-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            margin: 10px;
            flex-direction: column;
            gap: 15px;
            transition: box-shadow 0.3s;
        }

        .order-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .order-info {
            border-bottom: 1px solid #e1e1e1;
            padding-bottom: 15px;
        }

        .order-info h2 {
            font-size: 20px;
            margin: 0;
            color: #333;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-info img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        .product-info div {
            font-size: 14px;
        }

        .order-actions {
            display: flex;
            gap: 10px;
        }

        .order-actions button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .view-btn {
            background-color: #007bff;
            color: #ffffff;
        }

        .view-btn:hover {
            background-color: #0056b3;
        }

        .track-btn {
            background-color: #28a745;
            color: #ffffff;
        }

        .track-btn:hover {
            background-color: #218838;
        }


        /* dashbord*/


        .container {
            width: 100%;
            max-width: 900px;
            padding: 20px;
        }

        .dashboard {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .dashboard h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .dashboard-summary {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .summary-item {
            background: linear-gradient(135deg, #007bff, #00d4ff);
            padding: 20px;
            color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .summary-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .summary-item h2 {
            margin: 0 0 10px;
            font-size: 18px;
            color: #e0f7ff;
        }

        .summary-item p {
            font-size: 26px;
            margin: 0;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <!-- <div class="sidebar">
        <button id="pending-btn">Pending</button>
        <button id="complete-btn">Complete</button>
    </div> -->

    <!-- Content -->
    <!-- <div class="content" id="order-container">
        <h2>Order Details</h2> -->
    <!-- Order data will be displayed here -->
    <!-- </div> -->

<div class="main-content">

    <div class="side-bar">
        <div class="side-bar-icon">
            <a href="#" id="dashbord-btn"><i class="fas fa-home"></i> Dashboard</a>
        </div>
        <div class="side-bar-icon">
            <a href="#" id="complete-btn"><i class="fas fa-list-alt"></i>complete Orders</a>
        </div>
        <div class="side-bar-icon">
            <a href="#" id="pending-btn"><i class="fas fa-list-alt"></i>Pending Orders</a>
        </div>
        <div class="side-bar-icon">
            <a href="../userprofile.php"><i class="fas fa-user"></i> Profile</a>
        </div>

        <div class="side-bar-icon">
            <a href="../Home/dashbord.php"><i class="fas fa-home"></i> Go To Home</a>
        </div>
        <!-- Add more navigation items if needed -->
    </div>

    <!-- Main content area -->
    <div class="content" id="order-container">
    </div>
    </div>
        <script src="../script/userorder.js"></script>
</body>

</html>