function addCategory() {
    const main_container = document.getElementById('main_container');
    const xhr = new XMLHttpRequest();
    let catogoryHTML = `<div class="cat-container"><h1>Product Catogory</h1><table>
                        <tr>
                            <th>cat_id</th>
                            <th>Name</th>
                            
                        </tr>`;

    xhr.open('GET', 'getcatogory.php?type=product', true); 

    xhr.onload = function() {
        if (xhr.status === 200) {
            
            const data = JSON.parse(xhr.responseText);
            
        
            const productCategories = data.productCategories;
            const serviceCategories = data.serviceCategories;

        
            productCategories.forEach(function(cat) {
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
            serviceCategories.forEach(function(cat) {
                catogoryHTML += `
                    
                        <tr>
                            <td>${cat.service_cat_id}</td>
                            <td>${cat.name}</td>
                            
                        </tr>
                        
                        
                    `;
            });

            catogoryHTML +=`</table>
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
