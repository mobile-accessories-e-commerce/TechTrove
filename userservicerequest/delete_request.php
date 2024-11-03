<?php
include "../connect.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["request_id"])) {
    $request_id = intval($_POST["request_id"]);
    
    $sql = "DELETE FROM service_requests WHERE id = $request_id";
    $result = mysqli_query($con, $sql);
    
    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => mysqli_error($con)]);
    }
}
?>
