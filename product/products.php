<?php
session_start();
include '../connect.php';




function storeSearchQuary($input)
{

}
// Fetch all products with categories
$products_query = "
    SELECT p.product_id, p.seller_id, p.product_name, p.description, p.price, p.image_link, pc.name AS category_name, p.stock_quantity,pro.discount,pro.price_after_discount
    FROM products p
    JOIN product_catogory pc ON p.catogory_id = pc.product_cat_id
    LEFT JOIN promotions pro ON p.product_id = pro.product_id
";
$products_result = $con->query($products_query);

$product_list = array();
while ($row = mysqli_fetch_assoc($products_result)) {
    $product_list[] = $row;
}

// Fetch all product categories
$product_category_query = "SELECT product_cat_id, name FROM product_catogory";
$product_category_result = $con->query($product_category_query);
$product_category_list = array();
while ($row = mysqli_fetch_assoc($product_category_result)) {
    $product_category_list[] = $row;
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
    <title>Products</title>
    <link rel="stylesheet" href="../style/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                <?php foreach ($product_category_list as $category): ?>
                    <option value="<?php echo $category['product_cat_id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="search-container">
            <form action="javascript:void(0);" class="search">
                <input type="text" id="search" placeholder="Search products..." value="<?php echo $search_value; ?>" />
                <button id="search-btn" type="button" onclick="searchProducts()">Search</button>
            </form>
        </div>
        <div class="cart">
            <a href="../cart/cartlandingpage.php">
            <img src="../images/cart.png" alt="cart"></a>
        </div>
        <div id="search-results"></div>
    </div>



    <div class="product-section-container" id="product-section-container">
        <ul class="product-section-item-wrapper">
            <?php foreach ($product_list as $product): ?>
                <li class="product-item">
                    <div class="product-image">
                        <img src="../images/<?php echo $product['image_link']; ?>" alt="smart watch">
                    </div>
                    <div class="product-text">
                        <span class="product-title">
                            <?php echo $product['product_name']; ?>
                        </span>
                        <br>
                        <span style="color:red;">
                            <?php if ($product['stock_quantity'] == 0)
                                echo "This is out of stock"; ?>
                        </span>
                        <div class="product-purchase">
                            <?php if ($product['discount'] == null): ?>
                                <span class="product-price">
                                    <?php echo "$" . $product['price']; ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($product['discount'] != null): ?>
                                <span>Discount <?php echo $product['discount'] ?>%</span><br>
                                <span class="product-price">Price After Discount
                                    <?php echo "$" .$product['price_after_discount']?></span>
                            <?php endif; ?>

                            <a href="productveiwpage.php?product_id=<?php echo $product['product_id']; ?>">
                                <button class="blue-btn add-to-cart">View Product</button>
                            </a>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

  <script src="../script/productSearch.js"></script>
</body>

</html>