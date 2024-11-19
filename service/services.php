<?php
session_start();
include '../connect.php';
include '../pagination.php';

function getTotalService(){
    include '../connect.php';
    $sql = "SELECT COUNT(*) AS count FROM services";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    return $count;
 }

 function getServices($offset,$itemsPerPage){
    include "../connect.php";

        $services_query = "
            SELECT s.service_id,s.service_name, s.description, s.price, s.image_link, sc.name AS category_name
            FROM services s
            JOIN service_catogory sc ON s.catogory_id = sc.service_cat_id
            LIMIT $itemsPerPage OFFSET $offset
        ";


        $services_result = $con->query($services_query);

        $service_list = array();
        while ($row = mysqli_fetch_assoc($services_result)) {
            array_push($service_list, $row);
        }

        return $service_list;


 }
$service_category_query = "SELECT service_cat_id, name FROM service_catogory";
$service_category_result = $con->query($service_category_query);
$service_category_list = array();
while ($row = mysqli_fetch_assoc($service_category_result)) {
    $service_category_list[] = $row;
}


$search_value = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['search_value'])) {
        $search_value = $_POST['search_value'];
    }
}

$cat_id = "none";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
    if (isset($_GET['cat_id'])) {
        $cat_id = $_GET['cat_id'];
       
    }
}

$totalProducts = getTotalService(); 
$itemsPerPage = 12; 
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;
$service_list = getServices($offset, $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>
    <link rel="stylesheet" href="../style/services.css">
</head>

<body>
<div class="header">
        <div class="nav-bar-logo">
            <a href="../Home/dashbord.php">
            <img src="../images/elife_logo.png" width="140" height="70">
            </a>
        </div>
        <div class="category">
            <select name="category" id="category" onchange="categorySearch()">
                <option value="<?php echo $cart_id; ?>">All Categories</option>
                <?php foreach ($service_category_list as $category): ?>
                    <option value="<?php echo $category['service_cat_id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="search-container">
            <form action="javascript:void(0);" class="search">
                <input type="text" id="search" placeholder="Search service..." value="<?php echo $search_value?>" />
                <button id="search-btn" type="button" onclick="searchServices()">Search</button>
            </form>
        </div>
        
    </div>


    <div class="product-section-container" id="product-section-container">

        <ul class="product-section-item-wrapper">
            <?php foreach ($service_list as $service): ?>
                <a class="service-link" href="serviceviewpage.php?service_id='<?php echo $service['service_id']; ?>'"><li class="product-item">
                    <div class="product-image">
                        <img src="../images/<?php echo $service['image_link'] ?>" alt="smart watch">

                    </div>
                    <div class="product-text">
                        <div class="service-name">
                            <span class="product-title">
                                <?php echo $service['service_name'] ?>
                            </span>
                        </div>
                        
                        <div class="product-purchace">
                            <span class="product-price">
                                <?php echo "$" . $service['price'] ?>
                            </span>
                            <!-- Todo need to implement serviceview page -->
                            

                        </div>

                    </div>

                </li></a>

            <?php endforeach; ?>
        </ul>
    </div>
    <?php echo paginate($totalProducts, $itemsPerPage, $currentPage, 'services.php'); ?>


<script src="../script/serviceSearch.js">
        

</script>



</body>

</html>