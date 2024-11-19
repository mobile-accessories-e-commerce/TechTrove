<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['userid'])) {
    header("location:../authentication/loging.php");
}

if ($_GET['service_id']) {

    $service_id = $_GET['service_id'];
    $user_id = $_SESSION['userid'];

    $cat_query = "SELECT service_cat_id, name FROM service_catogory";
    $cat_result = $con->query($cat_query);


    $query = "SELECT * FROM services WHERE service_id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $service = $result->fetch_assoc();


    if ($service) {
        $service_name = $service['service_name'];
        $description = $service['description'];
        $price = $service['price'];
        $service_status = $service['service_status'];
        $location = $service['location'];
        $contact_detail = $service['contact_detail'];
        $duration = $service['duration'];



    } else {
        echo "Product not found!";
        exit();
    }
}






?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        *{
            font-family: Arial, sans-serif;
        }
        body {
            background-color:  #d9e5f4;
            
        }

        .container {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 15px 15px 15px rgba(0,0,0,0.1);
            position: relative;
        }
        .close-btn {
            
            position: absolute;
            right: 5px;
            top: 5px;
            background: none;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
            outline: none;
        }
        .close-btn a{
            text-decoration: none;
            color: gray;
        }
        .close-btn a:hover {
        color: #f00; 
        }
        label,option{
            font-size: 13px;
            color: #333;

        }

        input[type=text],
        input[type=number],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
    <button class="close-btn"><a href="../serviceprovider/servicedashbord.php">&times;</a></button>
        <h2>Edit Product</h2>

        <form action="serviceupdate.php" method="POST">
            <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">

            <label for="service_name">Service Name:</label>
            <input type="text" id="service_name" name="service_name" required value="<?php echo $service_name; ?>">

            <label for="description">Description:</label>
            <textarea id="description" name="description"
                required><?php echo htmlspecialchars($description); ?></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required value="<?php echo $price; ?>">

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required value="<?php echo $location; ?>">

            <label for="contact_detail">Contact Detail:</label>
            <input type="text" id="contact_detail" name="contact_detail" required
                value="<?php echo $contact_detail; ?>">


            <label for="duration">Duration:</label>
            <input type="text" id="duration" name="duration" required value="<?php echo $duration; ?>">

            <label for="service_status">Service Status (Available):</label>
            <input type="checkbox" id="service_status" name="service_status" value="<?php echo $is_free_shiping; ?>">

            <input type="submit" value="List Service">
        </form>
    </div>
</body>

</html>