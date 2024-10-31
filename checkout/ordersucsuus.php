<?php
include "../connect.php";
session_start();


function deleteitemfromcart($item_id)
{
    include "../connect.php";
    $quary = "DELETE FROM cart_product_items WHERE item_id='$item_id'";
    $result = mysqli_query($con, $quary);
    if ($result) {

    } else {
        die("erro when deleting product");
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $cart_id = $_GET['cart_id'];
    $order_id = $_GET['order_id'];
    $payment_method = $_GET['method'];


    $sql = "SELECT id FROM shipping_details WHERE order_id = $order_id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $shipping_details_id = $row['id'];





    $query = "
    SELECT 
        c.cart_id,
        cpi.item_id,
        p.product_id,
        p.product_name,
        p.price,
        p.image_link,
        cpi.quantity,
        p.stock_quantity
    FROM 
        carts AS c
    JOIN 
        cart_product_items AS cpi ON c.cart_id = cpi.cart_id
    JOIN 
        products AS p ON cpi.product_id = p.product_id
    JOIN 
        orders AS o ON c.cart_id = o.cart_id
    WHERE 
        o.order_id = ?
";

    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cartItems = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $cartItems = [];
    }

    foreach ($cartItems as $item) {

        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $cart_id = $item['cart_id'];
        $price = $item['price'];
        $order_status = "pending";


        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price,shipping_detail_id,order_status,payment_method) 
            VALUES ('$order_id', '$product_id', '$quantity', '$price','$shipping_details_id','$order_status','$payment_method')";

        // Execute the query
        if (mysqli_query($con, $sql)) {

            $new_quantity = $item['stock_quantity'] - $item['quantity'];

            $sql = "UPDATE products SET stock_quantity='$new_quantity' WHERE product_id = '$product_id'";
            $result = mysqli_query($con, $sql);
            deleteitemfromcart($item['item_id']);



        } else {
            echo "Error: " . mysqli_error($con) . "<br>";
        }
    }
    header("location:../userorders/userorders.php");
}



?>