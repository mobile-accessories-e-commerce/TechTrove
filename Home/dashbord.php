<?php
session_start();
include '../connect.php'; 

if(!isset($_SESSION["username"])){
    header("location:../authentication/loging.php");
}

include '../layouts/header.php';


$product_category_query = "SELECT product_cat_id, name FROM product_catogory";
$product_category_result = $con->query($product_category_query);


$service_category_query = "SELECT service_cat_id, name FROM service_catogory";
$service_category_result = $con->query($service_category_query);


$products_query = "
    SELECT p.product_id, p.seller_id, p.product_name, p.description, p.price, p.image_link, pc.name AS category_name
    FROM products p
    JOIN product_catogory pc ON p.catogory_id = pc.product_cat_id
";

$services_query = "
    SELECT s.service_name, s.description, s.price, s.image_link, sc.name AS category_name
    FROM services s
    JOIN service_catogory sc ON s.catogory_id = sc.service_cat_id
";

$products_result = $con->query($products_query);
$services_result = $con->query($services_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body{
            background-color: #ffeefe;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
        }
        .card {
            background-color: white ;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin: 10px;
            width: calc(25% - 40px); 
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        h2 {
            width: 100%;
            margin: 20px 0;
        }
    </style>
</head>
<body>
<h1>Wellcome <?php echo $_SESSION['username'] ?></h1>
<button><a href="../authentication/logout.php">LogOut</a></button>

<div class="container">
    <h1>Dashboard</h1>

   
    <h2>Products</h2>
    <?php while ($product_row = $products_result->fetch_assoc()): ?>
        <div class="card">
            <img src="../images/<?php echo $product_row['image_link']; ?>" alt="<?php echo $product_row['product_name']; ?>">
            <h4><?php echo $product_row['product_name']; ?></h4>
            <p><?php echo $product_row['description']; ?></p>
            <p>Price: $<?php echo number_format($product_row['price'], 2); ?></p>
            <button class="button add-to-cart" data-product-id="<?php echo $product_row['product_id']; ?>">Add to Cart</button>

        </div>
    <?php endwhile; ?>

    
    <h2>Services</h2>
    <?php while ($service_row = $services_result->fetch_assoc()): ?>
        <div class="card">
            <img src="../images/<?php echo $service_row['image_link']; ?>" alt="<?php echo $service_row['service_name']; ?>">
            <h4><?php echo $service_row['service_name']; ?></h4>
            <p><?php echo $service_row['description']; ?></p>
            <p>Price: $<?php echo number_format($service_row['price'], 2); ?></p>
            <button class="button">Add to Cart</button>
        </div>
    <?php endwhile; ?>
</div>

<script>
    document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');

        
        fetch('../cart/add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Product added to cart!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

</script>
</body>
</html>










