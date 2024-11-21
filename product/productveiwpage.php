<?php
include_once "../connect.php";
$stock_erro = 0;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['product_id'])) {
        $back_link = htmlspecialchars($_GET['back_link']);
        $product_id = intval($_GET['product_id']);

        // Update view count
        $getviewquery = "SELECT view_count FROM products WHERE product_id=?";
        $stmt = $con->prepare($getviewquery);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_view = $row['view_count'];
            $new_view = $current_view + 1;

            $updateviewquery = "UPDATE products SET view_count = ? WHERE product_id=?";
            $stmt = $con->prepare($updateviewquery);
            $stmt->bind_param("ii", $new_view, $product_id);
            $stmt->execute();
        }

        // Fetch product details
        $query = "SELECT p.image_link, p.price, p.product_id, p.description, pro.discount, 
                         p.product_name, p.stock_quantity, pro.price_after_discount 
                  FROM products p
                  LEFT JOIN promotions pro ON p.product_id = pro.product_id
                  WHERE p.product_id=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if (isset($_GET['erro'])) {
            $stock_erro = intval($_GET['erro']);
        }

        // Fetch feedback
        $feedback_query = "SELECT * FROM ratings WHERE product_id=?";
        $stmt = $con->prepare($feedback_query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $feedback_list = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="../style/productveiwpage.css">
</head>

<body>
    <div class="main-container">
        <button class="close-btn"><a href="<?php echo $back_link; ?>">&times;</a></button>

        <div class="container">
            <!-- Product Image -->
            <div class="image">
                <img src="../images/<?php echo htmlspecialchars($product['image_link'] ?? 'placeholder.jpg'); ?>" 
                     alt="Product Image">
            </div>

            <!-- Product Details -->
            <div class="details">
                <div class="title"><?php echo htmlspecialchars($product['product_name']); ?></div>
                <div class="description"><?php echo htmlspecialchars($product['description']); ?></div>
                <div class="stock">
                    <span style="color:red; font-size:13px">
                        <?php if ($product['stock_quantity'] == 0) echo "This is out of stock"; ?>
                    </span>
                </div>

                <!-- Pricing -->
                <div class="product-purchase">
                    <?php if ($product['discount'] === null): ?>
                        <div class="price">
                            <span class="product-price" id="price">
                                <?php echo "$" . number_format($product['price'], 2); ?>
                            </span>
                        </div>
                    <?php else: ?>
                        <div class="price">
                            <span class="product-price" id="price">
                                <?php echo "$" . number_format($product['price_after_discount'], 2); ?>
                            </span>
                            <div class="dis">
                                <del class="old-price">
                                    <?php echo "$" . number_format($product['price'], 2); ?>
                                </del>
                                <span class="discount">-<?php echo intval($product['discount']); ?>%</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Quantity Selector -->
                <div class="quantity">
                    <button onclick="decreaseQuantity()">-</button>
                    <input type="number" id="quantity" value="1" min="1">
                    <button onclick="increaseQuantity()">+</button>
                </div>
                <?php if ($stock_erro): ?>
                    <p style="color:red;">Stock is not sufficient</p>
                <?php endif; ?>
                <a href="../cart/add_to_cart.php?product_id=<?php echo $product['product_id']; ?>&quantity=1&back_link=<?php echo $back_link; ?>" 
                   id="addToCartLink">
                    <button class="add-to-cart">Add to Cart</button>
                </a>
            </div>
        </div>
    </div>

    <!-- Feedback Section -->
    <div class="feedback-container">
        <h1>Feedback</h1>
        <?php if (count($feedback_list) == 0): ?>
            <h3>No Feedback yet</h3>
        <?php else: ?>
            <?php foreach ($feedback_list as $feedback): ?>
                <div class="feedback-card">
                    <div class="feedback-content">
                        <h2><?php echo htmlspecialchars($feedback['review']); ?></h2>
                        <p>Rating:
                            <span class="star-rating">
                                <?php for ($i = 0; $i < intval($feedback['rating']); $i++): ?>
                                    ★
                                <?php endfor; ?>
                            </span>
                        </p>
                    </div>
                    <?php if (!empty($feedback['image_link'])): ?>
                        <img id="feedback-img" src="../images/<?php echo htmlspecialchars($feedback['image_link']); ?>" 
                             alt="Feedback Image">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
        const quantityInput = document.getElementById('quantity');
        const addToCartLink = document.getElementById('addToCartLink');
        const price = document.getElementById('price');

        function increaseQuantity() {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
            updatePrice();
            updateCartLink();
        }

        function decreaseQuantity() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                updatePrice();
                updateCartLink();
            }
        }

        function updatePrice() {
            const discount = <?php echo json_encode($product['discount']); ?>;
            const basePrice = discount === null ? 
                <?php echo json_encode($product['price']); ?> : 
                <?php echo json_encode($product['price_after_discount']); ?>;
            price.innerHTML = `$${(basePrice * quantityInput.value).toFixed(2)}`;
        }

        function updateCartLink() {
            const productId = "<?php echo $product['product_id']; ?>";
            const quantity = quantityInput.value;
            addToCartLink.href = `../cart/add_to_cart.php?product_id=${productId}&quantity=${quantity}&back_link=<?php echo $back_link; ?>`;
        }
    </script>
</body>

</html>
