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
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px 30px;
        }

        .container h1 {
            font-size: 24px;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-section {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-section .form-left,
        .form-section .form-right {
            flex: 1;
            min-width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        textarea {
            resize: vertical;
            height: 80px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .close-btn {
            display: inline-block;
            text-decoration: none;
            font-size: 20px;
            color: #999;
            float: right;
            margin-top: -10px;
        }

        .close-btn:hover {
            color: #f00;
        }

        .error, .success {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .error {
            background: #ffe5e5;
            color: #d9534f;
            border: 1px solid #d9534f;
        }

        .success {
            background: #e5ffee;
            color: #5cb85c;
            border: 1px solid #5cb85c;
        }

        @media (max-width: 768px) {
            .form-section {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="../sellers/sellerdashbord.php" class="close-btn">&times;</a>
        <h1>Product Listing</h1>

        <!-- Feedback Messages -->
        <div class="error" style="display: none;">Error message goes here.</div>
        <div class="success" style="display: none;">Success message goes here.</div>

        <!-- Form Start -->
        <form action="productlisting.php" method="POST" enctype="multipart/form-data">
            <div class="form-section">
                <!-- Left Section -->
                <div class="form-left">
                    <label for="product_name">Product Name:</label>
                    <input type="text" id="product_name" name="product_name" required>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>

                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" step="0.01" required>

                    <label for="brand">Brand:</label>
                    <input type="text" id="brand" name="brand" required>
                </div>

                <!-- Right Section -->
                <div class="form-right">
                    <label for="stock_quantity">Stock Quantity:</label>
                    <input type="number" id="stock_quantity" name="stock_quantity" required>

                    <label for="image_link">Image:</label>
                    <input type="file" id="image_link" name="image_link" accept="image/*" required>

                    <label for="color">Color:</label>
                    <input type="text" id="color" name="color">

                    <label for="catogory_id">Category:</label>
                    <select id="catogory_id" name="catogory_id" required>
                <option value="">Select a category</option>
                <?php while ($cat_row = $cat_result->fetch_assoc()): ?>
                    <option value="<?php echo $cat_row['product_cat_id']; ?>"><?php echo $cat_row['name']; ?></option>
                <?php endwhile; ?>
            </select>
                </div>
            </div>

            <!-- Submit Button -->
            <input type="submit" value="List Product">
        </form>
    </div>
</body>
</html>





