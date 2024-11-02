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



if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $product_id = $_GET['product_id'];
    $sql = "SELECT * FROM featured_products WHERE seller_id ='$seller_id'";
    $result = mysqli_query($con, $sql);
    //need to fix this error massage 
    if (mysqli_num_rows($result) > 5) {
        header("location:sellerdashbord.php");
    }
} else {
    header("location:sellerdashbord.php");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $image_link = trim($_POST['image_link']);
    $approved = 0;


    if (empty($title) || empty($description)) {
        $error = "Please fill out all required fields correctly.";
    } else {


        $insert_query = "INSERT INTO featured_products (product_id,seller_id, title,description,image_link,approved) VALUES (?, ?, ?, ?, ?,?)";
        $stmt = $con->prepare($insert_query);
        $stmt->bind_param("iisssi", $product_id, $seller_id, $title, $description, $image_link, $approved);

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


        <form action="heroSectionProduct.php" method="POST">
            <input type="hidden" value="<?php echo $product_id ?>" name="product_id">
            <label for="title">Hero Title</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="image_link">Image Link:</label>
            <input type="file" id="image_link" name="image_link" required>

            <input type="submit" value="List Product">
        </form>
    </div>
</body>

</html>