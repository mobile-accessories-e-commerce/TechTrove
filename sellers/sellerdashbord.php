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
            width: 30%; /* Each item takes 30% of the container width */
        margin-bottom: 20px; /* Add space between rows */
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
            width: 30%; /* Each item takes 30% of the container width */
        margin-bottom: 20px; /* Add space between rows */
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
                <li><a href="productlisting.php">Add Product</a></li>
                <li><a href="#" onclick="loadContent('all_products')">All Products</a></li>
                <li><a href="#" onclick="loadContent('product_status')">Product Status</a></li>
                <li><a href="#" onclick="loadContent('ordered_products')">Ordered Products</a></li>
                <li><a href="#" onclick="loadContent('reports')">Reports</a></li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <h1>Seller Dashboard</h1>
        <p>Welcome to your seller dashboard. Here you can manage your products, orders, and view reports.</p>
    </div>

    <script>
        function loadContent(section) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `fetch_seller_dashbord_data.php?section=${section}`, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let content = document.getElementById('main-content');
                    if (section === 'all_products') {
                        let products = JSON.parse(xhr.responseText);
                        content.innerHTML = "<h1>All Products</h1>";
                        if (products.length > 0) {
                            let productHTML = '<div class="product-list">';
                            products.forEach(function(product) {
                                productHTML += `
                                    <div class="product">
                                        <img src="../images/${product.image_link}" alt="${product.product_name}">
                                        <div class="product-name">${product.product_name}</div>
                                        <div class="product-price">$${product.price}</div>
                                        <div class="product-stock">Stock: ${product.stock_quantity}</div>
                                        <a href="editproduct.php?product_id=${product.product_id}">Edit</a>
                                    </div>
                                `;
                            });
                            productHTML += '</div>';
                            content.innerHTML += productHTML;
                        } else {
                            content.innerHTML = "<h1>No Products Found</h1><p>You haven't listed any products yet.</p>";
                        }
                    }
                    
                    if (section === 'ordered_products') {
                        let orders = JSON.parse(xhr.responseText);
                        content.innerHTML = "<h1>All Orders</h1>";
                        if (orders.length > 0) {
                            let ordersHTML = '<div class="order-list">';
                            orders.forEach(function(order) {
                                ordersHTML += `
                                    <div class="order">
                                        <img src="../images/${order.image_link}" alt="${order.product_name}">
                                        <div class="order-details">
                                            <strong>Product:</strong> ${order.product_name}
                                            <strong>Quantity:</strong> ${order.quantity}
                                            <div class="price">$${order.price}</div>
                                        </div>
                                        <div class="details">
                                            <h3>Shipping Details:</h3>
                                            <p><strong>Address:</strong> ${order.address}</p>
                                            <p><strong>Country:</strong> ${order.country}</p>
                                            <p><strong>Zip Code:</strong> ${order.zip_code}</p>
                                            <p><strong>Phone Number:</strong> ${order.phone_number}</p>
                                            <p><strong>Email:</strong> ${order.email}</p>
                                            <p><strong>Payment Method:</strong> ${order.payment_method}</p>
                                        </div>
                                        <button>Mark as Delivered</button>
                                    </div>
                                `;
                            });
                            ordersHTML += '</div>';
                            content.innerHTML += ordersHTML;
                        } else {
                            content.innerHTML = "<h1>No Orders Found</h1><p>No orders have been placed yet.</p>";
                        }
                    }
                }
            };
            xhr.send();
        }
    </script>

</body>
</html>
