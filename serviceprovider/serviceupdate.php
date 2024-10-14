<?php


include '../connect.php';


session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $service_id = (int)$_POST['service_id'];
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_link = $_POST['image_link'];
    $service_status = $_POST['service_status'];
    $category_id = (int)$_POST['category_id'];
    $location = $_POST['location'];
    $contact_detail = $_POST['contact_detail'];
    $duration = $_POST['duration'];

    
    if (empty($service_name) || empty($description) || empty($location) || empty($category_id)) {
        die("Error: All fields are required!");
    }
    echo $category_id;
    
    if (isset($_FILES['image_link']) && $_FILES['image_link']['error'] == UPLOAD_ERR_OK) {
       
        $uploadDir = 'uploads/'; 
        $uploadFile = $uploadDir . basename($_FILES['image_link']['name']);

        
        if (!move_uploaded_file($_FILES['image_link']['tmp_name'], $uploadFile)) {
            die("Error: Could not upload the image.");
        }
    }

  
    $stmt = $con->prepare("UPDATE services SET 
                            service_name = ?, 
                            description = ?, 
                            price = ?, 
                            location= ?,
                            contact_detail = ?,
                            image_link = ?,
                            duration = ?,
                            service_status = ?, 
                            catogory_id = ? 
                            WHERE service_id = ?"); 



    
    $stmt->bind_param("ssisssiiii", $service_name, $description, $price,$location,$contact_detail, $image_link,$duration,$service_status, $category_id, $service_id);
    
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
