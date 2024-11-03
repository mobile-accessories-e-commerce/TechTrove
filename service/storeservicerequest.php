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
</head>
<body>
    <?php if($sucuss==1): ?>
        <h1>Service Provider contact you</h1>
   
    <?php else: ?>
    <h1>oops Some erro occur try again</h1>
    <?php endif; ?>
</body>
</html>
