<?php
// connect to database
include('../connect.php');


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

// Get cart_id from the URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';

// Fetch the order details based on cart_id
$stmt = $con->prepare("SELECT p.product_name, p.price, o.quantity 
                       FROM order_items o 
                       JOIN products p ON o.product_id = p.product_id   
                       WHERE o.order_id = ?");
                       
// Bind the parameter (assuming order_id is an integer)
$stmt->bind_param("i", $order_id); // 'i' specifies that $order_id is an integer

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
        <h2>Your Purchased Items:</h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                
                <div class="order-item">
                    <h3><?php echo $row['product_name']; ?></h3>
                    <p>Price: $<?php echo $row['price']; ?></p>
                    <p>Quantity: <?php echo $row['quantity']; ?></p>
                </div>
                <?php deleteitemfromcart($row['item_id'])  ?>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No items found for this order.</p>
        <?php endif; ?>
    </div>

    <div class="thank-you">Thank you for shopping with us!</div>
    <a href="../Home/dashbord.php" class="btn-dashboard">Go to Dashboard</a>
</div>

</body>
</html>
