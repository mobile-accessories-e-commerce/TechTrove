<?php
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $input = $_GET['query'];

$sql = "SELECT * FROM invalid_search_quary WHERE quary='$input'";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0){
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $new_count = $row['search_count'] +1;
    $sql = "UPDATE invalid_search_quary SET search_count='$new_count' WHERE id='$id'";
    $result = mysqli_query($con,$sql);
}else{
    $sql = "INSERT INTO invalid_search_quary (quary) VALUE ('$input')";
    $result = mysqli_query($con,$sql);
}

}

?>