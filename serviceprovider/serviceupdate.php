<?php


include '../connect.php';


session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $service_id = (int) $_POST['service_id'];
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $service_status = $_POST['service_status'];
    $location = $_POST['location'];
    $contact_detail = $_POST['contact_detail'];
    $duration = $_POST['duration'];


    if (empty($service_name) || empty($description) || empty($location)) {
        die("Error: All fields are required!");
    }


    $stmt = $con->prepare("UPDATE services SET 
                            service_name = ?, 
                            description = ?, 
                            price = ?, 
                            location= ?,
                            contact_detail = ?,
                            duration = ?,
                            service_status = ? 
                            WHERE service_id = ?");




    $stmt->bind_param("ssissiii", $service_name, $description, $price, $location, $contact_detail, $duration, $service_status,$service_id);

    if ($stmt->execute()) {

        header("Location:servicedashbord.php");
        exit;
    } else {
        die("Error: Could not update product. " . $stmt->error);
    }


    $stmt->close();
    $con->close();
} else {

    die("Error: Invalid request.");
}
?>