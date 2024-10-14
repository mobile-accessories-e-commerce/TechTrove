<?php
include "../connect.php";
session_start();
$user_id = $_SESSION['userid'];


$serviceList = array();

$query = "SELECT service_provider_id FROM service_providers WHERE user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $service_provider_id = $row['service_provider_id'];
} else {
    
    echo "service provider not found. Please contact support.";
    exit;
}


$query = "SELECT * FROM services WHERE service_provider_id=? ";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $service_provider_id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows>0){
    while($row =mysqli_fetch_assoc($result)){
        array_push($serviceList,$row);
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>service provider dashbord</title>
    
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
    
<a href="servicelisting.php"><button>Add service</button></a>
<a href="../Home/dashbord.php"><button>Go to Home</button></a>
    <div class="container">
        <h1>Your Product</h1>
        <?php if (empty($serviceList)): ?>
            <p>No service List yet</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($serviceList as $service): ?>
                    <div class="card">
                        <img src="../images/<?php echo $service['image_link']; ?>" alt="<?php echo $service['service_name']; ?>">
                        <h2><?php echo $service['service_name']; ?></h2>
                        <p>Price: $<?php echo number_format($service['price'], 2); ?></p>
                        <form action="editservice.php"><input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>"> <input type="submit" value="edit"></form>
                        
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>




</body>
</html>



















