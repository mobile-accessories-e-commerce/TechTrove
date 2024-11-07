
function searchProducts() {
    let searchTerm = document.getElementById('search').value;
    const xhr = new XMLHttpRequest();
    const main_container = document.getElementById('product-section-container');

    xhr.open('GET', `search.php?query=${searchTerm}`, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            let products = JSON.parse(xhr.responseText);
            let updateContent = `<div>Search Result for "${searchTerm}"</div><ul class="product-section-item-wrapper">`;
            if (products == "false") {
                const xhr2 = new XMLHttpRequest();
                xhr2.open('GET', `storeSearchQuary.php?query=${searchTerm}?type`, true);
                xhr2.send();
                updateContent += `<h1>No product found try different keyword</h1>`;
            } else {
                if (products.length > 0) {
                    products.forEach(function (product) {
                        let discount = product['discount'] != null ? product['discount'] : "none";
                        let price = product['discount'] != null ? product['price_after_discount'] : product['price'];
                        let stockstatus = (product['stock_quantity'] ==0 )? "" : "This is out of stock.";
                        let discountStatus = (product['discount'] == null)?`<span class="product-price"> $${product['price']}</span>` : 
                        `<div class="price">
                                    
                                    <span class="product-price">
                                        $${product['price_after_discount']}</span>
                                        <div class="dis">
                                        <del class="old-price">$${product['price']}</del>
                                        <span class="discount">-${product['discount']}%</span>
                                        </div>
                                </div>`;
                        updateContent += `
            <a class="product-link" href="productveiwpage.php?product_id=${product['product_id']}"><li class="product-item">
                    <div class="product-image">
                        <img src="../images/${product['image_link']}" alt="smart watch">
                    </div>
                    <div class="product-text">
                        <span class="product-title">
                            ${product['product_name']}
                        </span>
                        
                        <span style="color:red; font-size:13px">
                            ${stockstatus}
                        </span>
                        <div class="product-purchase">
                           ${discountStatus}
                        </div>    
                    </div>
                    
                </li></a>`;


            /*  */
                    });
                } else {
                    updateContent += `<p>No products found</p>`;
                }
            }

            updateContent += `</ul>`;
            main_container.innerHTML = updateContent;
        }
    };

    xhr.send();
}

function categorySearch() {
    let searchTerm = document.getElementById('category').value;
    const xhr = new XMLHttpRequest();
    const main_container = document.getElementById('product-section-container');

    xhr.open('GET', `catogorySearch.php?query=${searchTerm}`, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            let products = JSON.parse(xhr.responseText);
            let updateContent = `<div>Category Result</div><ul class="product-section-item-wrapper">`;

            if (products.length > 0) {
                products.forEach(function (product) {
                    let discount = product['discount'] != null ? product['discount'] : "none";
                        let price = product['discount'] != null ? product['price_after_discount'] : product['price'];
                        let stockstatus = (product['stock_quantity'] ==0 )? "" : "This is out of stock.";
                        let discountStatus = (product['discount'] == null)?`<span class="product-price"> $${product['price']}</span>` : 
                        `<div class="price">
                                    
                                    <span class="product-price">
                                        $${product['price_after_discount']}</span>
                                        <div class="dis">
                                        <del class="old-price">$${product['price']}</del>
                                        <span class="discount">-${product['discount']}%</span>
                                        </div>
                                </div>`;
                        updateContent += `
            <a class="product-link" href="productveiwpage.php?product_id=${product['product_id']}"><li class="product-item">
                    <div class="product-image">
                        <img src="../images/${product['image_link']}" alt="smart watch">
                    </div>
                    <div class="product-text">
                        <span class="product-title">
                            ${product['product_name']}
                        </span>
                        
                        <span style="color:red; font-size:13px">
                            ${stockstatus}
                        </span>
                        <div class="product-purchase">
                           ${discountStatus}
                        </div>    
                    </div>
                    
                </li></a>`;

                });
            } else {
                updateContent += `<p>No products found in this category</p>`;
            }

            updateContent += `</ul>`;
            main_container.innerHTML = updateContent;
        }
    };

    xhr.send();
}


window.onload = function () {
    const searchTerm = document.getElementById('search').value;
    if (searchTerm) {
        searchProducts();  // Automatically call searchProducts to display results
    }
};
