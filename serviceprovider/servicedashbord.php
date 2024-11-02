<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 200px;
            background-color: #333;
            position: fixed;
            height: 100%;
            padding-top: 20px;
        }

        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar nav ul li {
            margin: 20px 0;
        }

        .sidebar nav ul li a {
            text-decoration: none;
            color: white;
            display: block;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .sidebar nav ul li a:hover {
            background-color: #575757;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 200px;
            padding: 20px;
        }

        /* Product Styles */
        .product-list {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .product {
            width: 30%;
            /* Each item takes 30% of the container width */
            margin-bottom: 20px;
            /* Add space between rows */
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-name {
            font-size: 18px;
            margin: 10px 0;
        }

        .product-price {
            color: green;
            font-weight: bold;
        }

        .product-stock {
            font-size: 14px;
            color: #555;
        }

        .product a {
            display: inline-block;
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
        }

        .product a:hover {
            background-color: #0056b3;
        }

        /* Order Styles */
        .order-list {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .order {
            width: 30%;
            /* Each item takes 30% of the container width */
            margin-bottom: 20px;
            /* Add space between rows */
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .order img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .order-details {
            margin-top: 10px;
        }

        .order-details strong {
            display: block;
            font-size: 14px;
            margin: 5px 0;
        }

        .order .price {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }

        .order .details {
            margin-top: 20px;
        }

        .order .details h3 {
            margin-bottom: 10px;
        }

        .order .details p {
            margin: 5px 0;
        }

        .order button {
            margin-top: 10px;
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .order button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

    <!-- Left Sidebar Navigation -->
    <div class="sidebar">
        <nav>
            <ul class="nav-links">
                <li><a href="#" onclick="loadContent('home')">Home</a></li>
                <li><a href="servicelisting.php">Add service</a></li>
                <li><a href="#" onclick="loadContent('all_service')">All service</a></li>
                <li><a href="#" onclick="loadContent('product_status')">Product Status</a></li>
                <li><a href="#" onclick="loadContent('ordered_products')">Ordered Products</a></li>
                <li><a href="#" onclick="loadContent('reports')">Reports</a></li>
                <li><a href="../Home/dashbord.php">Back to Home</a></li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <h1>Service Provider Dashboard</h1>
        <p>Welcome to your Service Provider dashboard. Here you can manage your services, orders, and view reports.</p>
    </div>

    <script src="../script/serviceproviderdashbord.js"></script>

</body>

</html>