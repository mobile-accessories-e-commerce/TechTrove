<?php
if($_SERVER['REQUEST_METHOD']=== 'POST'){
    include'../connect.php';

    $USERNAME = $_POST['username'];
    $PASSWORD = $_POST['password'];
    


    $sql = "select * from `users` where username = '$USERNAME' and password = '$PASSWORD'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result)> 0){
        session_start();
        $_SESSION["username"] = $USERNAME;
        header('location:../Home/dashbord.php');
    }else{
        echo'Cheack your user name and password and try again';

    }
}

?>













<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
   
<h1>Wellcome to techrow start your journy here </h1>

    <form action="loging.php" method="post">

    <input type="text" placeholder="Enter your Name" name="username">
    <input type="password" placeholder="Enter Your password" name="password">
    <input type="submit">

    </form>
    <button><a href="signup.php">SignUp</a></button>
</body>
</html>