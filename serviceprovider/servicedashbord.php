<?php
session_start();
include "../connect.php";

if (!isset($_SESSION['userid'])) {
    header("location:../authentication/loging.php");
    exit;
}

$user_id = $_SESSION['userid'];

// Fetch total listings
$queryListings = "SELECT COUNT(*) AS total_listings FROM services WHERE service_provider_id = (SELECT service_provider_id FROM service_providers WHERE user_id = $user_id)";
$resultListings = mysqli_query($con, $queryListings);
$totalListings = mysqli_fetch_assoc($resultListings)['total_listings'] ?? 0;

// Fetch total customers
$queryCustomers = "SELECT COUNT(DISTINCT user_id) AS total_customers FROM service_requests WHERE service_id IN (SELECT service_id FROM services WHERE service_provider_id = (SELECT service_provider_id FROM service_providers WHERE user_id = $user_id))";
$resultCustomers = mysqli_query($con, $queryCustomers);
$totalCustomers = mysqli_fetch_assoc($resultCustomers)['total_customers'] ?? 0;

// Fetch total pending requests
$queryPendingRequests = "SELECT COUNT(*) AS total_pending FROM service_requests WHERE accept = 0 AND service_id IN (SELECT service_id FROM services WHERE service_provider_id = (SELECT service_provider_id FROM service_providers WHERE user_id = $user_id))";
$resultPendingRequests = mysqli_query($con, $queryPendingRequests);
$totalPendingRequests = mysqli_fetch_assoc($resultPendingRequests)['total_pending'] ?? 0;

// Fetch total completed requests
$queryCompletedRequests = "SELECT COUNT(*) AS total_completed FROM service_requests WHERE accept = 1 AND service_id IN (SELECT service_id FROM services WHERE service_provider_id = (SELECT service_provider_id FROM service_providers WHERE user_id = $user_id))";
$resultCompletedRequests = mysqli_query($con, $queryCompletedRequests);
$totalCompletedRequests = mysqli_fetch_assoc($resultCompletedRequests)['total_completed'] ?? 0;



$queryProvider = "SELECT provider_name FROM service_providers WHERE user_id = $user_id";
$resultProvider = mysqli_query($con, $queryProvider);
$providerName = mysqli_fetch_assoc($resultProvider)['provider_name'] ?? "Service Provider";

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>service Provider dashbord</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../style/serviceproviderdashbord.css">


</head>

<body>


    <div class="hamburger" id="hamburger">
        ☰
    </div>

    <div class="main-container">
        <!-- Left Sidebar Navigation -->
        <div class="sidebar" id="sidebar">
            <nav>
                <ul class="nav-links">
                    <li><a href="servicedashbord.php">Home</a></li>
                    <li><a href="servicelisting.php">Add service</a></li>
                    <li><a href="#" onclick="loadContent('all_service')">All service</a></li>
                    <li><a href="#" onclick="loadContent('product_status')">Product Status</a></li>
                    <li><a href="#" onclick="loadContent('service_request')">Ordered Products</a></li>
                    <li><a href="../Home/dashbord.php">Back to Home</a></li>
                </ul>
            </nav>
        </div>

        <div class="main-content" id="main-content">
            <div class="container">
                <div class="welcome-message">
                    <h1>Welcome, <span><?php echo $providerName; ?></span>!</h1>
                </div>

                <div class="statistics-container">
                    <!-- Card 1 -->
                    <div class="stat-card">
                        <i class="fas fa-list-alt"></i>
                        <h2>Total Listings</h2>
                        <p><?php echo $totalListings; ?></p>
                    </div>

                    <!-- Card 2 -->
                    <div class="stat-card">
                        <i class="fas fa-users"></i>
                        <h2>Total Customers</h2>
                        <p><?php echo $totalCustomers; ?></p>
                    </div>

                    <!-- Card 3 -->
                    <div class="stat-card">
                        <i class="fas fa-hourglass-half"></i>
                        <h2>Pending Requests</h2>
                        <p><?php echo $totalPendingRequests; ?></p>
                    </div>

                    <!-- Card 4 -->
                    <div class="stat-card">
                        <i class="fas fa-check-circle"></i>
                        <h2>Completed Requests</h2>
                        <p><?php echo $totalCompletedRequests; ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    
    <script src="../script/serviceproviderdashbord.js"></script>
    <script>
        document.getElementById('hamburger').addEventListener('click', function () {
            const handbager = document.getElementById('hamburger');
            const sidebar = document.getElementById('sidebar');
            if (sidebar.style.display === 'block') {
                sidebar.style.display = 'none';


            } else {
                sidebar.style.display = 'block';


            }
        });
    </script>

</body>

</html>