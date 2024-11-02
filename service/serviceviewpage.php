<?php
include "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $service_id = $_GET['service_id'];

    $getviewquary = "SELECT view_count FROM services WHERE service_id = $service_id ";
    $result = mysqli_query($con, $getviewquary);
    $row = mysqli_fetch_assoc($result);
    $current_view = $row['view_count'];
    $new_view = $current_view + 1;

    $updateviewquary = "UPDATE services SET view_count = '$new_view' WHERE service_id=$service_id";
    $result = mysqli_query($con, $updateviewquary);

    if (!$result) {
        header("location:../Home/dashbord.php");
    }
    $query = "SELECT * FROM services WHERE service_id=$service_id";
    $result = mysqli_query($con, $query);

    $service = mysqli_fetch_assoc($result);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="../style/productveiwpage.css">
</head>

<body>
    <div><a href="services.php"><button class="back">back</button></a></div>

    <div class="main-container">
        <div class="container">
            <div class="image">
                <img src="../images/<?php echo $service['image_link']; ?>" alt="Product Image">
            </div>

            <div class="details">
                <div class="title"><?php echo $service['service_name']; ?></div>
                <div class="description"><?php echo $service['description']; ?></div>
                <div class="price">$<?php echo $service['price']; ?></div>
                <div class="location"><?php echo $service['location']; ?></div>
                <div class="contact_details"><?php echo $service['contact_detail']; ?></div>



                <a href="../cart/add_to_cart.php?product_id=<?php echo $product['product_id']; ?>&quantity=1"
                    id="addToCartLink">
                    <button class="add-to-cart">Contact Provider</button>
                </a>
            </div>
        </div>
    </div>


</body>

</html>