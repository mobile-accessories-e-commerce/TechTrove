<?php
include "../connect.php";

if (isset($_GET['query'])) {
    $searchTerm = $_GET['query'];
    $serviceList = array();


    $query = "SELECT * FROM services WHERE service_name LIKE ?";
    $stmt = mysqli_prepare($con, $query);


    $searchTerm = '%' . $searchTerm . '%';
    mysqli_stmt_bind_param($stmt, 's', $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);


    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($serviceList, $row);
        }
    }else {
        array_push($serviceList,"false");
    }
    echo json_encode($serviceList);

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>