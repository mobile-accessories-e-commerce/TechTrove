<?php
include "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT approved FROM featured_products WHERE id='$id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $approved_status = $row['approved'];
        $new_approved_status = $approved_status == 1 ? 0 : 1;

        $query = "UPDATE featured_products SET approved='$new_approved_status' WHERE id='$id'";
        $result = mysqli_query($con, $query);
        if (!$result) {
            die("An error occur updating seller status");
        } else {
            echo "succsufully update";
            header("location:admindashbord.php");
        }
    }


}

?>