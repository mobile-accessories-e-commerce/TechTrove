document.getElementById('pending-btn').addEventListener('click', function() {
    fetchPendingOrders();
});

document.getElementById('complete-btn').addEventListener('click', function() {
   fetchCompletedOrders();  
});

document.getElementById('dashbord-btn').addEventListener('click',function(){
    fetchOverallOrderData();
})

window.onload = fetchOverallOrderData();

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
                <div class="order-card">
                <div class="order-info">
                    <h2>Order #${order.order_id}</h2>
                    <p><strong>Date:</strong> ${order.ordered_data}</p>
                    <p><strong>Status:</strong> ${order.order_status}</p>
                </div>
                <div class="product-info">
                    <img src="../images/${order.image_link}" alt="Product Image">
                    <div>
                        <p><strong>Product Name:</strong>${order.product_name}</p>
                        <p><strong>Quantity:</strong>${order.quantity}</p>
                        <p><strong>Total Price:</strong>${order.price*order.quantity}</p>
                    </div>
                </div>
                <div class="order-actions">
                    
                    <a  href='trackorder.php?order_item_id=${order.item_id}'><button class="track-btn">Track Order</button></a>
                </div>
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
                <div class="order-card">
                <div class="order-info">
                    <h2>Order #${order.order_id}</h2>
                    <p><strong>Date:</strong> ${order.ordered_data}</p>
                    <p><strong>Status:</strong> ${order.order_status}</p>
                </div>
                <div class="product-info">
                    <img src="../images/${order.image_link}" alt="Product Image">
                    <div>
                        <p><strong>Product Name:</strong>${order.product_name}</p>
                        <p><strong>Quantity:</strong>${order.quantity}</p>
                        <p><strong>Total Price:</strong>${order.price*order.quantity}</p>
                    </div>
                </div>
                <div class="order-actions">
                    
                   <a href='productrating.php?product_id=${order.product_id}'><button class="track-btn">Give Feedback</button></a>
                </div>
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

function fetchOverallOrderData() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'getoverallorderdata.php', true); 
    
    xhr.onload = function() {
    if (xhr.status === 200) {
        let content = document.getElementById('order-container');
        let orders = JSON.parse(xhr.responseText);
    
       
            let ordersHTML = `<div class='container'>`;
           
                ordersHTML += `
                                    <div class="dashboard">
                        <h1>Order Dashboard</h1>
                        <div class="dashboard-summary">
                            <div class="summary-item">
                                <h2>Total Orders</h2>
                                <p id="total-orders">${orders.total_orders}</p>
                            </div>
                            <div class="summary-item">
                                <h2>Pending Orders</h2>
                                <p id="pending-orders">${orders.pending_orders}</p>
                            </div>
                            <div class="summary-item">
                                <h2>Completed Orders</h2>
                                <p id="completed-orders">${orders.completed_orders}</p>
                            </div>
                            <div class="summary-item">
                                <h2>Total Cost</h2>
                                <p id="total-cost">$${orders.total_cost}</p>
                            </div>
                        </div>
                    </div>
                `;
      
    
            ordersHTML += '</div>';
            content.innerHTML = ordersHTML; 
        
    }
    };
    
    xhr.send(); 
    }