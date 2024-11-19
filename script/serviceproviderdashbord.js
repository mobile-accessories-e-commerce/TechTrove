function loadContent(section) {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `fetch_serviceProvider_data.php?section=${section}`, true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      let content = document.getElementById("main-content");
      if (section === "all_service") {
        let services = JSON.parse(xhr.responseText);
        content.innerHTML = "<h1>All services</h1>";
        if (services.length > 0) {
          let productHTML = '<div class="product-list">';
          services.forEach(function (service) {
            productHTML += `
                            <div class="product">
                                <img src="../images/${service.image_link}" alt="${service.service_name}">                              
                                <div class="product-name">${service.service_name}</div>
                                <div class="product-price">$${service.price}</div>
                                <a href="editservice.php?service_id=${service.service_id}">Edit</a>
                            </div>
                        `;
          });
          productHTML += "</div>";
          content.innerHTML += productHTML;
        } else {
          content.innerHTML =
            "<h1>No services Found</h1><p>You haven't listed any service yet.</p>";
        }
      }
      if (section === "reports") {
        content.innerHTML = `<div class="reports-menu">
                                    <h2>Today Reports</h2>
                                    <ul>
                                        <li><a href='reports.php?report_type=sales_reports&type=daily'>Sales Summary Report</a></li>
                                        <li><a href='reports.php?report_type=product_reports&type=daily'>Product Performance Report</a></li>
                                        <li><a href='reports.php?report_type=top_selling_products&type=daily'>Top Selling Products</a></li>
                                        <li><a href='reports.php?report_type=customer_reports&type=daily'>Customer Report</a></li>
                                    </ul>
                                </div>

                                <div class="reports-menu">
                                    <h2>This Month Reports</h2>
                                    <ul>
                                        <li><a href='reports.php?report_type=sales_reports&type=monthly'>Sales Summary Report</a></li>
                                        <li><a href='reports.php?report_type=product_reports&type=monthly'>Product Performance Report</a></li>
                                        <li><a href='reports.php?report_type=top_selling_products&type=monthly'>Top Selling Products</a></li>
                                        <li><a href='reports.php?report_type=customer_reports&type=monthly'>Customer Report</a></li>
                                    </ul>
                                </div>

                                <div class="reports-menu">
                                    <h2>This Year Reports</h2>
                                    <ul>
                                        <li><a href='reports.php?report_type=sales_reports&type=yearly'>Sales Summary Report</a></li>
                                        <li><a href='reports.php?report_type=product_reports&type=yearly'>Product Performance Report</a></li>
                                        <li><a href='reports.php?report_type=top_selling_products&type=yearly'>Top Selling Products</a></li>
                                        <li><a href='reports.php?report_type=customer_reports&type=yearly'>Customer Report</a></li>
                                    </ul>
                                </div>
                                <div class="reports-menu">
                                    <h2>Overall Reports</h2>
                                    <ul>
                                        <li><a href='reports.php?report_type=sales_reports&type=all'>Sales Summary Report</a></li>
                                        <li><a href='reports.php?report_type=product_reports&type=all'>Product Performance Report</a></li>
                                        <li><a href='reports.php?report_type=top_selling_products&type=all'>Top Selling Products</a></li>
                                        <li><a href='reports.php?report_type=customer_reports&type=all'>Customer Report</a></li>
                                    </ul>
                                </div>
                                    `;
      }
      
      
      
      if (section === "service_request") {
        let services = JSON.parse(xhr.responseText);
        content.innerHTML = "<h1>All services</h1>";
        if (services.length > 0) {
          let productHTML = '<div class="product-list">';
          services.forEach(function (service) {
            productHTML += `
                            <div class="product">
                                <img src="../images/${service.image_link}" alt="${service.service_name}">
                                <div class="product-name">${service.service_name}</div>
                                <div class="product-stock">${service.user_name}</div>
                                <div class="product-stock">${service.location}</div>
                                 <div class="product-stock">${service.description}</div>
                                  <div class="product-stock">${service.contact_number}</div>
                                <a href="confirmorder.php?service_request_id=${service.id}">Confirm</a>
                            </div>
                        `;
          });
          productHTML += "</div>";
          content.innerHTML += productHTML;
        } else {
          content.innerHTML =
            `<div class='empty-service'>
            <h1>No services Found</h1>
            <img src="../images/empty.jpg" width="150px" height="150px">
            <p>You haven't listed any service yet.</p>
            </div>`;
              `<h1>No services Found</h1>
              <p>hiii</p>
            <img src="../images/backcover - Copy.jpeg">
              <p>You haven't listed any service yet.</p>`;
        }
      }
    }
  };
  xhr.send();
}
