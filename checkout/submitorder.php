<?php
include "../connect.php";
session_start();
$user_id = $_SESSION['userid'];


function deleteitemfromcart($item_id){
    include "../connect.php";
    $quary = "DELETE FROM cart_product_items WHERE item_id='$item_id'";
    $result = mysqli_query($con,$quary);
    if($result){
       
    }
    else{
        die("erro when deleting product");
    }
}



if($_SERVER['REQUEST_METHOD']==="POST"){
    $addres = $_POST['address'];
    $country = $_POST['country'];
    $zip_code = $_POST['zip_code'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $payment_method = $_POST['payment_method'];
    $cart_id = $_POST['cart_id'];
    $total_price = $_POST['total_price'];

    $query = "SELECT * FROM orders WHERE user_id='$user_id'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) > 0) {
        $sql = "
            UPDATE orders 
            SET 
                cart_id = '$cart_id', 
                total_amount = '$total_price', 
                Address = '$addres', 
                country = '$country', 
                zip_code = '$zip_code', 
                phone_number = '$phone_number', 
                email = '$email', 
                payment_method = '$payment_method'
            WHERE 
                user_id = '$user_id'
        ";
    }
    else{
        $sql="INSERT INTO orders (user_id,cart_id,total_amount,Address,country,zip_code,phone_number,email,payment_method) 
        VALUES ('$user_id','$cart_id','$total_price','$addres','$country','$zip_code','$phone_number','$email','$payment_method') ";
    }

    $result = mysqli_query($con,$sql);
    if($result){   
        $sql="SELECT order_id FROM orders WHERE user_id='$user_id'";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($result);
        $order_id = $row['order_id'];

        $query = "
        SELECT 
            c.cart_id,
            cpi.item_id,
            p.product_id,
            p.product_name,
            p.price,
            p.image_link,
            cpi.quantity
        FROM 
            carts AS c
        JOIN 
            cart_product_items AS cpi ON c.cart_id = cpi.cart_id
        JOIN 
            products AS p ON cpi.product_id = p.product_id
        WHERE 
            c.cart_id = ?
    ";
    
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $cart_id);
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
       
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price,order_status) 
                VALUES ('$order_id', '$product_id', '$quantity', '$price','$order_status')";
        
        // Execute the query
        if (mysqli_query($con, $sql)) {
            echo "Item inserted successfully!<br>";
            deleteitemfromcart($item['item_id']);
        } else {
            echo "Error: " . mysqli_error($con) . "<br>";
        }
    }
    
    
       
    }


        header("location:ordersucsuus.php");
    }else{
        die("error when checout ");
    }




  





















?>