<?php
include 'connect.php';
session_start();
if(!isset($_SESSION['userid'])){

}

$user_id = $_SESSION['userid'];
$quary = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($con,$quary);
$row = mysqli_fetch_assoc($result);

$name = $row['username'];


if($_SERVER['REQUEST_METHOD']==='POST'){
    $new_name = $_POST['name'];
    $quary = "UPDATE users SET username='$new_name'"; 
    $result = mysqli_query($con,$quary);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="userprofile.php" method="post">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo $name  ?>">
        <input type="submit">
    </form>
    
</body>
</html>