<?php
include "../connect.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 

if (isset($_GET['serviceprovider_id'])) {
    $serviceprovider_id = $_GET['serviceprovider_id'];
    $query = "SELECT provider_name, email, phone_number, location FROM service_providers WHERE service_provider_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $serviceprovider_id);

    try {
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $serviceprovider = $result->fetch_assoc();
            echo json_encode($serviceprovider);
        } else {
            echo json_encode(['error' => 'Seller not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
