<?php

session_start();
include '../connect.php';

if (!isset($_SESSION['userid'])) {
    header("location:../authentication/loging.php");
}


//Get current product details acording to product_id
if ($_GET['product_id']) {

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
        $color = $product['color'];
        
       


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
        *{
            font-family: Arial, sans-serif;
        }
        body{
            background-color: #f0f0f0;
        }
        .container {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            position: relative;
            background-color: white;
            border-radius: 10px;
            box-shadow: 18px 18px 18px rgba(0, 0, 0, 0.1);
        }
        .container p{
            font-size: 22px;
            color: black;
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
            background-color: lightgrey;

        }
        .close-btn:hover{
            background-color: red;
            color: white;
        }
        .close-btn a{
            text-decoration: none;
            color: white;
            
        }
        .close-btn a:hover {
        color: white; 

        }
        label,option{
            font-size: 13px;
            color: #333;
        }

        input[type=text],
        input[type=number],
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
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #218838; 
        }
    </style>
</head>

<body>
    <div class="container">
    <button class="close-btn"><a href="../sellers/sellerdashbord.php">&times;</a></button>
        <p>Edit Product</p>

        <form action="productupdate.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required
                value="<?php echo htmlspecialchars($product_name); ?>">

            <label for="description">Description:</label>
            <textarea id="description" name="description"
                required><?php echo htmlspecialchars($description); ?></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required
                value="<?php echo htmlspecialchars($price); ?>">

            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" required value="<?php echo htmlspecialchars($brand); ?>">

            <label for="stock_quantity">Stock Quantity:</label>
            <input type="number" id="stock_quantity" name="stock_quantity" required
                value="<?php echo htmlspecialchars($stock_quantity); ?>">

            <label for="color">Color:</label>
            <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($color); ?>">

            <input type="submit" value="Update Product">
        </form>
    </div>
</body>

</html>