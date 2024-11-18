<?php
session_start();
include '../connect.php';

$user_id = $_SESSION['userid'];


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


$cat_query = "SELECT product_cat_id, name FROM product_catogory";
$cat_result = $con->query($cat_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = trim($_POST['product_name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $brand = $_POST['brand'];
    $stock_quantity = intval($_POST['stock_quantity']);
    $color = trim($_POST['color']);
    $product_status = isset($_POST['product_status']) ? 1 : 0;
    $catogory_id = intval($_POST['catogory_id']);

 
    $image = $_FILES['image_link'];
    $uploadDir = '../images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); 
    }

    if ($image['error'] === UPLOAD_ERR_OK) {
        $uniqueFileName = uniqid() . '-' . basename($image['name']);
        $uploadPath = $uploadDir . $uniqueFileName;

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            $image_link = $uniqueFileName; 
        } else {
            $error = "Failed to upload image.";
        }
    } else {
        $error = "Error uploading image.";
    }

    if (empty($product_name) || empty($description) || $price <= 0 || $stock_quantity < 0 || empty($image_link)) {
        $error = "Please fill out all required fields correctly.";
    } else {
        $insert_query = "INSERT INTO products (seller_id, catogory_id, product_name, description, price, brand, stock_quantity,image_link, color) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insert_query);
        $stmt->bind_param("iissdssss", $seller_id, $catogory_id, $product_name, $description, $price, $brand, $stock_quantity, $image_link, $color);

        if ($stmt->execute()) {
            $success = "Product listed successfully!";
            header("Location: sellerdashbord.php");
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
        *{
            font-family: Arial, sans-serif;
        }
        body{
            background-color:  #d9e5f4;
        }
        .container {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            position: relative;
            background-color: white;
            border-radius: 10px;
            box-shadow: 18px 18px 18px rgba(0, 0, 0, 0.1);
        }
        .close-btn {
            
            position: absolute;
            right: 5px;
            top: 5px;
            background: none;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
            outline: none;
        }
        .close-btn a{
            text-decoration: none;
            color: gray;
        }
        .close-btn a:hover {
        color: #f00; 
        }
        .container p{
            font-size: 22px;
            color: black;
        }
        label,option{
            font-size: 13px;
            color: #333;
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
            border-radius: 4px;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #218838; 
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
        <button class="close-btn"><a href="../sellers/sellerdashbord.php">&times;</a></button>
        <p>Product Listing</p>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="productlisting.php" method="POST" enctype="multipart/form-data">
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
            <br>
            <br>
            <label for="image_link">Image:</label>
            <input type="file" id="image_link" name="image_link" accept="image/*" required>
            <br>
            <br>

            <label for="color">Color:</label>
            <input type="text" id="color" name="color">

            <label for="catogory_id">Category:</label>
            <select id="catogory_id" name="catogory_id" required>
                <option value="">Select a category</option>
                <?php while ($cat_row = $cat_result->fetch_assoc()): ?>
                    <option value="<?php echo $cat_row['product_cat_id']; ?>"><?php echo $cat_row['name']; ?></option>
                <?php endwhile; ?>
            </select>

            <input type="submit" value="List Product">
        </form>
    </div>
</body>

</html>




