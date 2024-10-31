<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../connect.php';

    $USERNAME = $_POST['username'];
    $PASSWORD = $_POST['password'];



    $sql = "select * from `users` where username = '$USERNAME' and password = '$PASSWORD'";


    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION["username"] = $USERNAME;
        $_SESSION['userid'] = $row['user_id'];
        header('location:../Home/dashbord.php');
    } else {
        echo 'Cheack your user name and password and try again';

    }
}

?>











<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        button a {
            color: white;
            text-decoration: none;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <h1>Welcome to Techrow, Start Your Journey Here</h1>

    <form action="loging.php" method="post">
        <input type="text" placeholder="Enter your Name" name="username" required>
        <input type="password" placeholder="Enter Your Password" name="password" required>
        <input type="submit" value="Login">
    </form>
    <button><a href="signup.php">Sign Up</a></button>
</body>

</html>