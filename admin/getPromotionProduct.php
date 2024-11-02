<?php
include "../connect.php";

$sql = "SELECT p.product_id, p.seller_id, p.product_name, p.description, p.image_link,
               pr.discount, pr.start_date, pr.end_date
        FROM products p
        JOIN promotions pr ON p.product_id = pr.product_id";

$result = $con->query($sql);

$promotional_products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $promotional_products[] = $row;
    }
}

echo json_encode($promotional_products);

$con->close();
?>