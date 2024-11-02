<?php
session_start();
include '../connect.php';

if (!isset($_SESSION["username"])) {
    header("location:../authentication/loging.php");
}

// include '../layouts/header.php';


$product_category_query = "SELECT product_cat_id, name FROM product_catogory";
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



        /* nav bar style */
        .nav-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #fffff; /* Blue background */
    padding: 2px 40px;
}

.nav-bar-logo img {
    flex:2;
    display: block;
}

.search-container {

    display: flex;
    align-items: center;
    gap: 20px;
}

.search-form {
   position: relative;
    display: flex;
    align-items: center;
    
}

.search-form input[type="text"] {
    
    padding: 10px;
    border-radius: 4px;
    box-shadow: 5px 6px 6px rgba(0,0,0,0.1);
    border-style: solid;
    border-color: gray;
    border-width: 1px;
    width: 500px;
       
    
}
#search-btn{
    position: absolute;
    right: 0;
    width: 41px;
    height: 42px;
    
    
    
}
#search-btn svg{
    position: absolute;
    right: 0;
    width: 41px;
    height: 42px;
    margin-top: 0;
    cursor: pointer;
    transform: translate(3px, -13px); /* Move right by 50px and down by 20px */
    
}



#search-btn:hover {
    
    background-color: gray; 
    border: none;
}
.account-icon{
    margin-right: 60px;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.account-icon p{
    font-size: 14px;
}






.nav-bar-link select {
    cursor: pointer;
    flex: 3;
    padding: 10px;
    border-radius: 4px;
    border: none;
    outline: none;
    font-size: 1em;
    background-color:  white; /* White background for dropdown */
    color: #333; /* Dark text color */
}



/* Style for option elements with icons */
.nav-bar-link select option {
    padding: 10px;
}


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
                <img src="../images/elife_logo.png" width="140" height="70" alt="Logo">
            </a>
        </div>

        <div class="search-container">
            <form action="../product/products.php" method="post" class="search-form">
                <input type="text" id="search" name="search_value" placeholder="Search products...">
                <button id="search-btn" type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 37" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" ><g class="style-scope yt-icon"><path d="M20.87,20.17l-5.59-5.59C16.35,13.35,17,11.75,17,10c0-3.87-3.13-7-7-7s-7,3.13-7,7s3.13,7,7,7c1.75,0,3.35-0.65,4.58-1.71 l5.59,5.59L20.87,20.17z M10,16c-3.31,0-6-2.69-6-6s2.69-6,6-6s6,2.69,6,6S13.31,16,10,16z" class="style-scope yt-icon"></path></g></svg>
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

        <div class="account-icon">
            
            <img src="../images/user.png" alt="Account" width="40" height="40">
            <p>Account</p>
        </div>
            <!-- <select id="product-dropdown" onchange="navigateToPage()">
                <option value="">Account</option>
                <option value="../product/products.php">🛍️ Products</option>
                <option value="../service/services.php">🛠️ Services</option>
                <option value="../userorders/userorders.php">📦 Orders</option>
                <option value="../sellers/sellersignup.php">👩‍💼 Seller Signup</option>
                <option value="../serviceprovider/servicesignup.php">🤝 Service Provider Signup</option>
                <option value="../userprofile.php">👤 Profile</option>
                <option value="../authentication/logout.php">🚪 LogOut</option>
            </select> -->
        </div>
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
                        <a href="../product/catogoryproduct.php?cat_id=<?php echo $catogory['product_cat_id']; ?>">
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

    <!--Best Sellers -product seection-->
    <div class="product-section-container scroll-animate">
        <h1>Best Selling Product</h1>
        <span class="product-section-description">
            ctus et netus et malesuada fames aVestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet,
            ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend
            leo.
        </span>



        <div class="product-slider">
            <div class="slider-controls">
                <button class="slide-btn" id="prevBtn">&#8249;</button>
                <button class="slide-btn" id="nextBtn">&#8250;</button>
            </div>
            <ul class="product-section-item-wrapper">

                <?php foreach ($product_list as $product): ?>
                    <li class="product-item">
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
                                    <span>Discount <?php echo $product['discount'] ?>%</span><br>
                                    <span class="product-price">Price After Discount
                                        <?php echo "$" . ($product['price'] - (($product['price'] / 100) * $product['discount'])) ?></span>
                                <?php endif; ?>
                                <a href="../product/productveiwpage.php?product_id=<?php echo $product['product_id']; ?>">
                                    <button class="blue-btn add-to-cart">View Product</button>
                                </a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!--IPAD PROMO-->

    <div class="promo-container scroll-animate">
        <div class="promo-box">
            <div class="promo-image">
                <img src="../images/07.png" alt="i pad">
            </div>
            <div class="promo-content">
                <h1>New Arrivals</h1>
                <h2>Sunshine Ipad</h2>
                <p>
                    Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat
                    eleifend leo
                </p>

                <button class="white-button">
                    SHOP NOW
                </button>
            </div>
        </div>
    </div>


    <!--Footer-->

    <footer class="scroll-animate">
        <div class="footer-top">
            <img src="../images/elife_logo.png" width="220px" height="110px">

            <div class="footer-socials-wrapper">
                <div class="footer-social">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-telephone" viewBox="0 0 16 16">
                        <path
                            d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                    </svg>
                    <span>077 8996508</span>
                </div>
                <div class="footer-social">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-telegram" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09" />
                    </svg>
                    <span>Telegram</span>
                </div>

                <div class="footer-social">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-twitter" viewBox="0 0 16 16">
                        <path
                            d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518 3.3 3.3 0 0 0 1.447-1.817 6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429 3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218 3.2 3.2 0 0 1-.865.115 3 3 0 0 1-.614-.057 3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15" />
                    </svg>
                    <span>Twitter</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    <a href="#">Products</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
            </ul>

            <p>
                Coppyright &#xA9; 2024 eLife. All Right Receved
            </p>
        </div>
    </footer>


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
           <a href="../product/productveiwpage.php?product_id=${product.product_id}"> <button class="blue-btn">
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