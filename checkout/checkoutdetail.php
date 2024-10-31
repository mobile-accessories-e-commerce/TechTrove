<?php
session_start();
include '../connect.php';




if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $cart_id = $_GET['cart_id'];


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
        c.cart_id = ?
    ";

    // Prepare and execute the query
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cartItems = $result->fetch_all(MYSQLI_ASSOC);
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $totalPrice += $itemTotal;
        }
    } else {
        $cartItems = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../style/checkoutdetail.css">
</head>

<body>
    <div><a href="../cart/cartlandingpage.php"><button class="back">back</button></a></div>
    <div class="container">

        <h1>Checkout</h1>

        <!-- Checkout Details Form -->
        <div class="form-container">
            <h2>Enter Your Details</h2>
            <form action="submitorder.php" method="POST">
                <input type="hidden" name="cart_id" value="<?php echo $cartItems['0']['cart_id']; ?>">
                <input type="hidden" name="total_price" value="<?php echo $totalPrice ?>">
                <label for="address">Shipping Address:</label>
                <textarea name="address" id="address" rows="4" required></textarea>

                <label for="country">Country:</label>
                <input type="text" name="country" id="country" required>

                <label for="zip_code">Zip Code / Postal Code:</label>
                <input type="text" name="zip_code" id="zip_code" required>

                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" required>

                <label for="email">Email Address:</label>
                <input type="email" name="email" id="email" required>

                <label for="payment_method">Payment Method:</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="cash_On_delivery">cash On delivery</option>
                </select>

                <button type="submit">Submit Order</button>
            </form>
        </div>

        <!-- Display Cart Items -->
        <div class="cart-items">
            <h2>Your Cart</h2>
            <?php if (!empty($cartItems)): ?>
                <?php
                $totalPrice = 0;
                foreach ($cartItems as $item):
                    $itemTotal = $item['price'] * $item['quantity'];
                    $totalPrice += $itemTotal;
                    ?>
                    <div class="item">
                        <img src="../images/<?php echo $item['image_link']; ?>" alt="<?php echo $item['product_name']; ?>"
                            width="100">
                        <span><?php echo $item['product_name']; ?></span>
                        <span>Quantity: <?php echo $item['quantity']; ?></span>
                        <span>Price: $<?php echo number_format($itemTotal, 2); ?></span>
                    </div>
                <?php endforeach; ?>
                <!-- Display Total Price -->
                <div class="total">
                    <h3>Total Price: $<?php echo number_format($totalPrice, 2); ?></h3>
                </div>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>