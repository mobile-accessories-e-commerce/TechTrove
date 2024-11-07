<?php 
include "../connect.php";
session_start();

$sucuss = 0;
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $service_id = $_POST['service_id'];
    $contact_number = $_POST['contact_number'];
    $user_id = $_SESSION['userid'];

    $sql = "INSERT INTO service_requests (service_id, user_id, location, user_name, description, contact_number) 
    VALUES ('$service_id', '$user_id', '$location', '$name', '$description', '$contact_number')";

$result = mysqli_query($con,$sql);

if($result){
    $sucuss =1;
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            position: relative;
        }
        .container{
            position: absolute;
            top: 25vh;
            left: 30%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .back{
            border: none;
            background-color: black;
            padding: 10px;
            width: 150px;
            color: white;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 15px;
            
        }
        .back:hover{
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <?php if($sucuss==1): ?>
        <div class="container">
            <h1>Service Provider will contact you soon.</h1>
            <img src="../images/contact.png" width="200px" height="160px">
            <a href="../Home/dashbord.php"><button class="back">Back to home</button></a>
        </div>
        
   
    <?php else: ?>
    <h1>Oops! Some error has occured.Please try again.</h1>
    <?php endif; ?>

    <script>
        setTimeout(function() {
    window.location.href = "../userservicerequest/userservicerequest.php"; // Replace with your target URL
}, 500);
    </script>
</body>
</html>
