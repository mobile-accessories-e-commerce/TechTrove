<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders</title>
    <style>
        /* Basic styling */
        body {
            display: flex;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 20%;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .sidebar button {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .sidebar button:hover {
            background-color: #0056b3;
        }
        .content {
            width: 80%;
            padding: 20px;
        }
        .order-item {
            padding: 15px;
            margin: 10px 0;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .track-btn {
            background-color: #28a745;
            color: white;
            padding: 8px;
            border: none;
            cursor: pointer;
        }
        .track-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <button id="pending-btn">Pending</button>
        <button id="complete-btn">Complete</button>
    </div>

    <!-- Content -->
    <div class="content" id="order-container">
        <h2>Order Details</h2>
        <!-- Order data will be displayed here -->
    </div>

    <script>
        // JavaScript to handle AJAX and update content
        document.getElementById('pending-btn').addEventListener('click', function() {
            fetchPendingOrders();
        });

        document.getElementById('complete-btn').addEventListener('click', function() {
           fetchCompletedOrders();  
        });



        function fetchPendingOrders() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'getpendingorders.php', true); 
    xhr.onload = function() {
        if (xhr.status === 200) {
            let content = document.getElementById('order-container');
            let orders = JSON.parse(xhr.responseText);

            if (orders.length > 0) {
                let ordersHTML = '<div class="orders-list">';
                
                orders.forEach(function(order) { 
                    ordersHTML += `
                        <div class="order">
                            <img src="../images/${order.image_link}" alt="${order.product_name}">
                            <div class="product-name">${order.product_name}</div>
                            <div class="product-price">$${order.price}</div>
                            <a href='trackorder.php?order_item_id=${order.item_id}'>Track</a>
                        </div>
                    `;
                });

                ordersHTML += '</div>';
                content.innerHTML = ordersHTML; 
            } else {
                content.innerHTML = "<h1>No orders Found</h1><p>You haven't listed any products yet.</p>";
            }
        }
    };

    xhr.send(); 
}


function fetchCompletedOrders() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'getcompletedorders.php', true); 

    xhr.onload = function() {
        if (xhr.status === 200) {
            let content = document.getElementById('order-container');
            let orders = JSON.parse(xhr.responseText);

            if (orders.length > 0) {
                let ordersHTML = '<div class="orders-list">';
                
                orders.forEach(function(order) {
                    ordersHTML += `
                        <div class="order">
                            <img src="../images/${order.image_link}" alt="${order.product_name}">
                            <div class="product-name">${order.product_name}</div>
                            <div class="product-price">$${order.price}</div>
                        </div>
                    `;
                });

                ordersHTML += '</div>';
                content.innerHTML = ordersHTML; 
            } else {
                content.innerHTML = "<h1>No orders Found</h1><p>You haven't listed any products yet.</p>";
            }
        }
    };

    xhr.send(); 
}

    </script>

</body>
</html>
