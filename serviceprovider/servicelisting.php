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
    $image_link = trim($_POST['image_link']);
    $duration = trim($_POST['duration']);
    $service_status = isset($_POST['service_status']) ? 1 : 0;
    $category_id = intval($_POST['category_id']);


    if (empty($service_name) || empty($description) || $price <= 0 || empty($location) || empty($contact_detail)) {
        $error = "Please fill out all required fields correctly.";
    } else {
        // Insert into service listings table
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
        body {
            background-color: #ffeefe;
        }

        .container {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
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

        input[type=submit] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
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
        <h2>Service Listing</h2>


        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>


        <form action="servicelisting.php" method="POST">
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
            <input type="file" id="image_link" name="image_link" required>

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