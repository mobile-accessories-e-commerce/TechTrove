<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout cancelled</title>
    <style>
        body{
            position: relative;

        }

        .container{
            position: absolute;
            left: 400px;
            top: 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .cart-btn{
            padding: 10px;
            width: 200px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .cart-btn a{
            color: white;
            font-size: 17px;
            text-decoration: none;
        }
        .cart-btn:hover{
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Unfortunately Your Checkout is Cancelled</h1>
        <img src="../images/checkout.jpg" width="220px" height="220px">
        <button class="cart-btn"><a href="../cart/cartlandingpage.php">Back to Cart</a></button>
    </div>


    
</body>
</html>