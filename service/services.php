<?php
session_start();
include '../connect.php'; 


$services_query = "
    SELECT s.service_name, s.description, s.price, s.image_link, sc.name AS category_name
    FROM services s
    JOIN service_catogory sc ON s.catogory_id = sc.service_cat_id
";


$services_result = $con->query($services_query);

$service_list = array();
while($row=mysqli_fetch_assoc($services_result)){
    array_push($service_list,$row);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>
    <link rel="stylesheet" href="../style/products.css">
</head>
<body>
<div class="product-section-container">
    
    <ul class="product-section-item-wrapper">
        <?php foreach($service_list as $service): ?>
        <li class="product-item">
            <div class="product-image">
                <img src="../images/<?php echo $service['image_link'] ?>" alt="smart watch">

            </div>
            <div class="product-text">
                <span class="product-title">
                    <?php echo $service['service_name'] ?>
                </span>
                <div class="product-purchace">
                    <span class="product-price">
                    <?php echo "$".$service['price'] ?>
                    </span>
        <!-- Todo need to implement serviceview page -->
                    <!-- <a href="../product/serviceviewpage.php?service_id="><button class="blue-btn add-to-cart" > -->
                        Veiw Product
                    <!-- </button></a> -->
                    
                </div>

            </div>

        </li>

        <?php endforeach; ?>
    </ul>
</div>
    
</body>
</html>