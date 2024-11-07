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
            left: 25%;
            top: 180px;
            left: 27%;
            top: 2vh;
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
        .error-message {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #f44336;
            background-color: #ffebee;
            color: #b71c1c;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .error-message h1 {
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .error-message p {
            font-size: 16px;
            margin: 0;
        }
        .error-message a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            color: white;
            background-color: #d32f2f;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .error-message a:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="container">
                <div class="error-message">
                <h1>Unfortunately, Your Checkout is Cancelled</h1>
                <p>It seems that your checkout process was not completed. If you need help, please feel free to contact us. Otherwise, you can try again to complete your purchase.</p>
                
            </div>
        
        <img src="../images/checkout.jpg" width="220px" height="220px">
        <button class="cart-btn"><a href="../cart/cartlandingpage.php">Back to Cart</a></button>
    </div>


    
</body>
</html>