
     function searchServices() {
            let searchTerm = document.getElementById('search').value;
            const xhr = new XMLHttpRequest();
            const main_container = document.getElementById('product-section-container');

            xhr.open('GET', `search.php?query=${searchTerm}`, true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    let services = JSON.parse(xhr.responseText);
                    let updateContent = `<div>Search Result for "${searchTerm}"</div><ul class="product-section-item-wrapper">`;
                    if (services == "false") {
                        const xhr2 = new XMLHttpRequest();
                        xhr2.open('GET', `../product/storeSearchQuary.php?query=${searchTerm}&type=${"service"}`, true);
                        xhr2.send();
                        updateContent += `<h1>No service found try different keyword</h1>`;
                    } else {
                        if (services.length > 0) {
                            services.forEach(function (service) {
                               
                                updateContent += `
                    <li class="product-item">
                        <div class="product-image">
                            <img src="../images/${service['image_link']}" alt="smart watch">
                        </div>
                        <div class="product-text">
                            <span class="product-title">${service['service_name']}</span>
                            <div class="product-purchase">
                                <span class="product-price">$${service['price']}</span>
                            
                                <a href="serviceviewpage.php?service_id=${service['service_id']}">
                                    <button class="blue-btn add-to-cart">View service</button>
                                    
                                </a>
                            </div>
                        </div>
                    </li>`;
                            });
                        } else {
                            updateContent += `<p>No service found</p>`;
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

            xhr.open('GET', `categorysearch.php?query=${searchTerm}`, true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    let services = JSON.parse(xhr.responseText);
                    let updateContent = `<div>Category Result</div><ul class="product-section-item-wrapper">`;

                    if (services.length > 0) {
                        services.forEach(function (service) {
                            updateContent += `
                    <li class="product-item">
                        <div class="product-image">
                            <img src="../images/${service['image_link']}" alt="smart watch">
                        </div>
                        <div class="product-text">
                            <span class="product-title">${service['service_name']}</span>
                            <div class="product-purchase">
                                <span class="product-price">$${service['price']}</span>
                                
                                <a href="servuceveiwpage.php?product_id=${service['service_id']}">
                                    <button class="blue-btn add-to-cart">View service</button>
                                    
                                </a>
                            </div>
                        </div>
                    </li>`;
                        });
                    } else {
                        updateContent += `<p>No service found in this category</p>`;
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
                searchServices(); 
            }
        };
