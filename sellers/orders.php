<?php
session_start();
include "../connect.php";

if(!isset($_SESSION['seller_id'])){
    header("location:sellerdashbord.php");
    exit();
} else {
    $seller_id = $_SESSION['seller_id'];
}

// Corrected SQL query
$sql = "SELECT o.address, o.country, o.zip_code, o.phone_number, o.email, o.payment_method, 
               p.product_name, oi.quantity, oi.price,p.image_link
        FROM orders AS o 
        JOIN order_items AS oi ON o.order_id = oi.order_id
        JOIN products AS p ON oi.product_id = p.product_id
        WHERE p.seller_id = '$seller_id'";

$result = mysqli_query($con, $sql);

if(!mysqli_num_rows($result)>0){
    header("location:sellerdashbord.php");
}
// Fetch order products into array
$order_products = array();
while($row = mysqli_fetch_assoc($result)){
    array_push($order_products, $row);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #28a745;
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 20px;
        }

        .order-message {
            text-align: center;
            font-size: 1.2em;
            color: #555;
        }

        .order-list {
            margin-top: 30px;
            list-style-type: none;
            padding: 0;
        }

        .order-list li {
            background-color: #f9f9f9;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            margin: 60px;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .order-list li .product-info {
            font-size: 1.1em;
        }

        .order-list li .price {
            font-size: 1.2em;
            font-weight: bold;
            color: #007bff;
        }

        .order-list li .quantity {
            font-size: 1.1em;
            color: #555;
        }

        .order-list li .icon {
            font-size: 2em;
            color: #28a745;
        }

        .success-icon {
            font-size: 5em;
            color: #28a745;
            text-align: center;
        }

        .details {
            margin-top: 30px;
            font-size: 1.2em;
            text-align: left;
            color: #333;
        }
    </style>
</head>
<body>

<a href="sellerdashbord.php"><button>back</button></a>
<div class="container">
    <h1>Your Orders</h1>
    <p class="order-message">Make sure you delevier items on time</p>

    <!-- Success Icon -->
    <div class="success-icon">
        &#10004; <!-- Checkmark icon -->
    </div>

    <ul class="order-list">
        <?php foreach($order_products as $product): ?>
        <li>
            <span class="icon">&#128722;</span> <!-- Cart icon -->
            <div class="product-info">
                <img src="../images/<?php echo $product['image_link'] ?>" alt="">
                <strong>Product:</strong> <?php echo $product['product_name']; ?> <br>
                <strong>Quantity:</strong> <?php echo $product['quantity']; ?>
            </div>
            <div class="price">$<?php echo $product['price']; ?></div>
       
        <div class="details">
        <h3>Shipping Details:</h3>
        <p><strong>Address:</strong> <?php echo $product['address']; ?></p>
        <p><strong>Country:</strong> <?php echo $product['country']; ?></p>
        <p><strong>Zip Code:</strong> <?php echo $product['zip_code']; ?></p>
        <p><strong>Phone Number:</strong> <?php echo $product['phone_number']; ?></p>
        <p><strong>Email:</strong> <?php echo $product['email']; ?></p>
        <p><strong>Payment Method:</strong> <?php echo $product['payment_method']; ?></p>
    </div>
    <div><button>Make as deliver</button></div>
    </li>
        <?php endforeach; ?>
    </ul>

    
</div>

</body>
</html>
