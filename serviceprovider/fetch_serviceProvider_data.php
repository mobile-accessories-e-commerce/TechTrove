<?php
session_start();
include('../connect.php');

$section = $_GET['section'];


if ($section == 'all_service') {
    $user_id = $_SESSION['userid'];
    $serviceList = array();


    $query = "SELECT service_provider_id FROM service_providers WHERE user_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $service_provider_id = $row['service_provider_id'];
        $_SESSION['service_provider_id'] = $service_provider_id;
    } else {
        echo json_encode(["error" => "service provider not found. Please contact support."]);
        exit;
    }


    $query = "SELECT * FROM services WHERE service_provider_id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $service_provider_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $serviceList[] = $row;
        }
        echo json_encode($serviceList);
    } else {
        echo json_encode([]);
    }
}
if($section=="service_request"){
    $service_provider_id = $_SESSION['service_provider_id'];
    $serviceList = array();
    $accept = 0;

    $query = "SELECT s.image_link,s.service_name,sr.user_name,sr.description,sr.location,sr.contact_number,sr.id FROM service_requests sr
    JOIN services s ON sr.service_id = s.service_id
     WHERE s.service_provider_id=? and sr.accept=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $service_provider_id,$accept);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $serviceList[] = $row;
        }
        echo json_encode($serviceList);
    } else {
        echo json_encode([]);
    }
}

?>