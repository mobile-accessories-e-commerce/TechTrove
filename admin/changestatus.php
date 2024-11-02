<?php
include "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['seller_approve'])) {
        $seller_id = $_POST['seller_approve'];
        $query = "SELECT approved FROM sellers WHERE seller_id='$seller_id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $approved_status = $row['approved'];
        $new_approved_status = $approved_status == 1 ? 0 : 1;

        $query = "UPDATE sellers SET approved='$new_approved_status' WHERE seller_id='$seller_id'";
        $result = mysqli_query($con, $query);
        if (!$result) {
            die("An error occur updating seller status");
        } else {
            echo "succsufully update";
            header("location:admindashbord.php");
        }
    }


    if (isset($_POST['service_approved'])) {
        $service_provider_id = $_POST['service_approved'];
        $query = "SELECT aproved FROM service_providers WHERE service_provider_id='$service_provider_id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $approved_status = $row['aproved'];
        $new_approved_status = $approved_status == 1 ? 0 : 1;

        $query = "UPDATE service_providers SET aproved='$new_approved_status' WHERE service_provider_id='$service_provider_id'";
        $result = mysqli_query($con, $query);
        if (!$result) {
            die("An error occur updating service provider status");
        } else {
            echo "succsufully update";
            header("location:admindashbord.php");
        }
    }
}

?>