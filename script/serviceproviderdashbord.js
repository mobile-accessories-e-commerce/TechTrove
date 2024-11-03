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
                                <div class="product-stock">Stock: ${service.service_status}</div>
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
            "<h1>No services Found</h1><p>You haven't listed any service yet.</p>";
        }
      }
    }
  };
  xhr.send();
}
