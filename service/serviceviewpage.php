<?php
include "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $service_id = $_GET['service_id'];

    $getviewquery = "SELECT view_count FROM services WHERE service_id = $service_id ";
    $result = mysqli_query($con, $getviewquery);
    $row = mysqli_fetch_assoc($result);
    $current_view = $row['view_count'];
    $new_view = $current_view + 1;

    $updateviewquery = "UPDATE services SET view_count = '$new_view' WHERE service_id=$service_id";
    $result = mysqli_query($con, $updateviewquery);

    if (!$result) {
        header("location:../Home/dashbord.php");
    }
    $query = "SELECT * FROM services WHERE service_id=$service_id";
    $result = mysqli_query($con, $query);

    $service = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="../style/productveiwpage.css">
    <style>
        /* Popup form styling */
        .form-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: 80%;
            max-width: 400px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin-top: 10px;
        }

        .form-container input[type="text"],
        .form-container input[type="tel"],
        .form-container input[type="text-area"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .form-container input[type="submit"] {
            margin-top: 15px;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            background: none;
            border: none;
            color: #888;
        }

        /* Background overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>

<body>
    <div><a href="services.php"><button class="back">back</button></a></div>

    <div class="main-container">
        <div class="container">
            <div class="image">
                <img src="../images/<?php echo $service['image_link']; ?>" alt="Product Image">
            </div>

            <div class="details">
                <div class="title"><?php echo $service['service_name']; ?></div>
                <div class="description"><?php echo $service['description']; ?></div>
                <div class="price">$<?php echo $service['price']; ?></div>
                <div class="location"><?php echo $service['location']; ?></div>
                <div class="contact_details"><?php echo $service['contact_detail']; ?></div>

                <button class="add-to-cart" onclick="showForm()">Contact Provider</button>
            </div>
        </div>

        <!-- Background overlay for form popup -->
        <div class="overlay" id="overlay" onclick="hideForm()"></div>

        <!-- Contact form popup -->
        <div class="form-container" id="formContainer">
            <button class="close-btn" onclick="hideForm()">×</button>
            <form action="storeservicerequest.php" method="post">
                <input type="hidden" name="service_id" value="<?php echo $service['service_id'] ?>">
                <label for="name">Your Name</label>
                <input type="text" name="name" id="name">
                <label for="contact-nummber">WhatsApp Number</label>
                <input type="tel" name="contact_number" id="contact-nummber">
                <label for="location">Location</label>
                <input type="text" name="location" id="location">
                <label for="description">Tell about what you want to do</label>
                <textarea name="description" id="description" rows="3"></textarea>
                <input type="submit" value="Send Request">
            </form>
        </div>
    </div>

    <script>
        function showForm() {
            document.getElementById("formContainer").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }

        function hideForm() {
            document.getElementById("formContainer").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }
    </script>
</body>

</html>
