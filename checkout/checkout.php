<?php
session_start();
include "../connect.php";
require '../vendor/autoload.php'; // Autoload the Stripe library



if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $cart_id = $_GET['cart_id'];
    $order_id = $_GET['order_id'];

    $query = "
    SELECT 
        c.cart_id,
        cpi.item_id,
        p.product_id,
        p.product_name,
        p.price,
        p.image_link,
        cpi.quantity,
         pro.discount,
        pro.price_after_discount
    FROM 
        carts AS c
    JOIN 
        cart_product_items AS cpi ON c.cart_id = cpi.cart_id
    JOIN 
        products AS p ON cpi.product_id = p.product_id
    LEFT JOIN 
        promotions AS pro ON p.product_id = pro.product_id
    WHERE 
        c.cart_id = ?
    ";

    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $cart_items = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($cart_items, $row);
    }


    foreach ($cart_items as $item) {
        if ($item['discount'] !== null && $item['discount'] !== "null") {
            $price = $item['price_after_discount'];
        } else {
            $price = $item['price'];
        }
        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $item['product_name'],
                    'images' => [$item['image_link']],
                ],
                'unit_amount' => $price * 100,
            ],
            'quantity' => $item['quantity'],
        ];
    }




    \Stripe\Stripe::setApiKey("sk_test_51QFZIjF4x1YbRjizik64qsiQsyPxSHpkaFf39l5knrEXbKc3CUkONwJWMVit44IcTWRVHwPxzdluf5JubgLCdGc000FWODed4U");

    $session = \Stripe\Checkout\Session::create(

        [

            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',


            'success_url' => "http://localhost/e-commercesite/checkout/ordersucsuus.php?session_id={CHECKOUT_SESSION_ID}&cart_id=$cart_id&order_id=$order_id&method=credit_card",

            'cancel_url' => 'http://localhost/e-commercesite/checkout/checkouterro.php',
        ]
    );

    header("Location: " . $session->url);

}
?>