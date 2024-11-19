<?php
session_start();
include '../connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $back_link = $_GET['back_link'];
    $product_id = $_GET['product_id'];
    $quantity = $_GET['quantity'];

    $stock_erro = 0;
    $sql = "SELECT stock_quantity FROM products WHERE product_id = '$product_id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $stock_quantity = $row['stock_quantity'];

    if ($stock_quantity < $quantity) {
        $stock_erro = 1;
        header("location:../product/productveiwpage.php?erro=1&product_id=$product_id&back_link=$back_link");
    } else {



        $query = "SELECT * FROM products WHERE product_id=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = mysqli_fetch_assoc($result);



        $user_id = $_SESSION['userid'];


        $cart_query = "SELECT cart_id FROM carts WHERE user_id = ? ";
        $stmt = $con->prepare($cart_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $cart_row = $result->fetch_assoc();
            $cart_id = $cart_row['cart_id'];
        } else {

            $create_cart_query = "INSERT INTO carts (user_id) VALUES (?)";
            $stmt = $con->prepare($create_cart_query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $cart_id = $con->insert_id;
        }

        $check_item_query = "SELECT * FROM cart_product_items WHERE cart_id = ? AND product_id = ?";
        $stmt = $con->prepare($check_item_query);
        $stmt->bind_param("ii", $cart_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            echo "<div style='
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background-color: rgba(0, 0, 0, 0.8);
                    color: white;
                    padding: 20px 40px;
                    border-radius: 8px;
                    font-size: 18px;
                    font-family: Arial, sans-serif;
                    text-align: center;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
                '>
                    This item is already in your cart
                </div>";

        } else {

            $insert_query = "INSERT INTO cart_product_items (cart_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $con->prepare($insert_query);
            $stmt->bind_param("iii", $cart_id, $product_id, $quantity);
            $stmt->execute();
            header("location:cartlandingpage.php");
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>alrady in cart</title>
</head>
<body>
    <script>
       
    setTimeout(function() {
        window.location.href = "../product/products.php"; 
    }, 1000);



    </script>
</body>
</html>