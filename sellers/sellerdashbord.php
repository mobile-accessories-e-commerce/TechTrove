<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
    <link rel="stylesheet" href="../style/sellerdashbord.css">
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
                                        <button> <a href='confirmorder.php?oder_item_id=${order.item_id}'>Make as ship</a></button>
                                        
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
