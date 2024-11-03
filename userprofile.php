<?php

include "connect.php";
session_start();
if (!isset($_SESSION["userid"])) {
    header("location:authentication/loging.php");
}

$success = 0;
$user_id = $_SESSION['userid'];
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$user_name = $row['display_name'];
$email = $row['email'];
$mobile = $row['mobile_number'];
$address = $row['address'];
$country = $row['country'];




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $country = $_POST['country'];

    $sql = "UPDATE users 
            SET display_name='$user_name',email='$email',mobile_number='$mobile',address='$address',country='$country' 
            WHERE user_id='$user_id'";

    $result = mysqli_query($con, $sql);
    if ($result) {
        $success = 1;
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
            background-color: #d9e5f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .top-txt{
            color: #f0f0f0;
            padding-left: 50px;
           
            font-size: 30px;
        }
        .txt{
            font-size: 17px;
            color: black;
        }
        .account-container{
            background-color: rgb(65,125,225);
            width: 75vw;
            height: 75vh;
            position: relative;
        }
        .account-info,form{
            position: absolute;
            right: 0;
            left: 0;
            bottom: 0;
            top: 20%;
            background: #fff;
            padding: 20px;
           
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            
            
        }
        label{
            font-size: 13px;
            color: #333;
        }



        * {
            box-sizing: border-box;
        }

        /* Container styling */
        .form-container {
            max-width: 600px; /* Limit width of form */
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Grid layout for the form */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Two equal-width columns */
            gap: 20px; /* Spacing between grid items */
        }

        /* Make labels and inputs full width in each grid cell */
        .form-grid label, 
        .form-grid input {
            display: block;
            width: 100%;
        }

        /* Full-width elements for single-column items */
        .full-width {
            grid-column: 1 / -1; /* Span across both columns */
        }

        /* Input styling */
        input[type="text"], input[type="email"]{
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Submit button styling */
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            
           
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .success {
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <header><a href="Home/dashbord.php"><img src="images/elife_logo.png" width="140" height="70" alt="Logo"></a></header>
    <div class="success"><?php if ($success) {
        echo "Succesfully Updated";
    } ?></div>
    <div class="account-container">
        <p class="top-txt">My Account</p>
        <div class="account-info">
            <p class="txt">Personal information</p>
            <div class="form-container">
        <form action="userprofile.php" method="post">
            <div class="form-grid">
                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo "$user_name" ?>">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo "$email" ?>">
                </div>
                <div>
                    <label for="mobile">Mobile Number</label>
                    <input type="text" name="mobile" id="mobile" value="<?php echo "$mobile" ?>">
                </div>
                <div>
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" value="<?php echo "$address" ?>">
                </div>
                <div class="full-width">
                    <label for="country">Country</label>
                    <input type="text" name="country" id="country" value="<?php echo "$country" ?>">
                </div>
                
                <div class="full-width">
                    <input type="submit" value="Update">
                </div>
            </div>
        </form>
    </div>
            
        </div>
    </div>
    
    

</body>

</html>