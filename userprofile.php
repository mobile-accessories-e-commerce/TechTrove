<?php

include "connect.php";
session_start();
if(!isset($_SESSION["userid"])){
    header("location:authentication/loging.php");
}

$success=0;
$user_id= $_SESSION['userid'];
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);

$user_name=$row['display_name'];
$email=$row['email'];
$mobile=$row['mobile_number'];
$address=$row['address'];
$country=$row['country'];




if($_SERVER['REQUEST_METHOD']==='POST'){
    $user_name = $_POST['name'];
    $email= $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $country = $_POST['country'];

    $sql = "UPDATE users 
            SET display_name='$user_name',email='$email',mobile_number='$mobile',address='$address',country='$country' 
            WHERE user_id='$user_id'";

    $result = mysqli_query($con,$sql);
   if($result){
    $success= 1;
   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; 
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        

        form {
            background: #fff; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
            width: 300px; 
        }

        input[type="text"] ,input[type="email"]{
            width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ccc; 
            border-radius: 4px;
            box-sizing: border-box; 
        }

        input[type="submit"] {
            background-color: #28a745; 
            color: white;
            border: none; 
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px; 
            transition: background-color 0.3s; 
        }

        input[type="submit"]:hover {
            background-color: #218838; 
        }
        .back{
        position:absolute;
        left: 40px;
        top: 40px;
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 15px;
        font-size: 14px;
        cursor: pointer;
        border-radius: 4px;
        z-index: +1;
        }
        .success{
            color: #28a745;
            margin-bottom: 20px;
        }
        </style>
</head>
<body>
<div ><a href="Home/dashbord.php"><button class="back">back</button></a></div>
    <div class="success"><?php if($success){echo "Succesfully Updated";} ?></div>
    <form action="userprofile.php" method="post">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo "$user_name" ?>"><br><br>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo "$email" ?>"><br><br>
        <label for="mobile">Mobile Number</label>
        <input type="text" name="mobile" id="mobile" value="<?php echo "$mobile" ?>"><br><br>
        <label for="address">Address</label>
        <input type="text" name="address" id="address" value="<?php echo "$address" ?>"><br><br>
        <label for="country">Country</label>
        <input type="text" name="country" id="country" value="<?php echo "$country" ?>">
        <input type="submit" value="Update" >
       


    </form>
    
</body>
</html>