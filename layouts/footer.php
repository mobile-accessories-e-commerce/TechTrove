<style>


@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

* {
    font-family: 'poppins', sans-serif;
    margin: 0;
    padding: 0;
}
    footer {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    background-color: #d9e5f4;
    text-align: center;
    padding: 30px;
    color: rgb(64, 64, 64);
}

.footer-top {
    align-items: c;
    padding: 20px;
    width: 100%;
    
    
}


.footer-link-container{
    width: auto;
    display: flex;
    justify-content: space-between;
    gap: 20px;
    align-items: center;
    margin-top: 20px;
}
.footer-link-container li{
    list-style: none;
    font-size: 14px;
    margin: 2px;
    cursor: pointer;
   
}

.footer-link-container a{
    color: rgb(64, 64, 64);
    text-decoration: none;
    transition: 0.3s,ease;
}
.footer-link-container a:hover{
    color: rgb(64, 105, 225);
}
.footer-link-container h6{
    font-size: 18px;
    font-weight: 500;
    margin-bottom: 10px;
}
.contactus-link{
    margin-left: 20px;
    width: 300px;
    height: 100px;
    text-align: left;
}

.make-money-link{
    text-align: left;
    width: 300px;
    height: 100px;  
}

.shoping-link{
    text-align: left;
    width: 300px;
    height: 100px;
}

.social-media-link{
    text-align: left;
    width: 300px;
    height: 100px;
}

.social-media-link ul{
    display: flex;
    gap: 15px;
}
.social-media-link svg:hover{
  fill:rgb(65, 105, 225);;
}


.payment-link{   
    text-align: left;
    width: 300px;
    height: 100px;
}

.payment-link ul{
    display: flex;
    gap: 10px;
}


.footer-bottom {
    display: flex;
    justify-content: center;
    width: 90%;
    margin: auto;
    border-top: 1px solid rgb(169, 169, 169);
    padding-top: 30px;
    margin-top: 20px;
}
.footer-bottom ul {
    list-style: none;
    display: flex;
}

.footer-bottom a {
    margin-right: 20px;
    text-decoration: none;
    color: rgb(64, 64, 64);
    transition: 0.4s ease-in-out;
}

.footer-bottom a:hover {
    color: rgb(65, 105, 225);
}

</style>







<footer class="scroll-animate">
        <div class="footer-top">
            <img src="../images/elife_logo.png" width="220px" height="110px">

            <div class="footer-link-container">
                <div class="contactus-link">
                    <h6>Contact us</h6>
                    <ul>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Get help</a></li>
                        
                        
                    </ul>

                </div>
                
                <div class="make-money-link">
                <h6>Make Money</h6>
                    <ul>
                        <li><a href="../sellers/sellersignup.php">Become a Seller</a></li>
                        <li><a href="../serviceprovider/servicesignup.php">Give Serive</a></li>
                        
                    </ul>


                </div>
                
                <div class="shoping-link">
                <h6>Shoping</h6>
                    <ul>
                        <li><a href="../product/products.php">Product</a></li>
                        <li><a href="../service/services.php">Service</a></li>

                        
                    </ul>
                </div>
               
                <div class="social-media-link">
                <h6>Stay touch With us</h6>
                    <ul>
                        <li><a href="#"><svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/></svg></a></li>
                        <li><a href="#"><svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg></a></li>
                        <li><a href=""><svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg></a></li>
                        <li><a href=""><svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256.6 8C116.5 8 8 110.3 8 248.6c0 72.3 29.7 134.8 78.1 177.9 8.4 7.5 6.6 11.9 8.1 58.2A19.9 19.9 0 0 0 122 502.3c52.9-23.3 53.6-25.1 62.6-22.7C337.9 521.8 504 423.7 504 248.6 504 110.3 396.6 8 256.6 8zm149.2 185.1l-73 115.6a37.4 37.4 0 0 1 -53.9 9.9l-58.1-43.5a15 15 0 0 0 -18 0l-78.4 59.4c-10.5 7.9-24.2-4.6-17.1-15.7l73-115.6a37.4 37.4 0 0 1 53.9-9.9l58.1 43.5a15 15 0 0 0 18 0l78.4-59.4c10.4-8 24.1 4.5 17.1 15.6z"/></svg></a></li>
                    </ul>
                </div>

                <div class="payment-link">
                <h6>Payment Method</h6>
                    <ul>
                        <li><img src="../images/visa.png " width="60" height="50" alt=""></li>
                        <li><img src="../images/money.png " width="60" height="50" alt=""></li>
                        
                        
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
           
            <p>
                Copyright &#xA9; 2024 eLife. All Right Receved
            </p>
        </div>
    </footer>