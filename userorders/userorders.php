<?php
include '../layouts/header.php';

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
    <title>User Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../style/userorder.css">
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
<div class="hamburger" id="hamburger">
        ☰
    </div>

    <div class="side-bar" id="sidebar">
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
        <script>
            document.getElementById('hamburger').addEventListener('click', function () {
    const sidebar = document.getElementById('sidebar');
   if(sidebar.style.display === 'block'){
        sidebar.style.display = 'none';
   }else{
    sidebar.style.display = 'block';
   }
});
        </script>
</body>


</html>