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
    <title>Admin Dashboard</title>
    
    <style>
        /* Basic styling for the dashboard */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Navbar styling */
        .navbar {
            display: flex;
            justify-content: space-between;
            background-color: #333;
            padding: 10px 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            text-align: center;
        }

        .navbar a:hover {
            background-color: #575757;
        }

        /* Dashboard content */
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        /* Tables styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .sellercontainer, .serviceprovidercontainer {
            width: 48%;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin: 10px;
        }
          /* Buttons */
        .block{
            background-color: red;
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .approve{
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

      
        button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .approve, button:hover {
            background-color: #45a049;
        }
        .block:hover{
            background-color: darkred;
        }

        @media screen and (max-width: 768px) {
    .container {
        flex-direction: column;
        align-items: center;
    }

    .sellercontainer, .serviceprovidercontainer {
        width: 100%;
        margin-bottom: 20px;
    }
  
    
}


    </style>
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
                <?php foreach($sellerList as $seller ): ?>
                <tr>
                    <td><?php echo $seller['store_name'] ?></td>
                    <td><?php echo $seller['seller_id'] ?></td>
                    <td>
                        <form action="changestatus.php" method="post">
                            <input type="hidden" name="seller_approve" value="<?php echo $seller['seller_id'] ?>">
                            <input type="submit" value="<?php echo ( $seller['approved']==1 ?  "Block" :  "Approve" )?>" class="<?php echo ( $seller['approved']==1 ?  "block" :  "approve" )?>">
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
                <?php foreach($serviceProviderList as $serviceProvider ): ?>
                <tr>
                    <td><?php echo $serviceProvider['service_name'] ?></td>
                    <td><?php echo $serviceProvider['service_provider_id'] ?></td>
                    <td>
                        <form action="changestatus.php" method="post">
                            <input type="hidden" name="service_approved" value="<?php echo $serviceProvider['service_provider_id']  ?>">
                            <input type="submit" value="<?php echo ( $serviceProvider['aproved']==1 ?  "Block" :  "Approve" )?>"  class="<?php echo ( $serviceProvider['aproved']==1 ?  "block" :  "approve" )?>">
                        </form>
                    </td>
                    <td><a href=""><button>View Detail</button></a></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>



<script>
       function addCategory() {
            const main_container = document.getElementById('main_container');
            const xhr = new XMLHttpRequest();
            let catogoryHTML = `<div class="cat-container"><h1>Product Catogory</h1><table>
                                <tr>
                                    <th>cat_id</th>
                                    <th>Name</th>
                                    
                                </tr>`;
        
            xhr.open('GET', 'getcatogory.php?type=product', true); 

            xhr.onload = function() {
                if (xhr.status === 200) {
                    
                    const data = JSON.parse(xhr.responseText);
                    
                
                    const productCategories = data.productCategories;
                    const serviceCategories = data.serviceCategories;

                
                    productCategories.forEach(function(cat) {
                            catogoryHTML += `
                                <tr>
                                    <td>${cat.product_cat_id}</td>
                                    <td>${cat.name}</td>
                                    
                                </tr>
                            `;
                        });

                    catogoryHTML += `</table>
                            <div>
                                <form action='addcatogory.php' method='POST'>
                                <input type='hidden' name='cat_type' value='product'>
                                <input type='text' name='cat_name' requered>
                                <input type='submit' value='Add Catogory' name='name'>
                                </form>
                            </div>
                    </div>`;
                    
                    catogoryHTML += `<div class="cat-container"><h1>service Catogory</h1> <table>
                                <tr>
                                    <th>cat_id</th>
                                    <th>Name</th>
                                    
                                </tr>`;
                    serviceCategories.forEach(function(cat) {
                        catogoryHTML += `
                            
                                <tr>
                                    <td>${cat.service_cat_id}</td>
                                    <td>${cat.name}</td>
                                    
                                </tr>
                                
                                
                            `;
                    });

                    catogoryHTML +=`</table>
                    <div>
                                <form action='addcatogory.php' method='POST'>
                                <input type='hidden' name='cat_type' value='service'>
                                <input type='text' name='cat_name' requered>
                                <input type='submit' value='Add Catogory' name='name'>
                                </form>
                            </div>
                    </div>`;
                    main_container.innerHTML = catogoryHTML;  
                }
            };

        
            xhr.send();
}





    </script>
</body>
</html>
