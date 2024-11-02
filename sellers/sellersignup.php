<?php

session_start();


if (!isset($_SESSION['userid'])) {
    header("Location: ../login.php");
    exit();
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
    $bank_ac_num = $con->real_escape_string($_POST['bank_ac_num']);
    $store_description = $con->real_escape_string($_POST['store_description']);


    if (empty($store_name) || empty($seller_name) || empty($email) || empty($phone_number) || empty($bank_ac_num) || empty($store_description)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone_number)) {
        $error = "Invalid phone number! Please enter a 10-digit phone number.";
    } elseif (!preg_match('/^[0-9]{9,18}$/', $bank_ac_num)) {
        $error = "Invalid bank account number! It should be between 9 to 18 digits.";
    } else {

        $sql = "INSERT INTO sellers (user_id, store_name, seller_name, store_description, phone_number, email, bank_ac_num) 
                VALUES ('$user_id', '$store_name', '$seller_name', '$store_description', '$phone_number', '$email', '$bank_ac_num')";

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
        body { font-family: Arial, sans-serif; }
        .container { width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        label, input, textarea { display: block; width: 100%; margin-bottom: 10px; }
        input[type="submit"] { width: auto; padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer; }
        input[type="submit"]:hover { background-color: #218838; }
        .error { color: red; margin-bottom: 10px; }
    </style>
</head>

<body>
    <div class="container">
    

    <h1>Become A <img src="../images/elife_logo.png" alt="elife" width="140" height="70"> Seller Today!</h1>
    

    <div class="form-container">
    
        

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