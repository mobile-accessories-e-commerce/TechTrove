<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
         /* nav bar style */
         .nav-bar {
           
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #fffff; /* Blue background */
    padding: 10px 20px;
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
border-width: 1.5px;
width: 500px; /* Search bar takes up 50% width */
height: 21px;
font-size: 15px;

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
transform: translate(3px, -13px); /* Move right by 50px and down by 20px */

}



#search-btn:hover {

background-color: gray; 
border: none;
cursor: pointer;
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
    </style>
</head>
<body>
<nav class="nav-bar">
        <div class="nav-bar-logo">
            <a href="../Home/dashbord.php">
                <img src="../images/elife_logo.png" width="140" height="70" alt="Logo">
            </a>
        </div>

        <div class="search-container">
            <form action="../product/products.php" method="post" class="search-form">
                <input type="text" id="search" name="search_value" placeholder="Search products...">
                <button id="search-btn" type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 37" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" ><g class="style-scope yt-icon"><path d="M20.87,20.17l-5.59-5.59C16.35,13.35,17,11.75,17,10c0-3.87-3.13-7-7-7s-7,3.13-7,7s3.13,7,7,7c1.75,0,3.35-0.65,4.58-1.71 l5.59,5.59L20.87,20.17z M10,16c-3.31,0-6-2.69-6-6s2.69-6,6-6s6,2.69,6,6S13.31,16,10,16z" class="style-scope yt-icon"></path></g></svg></button>
            </form>

            <div class="cart">
                <a href="../cart/cartlandingpage.php">
                <img src="../images/cart.png" alt="cart">
                </a>
            </div>
        </div>

        <div class="nav-bar-link">
            <select id="product-dropdown" onchange="navigateToPage()">
                <option value="">Account</option>
                <option value="../product/products.php">🛍️ Products</option>
                <option value="../service/services.php">🛠️ Services</option>
                <option value="../userorders/userorders.php">📦 Orders</option>
                <option value="../sellers/sellersignup.php">👩‍💼 Seller Signup</option>
                <option value="../serviceprovider/servicesignup.php">🤝 Service Provider Signup</option>
                <option value="../userprofile.php">👤 Profile</option>
                <option value="../authentication/logout.php">🚪 LogOut</option>
            </select>
        </div>
    </nav>
</body>

<script>
     function navigateToPage() {
        const dropdown = document.getElementById("product-dropdown");
        const selectedValue = dropdown.value;
        
        if (selectedValue) {
            window.location.href = selectedValue; 
        }
    }
</script>
</html>