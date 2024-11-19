<?php

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../authentication/adminloging.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Reset margin, padding, and box-sizing */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and overall background */
        body {
            font-family: 'Arial', sans-serif;
            background: #f8f8f8; /* Light background */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Container to hold everything */
        .container {
            width: 80%;
            max-width: 1200px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        /* Header section */
        header {
            margin-bottom: 40px;
        }

        header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #333;
        }

        header p {
            font-size: 1.1rem;
            color: #555;
        }

        /* Grid setup for the reports */
        .report-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 columns layout */
            gap: 30px;
            margin-top: 20px;
        }

        /* Individual report card styles */
        .report-card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            color: #333;
        }

        .report-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .report-card h3 {
            font-size: 1.6rem;
            color: #333;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .report-card a {
            display: inline-block;
            font-size: 1.1rem;
            color: #fff;
            background-color: #4e9af1; /* Light blue */
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        .report-card a:hover {
            background-color: #3498db; /* Darker blue on hover */
        }

        /* Icon Styles */
        .report-card .icon {
            font-size: 2rem;
            color: #4e9af1; /* Blue icon */
            margin-bottom: 15px;
        }

        /* Adding light background and minimalistic color to report cards */
        .report-card:nth-child(1) {
            background: #f0faff; /* Light blue background */
        }

        .report-card:nth-child(2) {
            background: #fff9e5; /* Light yellow background */
        }

        .report-card:nth-child(3) {
            background: #f0f8f0; /* Light green background */
        }

        .report-card:nth-child(4) {
            background: #f8e5ff; /* Light purple background */
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .report-grid {
                grid-template-columns: 1fr; /* Stack the cards on small screens */
            }
        }

    </style>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="container">
        <header>
            <h1>Admin Report Dashboard</h1>
            <p>View and manage all reports below</p>
        </header>

        <div class="report-grid">
            <!-- Seller Reports -->
            <div class="report-card">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Seller Reports</h3>
                <a href="reportview.php?type=seller" target="_blank">View Reports</a>
            </div>

            <!-- Service Provider Reports -->
            <div class="report-card">
                <div class="icon">
                <i class="fas fa-users"></i>
                </div>
                <h3>Service Provider Reports</h3>
                <a  href="reportview.php?type=service_provider" target="_blank">View Reports</a>
            </div>

            <!-- Product Reports -->
            <div class="report-card">
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <h3>Product Reports</h3>
                <a  href="reportview.php?type=product" target="_blank">View Reports</a>
            </div>

            <!-- Service Reports -->
            <div class="report-card">
                <div class="icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <h3>Service Reports</h3>
                <a href="reportview.php?type=service" target="_blank" >View Reports</a>
            </div>
        </div>
    </div>

</body>
</html>
