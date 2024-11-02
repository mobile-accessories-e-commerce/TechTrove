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
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="admindashbord.php">Dashboard</a>
        <button onclick="addCategory()">addcatogory</button>
        <a href="#">All Products</a>
        <a href="#">Reports</a>
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
                        <td><a href=""><button>View Detail</button></a></td>
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


    <script src="../script/admindashbord.js"></script>
</body>

</html>