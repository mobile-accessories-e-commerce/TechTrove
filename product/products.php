<?php
session_start();
include '../connect.php'; 


$products_query = "
    SELECT p.product_id, p.seller_id, p.product_name, p.description, p.price, p.image_link, pc.name AS category_name
    FROM products p
    JOIN product_catogory pc ON p.catogory_id = pc.product_cat_id
";


$products_result = $con->query($products_query);


$product_list = array();
while($row=mysqli_fetch_assoc($products_result)){
    array_push($product_list,$row);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>
    <link rel="stylesheet" href="../style/product.css">
</head>
<body>
<div class="header">
    <input type="text" id="search" placeholder="Search products..." onkeyup="searchProducts()" />
    <div id="search-results"></div> 
</div>

<div class="side-bar">
    <div class="side-bar-icon">
        <a href="../cart/cartlandingpage.php">Cart</a>
    </div>
    <div class="side-bar-icon">
        <a href="../Home/dashbord.php">Home</a>
    </div>
    <div class="side-bar-icon">
        <a href="">Free shipping</a>
    </div>
</div>

<div class="product-section-container" id="product-section-container">
    
    <ul class="product-section-item-wrapper">
        <?php foreach($product_list as $product): ?>
        <li class="product-item">
            <div class="product-image">
                <img src="../images/<?php echo $product['image_link'] ?>" alt="smart watch">

            </div>
            <div class="product-text">
                <span class="product-title">
                    <?php echo $product['product_name'] ?>
                </span>
                <div class="product-purchace">
                    <span class="product-price">
                    <?php echo "$".$product['price'] ?>
                    </span>
                    <a href="../product/productveiwpage.php?product_id=<?php echo $product['product_id']; ?>"><button class="blue-btn add-to-cart" >
                        Veiw Product
                    </button></a>
                    
                </div>

            </div>

        </li>

        <?php endforeach; ?>
    </ul>
</div>

<script>
function searchProducts() {
    let searchTerm = document.getElementById('search').value;

    
    const xhr = new XMLHttpRequest();
    let main_container = document.getElementById('product-section-container');

   
    xhr.open('GET', `search.php?query=${searchTerm}`, true);
    
    let updateContent = `<div>Search Result for "${searchTerm}"</div>  <ul class="product-section-item-wrapper">`;

  
    xhr.onload = function() {
        if (xhr.status === 200) {
            let products = JSON.parse(xhr.responseText);  
            
        
            products.forEach(function(product) {
                updateContent += ` 
                <li class="product-item">
                    <div class="product-image">
                        <img src="../images/${product['image_link']}" alt="smart watch">
                    </div>
                    <div class="product-text">
                        <span class="product-title">
                            ${product['product_name']}
                        </span>
                        <div class="product-purchace">
                            <span class="product-price">
                                $${product['price']}
                            </span>
                            <a href="../product/productveiwpage.php?product_id=${product['product_id']}">
                                <button class="blue-btn add-to-cart">
                                    View Product
                                </button>
                            </a>
                        </div>
                    </div>
                </li>`;
            });

            
            main_container.innerHTML = updateContent;
        }
    };

    
    xhr.send();
}
</script>
</body>
</html>