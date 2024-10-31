<?php
session_start();
include "../connect.php";

if (!isset($_SESSION['userid'])) {
    header("location:../authentication/loging.php");
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $stock_quantity = $_POST['stock_quantity'];
    $sql = "UPDATE products SET stock_quantity ='$stock_quantity' WHERE product_id = '$product_id' ";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("location:../sellers/sellerdashbord.php");
    }

}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>erro</title>
</head>

<body>

    <h1>Erro occur updating the quantity try again</h1>
    <a href="../sellers/sellerdashbord.php"><button>GO BACK</button></a>

</body>

</html>