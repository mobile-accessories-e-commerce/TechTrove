<?php
session_start();
include '../connect.php'; 

if (!isset($_SESSION['userid'])) {
   header("location:../authentication/loging.php");
}

if($_GET['product_id']){
    
    $product_id = $_GET['product_id'];
    $user_id = $_SESSION['userid'];

    $cat_query = "SELECT product_cat_id, name FROM product_catogory";
    $cat_result = $con->query($cat_query);

    
    $query = "SELECT * FROM products WHERE product_id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc(); 
   
    
    if ($product) {
        $product_name = $product['product_name'];
        $description = $product['description'];
        $price = $product['price'];
        $brand = $product['brand'];
        $stock_quantity = $product['stock_quantity'];
        $shipping_cost = $product['shipping_cost'];
        $image_link = $product['image_link'];
        $color = $product['color'];
        $size = $product['size'];
        $weight = $product['weight'];
        $is_free_shipping = $product['is_free_shiping'] ? 1 : 0;
        $product_status = $product['product_status'] ? 1 : 0;
        $category_id = $product['catogory_id'];

       
    } else {
        echo "Product not found!";
        exit();
    }
}






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        .container {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        input[type=text], input[type=number], textarea, select {
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>

        <form action="productupdate.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required value="<?php echo htmlspecialchars($product_name); ?>">

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required value="<?php echo htmlspecialchars($price); ?>">

            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" required value="<?php echo htmlspecialchars($brand); ?>">

            <label for="stock_quantity">Stock Quantity:</label>
            <input type="number" id="stock_quantity" name="stock_quantity" required value="<?php echo htmlspecialchars($stock_quantity); ?>">

            <label for="shipping_cost">Shipping Cost:</label>
            <input type="number" id="shipping_cost" name="shipping_cost" step="0.01" required value="<?php echo htmlspecialchars($shipping_cost); ?>">

            <label for="image_link">Image Link:</label>
            <input type="file" id="image_link" name="image_link" required >

            <label for="color">Color:</label>
            <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($color); ?>">

            <label for="size">Size:</label>
            <input type="text" id="size" name="size" value="<?php echo htmlspecialchars($size); ?>">

            <label for="weight">Weight:</label>
            <input type="number" id="weight" name="weight" step="0.01" required value="<?php echo htmlspecialchars($weight); ?>">

            <label for="is_free_shipping">Is Free Shipping:</label>
            <input type="checkbox" id="is_free_shipping" name="is_free_shipping" <?php if ($is_free_shipping) echo 'checked'; ?>>

            <label for="product_status">Product Status (Available):</label>
            <input type="checkbox" id="product_status" name="product_status" <?php if ($product_status) echo 'checked'; ?>>

            <label for="category_id">Category:</label>
            <select id="catogory_id" name="catogory_id" required>
                <option value="">Select a catogory</option>
                <?php while ($cat_row = $cat_result->fetch_assoc()): ?>
                    <option value="<?php echo $cat_row['product_cat_id']; ?>"><?php echo $cat_row['name']; ?></option>
                <?php endwhile; ?>
            </select>

            <input type="submit" value="Update Product">
        </form>
    </div>
</body>
</html>




