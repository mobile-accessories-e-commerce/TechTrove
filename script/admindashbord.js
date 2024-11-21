function addCategory() {
  const main_container = document.getElementById("main_container");
  const xhr = new XMLHttpRequest();

  let categoryHTML = `
    <div class="cat-container">
      <h1>Product Category</h1>
      <table>
        <tr>
          <th>cat_id</th>
          <th>Name</th>
        </tr>`;

  xhr.open("GET", "getcatogory.php?type=product", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);

      // Populate Product Categories
      data.productCategories.forEach(function (cat) {
        categoryHTML += `
          <tr>
            <td>${cat.product_cat_id}</td>
            <td>${cat.name}</td>
          </tr>`;
      });

      categoryHTML += `
        </table>
        <div>
          <form action='addcategory.php' method='POST'>
            <input type='hidden' name='cat_type' value='product'>
            <input type='text' name='cat_name' required>
            <input type='submit' value='Add Category' name='submit'>
          </form>
        </div>
      </div>`;

      // Populate Service Categories
      categoryHTML += `
        <div class="cat-container">
          <h1>Service Category</h1>
          <table>
            <tr>
              <th>cat_id</th>
              <th>Name</th>
            </tr>`;
      
      data.serviceCategories.forEach(function (cat) {
        categoryHTML += `
          <tr>
            <td>${cat.service_cat_id}</td>
            <td>${cat.name}</td>
          </tr>`;
      });

      categoryHTML += `
        </table>
        <div>
          <form action='addcategory.php' method='POST'>
            <input type='hidden' name='cat_type' value='service'>
            <input type='text' name='cat_name' required>
            <input type='submit' value='Add Category' name='submit'>
          </form>
        </div>
      </div>`;

      main_container.innerHTML = categoryHTML;
    }
  };

  xhr.send();
}

function getAllProduct() {
  const main_container = document.getElementById("main_container");
  let productsHTML = `
    <div class="cat-container">
      <h1>Products</h1>
      <table>
        <tr>
          <th>Image</th>
          <th>Product Name</th>
          <th>Price</th>
          <th>Seller ID</th>
          <th>Quantity</th>
          <th>Category ID</th>
          <th>Product ID</th>
          <th>View Count</th>
          <th>Rating</th>
        </tr>`;

  const xhr = new XMLHttpRequest();
  xhr.open("GET", "getproduct.php", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const productList = JSON.parse(xhr.responseText);

      productList.forEach(function (product) {
        const rating = product.rating || 0;
        productsHTML += `
          <tr>
            <td><img src="../images/${product.image_link}" width="100" height="100"></td>
            <td>${product.product_name}</td>
            <td>${product.price}</td>
            <td>${product.seller_id}</td>
            <td>${product.stock_quantity}</td>
            <td>${product.category_id}</td>
            <td>${product.product_id}</td>
            <td>${product.view_count}</td>
            <td>${rating}</td>
          </tr>`;
      });

      productsHTML += `</table></div>`;
      main_container.innerHTML = productsHTML;
    }
  };

  xhr.send();
}

function getSearchKeyword() {
  const main_container = document.getElementById("main_container");
  let keywordHTML = `
    <div class="cat-container">
      <h1>Product Search Keywords</h1>
      <table>
        <tr>
          <th>ID</th>
          <th>Date</th>
          <th>Query</th>
          <th>Search Count</th>
        </tr>`;

  const xhr = new XMLHttpRequest();
  xhr.open("GET", "getkeyword.php", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);

      // Populate Product Keywords
      data.productKeyword.forEach(function (keyword) {
        keywordHTML += `
          <tr>
            <td>${keyword.id}</td>
            <td>${keyword.date}</td>
            <td>${keyword.query}</td>
            <td>${keyword.search_count}</td>
          </tr>`;
      });

      keywordHTML += `
        </table>
      </div>
      <div class="cat-container">
        <h1>Service Search Keywords</h1>
        <table>
          <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Query</th>
            <th>Search Count</th>
          </tr>`;

      // Populate Service Keywords
      data.serviceKeyword.forEach(function (keyword) {
        keywordHTML += `
          <tr>
            <td>${keyword.id}</td>
            <td>${keyword.date}</td>
            <td>${keyword.quary}</td>
            <td>${keyword.search_count}</td>
          </tr>`;
      });

      keywordHTML += `</table></div>`;
      main_container.innerHTML = keywordHTML;
    }
  };

  xhr.send();
}

function getFeatureProduct() {
  const main_container = document.getElementById("main_container");
  let featureHTML = `
    <div class="cat-container">
      <h1>Feature Products</h1>
      <table>
        <tr>
          <th>Image</th>
          <th>Product ID</th>
          <th>Seller ID</th>
          <th>Product Name</th>
          <th>Description</th>
          <th>Start Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>`;

  const xhr = new XMLHttpRequest();
  xhr.open("GET", "getfeatureproduct.php", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const productList = JSON.parse(xhr.responseText);

      productList.forEach(function (product) {
        const status = product.approved ? "Block" : "Approve";
        featureHTML += `
          <tr>
            <td><img src="../images/${product.image_link}" width="100" height="100"></td>
            <td>${product.product_id}</td>
            <td>${product.seller_id}</td>
            <td>${product.title}</td>
            <td>${product.description}</td>
            <td>${product.start_date}</td>
            <td>
              <a class="${product.approved ? "block" : "approve"}" 
                 href="changefetureproductstatus.php?id=${product.id}">
                ${status}
              </a>
            </td>
            <td>
              <button onclick="deleteFeatureProduct(${product.product_id})">
                Delete
              </button>
            </td>
          </tr>`;
      });

      featureHTML += `</table></div>`;
      main_container.innerHTML = featureHTML;
    }
  };

  xhr.send();
}

function deleteFeatureProduct(product_id) {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `deletefeatureproduct.php?product_id=${product_id}`, true);

  xhr.onload = function () {
    if (xhr.status === 200 && JSON.parse(xhr.responseText) === 1) {
      console.log("Success");
      getFeatureProduct();
    }
  };

  xhr.send();
}

function givePromotion() {
  const main_container = document.getElementById("main_container");
  let promotionHTML = `
    <div>
      <button onclick='displayForm()'>Give Promotion</button>
      <div id="myModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2>Submit Data</h2>
          <form id="popupForm">
            <label for="product_id">Product ID</label>
            <input type="number" id="product_id" name="product_id" required><br><br>
            <label for="discount">Discount</label>
            <input type="number" id="discount" name="discount" required><br><br>
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" required><br><br>
            <button onclick="submitForm()" type="submit">Submit</button>
            <p id="message"></p>
          </form>
        </div>
      </div>
    </div>`;

  promotionHTML += `
    <div class="cat-container">
      <h1>Promotion Products</h1>
      <table>
        <tr>
          <th>Image</th>
          <th>Product ID</th>
          <th>Seller ID</th>
          <th>Product Name</th>
          <th>Description</th>
          <th>Discount</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Final Price</th>
          <th>Action</th>
        </tr>`;

  const xhr = new XMLHttpRequest();
  xhr.open("GET", "getPromotionProduct.php", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const productList = JSON.parse(xhr.responseText);

      productList.forEach(function (product) {
        const finalPrice = (product.price - product.price * (product.discount / 100)).toFixed(2);
        promotionHTML += `
          <tr>
            <td><img src="../images/${product.image_link}" width="100" height="100"></td>
            <td>${product.product_id}</td>
            <td>${product.seller_id}</td>
            <td>${product.title}</td>
            <td>${product.description}</td>
            <td>${product.discount}%</td>
            <td>${product.start_date}</td>
            <td>${product.end_date}</td>
            <td>${finalPrice}</td>
            <td>
              <button onclick="deletePromotion(${product.product_id})">
                Delete
              </button>
            </td>
          </tr>`;
      });

      promotionHTML += `</table></div>`;
      main_container.innerHTML = promotionHTML;
    }
  };

  xhr.send();
}

function deletePromotion(product_id) {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `deletepromotion.php?product_id=${product_id}`, true);

  xhr.onload = function () {
    if (xhr.status === 200 && JSON.parse(xhr.responseText) === 1) {
      console.log("Success");
      givePromotion();
    }
  };

  xhr.send();
}

function submitForm() {
  const product_id = document.getElementById("product_id").value;
  const discount = document.getElementById("discount").value;
  const end_date = document.getElementById("end_date").value;
  const message = document.getElementById("message");

  if (!product_id || !discount || !end_date) {
    message.textContent = "All fields are required!";
    message.style.color = "red";
    return;
  }

  const xhr = new XMLHttpRequest();
  xhr.open("GET", `update_promotion.php?product_id=${product_id}&discount=${discount}&end_date=${end_date}`, true);

  xhr.onload = function () {
    if (xhr.status === 200 && JSON.parse(xhr.responseText) === 1) {
      console.log("Success");
      givePromotion();
      closeModal();
    } else {
      message.textContent = "Failed to update promotion!";
      message.style.color = "red";
    }
  };

  xhr.send();
}

function displayForm() {
  const modal = document.getElementById("myModal");
  modal.style.display = "block";
}

function closeModal() {
  const modal = document.getElementById("myModal");
  modal.style.display = "none";
}

// Close modal on outside click
window.onclick = function (event) {
  const modal = document.getElementById("myModal");
  if (event.target === modal) {
    closeModal();
  }
};
