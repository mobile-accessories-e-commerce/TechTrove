<?php

session_start();
if(!isset($_SESSION["username"])){
    header("location:../authentication/loging.php");
}




?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
   <h1>Wellcome <?php echo $_SESSION['username'] ?></h1>
   <button><a href="../authentication/logout.php">LogOut</a></button>
</body>
</html>