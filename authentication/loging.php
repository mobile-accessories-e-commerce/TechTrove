<?php
if($_SERVER['REQUEST_METHOD']=== 'POST'){
    include'../connect.php';

    $USERNAME = $_POST['username'];
    $PASSWORD = $_POST['password'];
    


    $sql = "select * from `users` where username = '$USERNAME' and password = '$PASSWORD'";
   
  
    $result = mysqli_query($con, $sql);
  
    if(mysqli_num_rows($result)> 0){
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION["username"] = $USERNAME;
        $_SESSION['userid'] = $row['user_id'];
        header('location:../Home/dashbord.php');
    }else{
        echo'Check your user name and password and try again';

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
            background-color:  #d9e5f4; 
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            position: relative;
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
            color:rgb(24, 144, 180); 
            text-align: center;
            margin-bottom: 20px; 
            font-size: 40px;
            margin-bottom: 5px;
        }
        .text{
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
            height: 300px 
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

       
        .signup{
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
        }
        .signup a{
            color: blue;
        }
        .signup a:hover{
            color: red;
        }
    </style>
</head>
<body>
    <header><img src="../images/elife_logo.png" alt="elife" width="140" height="70"></header>
    <div class="form-container">
            <h1>Welcome</h1>
            <p class="text"> Start Your Journey Here</p>

        <form action="loging.php" method="post">
            <input type="text" placeholder="Enter your Name" name="username" required>
            <input type="password" placeholder="Enter Your Password" name="password" required>
            <input type="submit" value="Log In">
        </form>
        <p class="signup">Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
    
    
</body>
</html>
