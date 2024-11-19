<?php
session_start();
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    
    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        
        
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['user_id'];
            header("Location: ../admin/admindashbord.php"); 
            exit();
        } else {
            $error_message = "Incorrect password!";
        }
    } else {
        $error_message = "No admin found with that username!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #00feba, #5b548a);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            position: relative;
        }
        header {
            width: 100%;
            background-color: white;
            position: absolute;
            top: 0;
            z-index: 2;
            padding: 10px;
            text-align: center;
        }
        h1 {
            color: rgb(24, 144, 180);
            text-align: center;
            margin-bottom: 20px;
            font-size: 40px;
            margin-bottom: 5px;
        }
        .text {
            text-align: center;
            font-size: 15px;
            margin-top: 5px;
            color: rgb(2, 60, 82);
        }
        .form-container {
            background: #fff;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 18px 18px 18px rgba(0, 0, 0, 0.3);
            width: 350px;
            height: 200px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            text-align: center;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 14px;
        }
        input[type="submit"] {
            background-color: #007bff;
            width: 100%;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 7px;
            margin-top: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .signup {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
        }
        .signup a {
            color: blue;
        }
        .signup a:hover {
            color: red;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<header>
    <h1>Admin Login</h1>
</header>

<div class="form-container">
    <!-- Display error message if login fails -->
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div>
            <input type="submit" value="Login">
        </div>
    </form>
    
</div>

</body>
</html>
