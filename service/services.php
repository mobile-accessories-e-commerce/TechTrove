<?php
session_start();
include '../connect.php';


$services_query = "
    SELECT s.service_id,s.service_name, s.description, s.price, s.image_link, sc.name AS category_name
    FROM services s
    JOIN service_catogory sc ON s.catogory_id = sc.service_cat_id
";


$services_result = $con->query($services_query);

$service_list = array();
while ($row = mysqli_fetch_assoc($services_result)) {
    array_push($service_list, $row);
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
                <option value="none">All Categories</option>
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
                <li class="product-item">
                    <div class="product-image">
                        <img src="../images/<?php echo $service['image_link'] ?>" alt="smart watch">

                    </div>
                    <div class="product-text">
                        <span class="product-title">
                            <?php echo $service['service_name'] ?>
                        </span>
                        <div class="product-purchace">
                            <span class="product-price">
                                <?php echo "$" . $service['price'] ?>
                            </span>
                            <!-- Todo need to implement serviceview page -->
                            <a href="serviceviewpage.php?service_id='<?php echo $service['service_id']; ?>'"><button
                                    class="blue-btn add-to-cart">
                                    Veiw service
                                </button></a>

                        </div>

                    </div>

                </li>

            <?php endforeach; ?>
        </ul>
    </div>

<script src="../script/serviceSearch.js">
        

</script>



</body>

</html>