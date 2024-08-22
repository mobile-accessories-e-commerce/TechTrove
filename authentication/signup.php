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
    <title>signup</title>
</head>
<body>
    <h1>Wellcome to techrow start your journy here </h1>

    <form action="signup.php" method="post">

    <input type="text" placeholder="Enter your Name" name="username">
    <input type="text" placeholder="Enter Your Email" name="email">
    <input type="password" placeholder="Enter Your password" name="password">
    <input type="submit">

    </form>
</body>
</html>