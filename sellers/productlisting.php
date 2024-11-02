<?php
session_start();
include '../connect.php';

$user_id = $_SESSION['userid'];



//Get seller id for user in session 
$query = "SELECT seller_id FROM sellers WHERE user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $seller_id = $row['seller_id'];
} else {

    echo "Seller not found. Please contact support.";
    exit;
}

//Get catogaries
$cat_query = "SELECT product_cat_id, name FROM product_catogory";
$cat_result = $con->query($cat_query);


//list product 
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $product_name = trim($_POST['product_name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $brand = $_POST['brand'];
    $stock_quantity = intval($_POST['stock_quantity']);
    $shipping_cost = floatval($_POST['shipping_cost']);
    $image_link = trim($_POST['image_link']);
    $color = trim($_POST['color']);
    $size = trim($_POST['size']);
    $weight = floatval($_POST['weight']);
    $is_free_shiping = isset($_POST['is_free_shiping']) ? 1 : 0;
    $product_status = isset($_POST['product_status']) ? 1 : 0;
    $catogory_id = intval($_POST['catogory_id']);


    if (empty($product_name) || empty($description) || $price <= 0 || $stock_quantity < 0) {
        $error = "Please fill out all required fields correctly.";
    } else {

        $insert_query = "INSERT INTO products (seller_id, catogory_id, product_name, description, price, brand, stock_quantity, shipping_cost, image_link, color, size, weight, is_free_shiping, product_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insert_query);
        $stmt->bind_param("iissdssdsssidi", $seller_id, $catogory_id, $product_name, $description, $price, $brand, $stock_quantity, $shipping_cost, $image_link, $color, $size, $weight, $is_free_shiping, $product_status);

        if ($stmt->execute()) {
            $success = "Product listed successfully!";
            header("Location:sellerdashbord.php");
            exit;
        } else {
            $error = "Failed to list product. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <style>
        .container {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }

        input[type=text],
        input[type=number],
        input[type=float],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Product Listing</h2>


        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>


        <form action="productlisting.php" method="POST">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" required>

            <label for="stock_quantity">Stock Quantity:</label>
            <input type="number" id="stock_quantity" name="stock_quantity" required>

            <label for="shipping_cost">Shipping Cost:</label>
            <input type="number" id="shipping_cost" name="shipping_cost" step="0.01" required>

            <label for="image_link">Image Link:</label>
            <input type="file" id="image_link" name="image_link" required>

            <label for="color">Color:</label>
            <input type="text" id="color" name="color">

            <label for="size">Size:</label>
            <input type="text" id="size" name="size">

            <label for="weight">Weight:</label>
            <input type="number" id="weight" name="weight" step="0.01" required>

            <label for="is_free_shiping">Is Free Shiping:</label>
            <input type="checkbox" id="is_free_shiping" name="is_free_shiping">

            <label for="product_status">Product Status (Available):</label>
            <input type="checkbox" id="product_status" name="product_status">

            <label for="catogory_id">Catogory:</label>
            <select id="catogory_id" name="catogory_id" required>
                <option value="">Select a catogory</option>
                <?php while ($cat_row = $cat_result->fetch_assoc()): ?>
                    <option value="<?php echo $cat_row['product_cat_id']; ?>"><?php echo $cat_row['name']; ?></option>
                <?php endwhile; ?>
            </select>

            <input type="submit" value="List Product">
        </form>
    </div>
</body>

</html>