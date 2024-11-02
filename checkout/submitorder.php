<?php
include "../connect.php";
session_start();
$user_id = $_SESSION['userid'];








if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $addres = $_POST['address'];
    $country = $_POST['country'];
    $zip_code = $_POST['zip_code'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $payment_method = $_POST['payment_method'];
    $cart_id = $_POST['cart_id'];
    $total_price = $_POST['total_price'];




    $add_order_sql = "INSERT INTO orders (cart_id) VALUES('$cart_id')";
    $result = mysqli_query($con, $add_order_sql);

    if ($result) {
        $order_id = mysqli_insert_id($con);
    }


    $sql = "INSERT INTO shipping_details (order_id,address,mobile_number,zip_code,country)
             VALUES ('$order_id' , '$addres' , '$phone_number' , '$zip_code' , '$country')";


    $result = mysqli_query($con, $sql);




    if ($payment_method == 'cash_On_delivery') {
        header("location:ordersucsuus.php?order_id=$order_id&cart_id=$cart_id&method=cash_On_delivery");
    } else {
        header("location:checkout.php?cart_id=$cart_id&order_id=$order_id");

    }



} else {
    die("error when checout ");
}


























?>