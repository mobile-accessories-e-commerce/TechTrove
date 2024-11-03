<?php
include "../connect.php";
include "../layouts/serviceheader.php";
session_start();

if (!isset($_SESSION['userid'])) {
    header("location:../authentication/loging.php");
    exit;
}

$user_id = $_SESSION['userid'];

// Query to join the tables and retrieve the required fields
$sql = "SELECT sr.id, s.image_link, s.service_name, s.description AS service_description, s.location AS service_location, sr.accept 
        FROM service_requests sr 
        JOIN services s ON sr.service_id = s.service_id 
        WHERE sr.user_id = $user_id";
$result = mysqli_query($con, $sql);

$request_list = array();
while ($row = mysqli_fetch_assoc($result)) {
    $request_list[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Request</title>
    <style>
        body{
            background-color: #f0f0f0;
        }
        .main-container {
            margin-top: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .table-container {
            width: 80%;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: gray;
            color: white;
        }
        td{
            background-color: white;
        }
        td img {
            width: 100px;
            height: auto;
            border-radius: 8px;
        }
        td.status {
           
            font-weight: bold;
            text-align: center;
        }
        .not-confirmed {
            color: red;
            
        }
        .confirmed {
            color: blue;
            
        }
        .delete-btn {
            padding: 15px 15px;
            color: blue;
            background-color: transparent;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color:#fff8f8;;
        
        }

        /* Popup Message Styles */
        .popup-container, .confirm-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            display: none;
            z-index: 1000;
        }
        .popup-container.show {
            display: block;
        }
        /* Confirmation Popup Styles */
        .confirm-popup {
            top: 30%;
            left: 50%;
            transform: translate(-50%, -30%);
            width: 300px;
            background-color: white;
            color: black;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        .confirm-popup .popup-message {
            margin-bottom: 20px;
        }
        .confirm-popup button {
            padding: 8px 16px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .confirm-popup .confirm-btn {
            background-color: #4CAF50;
            color: white;
        }
        .confirm-popup .cancel-btn {
            background-color: #f44336;
            color: white;
        }
    </style>
    <script>
        let deleteRequestId = null;

        function showConfirmPopup(requestId) {
            deleteRequestId = requestId;
            document.getElementById("confirm-popup").style.display = "block";
        }

        function hideConfirmPopup() {
            document.getElementById("confirm-popup").style.display = "none";
            deleteRequestId = null;
        }

        function confirmDelete() {
            if (deleteRequestId !== null) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_request.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            document.getElementById("request-row-" + deleteRequestId).remove();
                            showPopup("Request deleted successfully.");
                        } else {
                            showPopup("Failed to delete request.");
                        }
                        hideConfirmPopup();
                    }
                };
                xhr.send("request_id=" + deleteRequestId);
            }
        }

        function showPopup(message) {
            var popup = document.getElementById("popup");
            popup.textContent = message;
            popup.classList.add("show");
            setTimeout(function () {
                popup.classList.remove("show");
            }, 3000);
        }
    </script>
</head>
<body>
<div class="main-container">
    <?php if (count($request_list) > 0): ?>
        <h1>Your Service Requests</h1>
        <div class="table-container">
            <table>
                <tr>
                    <th>Image</th>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($request_list as $request): ?>
                    <tr id="request-row-<?php echo $request['id']; ?>">
                        <td><img src="../images/<?php echo htmlspecialchars($request['image_link']); ?>" alt="Service Image"></td>
                        <td><?php echo htmlspecialchars($request['service_name']); ?></td>
                        <td><?php echo htmlspecialchars($request['service_description']); ?></td>
                        <td><?php echo htmlspecialchars($request['service_location']); ?></td>
                        <td class="status <?php echo $request['accept'] == 0 ? 'not-confirmed' : 'confirmed'; ?>">
                            <?php if ($request['accept'] == 0): ?>
                                Not Confirmed
                            <?php else: ?>
                                <button class="delete-btn" onclick="showConfirmPopup(<?php echo $request['id']; ?>)">
                                    This request is confirmed<br>Delete this request
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php else: ?>
        <h1>You do not have any requests</h1>
    <?php endif; ?>
</div>

<!-- Popup Message Container -->
<div id="popup" class="popup-container"></div>

<!-- Confirmation Popup -->
<div id="confirm-popup" class="confirm-popup">
    <div class="popup-message">Are you sure you want to delete this request?</div>
    <button class="confirm-btn" onclick="confirmDelete()">Confirm</button>
    <button class="cancel-btn" onclick="hideConfirmPopup()">Cancel</button>
</div>

</body>
</html>
