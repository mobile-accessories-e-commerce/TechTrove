<?php
include "../connect.php";

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $user_id = $_SESSION['userid'];  // Get the logged-in user ID from session
    $item_id = $_POST['item_id'];  // Get product_id from the form
    $rating = intval($_POST['rating']);  // Ensure rating is an integer
    $image_link = $_POST['image'];
    $review = $con->real_escape_string($_POST['review']);



    //Get order items detail acording to item id
    $sql = "SELECT * FROM order_items WHERE item_id='$item_id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    $product_id = $row['product_id'];




    // User has purchased the product, allow rating
    $sql = "INSERT INTO ratings (user_id, product_id, rating, review, created_at,image_link) 
                VALUES (?, ?, ?, ?, NOW(),?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("iiiss", $user_id, $product_id, $rating, $review,$image_link);

    if ($stmt->execute()) {
        $update_order_item_sql = "UPDATE order_items SET can_feedback=0 WHERE item_id='$item_id'";
        $result = mysqli_query($con, $update_order_item_sql);

        if ($result) {


            $sql = "UPDATE products SET rating = (SELECT AVG(rating) FROM ratings WHERE product_id = '$product_id') WHERE product_id = '$product_id'";
            $result = mysqli_query($con, $sql);
            if ($result) {
                header("location:userorders.php");
            }
        }
    } else {
        echo "Error: " . $con->error;
    }
    $stmt->close();



    $con->close();
}
?>