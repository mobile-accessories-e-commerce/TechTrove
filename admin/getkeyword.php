<?php 
include "../connect.php";
session_start();

$sql = "SELECT * FROM invalid_search_quary";
$result = mysqli_query($con,$sql);
$keyword_list = array();
while($row = mysqli_fetch_assoc($result)){
    array_push($keyword_list,$row);
}

echo json_encode($keyword_list);

?>