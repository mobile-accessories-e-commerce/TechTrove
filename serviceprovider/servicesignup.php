<?php

session_start();


if(!isset($_SESSION['userid'])){
    header("location:../authentication/loging.php");
}


include '../connect.php';
$error = '';
$user_id = $_SESSION['userid'];


$checkQuery = "SELECT * FROM service_providers WHERE user_id = '$user_id'";
$result = $con->query($checkQuery);

if ($result->num_rows > 0) {
    $checkstatusquery = "SELECT aproved FROM service_providers  WHERE user_id = '$user_id'";
    $statusresult = $con->query(query: $checkstatusquery);
    $row = mysqli_fetch_assoc($statusresult);

    //check seller is approved or not
    if ($row['aproved'] == 1) {
        header("location:servicedashbord.php");
    } else {
        header("location:../sellers/sllerapprovedwaiting.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($error)) {

    $service_name = $con->real_escape_string($_POST['service_name']);
    $service_description = $con->real_escape_string($_POST['service_description']);
    $provider_name = $con->real_escape_string($_POST['provider_name']);
    $email = $con->real_escape_string($_POST['email']);
    $phone_number = $con->real_escape_string($_POST['phone_number']);
    $bank_ac_num = $con->real_escape_string($_POST['bank_ac_num']);


    if (empty($service_name) || empty($service_description) || empty($provider_name) || empty($email) || empty($phone_number) || empty($bank_ac_num)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone_number)) {
        $error = "Invalid phone number! Please enter a 10-digit phone number.";
    } elseif (!preg_match('/^[0-9]{9,18}$/', $bank_ac_num)) {
        $error = "Invalid bank account number! It should be between 9 to 18 digits.";
    } else {

        $sql = "INSERT INTO service_providers (user_id, service_name, service_description, provider_name, email, phone_number, bank_ac_num) 
                VALUES ('$user_id', '$service_name', '$service_description', '$provider_name', '$email', '$phone_number', '$bank_ac_num')";

        if ($con->query($sql) === TRUE) {

            header("Location: ../Home/dashbord.php");
            exit();
        } else {
            $error = "Error: " . $sql . "<br>" . $con->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg,#00feba, #5b548a);
          
           
          
         
        }
        .gohome{
            padding: 10px;
            border: none;
            border-radius: 4px;
            color: #f0f0f0;
            background-color: black;
            width: 200px;
            
        }
       
        .container {
            width: 400px;
            margin: 50px auto;
            padding: 40px;
            padding-right: 60px;
            border: 1px solid #ccc;
            border-radius: 7px;
            background-color: #fff;
            position: relative;
         
        }
        .close-btn {
            
            position: absolute;
            right: 2px;
            top: 2px;
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
        .container img{
           display: flex;
           align-items: center;
           margin-left: 120px;
        }
    
        .container p{
            text-align: left;
            color: black;
            margin-top: 0;
            font-size: 26px;
        }

        label,
        input{
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        label{
            font-size: 13px;
            color: #333;
        }

        input[type="submit"] {
            width: 100%;
            border-radius: 4px;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
        input[type="text"],input[type="email"]{
            padding: 8px;
            font-size: 14px;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
   
    <div class="container">
        <img src="../images/elife_logo.png" width="140" height="70" alt="Logo">
        <button class="close-btn"><a href="../Home/dashbord.php">&times;</a></button>
        <p> Sign Up</p>


        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
            <a href="../Home/dashbord.php"><button class="gohome">Go to Home</button></a>
        <?php else: ?>

            <form action="servicesignup.php" method="POST">
                <label for="service_name">Service Name:</label>
                <input type="text" id="service_name" name="service_name" required>

                <label for="provider_name">Provider Name:</label>
                <input type="text" id="provider_name" name="provider_name" required>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>

                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" required>

                <input type="submit" value="Sign Up">
            </form>
        <?php endif; ?>
    </div>
</body>

</html>