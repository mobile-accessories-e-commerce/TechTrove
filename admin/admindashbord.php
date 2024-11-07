<?php
include "../connect.php";

$quary = "SELECT * FROM sellers ";
$result = mysqli_query($con, $quary);
$sellerList = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($sellerList, $row);
    }
} else {
    die("An erro occur when geting sellers information");
}

$quary = "SELECT * FROM service_providers ";
$result = mysqli_query($con, $quary);
$serviceProviderList = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($serviceProviderList, $row);
    }
} else {
    die("An erro occur when geting service providers information");
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

    <!--form html-->




    <!-- Navbar -->
    <div class="navbar">
        <a href="admindashbord.php">Dashboard</a>
        <a onclick="addCategory()">addcatogory</a>
        <a onclick="getAllProduct()">All Products</a>
        <a onclick="getSearchKeyword()">Search keyword</a>
        <a onclick="getFeatureProduct()">Approve Feature Product</a>
        <a onclick="givePromotion()">Promotion</a>
        <a href="#">Logout</a>
    </div>

    <!-- Dashboard content -->
    <div class="container" id="main_container">
        <!-- Sellers Section -->
        <div class="sellercontainer">
            <h1>Sellers</h1>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Id</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
                <?php foreach ($sellerList as $seller): ?>
                    <tr>
                        <td><?php echo $seller['store_name'] ?></td>
                        <td><?php echo $seller['seller_id'] ?></td>
                        <td>
                            <form action="changestatus.php" method="post">
                                <input type="hidden" name="seller_approve" value="<?php echo $seller['seller_id'] ?>">
                                <input type="submit" value="<?php echo ($seller['approved'] == 1 ? "Block" : "Approve") ?>"
                                    class="<?php echo ($seller['approved'] == 1 ? "block" : "approve") ?>">
                            </form>
                        </td>
                        <td><button onclick="viewSellerDetail(<?php echo $seller['seller_id']; ?>)">View Detail</button></td>

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
                    <th>Id</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
                <?php foreach ($serviceProviderList as $serviceProvider): ?>
                    <tr>
                        <td><?php echo $serviceProvider['service_name'] ?></td>
                        <td><?php echo $serviceProvider['service_provider_id'] ?></td>
                        <td>
                            <form action="changestatus.php" method="post">
                                <input type="hidden" name="service_approved"
                                    value="<?php echo $serviceProvider['service_provider_id'] ?>">
                                <input type="submit"
                                    value="<?php echo ($serviceProvider['aproved'] == 1 ? "Block" : "Approve") ?>"
                                    class="<?php echo ($serviceProvider['aproved'] == 1 ? "block" : "approve") ?>">
                            </form>
                        </td>
                        <td><a href=""><button>View Detail</button></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <!-- Seller Detail Modal -->
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
// Function to open the modal and make the XHR request
function viewSellerDetail(sellerId) {
    // Show modal
    document.getElementById("sellerDetailModal").style.display = "block";

    // Create new XHR request
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `get_seller_details.php?seller_id=${sellerId}`, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) { // Request is complete
            if (xhr.status === 200) { // Status OK
                const data = JSON.parse(xhr.responseText);

                if (!data.error) {
                    // Populate modal fields with the retrieved data
                    document.getElementById("modalStoreName").innerText = data.store_name;
                    document.getElementById("modalEmail").innerText = data.email;
                    document.getElementById("modalPhone").innerText = data.phone_number;
                    document.getElementById("modalLocation").innerText = data.location;
                } else {
                    alert("Error: " + data.error);
                }
            } else {
                alert("Error fetching data. Status: " + xhr.status);
            }
        }
    };

    // Send the request
    xhr.send();
}

// Event listener for "View Detail" buttons
document.addEventListener("DOMContentLoaded", function() {
    const viewDetailButtons = document.querySelectorAll(".view-detail-btn");
    viewDetailButtons.forEach(button => {
        button.addEventListener("click", function() {
            const sellerId = this.getAttribute("data-seller-id");
            viewSellerDetail(sellerId);
        });
    });

    // Close modal functionality
    document.querySelector(".close").addEventListener("click", function() {
        document.getElementById("sellerDetailModal").style.display = "none";
    });
});
</script>

</body>

</html>