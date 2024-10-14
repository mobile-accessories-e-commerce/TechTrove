<?php
session_start();
include '../connect.php'; 
include '../layouts/header.php';

$userId = $_SESSION['userid']; 


$query = "
    SELECT 
        c.cart_id,
        cpi.item_id,
        p.product_name,
        p.price,
        p.image_link,
        cpi.quantity
    FROM 
        carts AS c
    JOIN 
        cart_product_items AS cpi ON c.cart_id = cpi.cart_id
    JOIN 
        products AS p ON cpi.product_id = p.product_id
    WHERE 
        c.user_id = ?
";

$stmt = $con->prepare($query);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $cartItems = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $cartItems = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    
    <style>
        .row {
            width: 80%;
            margin: auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
        }
        .card {
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
    <div class="container">
        <h1>Your Cart</h1>
        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($cartItems as $item): ?>
                    <div class="card">
                        <img src="../images/<?php echo $item['image_link']; ?>" alt="<?php echo $item['product_name']; ?>">
                        <h2><?php echo $item['product_name']; ?></h2>
                        <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                        <p>Quantity: <?php echo $item['quantity']; ?></p>
                        <button class="buy-button" data-item-id="<?php echo $item['item_id']; ?>">Buy</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
