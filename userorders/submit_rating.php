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
    $product_id = $_POST['product_id'];  // Get product_id from the form
    $rating = intval($_POST['rating']);  // Ensure rating is an integer
    $review = $con->real_escape_string($_POST['review']);

    

   
  

        // User has purchased the product, allow rating
        $sql = "INSERT INTO ratings (user_id, product_id, rating, review, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iiis", $user_id, $product_id, $rating, $review);

        if ($stmt->execute()) {
            echo "Thank you for your rating!";
        } else {
            echo "Error: " . $con->error;
        }
        $stmt->close();
    


    $con->close();
}
?>
