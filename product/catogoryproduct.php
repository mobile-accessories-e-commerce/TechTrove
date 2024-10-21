<?php
session_start();
include '../connect.php'; 



$product_list = array();
if($_SERVER['REQUEST_METHOD']==='GET'){

    $cat_id = $_GET['cat_id'];
$products_query = "
    SELECT p.product_id, p.seller_id, p.product_name, p.description, p.price, p.image_link, pc.name AS category_name
    FROM products p
    JOIN product_catogory pc ON p.catogory_id = pc.product_cat_id
    WHERE pc.product_cat_id = '$cat_id';
";


$products_result = $con->query($products_query);



while($row=mysqli_fetch_assoc($products_result)){
    array_push($product_list,$row);
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>
    <link rel="stylesheet" href="../style/products.css">
</head>
<body>
<div class="product-section-container">
    <?php if(count($product_list)>0): ?>
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
    <?php else :?>
        <h2>No Product in this catogory</h2> </br>
        <a href="../Home/dashbord.php"><button>Back to Home</button></a>
</div>
    <?php endif; ?>
</body>
</html>