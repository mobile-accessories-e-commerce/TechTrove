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
                    <div><button><a href='productrating.php?product_id=${order.product_id}'>Give Feedback</a></button></div>
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