<?php
session_start();
include '../connect.php';
include '../layouts/header.php';


$userId = $_SESSION['userid'];

function updateQuantity($value, $item_id)
{
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
        cpi.quantity,
        p.stock_quantity,
        pro.discount,
        pro.price_after_discount
    FROM 
        carts AS c
    JOIN 
        cart_product_items AS cpi ON c.cart_id = cpi.cart_id
    JOIN 
        products AS p ON cpi.product_id = p.product_id
    LEFT JOIN 
        promotions AS pro ON p.product_id = pro.product_id

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
    <link rel="stylesheet" href="../style/cartlandingpage.css">

</head>

<body>
  
    <div class="container">
        <h1>Your Cart</h1>
        <?php if (empty($cartItems)): ?>
            
            <video src="../images/Animation.mp4" autoplay loop muted width="100%" height="auto"></video>
            <p>No items yet? Continue shopping to <a href="../product/products.php">explore more.</a></p>
        <?php else: ?>
            <div class="row">


                <?php foreach ($cartItems as $item): ?>
                    <?php if($item['discount'] !== null && $item['discount'] !== "null"){
                        $price = $item['price_after_discount'];
                    } else{
                        $price = $item['price'];
                    }?>
                    <div class="card">
                        <img src="../images/<?php echo $item['image_link']; ?>" alt="<?php echo $item['product_name']; ?>">
                        
                        <div class="product_detail">
                            <p>$<?php echo number_format($item['price'], 2); ?></p>
                            <?php if($item['discount'] != null): ?>
                                <p> <?php echo $item['discount'] ?></p>
                                <p><?php echo ($item['price']-(($item['price']/100)*$item['discount'])) ?></p>
                            <?php endif;?>
                        </div>
                        <div class="quantity_container product_detail">
                            <button
                                onclick="decreaseQuantity(<?php echo $item['item_id']; ?>, <?php echo $price?>,<?php echo $item['stock_quantity'] ?>)">-</button>
                            <input type="number" id="quantity_<?php echo $item['item_id']; ?>"
                                value="<?php echo $item['quantity']; ?>" min="1">
                            <button
                                onclick="increaseQuantity(<?php echo $item['item_id']; ?>, <?php echo $price?>,<?php echo $item['stock_quantity'] ?>)">+</button>
                        </div>
                        <div class="product_detail">
                            <p id="price_<?php echo $item['item_id']; ?>">
                                $<?php echo number_format($price * $item['quantity'], 2); ?></p>
                        </div>
                        <p id="stock_erro" style="color:red;"></p>
                        <div><a href="deletecartitem.php?item_id=<?php echo $item['item_id']; ?>"><button
                                    class="button">Delete</button></a></div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="total-container">
                <h3>Total Cost: $<span id="totalCost">0.00</span></h3>
                <a href="../checkout/checkoutdetail.php?cart_id=<?php echo $cartItems[0]['cart_id']; ?>">Checkout</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        calculateTotalCost();
        function calculateTotalCost() {
            let totalCost = 0; // Reset the total cost
            let itemQuantity;
            <?php foreach ($cartItems as $item): ?>
                <?php if($item['discount'] !== null && $item['discount'] !== "null"){
                        $price = $item['price_after_discount'];
                    } else{
                        $price = $item['price'];
                    }?>
                itemQuantity = document.getElementById('quantity_<?php echo $item['item_id']; ?>').value;
                totalCost += <?php echo $price;?> * itemQuantity;
            <?php endforeach; ?>
            document.getElementById('totalCost').innerHTML = totalCost.toFixed(2);
        }

        function increaseQuantity(itemId, pricePerItem, max_value) {
            const quantityInput = document.getElementById('quantity_' + itemId);
            const priceElement = document.getElementById('price_' + itemId);
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < max_value) {
                quantityInput.value = currentValue + 1;

                const newPrice = (pricePerItem * quantityInput.value).toFixed(2);
                priceElement.innerHTML = '$' + newPrice;

                // Call the PHP function via AJAX to update the quantity
                updateQuantityInDB(itemId, quantityInput.value);

                calculateTotalCost();
            } else {
                document.getElementById('stock_erro').innerText = `item have only ${currentValue} in stock`;
            }
        }

        function decreaseQuantity(itemId, pricePerItem, maxvalue) {
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

            if (currentValue <= maxvalue) {
                document.getElementById('stock_erro').innerText = ``;
            }
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