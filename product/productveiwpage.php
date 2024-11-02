<?php
include "../connect.php";
$stock_erro = 0;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        $getviewquary = "SELECT view_count FROM products WHERE product_id='$product_id'";
        $result = mysqli_query($con, $getviewquary);
        $row = mysqli_fetch_assoc($result);
        $current_view = $row['view_count'];
        $new_view = $current_view + 1;

        $updateviewquary = "UPDATE products SET view_count = '$new_view' WHERE product_id='$product_id'";
        $result = mysqli_query($con, $updateviewquary);

        if (!$result) {
            header("location:../Home/dashbord.php");
        }
        $query = "SELECT * FROM products WHERE product_id=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = mysqli_fetch_assoc($result);

        if (isset($_GET['erro'])) {
            $stock_erro = $_GET['erro'];
        }
    }

$sql = "SELECT * FROM ratings WHERE product_id='$product_id'";
$result = mysqli_query($con,$sql);
$feedback_list = array();
while($row=mysqli_fetch_assoc($result)){
    array_push($feedback_list,$row);
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
    <div><a href="../Home/dashbord.php"><button class="back">back</button></a></div>

    <div class="main-container">
        <div class="container">
            <div class="image">
                <img src="../images/<?php echo $product['image_link']; ?>" alt="Product Image">
            </div>

            <div class="details">
                <div class="title"><?php echo $product['product_name']; ?></div>
                <div class="description"><?php echo $product['description']; ?></div>
                <div class="price">$<span id="price"><?php echo $product['price']; ?></span></div>

                <div class="quantity">
                    <button onclick="decreaseQuantity()">-</button>
                    <input type="number" id="quantity" value="1" min="1">
                    <button onclick="increaseQuantity()">+</button>
                </div>
                <?php if ($stock_erro): ?>
                    <p style="color:red;">Stock is not suffcieant</p>
                <?php endif; ?>
                <a href="../cart/add_to_cart.php?product_id=<?php echo $product['product_id']; ?>&quantity=1"
                    id="addToCartLink">
                    <button class="add-to-cart">Add to Cart</button>
                </a>
            </div>
        </div>
    </div>
    <div class="feedback-container">
        <h1>Feedback</h1>
        <?php if(count($feedback_list)==0):?>
            <h3>No Feedback yet</h3>
        <?php endif; ?>
        <?php foreach($feedback_list as $feedback):?>
            <div class="feedback-card">
                <div class="feedback-content">
                    <h2><?php echo $feedback['review'] ?></h2>
                    <p>Rating:
                    <span class="star-rating">
                        <?php for($i = 0; $i < $feedback['rating']; $i++): ?>
                            ★
                        <?php endfor; ?>
                    </span>
</p>

                    
                </div>
                <?php if($feedback['image_link']!=null): ?>
                <img id="feedback-img" src="../images/<?php echo $feedback['image_link'] ?>" alt="image">
                <img src="../images/<?php echo $feedback['image_link'] ?>" alt="popup image" class="popup-image">
               <?php endif; ?>
            </div>
            <?php endforeach; ?>

            
            
    </div>
    <script>
        const quantityInput = document.getElementById('quantity');
        const addToCartLink = document.getElementById('addToCartLink');
        const price = document.getElementById('price');

        function increaseQuantity() {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
            price.innerHTML = (<?php echo ($product['price']); ?> * quantityInput.value);
            updateCartLink();
        }

        function decreaseQuantity() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                price.innerHTML = <?php echo ($product['price']); ?> * quantityInput.value;
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