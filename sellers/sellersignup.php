<?php

session_start();


if(!isset($_SESSION['userid'])){
    header("location:../authentication/loging.php");
}

include "../connect.php";
$error = '';
$user_id = $_SESSION['userid'];


$checkQuery = "SELECT * FROM sellers WHERE user_id = '$user_id'";
$result = $con->query($checkQuery);



//check if the user is alrady a seller
if ($result->num_rows > 0) {
    $checkstatusquery = "SELECT approved FROM sellers  WHERE user_id = '$user_id'";
    $statusresult = $con->query(query: $checkstatusquery);
    $row = mysqli_fetch_assoc($statusresult);

    //check seller is approved or not
    if ($row['approved'] == 1) {
        header("location:sellerdashbord.php");
    } else {
        header("location:sllerapprovedwaiting.php");
    }

}


//get seller details and register seller
if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($error)) {

    $store_name = $con->real_escape_string($_POST['store_name']);
    $seller_name = $con->real_escape_string($_POST['seller_name']);
    $email = $con->real_escape_string($_POST['email']);
    $phone_number = $con->real_escape_string($_POST['phone_number']);


    if (empty($store_name) || empty($seller_name) || empty($email) || empty($phone_number)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone_number)) {
        $error = "Invalid phone number! Please enter a 10-digit phone number.";

    } else {

        $sql = "INSERT INTO sellers (user_id, store_name, seller_name, phone_number, email) 
                VALUES ('$user_id', '$store_name', '$seller_name', '$phone_number', '$email')";

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
    <title>Seller Signup</title>
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
            font-size: 70px;
            color: #1A3C60;
            margin-top: 30px;


        }


        .container {
            position: relative;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(135deg,#00feba, #5b548a);



           
        }

        .form-container {
            position: absolute;
            right:25%;
            left: 30%;
            bottom: 30px;


        }
        .close-btn {
            
            position: absolute;
            right: 100px;
            top: 5px;
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
            border-radius: 7px;
            box-shadow: 18px 18px 18px rgba(0, 0, 0, 0.2);
            width: 400px;
        

        }
        label{
            font-size: 13px;
            color:#333;
        }
        

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 7px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 15px;
        }

        input[type="submit"] {
            background-color: #28a745;
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
            background-color: #218838;
        }

       
    </style>
</head>

<body>
    <div class="container">


        <h1>Become A <img src="../images/elife_logo.png" alt="elife" width="140" height="70"> Seller Today!</h1>


        <div class="form-container">
            
        
        <button class="close-btn"><a href="../Home/dashbord.php">&times;</a></button>

            <!--check for error-->
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo $error; ?></div>
                <a href="../Home/dashbord.php"><button>Go to Dashboard</button></a>
            <?php else: ?>
                
                <form action="sellersignup.php" method="POST">
        
                    <label for="store_name">Store Name:</label>
                    <input type="text" id="store_name" name="store_name" required>

                    <label for="seller_name">Seller Name:</label>
                    <input type="text" id="seller_name" name="seller_name" required>

                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" required>


                    <input type="submit" value="Sign Up">
                </form>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>