<?php
if($_SERVER['REQUEST_METHOD']=== 'POST'){
    include'../connect.php';

    $USERNAME = $_POST['username'];
    $PASSWORD = $_POST['password'];
    $EMAIL = $_POST['email'];
    $USERTYPE = 'NORMAL';


    $sql = "select * from `users` where username='$USERNAME'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result)> 0){
        echo"user already exit in the system";
    }else{
        $sql = "insert into `users` (user_type,username,password,email) values ('$USERTYPE','$USERNAME','$PASSWORD','$EMAIL') ";
        $result = mysqli_query($con, $sql);
        if($result){
            header('location:loging.php');
        }

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg,#00feba, #5b548a);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        header{
           width: 100%;
           background-color: white;
            position: absolute;
            top: 0;
            z-index: 2;
            padding: 10px;
           text-align: center;

        }

        h1 {
            color: #333; 
            text-align: center;
            margin-bottom: 20px; 
        }
        p{
           text-align: center;
           font-size: 25px;
           color:  rgb(5, 111, 150);
        }

        .form-container {
            background: #fff; 
            padding: 20px; 
            border-radius: 12px; 
            box-shadow: 18px 18px 18px rgba(0, 0, 0, 0.2); 
            width: 350px; 
            height: 440px;
            margin-top: 60px
        }

        input[type="text"], input[type="password"] {
            width: 100%; 
            padding: 12px; 
            margin: 10px 0; 
            border: 1px solid #ccc; 
            border-radius: 10px;
            box-sizing: border-box; 
            text-align: center;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #28a745; 
            width: 100%;
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
        button {
            background-color: #007bff; 
            width: 100%;
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
            background-color: #0056b3; 
        }
    </style>
</head>
<body>
    <header><img src="../images/elife_logo.png" alt="elife" width="140" height="70"></header>
    <div class="form-container">
    <p>Hello<br> Create Your Account</p>
        <h1>Sign Up</h1>
    <form action="signup.php" method="post">
        <input type="text" placeholder="Enter your Name" name="username" required>
        <input type="text" placeholder="Enter Your Email" name="email" required>
        <input type="password" placeholder="Enter Your Password" name="password" required>
        <input type="submit" value="Sign Up">
    </form>
    <button><a href="loging.php">Log In</a></button>
    </div>
    
</body>
</html>
