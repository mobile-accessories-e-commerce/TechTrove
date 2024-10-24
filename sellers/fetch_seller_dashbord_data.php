<?php
session_start();
include('../connect.php'); 

$section = $_GET['section']; 


if ($section == 'all_products') {
    $user_id = $_SESSION['userid']; 
    $productList = array(); 
    
   
    $query = "SELECT seller_id FROM sellers WHERE user_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $seller_id = $row['seller_id'];
        $_SESSION['seller_id'] = $seller_id; 
    } else {
        echo json_encode(["error" => "Seller not found. Please contact support."]);
        exit;
    }

    
    $query = "SELECT * FROM products WHERE seller_id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $seller_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productList[] = $row; 
        }
        echo json_encode($productList); 
    } else {
        echo json_encode([]); 
    }
}

elseif($section=='ordered_products'){
    if(!isset($_SESSION['seller_id'])){
        header("location:sellerdashbord.php");
        exit();
    } else {
        $seller_id = $_SESSION['seller_id'];
    }
    
    
    $sql = "SELECT sp.address, sp.country,sp.zip_code, sp.mobile_number,sp.email, oi.payment_method, 
                   p.product_name, oi.quantity, oi.price,p.image_link,oi.item_id
            FROM orders AS o 
            JOIN order_items AS oi ON o.order_id = oi.order_id
            JOIN products AS p ON oi.product_id = p.product_id
            JOIN shipping_details AS sp ON o.order_id = sp.order_id
            WHERE p.seller_id = '$seller_id' and oi.order_status='pending'";
    
    $result = mysqli_query($con, $sql);
    
    if(!mysqli_num_rows($result)>0){
        header("location:sellerdashbord.php");
    }
    
    $order_products = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($order_products, $row);
        
    }
    echo json_encode($order_products); 
}




if ($section == 'product_status') {
    $user_id = $_SESSION['userid']; 
    $productList = array(); 
    
    // Fetch the seller ID from the session
    if (isset($_SESSION['seller_id'])) {
        $seller_id = $_SESSION['seller_id'];
    } else {
        // Retrieve seller ID based on user ID
        $query = "SELECT seller_id FROM sellers WHERE user_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $seller_id = $row['seller_id'];
            $_SESSION['seller_id'] = $seller_id;
        } else {
            echo json_encode(["error" => "Seller not found. Please contact support."]);
            exit;
        }
    }

    // Fetch product details with view count, rating, and order count
    $query = "
        SELECT p.product_id, p.product_name, p.image_link, p.stock_quantity, p.view_count, p.rating, 
               IFNULL(SUM(oi.quantity), 0) AS total_orders
        FROM products p
        LEFT JOIN order_items oi ON p.product_id = oi.product_id
        WHERE p.seller_id = ?
        GROUP BY p.product_id;
    ";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $seller_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productList[] = $row;
        }
        echo json_encode($productList);
    } else {
        echo json_encode([]);
    }
}
?>
