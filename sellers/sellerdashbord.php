<?php
include "../connect.php";
session_start();
$user_id = $_SESSION['userid'];


$productList = array();

$query = "SELECT seller_id FROM sellers WHERE user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $seller_id = $row['seller_id'];
} else {
    
    echo "Seller not found. Please contact support.";
    exit;
}
echo $seller_id;

$query = "SELECT * FROM products WHERE seller_id=? ";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows>0){
    while($row =mysqli_fetch_assoc($result)){
        array_push($productList,$row);
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller dashbord</title>
    
    <style>
        body{
            background-color: #ffeefe;
        }
        .row {
            width: 80%;
            margin: auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin: 10px;
            width: calc(25% - 40px); 
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        h2 {
            width: 100%;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    
<a href="productlisting.php"><button>Add Product</button></a>
<a href="../Home/dashbord.php"><button>Go to Home</button></a>
    <div class="container">
        <h1>Seller Dashbord</h1>
        <?php if (empty($productList)): ?>
            <p>Your have no product listed yet</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($productList as $item): ?>
                    <div class="card">
                        <img src="../images/<?php echo $item['image_link']; ?>" alt="<?php echo $item['product_name']; ?>">
                        <h2><?php echo $item['product_name']; ?></h2>
                        <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                        <form action="editproduct.php"><input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>"> <input type="submit" value="edit"></form>
                        
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>




</body>
</html>



















