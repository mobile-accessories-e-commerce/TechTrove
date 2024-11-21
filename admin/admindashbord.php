<?php
include "../connect.php";
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../authentication/adminloging.php");
    exit();
}

// Fetch sellers
$querySellers = "SELECT * FROM sellers";
$resultSellers = mysqli_query($con, $querySellers);
$sellerList = [];
if ($resultSellers) {
    while ($row = mysqli_fetch_assoc($resultSellers)) {
        $sellerList[] = $row;
    }
} else {
    die("Error occurred while fetching sellers: " . mysqli_error($con));
}

// Fetch service providers
$queryProviders = "SELECT * FROM service_providers";
$resultProviders = mysqli_query($con, $queryProviders);
$serviceProviderList = [];
if ($resultProviders) {
    while ($row = mysqli_fetch_assoc($resultProviders)) {
        $serviceProviderList[] = $row;
    }
} else {
    die("Error occurred while fetching service providers: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style/admindashbord.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: white;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: #000;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="admindashbord.php">Dashboard</a>
        <a onclick="addCategory()">Add Category</a>
        <a onclick="getAllProduct()">All Products</a>
        <a onclick="getSearchKeyword()">Search Keyword</a>
        <a onclick="getFeatureProduct()">Approve Featured Products</a>
        <a onclick="givePromotion()">Promotion</a>
        <a href="reports.php">Reports</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container" id="main_container">
        <!-- Sellers Section -->
        <div class="sellercontainer">
            <h1>Sellers</h1>
            <table>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
                <?php foreach ($sellerList as $seller): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($seller['store_name']); ?></td>
                        <td><?php echo htmlspecialchars($seller['seller_id']); ?></td>
                        <td>
                            <form action="changestatus.php" method="post">
                                <input type="hidden" name="seller_approve" value="<?php echo htmlspecialchars($seller['seller_id']); ?>">
                                <input type="submit" value="<?php echo ($seller['approved'] == 1 ? "Block" : "Approve"); ?>" class="<?php echo ($seller['approved'] == 1 ? "block" : "approve"); ?>">
                            </form>
                        </td>
                        <td>
                            <button onclick="viewSellerDetail(<?php echo htmlspecialchars($seller['seller_id']); ?>)">View Detail</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- Service Providers Section -->
        <div class="serviceprovidercontainer">
            <h1>Service Providers</h1>
            <table>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
                <?php foreach ($serviceProviderList as $provider): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($provider['service_name']); ?></td>
                        <td><?php echo htmlspecialchars($provider['service_provider_id']); ?></td>
                        <td>
                            <form action="changestatus.php" method="post">
                                <input type="hidden" name="service_approved" value="<?php echo htmlspecialchars($provider['service_provider_id']); ?>">
                                <input type="submit" value="<?php echo ($provider['aproved'] == 1 ? "Block" : "Approve"); ?>" class="<?php echo ($provider['aproved'] == 1 ? "block" : "approve"); ?>">
                            </form>
                        </td>
                        <td>
                            <button onclick="viewServiceProviderDetail(<?php echo htmlspecialchars($provider['service_provider_id']); ?>)">View Detail</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <div id="sellerDetailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Seller Details</h2>
            <p><strong>Name:</strong> <span id="modalStoreName"></span></p>
            <p><strong>Email:</strong> <span id="modalEmail"></span></p>
            <p><strong>Phone:</strong> <span id="modalPhone"></span></p>
            <p><strong>Location:</strong> <span id="modalLocation"></span></p>
        </div>
    </div>

    <script src="../script/admindashbord.js"></script>
    <script>
        function viewSellerDetail(sellerId) {
            const modal = document.getElementById("sellerDetailModal");
            modal.style.display = "block";

            const xhr = new XMLHttpRequest();
            xhr.open("GET", `get_seller_details.php?seller_id=${sellerId}`, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    document.getElementById("modalStoreName").innerText = data.store_name || "N/A";
                    document.getElementById("modalEmail").innerText = data.email || "N/A";
                    document.getElementById("modalPhone").innerText = data.phone_number || "N/A";
                    document.getElementById("modalLocation").innerText = data.location || "N/A";
                } else {
                    alert("Failed to fetch seller details");
                }
            };
            xhr.send();
        }

        function closeModal() {
            document.getElementById("sellerDetailModal").style.display = "none";
        }
    </script>
</body>
</html>
