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
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;



        }


        h1 {
            text-align: center;
            font-size: 50px;
            color: #1A3C60;
            margin-top: 30px;


        }


        .container {
            position: relative;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(135deg,#00feba, #5b548a);



           
        }
        .container img{
            position: absolute;
            left: 10%;
            top: 25%;
        }

        .form-container {

            position: absolute;
            right:12%;
            
            bottom: 7%;


        }
        .close-btn {
            
            position: absolute;
            right: 3%;
            top: 3%;
            background-color: #f1f1f1;
            border: none;
           border-radius: 4px;
            font-size: 24px;
            color: #333;
            cursor: pointer;
            outline: none;
        }
        .close-btn a{
            text-decoration: none;
            color: gray;
        }
        .close-btn:hover {
            background-color: #f00;
            color: white;
       
        }
        .close-btn a:hover{
            color: white;
        }

        form {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 18px 18px 18px rgba(0, 0, 0, 0.2);
            width: 400px;
            height: 320px;
            
        

        }
        form p{
            font-size: 22px;
            color: #023e61;
            font-weight: 500;
            text-align: center;
        }
        
        

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 7px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 13px;
            text-align: center;
            color: #555;
        }

        input[type="submit"] {
            background-color: #0a5c80;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            margin-top: 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%
        }

        input[type="submit"]:hover {
            background-color: #023e61;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <header><img src="../images/elife_logo.png" width="140" height="70" alt="Logo"></header>
   
    <div class="container">
        
        <h1>Start Offering Your Expert Services To eLife!</h1>
        <img src="../images/service4.png" alt="" width="500px" height="400px">

        <div class="form-container">


        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
            <a href="../Home/dashbord.php"><button class="gohome">Go to Home</button></a>
        <?php else: ?>

            <form action="servicesignup.php" method="POST">
                <button class="close-btn"><a href="../Home/dashbord.php">&times;</a></button>
                <p> Sign Up Here!</p>
                
                <input type="text" id="service_name" name="service_name" placeholder="Enter Your service" required>

                
                <input type="text" id="provider_name" name="provider_name" placeholder="Enter Your Name" required>

                
                <input type="email" id="email" name="email" placeholder="Enter Your Email" required>

                
                <input type="text" id="phone_number" name="phone_number" placeholder="Enter Your Mobile Number" required>

                <input type="submit" value="Sign Up">
            </form>
        <?php endif; ?>
        </div>
    </div>
</body>

</html>