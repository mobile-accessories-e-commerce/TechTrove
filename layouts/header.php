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
    display: flex;
    align-items: center;
    gap: 5px;
}

.search-form input[type="text"] {
    padding: 10px;
    border: solid;
    border-color: black;
    border-radius: 4px;
    outline: black;
    width: 500px; /* Search bar takes up 50% width */
}

.search-form button {
    background-color: #0056b3; /* Darker blue for button */
    border: none;
    padding: 10px;
    cursor: pointer;
    border-radius: 4px;
    color: white;
}

.search-form button:hover {
    background-color: #004494; /* Even darker blue on hover */
}

.cart {
    position: relative;
}

.cart a {
    font-size: 1.5em;
    color: white;
    text-decoration: none;
}

.cart-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: red;
    color: white;
    font-size: 0.8em;
    padding: 2px 6px;
    border-radius: 50%;
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
                <button id="search-btn" type="submit">🔍</button>
            </form>

            <div class="cart">
                <a href="../cart/cartlandingpage.php">
                &#x1F6D2;   
                    <span class="cart-count">3</span>
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