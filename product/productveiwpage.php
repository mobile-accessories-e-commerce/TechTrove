<?php
include "../connect.php";

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $product_id = $_GET['product_id'];

    $query = "SELECT * FROM products WHERE product_id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .container {
            background-color: #fff;
            width: 80%; /* 80% of screen width */
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            border-radius: 8px;
        }

        .image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .details {
            flex: 1.5;
            padding: 20px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .description {
            margin-bottom: 20px;
            font-size: 16px;
            color: #555;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 20px;
        }

        .quantity {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .quantity button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 10px;
        }

        .quantity input {
            width: 50px;
            text-align: center;
            font-size: 16px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button.add-to-cart {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 4px;
        }

        button.add-to-cart:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="image">
            <img src="../images/<?php echo $product['image_link']; ?>" alt="Product Image">
        </div>

        <div class="details">
            <div class="title"><?php echo $product['product_name']; ?></div>
            <div class="description"><?php echo $product['description']; ?></div>
            <div class="price" id="price">$<?php echo $product['price']; ?></div>
            
            <div class="quantity">
                <button onclick="decreaseQuantity()">-</button>
                <input type="number" id="quantity" value="1" min="1">
                <button onclick="increaseQuantity()">+</button>
            </div>

            <a href="../cart/add_to_cart.php?product_id=<?php echo $product['product_id']; ?>&quantity=1" id="addToCartLink">
                <button class="add-to-cart">Add to Cart</button>
            </a>
        </div>
    </div>

    <script>
        const quantityInput = document.getElementById('quantity');
        const addToCartLink = document.getElementById('addToCartLink');
        const price = document.getElementById('price');

        function increaseQuantity() {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
            price.innerHTML = <?php echo ($product['price']); ?> *quantityInput.value;
            updateCartLink();
        }

        function decreaseQuantity() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                updateCartLink();
            }
        }

        function updateCartLink() {
            const productId = "<?php echo $product['product_id']; ?>";
            const quantity = quantityInput.value;
            addToCartLink.href = `../cart/add_to_cart.php?product_id=${productId}&quantity=${quantity}`;
        }
    </script>

</body>
</html>
