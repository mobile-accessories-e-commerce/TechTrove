<?php
session_start();
include '../connect.php';


$user_id = $_SESSION['userid'];


$query = "SELECT service_provider_id FROM service_providers WHERE user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $service_provider_id = $row['service_provider_id'];
} else {

    echo "Service provider not found. Please contact support.";
    exit;
}


$cat_query = "SELECT service_cat_id, name FROM service_catogory";
$cat_result = $con->query($cat_query);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $service_name = trim($_POST['service_name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $location = trim($_POST['location']);
    $contact_detail = trim($_POST['contact_detail']);
    $duration = trim($_POST['duration']);
    $service_status = isset($_POST['service_status']) ? 1 : 0;
    $category_id = intval($_POST['category_id']);



    $image = $_FILES['image_link'];
    $uploadDir = '../images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); 
    }

    if ($image['error'] === UPLOAD_ERR_OK) {
        $uniqueFileName = uniqid() . '-' . basename($image['name']);
        $uploadPath = $uploadDir . $uniqueFileName;

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            $image_link = $uniqueFileName; 
        } else {
            $error = "Failed to upload image.";
        }
    } else {
        $error = "Error uploading image.";
    }

    if (empty($service_name) || empty($description) || $price <= 0 || empty($location) || empty($contact_detail)) {
        $error = "Please fill out all required fields correctly.";
    } else {
        
        $insert_query = "INSERT INTO services (service_provider_id, catogory_id, service_name, description, price, location, contact_detail, image_link, duration, service_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insert_query);
        $stmt->bind_param("iissdssssi", $service_provider_id, $category_id, $service_name, $description, $price, $location, $contact_detail, $image_link, $duration, $service_status);

        if ($stmt->execute()) {
            $success = "Service listed successfully!";
            header("Location:servicedashbord.php");
            exit;
        } else {
            $error = "Failed to list service. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Listing</title>
    <style>
        *{
            font-family: Arial, sans-serif;
        }
        body {
            background-color:  #d9e5f4;
        }

        .container {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: white;
            border-radius: 10px;
            box-shadow: 18px 18px 18px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .close-btn {
            
            position: absolute;
            right: 5px;
            top: 5px;
            background: none;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
            outline: none;
        }
        .close-btn a{
            text-decoration: none;
            color: gray;
        }
        .close-btn a:hover {
        color: #f00; 
        }
        
        .container p{
            font-size: 22px;
            font-weight: 500;
        }

        input[type=text],
        input[type=number],
        input[type=float],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            box-sizing: border-box;
            
        }
        label,option{
            font-size: 13px;
            color: #333;
        }

        input[type=submit] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #218838; 
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>
    <div class="container">
    
    <button class="close-btn"><a href="../serviceprovider/servicedashbord.php">&times;</a></button>
        <p>Service Listing</p>


        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>


        <form action="servicelisting.php" method="POST" enctype="multipart/form-data">
            <label for="service_name">Service Name:</label>
            <input type="text" id="service_name" name="service_name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="contact_detail">Contact Detail:</label>
            <input type="text" id="contact_detail" name="contact_detail" required>

            <label for="image_link">Image Link:</label>
            <input type="file" id="image_link" name="image_link" accept="image/*" required>

            <label for="duration">Duration:</label>
            <input type="text" id="duration" name="duration" required>

            <label for="service_status">Service Status (Available):</label>
            <input type="checkbox" id="service_status" name="service_status">

            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
                <option value="">Select a category</option>
                <?php while ($cat_row = $cat_result->fetch_assoc()): ?>
                    <option value="<?php echo $cat_row['service_cat_id']; ?>"><?php echo $cat_row['name']; ?></option>
                <?php endwhile; ?>
            </select>

            <input type="submit" value="List Service">
        </form>
    </div>
</body>

</html>