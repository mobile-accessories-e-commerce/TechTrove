<?php
include "../connect.php";

$quary = "SELECT * FROM sellers ";
$result = mysqli_query($con,$quary);
$sellerList = array();

if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
        array_push($sellerList,$row);
    }
}else{
    die("An erro occur when geting sellers information");
}

$quary = "SELECT * FROM service_providers ";
$result = mysqli_query($con,$quary);
$serviceProviderList = array();

if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
        array_push($serviceProviderList,$row);
    }
}else{
    die("An erro occur when geting service providers information");
}





?>










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
</head>
<body>
    <div class="sellercontainer">
        <h1>Sellers</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Id</th>
            <th>status</th>
            <th>Detail</th>
        </tr>
        <?php foreach($sellerList as $seller ): ?>
        <tr>

        <td><?php echo $seller['store_name'] ?></td>
        <td><?php echo $seller['seller_id'] ?></td>
        <td><form action="changestatus.php" method="post">
            <input type="hidden" name="seller_approve" value="<?php echo $seller['seller_id'] ?>">
            <input type="submit" value="<?php echo ( $seller['approved']==1 ?  "Block" :  "Approve" )?>">
        </form></td>
        <td><a href=""><button>view detail</button></a></td>

         </tr>
    
    <?php endforeach; ?>
    </table>

    </div>

    <div class="serviceprovidercontainer">
        <h1>Service providers</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Id</th>
            <th>status</th>
            <th>Detail</th>
        </tr>
        <?php foreach($serviceProviderList as $serviceProvider ): ?>
        <tr>

        <td><?php echo $serviceProvider['service_name'] ?></td>
        <td><?php echo $serviceProvider['service_provider_id'] ?></td>
        <td><form action="changestatus.php" method="post">
            <input type="hidden" name="service_approved" value="<?php echo $serviceProvider['service_provider_id']  ?>">
            <input type="submit" value="<?php echo ( $serviceProvider['aproved']==1 ?  "Block" :  "Approve" )?>">
        </form></td>
        <td><a href=""><button>view detail</button></a></td>

         </tr>
    
    <?php endforeach; ?>
    </table>

    </div>
</body>
</html>
