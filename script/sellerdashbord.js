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
                                <div class="product-stock">
                                <form action='../product/updatestock.php' method='POST'>
                                    <input type='hidden' name='product_id' value='${product.product_id}'>
                                    <input type='number' name='stock_quantity' value='${product.stock_quantity}'>
                                    <button type='submit'>Update Stock</button>
                                </form>
                                
                                </div>
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
                                    <p><strong>Phone Number:</strong> ${order.mobile_number}</p>
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

            if (section === 'product_status') {
                let products = JSON.parse(xhr.responseText);
                content.innerHTML = "<h1>Product Status</h1>";
                if (products.length > 0) {
                    let productHTML = '<div class="product-status-list">';
                    products.forEach(function(product) {
                        let stockClass = product.stock_quantity < 10 ? 'low-stock' : 'stock';
                        productHTML += `
                            <div class="product-card">
                                <img src="../images/${product.image_link}" alt="${product.product_name}">
                                <div class="product-details">
                                    <h3>${product.product_name}</h3>
                                    <p><strong>Available Stock:</strong> <span class="${stockClass}">${product.stock_quantity}</span></p>
                                    <p><strong>View Count:</strong> <span>${product.view_count}</span></p>
                                    <p><strong>Rating:</strong> <span class="rating">${product.rating} / 5</span></p>
                                    <p><strong>Number of Orders:</strong> <span class="orders">${product.total_orders}</span></p>
                                </div>
                            </div>
                        `;
                    });
                    productHTML += '</div>';
                    content.innerHTML += productHTML;
                } else {
                    content.innerHTML = "<h1>No Products Found</h1><p>No product data is available.</p>";
                }
            }

            if(section=='reports'){
                content.innerHTML = `<div class="reports-menu">
                                    <h2>Reports</h2>
                                    <ul>
                                        <li><a href='reports.php?report_type=sales_reports'>Sales Summary Report</a></li>
                                        <li><a href='reports.php?report_type=product_reports'>Product Performance Report</a></li>
                                        <li><a href='reports.php?report_type=top_selling_products'>Top Selling Products</a></li>
                                        <li><a href='reports.php?report_type=customer_reports'>Customer Report</a></li>
                                    </ul>
                                </div>
                                    `
            }
                
        }
    };
    xhr.send();
}