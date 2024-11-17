<?php
session_start();
include '../connect.php';



// include '../layouts/header.php';



$new_arrival_quary ="SELECT * FROM products 
                    ORDER BY product_id DESC 
                    LIMIT 1;";
$result = mysqli_query($con,$new_arrival_quary);

$new_arrival_product = mysqli_fetch_assoc($result);


$product_category_query = "SELECT product_cat_id, name FROM product_catogory LIMIT 5";
$product_category_result = $con->query($product_category_query);
$product_category_list = array();
while ($row = mysqli_fetch_assoc($product_category_result)) {
    array_push($product_category_list, $row);
}


$service_category_query = "SELECT service_cat_id, name FROM service_catogory";
$service_category_result = $con->query($service_category_query);
$service_category_list = array();
while ($row = mysqli_fetch_assoc($service_category_result)) {
    array_push($service_category_list, $row);
}



$products_query = "
    SELECT p.product_id, p.seller_id, p.product_name, p.description, p.price, p.image_link, pc.name AS category_name ,pro.discount
    FROM products p
    JOIN product_catogory pc ON p.catogory_id = pc.product_cat_id
    LEFT JOIN promotions pro ON p.product_id = pro.product_id 
    LIMIT 10
";

$services_query = "
    SELECT s.service_name, s.description, s.price, s.image_link, sc.name AS category_name
    FROM services s
    JOIN service_catogory sc ON s.catogory_id = sc.service_cat_id
";

$products_result = $con->query($products_query);
$services_result = $con->query($services_query);

$product_list = array();
while ($row = mysqli_fetch_assoc($products_result)) {
    array_push($product_list, $row);
}



$query = "SELECT product_id,title, description, image_link FROM featured_products WHERE approved = 1";
$hero_result = mysqli_query($con, $query);
$hero_products = array();
while ($row = mysqli_fetch_assoc($hero_result)) {
    array_push($hero_products, $row);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    <link rel="stylesheet" href="../style/dashbord.css">

    <style>
        .product-section-container {
            max-width: 980px;
            margin: auto;
            text-align: center;
        }

        .product-slider {
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        .product-section-item-wrapper {
            display: flex;
            transition: transform 0.5s ease;
            width: 100%;
        }

        .product-item {
            flex: 1 0 33.333%;
            box-sizing: border-box;
            padding: 10px;
        }

        .slider-controls {
            margin: 10px 0;
        }
















        
    </style>

</head>

<body>

    <nav class="nav-bar">
        <div class="nav-bar-logo">
            <a href="#">
                <img src="../images/elife_logo.png" width="120" height="64" alt="Logo">
            </a>
        </div>

        <div class="search-container">
            <form action="../product/products.php" method="post" class="search-form">
                <input type="text" id="search" name="search_value" placeholder="Search products...">
                <button id="search-btn" type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 37"
                        preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon">
                        <g class="style-scope yt-icon">
                            <path
                                d="M20.87,20.17l-5.59-5.59C16.35,13.35,17,11.75,17,10c0-3.87-3.13-7-7-7s-7,3.13-7,7s3.13,7,7,7c1.75,0,3.35-0.65,4.58-1.71 l5.59,5.59L20.87,20.17z M10,16c-3.31,0-6-2.69-6-6s2.69-6,6-6s6,2.69,6,6S13.31,16,10,16z"
                                class="style-scope yt-icon"></path>
                        </g>
                    </svg>
                </button>
            </form>

            <div class="cart">
                <a href="../cart/cartlandingpage.php">
                    <img src="../images/cart.png" alt="cart">
                </a>
            </div>



        </div>
        </div>

        <div class="nav-bar-link">
            <ul>
            <li ><a class="nav-sp-link" href="../product/products.php">Products</a></li>
            <li ><a class="nav-sp-link" href="../service/services.php">Services</a></li>
                <li>
        <div class="account-container">
        <div class="account-icon">
            
            <img src="../images/user.png" alt="Account" width="40" height="40">
            <p class="nav-sp-link" >Account</p>
         </div>
        <div class="dropdown-menu">
            <a href="../userprofile.php"><img src="../images/user2.png" width="20" height="20" alt="">My Profile</a>
            <a href="../userorders/userorders.php"><img src="../images/shopping-bag.png" width="20" height="20" alt="">My Orders</a>
            <a href="../userservicerequest/userservicerequest.php"><img src="../images/interview.png" width="20" height="20" alt="">My Request</a>
            <a href="../sellers/sellersignup.php"><img src="../images/business-man.png" width="20" height="20" alt="">Seller</a>
            <a href="../serviceprovider/servicesignup.php"><img src="../images/employee.png" width="20" height="20" alt="">Service Provider</a>
            <a href="../authentication/logout.php"><img src="../images/logout.png" width="20" height="20" alt="">Log Out</a>
            
        </div>
        </div>
        </li>
               
        </ul>

          
    </nav>

    <!-- Top-->
    <div class="home-top-container">

        <div class="home-top-wrapper" id="home-top-wrapper">

        </div>

    </div>



    <!---our collection/type of product selling-->
    <div class="collection-header">
        <h1>Our Collection</h1>
    </div>

    <div class="collection-container scroll-animate">


        <div class="catogory">
            <p onclick="loadProductCatogory()" class="cat-btn">Product</p>
            <p onclick="loadServiceCatogory()" class="cat-btn">Service</p>
        </div>

        <div class="collection-item-wrapper" id="collection-item-wrapper">
            <?php foreach ($product_category_list as $catogory): ?>
                <div class="collection-item">
                    <div class="collection-icon">
                        <a href="../product/products.php?cat_id=<?php echo  $catogory['product_cat_id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                                class="bi bi-tablet-landscape" viewBox="0 0 16 16">
                                <path
                                    d="M1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm-1 8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2z" />
                                <path d="M14 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0" />
                            </svg></a>
                    </div>
                    <span class="collection-name"><?php echo $catogory['name'] ?></span>
                </div>
            <?php endforeach; ?>
        </div>

    </div>


    <div class="marquee-container">
  <span class="marquee-text">&#9734;&nbsp;&#9734;&nbsp;We Ship Your Items In 2 to 4 days with 100% free Shipping  &nbsp;&#9734;&nbsp;&#9734;</span>
</div>

    <!--Best Sellers -product seection-->
    <div class="product-section-container scroll-animate">
        <h1>Best Selling Product</h1>
        <span class="product-section-description">
        Discover our top-selling products, loved for quality and style. From must-have gadgets to timeless accessories, each item is chosen for its popularity and customer satisfaction. Find out what makes these favorites stand out!        </span>



        <div class="product-slider">
            <div class="slider-controls">
                <button class="slide-btn" id="prevBtn">&#8249;</button>
                <button class="slide-btn" id="nextBtn">&#8250;</button>
            </div>
            <ul class="product-section-item-wrapper">

                <?php foreach ($product_list as $product): ?>
                    <li class="product-item"><a class="product-link" href="../product/productveiwpage.php?product_id=<?php echo $product['product_id']; ?>&back_link=../Home/dashbord.php">
                        <div class="product-image">
                            <img src="../images/<?php echo $product['image_link'] ?>" alt="smart watch">
                        </div>
                        <div class="product-text">
                            <span class="product-title">
                                <?php echo $product['product_name'] ?>
                            </span>
                            <div class="product-purchase">
                                <?php if ($product['discount'] == null): ?>
                                    <span class="product-price">
                                        <?php echo "$" . $product['price']; ?>
                                    </span>
                                <?php endif; ?>
                                <?php if ($product['discount'] != null): ?>
                                    <div class="price">
                                    <span class="product-price">
                                    <?php echo "$" .$product['price']-$product['price']*$product['discount']/100?></span>
                                    <div class="dis">
                                    <del class="old-price"><?php echo "$" .$product['price'];?></del>
                                    <span class="discount">-<?php echo $product['discount'] ?>%</span>
                                    </div>
                                    </div>
                                <?php endif; ?>
                               
                            </div>
                        </div>
                        </a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!--IPAD PROMO-->

    <div class="promo-container scroll-animate">
    <div class="promo-box">
        <!-- Left side with image -->
        <div class="promo-image">
            <img src="../images/<?php echo $new_arrival_product['image_link']; ?>" alt="Product Image">
        </div>
        
        <!-- Right side with content -->
        <div class="promo-content">
            <h1>New Arrivals</h1>
            <h2><?php echo $new_arrival_product['product_name']; ?></h2>
            <p><?php echo $new_arrival_product['description']; ?></p>
            <a href="../product/productveiwpage.php?product_id=<?php echo $new_arrival_product['product_id']; ?>&back_link=../Home/dashbord.php">
                <button class="white-button">SHOP NOW</button>
            </a>
        </div>
    </div>
</div>



    <!--Footer-->

 <?php include "../layouts/footer.php" ?>


    <script>

        // document.addEventListener('scroll',()=>{
        //     let navBar = document.querySelector('nav');
        //     if(window.scrollY > 0){
        //         navBar.style.background = 'white';
        //         navbar.style.boxShadow = '0 5px 20px rgba (190,190,190,0.15)';
        //     }

        //     else{
        //         navBar.style.background = 'white';
        //         navBar.style.boxShadow = 'none'
        //     }
        // });

        const heroProducts = <?php echo json_encode($hero_products); ?>;
        const slider = document.getElementById("home-top-wrapper");
        const productsData = heroProducts;
        let currentIndex = 0;

        // Function to render a product slide
        function renderSlide(index) {

            const product = productsData[index];
            console.log(product.title);
            slider.innerHTML = `
        
        <div class="home-top-text">
            <h1>
                    ${product.title}
            </h1>
            <p>
                    ${product.description}
            </p>
           <a href="../product/productveiwpage.php?product_id=${product.product_id}&back_link=../Home/dashbord.php"> <button class="blue-btn">
                See Product
            </button>
        </div>

        <div class="home-top-image">
            <img src="../images/${product.image_link}" alt="large head phone">
        </div>
    
    `;
        }


        function changeSlide(direction) {
            currentIndex = (currentIndex + direction + productsData.length) % productsData.length;
            renderSlide(currentIndex);
        }





        setInterval(() => changeSlide(1), 5000);

        renderSlide(currentIndex);



        function loadServiceCatogory() {
            const item_wraper = document.getElementById("collection-item-wrapper")
            item_wraper.innerHTML = `
     <?php foreach ($service_category_list as $catogory): ?>
                    <div class="collection-item">
                        <div class="collection-icon">
                            <a href="../product/catogoryproduct.php?cat_id=<?php echo $catogory['service_cat_id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-tablet-landscape" viewBox="0 0 16 16">
                <path d="M1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm-1 8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2z"/>
                <path d="M14 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0"/>
                </svg></a>
                        </div>
                        <span class="collection-name"><?php echo $catogory['name'] ?></span>
                    </div>
    <?php endforeach; ?>`

        }


        function loadProductCatogory() {
            const item_wraper = document.getElementById("collection-item-wrapper")
            item_wraper.innerHTML = `
    <?php foreach ($product_category_list as $catogory): ?>
                    <div class="collection-item">
                        <div class="collection-icon">
                            <a href="../product/catogoryproduct.php?cat_id=<?php echo $catogory['product_cat_id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-tablet-landscape" viewBox="0 0 16 16">
                <path d="M1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm-1 8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2z"/>
                <path d="M14 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0"/>
                </svg></a>
                        </div>
                        <span class="collection-name"><?php echo $catogory['name'] ?></span>
                    </div>
    <?php endforeach; ?>
    `
        }





        //product section
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const productSlider = document.querySelector('.product-section-item-wrapper');
        const totalItems = document.querySelectorAll('.product-item').length;
        const itemsPerSlide = 3;
        let currentPosition = 0;

        function updateSliderPosition() {
            const offset = currentPosition * -100;
            productSlider.style.transform = `translateX(${offset}%)`;
        }

        prevBtn.addEventListener('click', () => {
            if (currentPosition > 0) {
                currentPosition--;
                updateSliderPosition();
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentPosition < Math.ceil(totalItems / itemsPerSlide) - 1) {
                currentPosition++;
                updateSliderPosition();
            }
        });


        function navigateToPage() {
            const dropdown = document.getElementById("product-dropdown");
            const selectedValue = dropdown.value;

            if (selectedValue) {
                window.location.href = selectedValue;
            }
        }



        document.addEventListener("DOMContentLoaded", function () {
            const observerOptions = {
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('scroll-active');
                        observer.unobserve(entry.target);  // Stop observing once the animation is triggered
                    }
                });
            }, observerOptions);

            // Select all sections to animate on scroll
            document.querySelectorAll('.scroll-animate').forEach(section => {
                observer.observe(section);
            });
        });


        document.addEventListener("DOMContentLoaded", function () {
            const collectionContainer = document.querySelector('.collection-container');
            const backgroundImages = [
                '../images/cat-slider1.jpg',
                '../images/cat-slider2.jpg',
                '../images/cat-slider3.jpg',
                '../images/cat-slider4.jpg'
            ];
            let currentImageIndex = 0;

            // Function to update background image
            function updateBackgroundImage() {
                collectionContainer.style.backgroundImage = `url(${backgroundImages[currentImageIndex]})`;
                currentImageIndex = (currentImageIndex + 1) % backgroundImages.length;
            }

            // Initial background setup
            updateBackgroundImage();

            // Set interval to change background image every 5 seconds
            setInterval(updateBackgroundImage, 5000);  // Adjust as needed
        });

    </script>
</body>

</html>