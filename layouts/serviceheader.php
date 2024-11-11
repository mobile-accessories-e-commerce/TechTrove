<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <link rel="stylesheet" href="../style/header.css">
</head>
<body>
    
<nav class="nav-bar">
        <div class="nav-bar-logo">
            <a href="../Home/dashbord.php">
                <img src="../images/elife_logo.png" width="140" height="70" alt="Logo">
            </a>
        </div>

        <div class="search-container">
            <form action="../service/services.php" method="POST" class="search-form">
                <input type="text" id="search" name="search_value" placeholder="Search services...">
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

</body>
</html>




