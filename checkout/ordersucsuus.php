

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="styles.css">
   
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 40px;
            text-align: center;
        }
        .success-message {
            color: #28a745;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .success-icon {
            font-size: 50px;
            color: #28a745;
            margin-bottom: 20px;
        }
        .order-details {
            text-align: left;
            margin-bottom: 20px;
        }
        .order-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-item h3 {
            margin: 0;
            font-size: 18px;
        }
        .order-item p {
            margin: 5px 0;
            color: #555;
        }
        .thank-you {
            margin-top: 20px;
            font-size: 22px;
        }
        .btn-dashboard {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
        }
        .btn-dashboard:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <i class="fas fa-check-circle success-icon"></i>
    <div class="success-message">Order Placed Successfully!</div>

    <div class="order-details">
        
        
    <div class="thank-you">Thank you for shopping with us!</div>
    <a href="../Home/dashbord.php" class="btn-dashboard">Go to Dashboard</a>
</div>

</body>
</html>
