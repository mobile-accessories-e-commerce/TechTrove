<?php
session_start();
include '../connect.php'; 
include '../layouts/header.php';

$userId = $_SESSION['userid']; 

function updateQuantity($value, $item_id){
    include '../connect.php'; 
    $query = "UPDATE cart_product_items SET quantity='$value' WHERE item_id='$item_id' ";
    $result = mysqli_query($con, $query);
    if (!$result) {
        die("An error updating the quantity");
    }
}

$query = "
    SELECT 
        c.cart_id,
        cpi.item_id,
        p.product_id,
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
            flex-direction: column;
        }
        .title {
            display: flex;
            width: 100%;
            justify-content: space-between;
            padding: 10px 0;
            font-weight: bold;
            background-color: #f7f7f7;
            border-bottom: 2px solid #e1e1e1;
        }
        .card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 15px;
            margin: 10px;
            width: 100%
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {

            width: 150px;
            height: 100px;
            border-radius: 5px;
        }
        .product_detail{
            width: 100px;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #45a049;
        }
        .quantity_container {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .quantity_container input {
            width: 60px;
            text-align: center;
        }
        .total-container {
            text-align: right;
            margin-top: 20px;
            font-size: 1.2em;
        }
        .total-container a {
            text-decoration: none;
            color: #fff;
            background-color: #007BFF;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .total-container a:hover {
            background-color: #0056b3;
        }
        @media (max-width: 768px) {
            .card {
                width: calc(50% - 40px); /* Responsive layout for smaller screens */
            }
        }
        @media (max-width: 480px) {
            .card {
                width: 100%; /* Full width on mobile */
            }
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
                        <div class="product_detail"><h2><?php echo $item['product_name']; ?></h2></div>
                        <div class="product_detail"><p>$<?php echo number_format($item['price'], 2); ?></p></div>
                        <div class="quantity_container product_detail">
                            <button onclick="decreaseQuantity(<?php echo $item['item_id']; ?>, <?php echo $item['price']; ?>)">-</button>
                            <input type="number" id="quantity_<?php echo $item['item_id']; ?>" value="<?php echo $item['quantity']; ?>" min="1">
                            <button onclick="increaseQuantity(<?php echo $item['item_id']; ?>, <?php echo $item['price']; ?>)">+</button>
                        </div>
                        <div class="product_detail"><p id="price_<?php echo $item['item_id']; ?>">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p></div>
                        <div><a href="deletecartitem.php?item_id=<?php echo $item['item_id']; ?>"><button class="button">Delete</button></a></div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="total-container">
                <h3>Total Cost: $<span id="totalCost">0.00</span></h3>
                <a href="../checkout/checkoutdetail.php?cart_id=<?php echo  $cartItems[0]['cart_id']; ?>">Checkout</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        calculateTotalCost();
        function calculateTotalCost() {
           let totalCost = 0; // Reset the total cost
           let itemQuantity;
            <?php foreach ($cartItems as $item): ?>
                itemQuantity = document.getElementById('quantity_<?php echo $item['item_id']; ?>').value;
                totalCost += <?php echo $item['price']; ?> * itemQuantity;
            <?php endforeach; ?>
            document.getElementById('totalCost').innerHTML = totalCost.toFixed(2);
        }

        function increaseQuantity(itemId, pricePerItem) {
            const quantityInput = document.getElementById('quantity_' + itemId);
            const priceElement = document.getElementById('price_' + itemId);
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
            
            const newPrice = (pricePerItem * quantityInput.value).toFixed(2);
            priceElement.innerHTML = '$' + newPrice;
            
            // Call the PHP function via AJAX to update the quantity
            updateQuantityInDB(itemId, quantityInput.value);
            
            calculateTotalCost();
        }

        function decreaseQuantity(itemId, pricePerItem) {
            const quantityInput = document.getElementById('quantity_' + itemId);
            const priceElement = document.getElementById('price_' + itemId);
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                const newPrice = (pricePerItem * quantityInput.value).toFixed(2);
                priceElement.innerHTML = '$' + newPrice;
                updateQuantityInDB(itemId, quantityInput.value);
            }
            calculateTotalCost();
        }

        function updateQuantityInDB(itemId, currentValue) {
                fetch('updateQuantity.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `item_id=${itemId}&quantity=${currentValue}`
                })
                .then(response => response.text())  // Assuming the PHP file returns a text response
                .then(data => {
                    console.log('Quantity updated:', data); // Optional, just for debugging
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>
</html>
