document.getElementById("pending-btn").addEventListener("click", function () {
  fetchPendingOrders();
});

document.getElementById("complete-btn").addEventListener("click", function () {
  fetchCompletedOrders();
});

document.getElementById("dashbord-btn").addEventListener("click", function () {
  fetchOverallOrderData();
});

window.onload = fetchOverallOrderData();

let currentPendingPage = 1; 
const pendingLimit = 2; 

function fetchPendingOrders(page = 1) {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `getpendingorders.php?page=${page}&limit=${pendingLimit}`, true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      let content = document.getElementById("order-container");
      let response = JSON.parse(xhr.responseText);
      let orders = response.orders;
      let total = response.total;
      let totalPages = Math.ceil(total / pendingLimit);

      let ordersHTML = "";

      if (orders.length > 0) {
        ordersHTML = '<div class="orders-list">';
        orders.forEach(function (order) {
          ordersHTML += `
                <div class="order-card">
                <div class="order-info">
                    <h2>Order #${order.item_id}</h2>
                    <p><strong>Date:</strong> ${order.ordered_data}</p>
                    <p><strong>Status:</strong> ${order.order_status}</p>
                </div>
                <div class="product-info">
                    <img src="../images/${
                      order.image_link
                    }" alt="Product Image">
                    <div>
                        <p><strong>Product Name:</strong>${
                          order.product_name
                        }</p>
                        <p><strong>Quantity:</strong>${order.quantity}</p>
                        <p><strong>Total Price:</strong>${
                          order.price * order.quantity
                        }</p>
                    </div>
                </div>
                <div class="order-actions">
                    <a href='trackorder.php?order_item_id=${
                      order.item_id
                    }'><button class="track-btn">Track Order</button></a>
                </div>
                </div>
            `;
        });
        ordersHTML += "</div>";
      } else {
        ordersHTML =
          "<h1>No orders Found</h1><p>You haven't listed any products yet.</p>";
      }

     
      content.innerHTML = ordersHTML;

      
      let paginationHTML = '<div class="pagination">';
      if (page > 1) {
        paginationHTML += `<button onclick="fetchPendingOrders(${
          page - 1
        })">Previous</button>`;
      }
      if (page < totalPages) {
        paginationHTML += `<button onclick="fetchPendingOrders(${
          page + 1
        })">Next</button>`;
      }
      paginationHTML += "</div>";

      content.innerHTML += paginationHTML;

    
      currentPendingPage = page;
    }
  };

  xhr.send();
}




let currentPage = 1; 
const limit = 2; 

function fetchCompletedOrders(page = 1) {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `getcompletedorders.php?page=${page}&limit=${limit}`, true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      let content = document.getElementById("order-container");
      let response = JSON.parse(xhr.responseText);
      let orders = response.orders;
      let total = response.total;
      let totalPages = Math.ceil(total / limit);

      let ordersHTML = "";

      if (orders.length > 0) {
        ordersHTML = '<div class="orders-list">';
        orders.forEach(function (order) {
          const feedbackButton =
            order.can_feedback == 1
              ? `<a href='productrating.php?item_id=${order.item_id}'><button class="track-btn">Give Feedback</button></a>`
              : "";
          ordersHTML += `
                <div class="order-card">
                <div class="order-info">
                    <h2>Order #${order.order_id}</h2>
                    <p><strong>Date:</strong> ${order.ordered_data}</p>
                    <p><strong>Status:</strong> ${order.order_status}</p>
                </div>
                <div class="product-info">
                    <img src="../images/${
                      order.image_link
                    }" alt="Product Image">
                    <div>
                        <p><strong>Product Name:</strong>${
                          order.product_name
                        }</p>
                        <p><strong>Quantity:</strong>${order.quantity}</p>
                        <p><strong>Total Price:</strong>${
                          order.price * order.quantity
                        }</p>
                    </div>
                </div>
                <div class="order-actions">
                    ${feedbackButton}
                </div>
                </div>
            `;
        });
        ordersHTML += "</div>";
      } else {
        ordersHTML =
          "<h1>No orders Found</h1><p>You haven't listed any products yet.</p>";
      }

      
      content.innerHTML = ordersHTML;


      let paginationHTML = '<div class="pagination">';
      if (page > 1) {
        paginationHTML += `<button onclick="fetchCompletedOrders(${
          page - 1
        })">Previous</button>`;
      }
      if (page < totalPages) {
        paginationHTML += `<button onclick="fetchCompletedOrders(${
          page + 1
        })">Next</button>`;
      }
      paginationHTML += "</div>";

      content.innerHTML += paginationHTML;

      currentPage = page;
    }
  };

  xhr.send();
}





function fetchOverallOrderData() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "getoverallorderdata.php", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      let content = document.getElementById("order-container");
      let orders = JSON.parse(xhr.responseText);
      let cost = orders.total_cost ==null ? 0 : orders.total_cost;

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
                                <p id="total-cost">$${cost}</p>
                            </div>
                        </div>
                    </div>
                `;

      ordersHTML += "</div>";
      content.innerHTML = ordersHTML;
    }
  };

  xhr.send();
}
