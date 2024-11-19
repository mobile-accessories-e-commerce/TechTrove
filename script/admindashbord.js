function addCategory() {
  const main_container = document.getElementById("main_container");
  const xhr = new XMLHttpRequest();
  let catogoryHTML = `<div class="cat-container"><h1>Product Catogory</h1><table>
                        <tr>
                            <th>cat_id</th>
                            <th>Name</th>
                            
                        </tr>`;

  xhr.open("GET", "getcatogory.php?type=product", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);

      const productCategories = data.productCategories;
      const serviceCategories = data.serviceCategories;

      productCategories.forEach(function (cat) {
        catogoryHTML += `
                        <tr>
                            <td>${cat.product_cat_id}</td>
                            <td>${cat.name}</td>
                            
                        </tr>
                    `;
      });

      catogoryHTML += `</table>
                    <div>
                        <form action='addcatogory.php' method='POST'>
                        <input type='hidden' name='cat_type' value='product'>
                        <input type='text' name='cat_name' requered>
                        <input type='submit' value='Add Catogory' name='name'>
                        </form>
                    </div>
            </div>`;

      catogoryHTML += `<div class="cat-container"><h1>service Catogory</h1> <table>
                        <tr>
                            <th>cat_id</th>
                            <th>Name</th>
                            
                        </tr>`;
      serviceCategories.forEach(function (cat) {
        catogoryHTML += `
                    
                        <tr>
                            <td>${cat.service_cat_id}</td>
                            <td>${cat.name}</td>
                            
                        </tr>
                        
                        
                    `;
      });

      catogoryHTML += `</table>
            <div>
                        <form action='addcatogory.php' method='POST'>
                        <input type='hidden' name='cat_type' value='service'>
                        <input type='text' name='cat_name' requered>
                        <input type='submit' value='Add Catogory' name='name'>
                        </form>
                    </div>
            </div>`;
      main_container.innerHTML = catogoryHTML;
    }
  };

  xhr.send();
}

function getAllProduct() {
  const main_container = document.getElementById("main_container");

  let productsHTML = `<div class="cat-container"><h1>Products</h1><table>
                        <tr>
                         <th></th>
                            <th>product name</th>
                            <th>Price</th>
                            <th>Seller_id</th>
                            <th>quantity</th>
                             <th>category_id</th>
                              <th>Product id</th>
                               <th>View Count</th>
                            <th>rating</th>
                            

          
                        </tr>`;
  const xhr = new XMLHttpRequest();

  xhr.open("GET", "getproduct.php", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const product_list = JSON.parse(xhr.responseText);

      product_list.forEach(function (product) {
        rating = product.rating == null ? 0 : product.rating;
        productsHTML += `
                        <tr>
                        <td><img src="../images/${product.image_link}" width="100" height="100"></td>
                        <td>${product.product_name}</td>
                        <td>${product.price}</td>
                        <td>${product.seller_id}</td>
                        <td>${product.stock_quantity}</td>
                        <td>${product.catogory_id}</td>
                        <td>${product.product_id}</td>
                        <td>${product.view_count}</td>
                        <td>${rating}</td>
                        
                        </tr>    
                `;
      });
      productsHTML += `</table>`;
      main_container.innerHTML = productsHTML;
    }
  };

  xhr.send();
}

function getSearchKeyword() {
  const main_container = document.getElementById("main_container");

  let keyWordHTML = `<div class="cat-container"><h1>Product Search KeyWord</h1><table>
                        <tr>
                         
                            <th>Id</th>
                            <th>Date</th>
                            <th>Quary</th>
                            <th>Search_count</th>
                        </tr>`;
  const xhr = new XMLHttpRequest();

  xhr.open("GET", "getkeyword.php", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);
      const productKeyword = data.productKeyword;
      const serviceKeyword = data.serviceKeyword;

      productKeyword.forEach(function (keyword) {
        keyWordHTML += `
                        <tr>
                       
                        <td>${keyword.id}</td>
                        <td>${keyword.date}</td>
                        <td>${keyword.quary}</td>
                        <td>${keyword.search_count}</td> 
                        </tr>    
                `;
      });
      keyWordHTML += `</table></div>`;

       keyWordHTML += `<div class="cat-container"><h1>Service Search KeyWord</h1><table>
      <tr>
       
          <th>Id</th>
          <th>Date</th>
          <th>Quary</th>
          <th>Search_count</th>
      </tr>`;

      serviceKeyword.forEach(function (keyword) {
        keyWordHTML += `
                        <tr>
                       
                        <td>${keyword.id}</td>
                        <td>${keyword.date}</td>
                        <td>${keyword.quary}</td>
                        <td>${keyword.search_count}</td> 
                        </tr>    
                `;
      });

      keyWordHTML += `</table></div>`;
      main_container.innerHTML = keyWordHTML;
    }
  };

  xhr.send();
}

function getFeatureProduct() {
  const main_container = document.getElementById("main_container");

  let productsHTML = `<div class="cat-container"><h1>Feature Products</h1><table>
                        <tr>
                         <th></th>
                            <th>product_id</th>
                            <th>Seller_id</th>
                            <th>product name</th>
                            <th>description</th>
                             <th>start_date</th>
                              <th>status</th>
                              <th>Action</th>
          
                        </tr>`;
  const xhr = new XMLHttpRequest();

  xhr.open("GET", "getfeatureproduct.php", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const product_list = JSON.parse(xhr.responseText);

      product_list.forEach(function (product) {
        productsHTML += `
                        <tr>
                        <td><img src="../images/${
                          product.image_link
                        }" width="100" height="100"></td>
                        <td>${product.product_id}</td>
                        <td>${product.seller_id}</td>
                        <td>${product.title}</td>
                        <td>${product.description}</td>
                        <td>${product.start_date}</td>
                        <td ><a class="${
                          product.approved == 1 ? "block" : "approve"
                        }" href="changefetureproductstatus.php?id=${
          product.id
        }">${product.approved == 1 ? "Block" : "Approved"}</a></td>
                        <td><button onclick="deleteFeatureProduct(${product.product_id})">Delete</button></td>
                       
                        
                        
                        </tr>    
                `;
      });
      productsHTML += `</table>`;
      main_container.innerHTML = productsHTML;
    }
  };

  xhr.send();
}

function deleteFeatureProduct(product_id){
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `deletefeatureproduct.php?product_id=${product_id}`, true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const responce = JSON.parse(xhr.responseText);
      if(responce==1){
        console.log("sucsuss");
        getFeatureProduct();

      }
}

  };
  xhr.send();
}

function givePromotion() {
  const main_container = document.getElementById("main_container");

  let promotionHTML = `<div>
    <button onclick='displayForm()'>Give Promotion</button>
    
                            <div id="myModal" class="modal">
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <h2>Submit Data</h2>
                                    <form id="popupForm">
                                        <label for="product id">Product Id</label>
                                        <input type="number" id="product_id" name="product_id" required><br><br>
                                        <label for="discount">Discount:</label>
                                        <input type="number" id="discount" name="discount" required><br><br>
                                         <label for="end_date">End Date:</label>
                                        <input type="date" id="end_date" name="end_date" required><br><br>
                                        <button onclick="submitForm()" type="submit">Submit</button>
                                        <p id="message"></p>
                                    </form>
                                </div>
                            </div>
    `;
  promotionHTML += `<div class="cat-container"><h1>Promotion Products</h1><table>
    <tr>
        <th></th>
        <th>Product ID</th>
        <th>Seller ID</th>
        <th>Product Name</th>
        <th>Description</th>
        <th>Discount</th>
        <th>Start Date</th>
        <th>End Date </th>
        <th>Final Price</th>
        <th>Action</th>`;

  const xhr = new XMLHttpRequest();
  xhr.open("GET", "getPromotionProduct.php", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const product_list = JSON.parse(xhr.responseText);

      product_list.forEach(function (product) {
        promotionHTML += `
                        <tr>
                            <td><img src="../images/${product.image_link}" width="100" height="100"></td>
                            <td>${product.product_id}</td>
                            <td>${product.seller_id}</td>
                            <td>${product.product_name}</td>
                            <td>${product.description}</td>
                            <td>${product.discount}%</td>
                            <td>${product.start_date}</td>
                            <td>${product.end_date}</td>
                            <td>${product.price_after_discount}</td>
                            <td><button onclick="deletePromotion(${product.product_id})">Delete</button></td>
                        </tr>
                    `;
      });
      promotionHTML += `</table></div></div>`;
      main_container.innerHTML = promotionHTML;
    }
  };
  xhr.send();
}


function deletePromotion(product_id){
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `deletepromotion.php?product_id=${product_id}`, true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const responce = JSON.parse(xhr.responseText);
      if(responce==1){
        console.log("sucsuss");
        givePromotion()

      }
}

  };
  xhr.send();
}

function displayForm() {
  document.getElementById("myModal").style.display = "block";

  document.getElementsByClassName("close")[0].onclick = function () {
    document.getElementById("myModal").style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == document.getElementById("myModal")) {
      document.getElementById("myModal").style.display = "none";
    }
  };
}

function submitForm() {
  document.getElementById("popupForm").onsubmit = function (event) {
    event.preventDefault(); 

    const product_id = document.getElementById("product_id").value;
    const discount = document.getElementById("discount").value;
    const end_date = document.getElementById("end_date").value;

    // Send data via AJAX
    const xhr = new XMLHttpRequest();
    xhr.open(
      "GET",
      `update_promotion.php?product_id=${product_id}&discount=${discount}&end_date=${end_date}`,
      true
    );

    xhr.onload = function () {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        const messageElement = document.getElementById("message");
        messageElement.textContent = response.message;

        if (response.status === "success") {
          messageElement.style.color = "green";
          givePromotion();
        } else {
          messageElement.style.color = "red";
        }
      } else {
        alert("An error occurred while processing your request.");
      }
    };
    xhr.send();
  };
}
