<?php
include "../connect.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error reporting

if (isset($_GET['seller_id'])) {
    $seller_id = $_GET['seller_id'];
    $query = "SELECT store_name, email, phone_number,location FROM sellers WHERE seller_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $seller_id);

    try {
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $seller = $result->fetch_assoc();
            echo json_encode($seller);
        } else {
            echo json_encode(['error' => 'Seller not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
