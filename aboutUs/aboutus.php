<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }

        /* Header Section */
        header {
            background-color:rgb(65, 105, 225);
            color: white;
            padding: 20px 40px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        header nav ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        header nav ul li {
            display: inline-block;
            margin: 0 20px;
        }

        header nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: color 0.3s;
        }

        header nav ul li a:hover {
            color: #18bc9c;
        }

        /* Hero Section */
        .hero {
            background: url('../images/background3.jpg') no-repeat center center/cover;
            height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
        }

        .hero h1 {
            font-size: 60px;
            font-weight: bold;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.5);
        }

        .hero p {
            font-size: 24px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Section Styles */
        section {
            padding: 60px 20px;
            text-align: center;
        }

        /* Our Service Section */
        .services {
            display: flex;
            justify-content: space-around;
            gap: 30px;
            flex-wrap: wrap;
            
        }

        #services h2{
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 40px;
            margin-top: 20px;
        }

        .service-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 30%;
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-10px);
        }

        .service-card img {
            width: 100%;
            border-radius: 10px;
            height: 200px;
            object-fit: cover;
        }

        .service-card h3 {
            font-size: 22px;
            margin-top: 15px;
            color: #333;
        }

        .service-card p {
            font-size: 16px;
            color: #777;
        }

        /* Our Team Section */
        .team {
            display: flex;
            justify-content: space-between;
            gap: 10px;
           margin-bottom: 100px;
        }

        #team h2{
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 40px;
            margin-top: 20px;
        }

        .team-member {
            width: 30%;
            text-align: center;
            border-radius: 10px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .team-member img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .team-member h4 {
            margin-top: 15px;
            font-size: 22px;
            color: #333;
        }

        .team-member p {
            font-size: 16px;
            color: #777;
        }

        /* Vision & Mission Section */
        .vision-mission {
            background-color: #18bc9c;
            color: white;
            padding: 50px 20px;
        }

        .vision-mission h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .vision-mission p {
            font-size: 18px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Contact Form */
        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .contact-form input,
        .contact-form textarea {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .contact-form button {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .contact-form button:hover {
            background-color: #18bc9c;
        }

      
       

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .services {
                flex-direction: column;
                align-items: center;
            }

            .service-card,
            .team-member {
                width: 80%;
            }

            .team {
                flex-direction: column;
                align-items: center;
            }

            .contact-form {
                width: 80%;
            }
        }


@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 1s, transform 1s;  
}


.fade-in-up-visible {
    opacity: 1;
    transform: translateY(0);
    animation: fadeInUp 1s forwards;
}



    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <nav>
            <ul>
                <li><a href="#hero">Home</a></li>
                <li><a href="#services">Our Services</a></li>
                <li><a href="#team">Our Team</a></li>
                <li><a href="#vision">Vision & Mission</a></li>
                <li><a href="#contact">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="hero" class="hero fade-in-up delay-2">
        <div>
            <h1>Welcome to Our World</h1>
            <p>Your journey towards success begins here.</p>
        </div>
    </section>

    <!-- Our Services Section -->
   <!-- Service Cards Section -->
<section id="services">
    <h2>Our Services</h2>
    <div class="services">
        <div class="service-card fade-in-up delay-2">
            <img src="../images/empty.jpg" alt="Customer Service">
            <h3>For Customers</h3>
            <p>Access the best services and products with a seamless experience.</p>
        </div>
        <div class="service-card fade-in-up delay-2">
            <img src="../images/checkout.jpg" alt="Seller Service">
            <h3>For Sellers</h3>
            <p>Grow your business with our platform and reach a wider audience.</p>
        </div>
        <div class="service-card fade-in-up delay-3">
            <img src="../images/contact.png" alt="Service Provider">
            <h3>For Service Providers</h3>
            <p>Offer your services to a large pool of customers in need of expertise.</p>
        </div>
    </div>
</section>

<!-- Team Section -->
<section id="team">
    <h2>Our Team</h2>
    <div class="team">
        <div class="team-member fade-in-up delay-1">
            <img src="../images/lakshitha.png" alt="Team Member 1">
            <h4>Lakshitha Madushan</h4>
            <p>CEO & Founder</p>
        </div>
        <div class="team-member fade-in-up delay-2">
            <img src="../images/budhika2.jpg" alt="Team Member 2">
            <h4>Budhika Madumali</h4>
            <p>CTO</p>
        </div>
        <div class="team-member fade-in-up delay-3">
            <img src="../images/praveen2.jpg" alt="Team Member 3">
            <h4>Praveen Dadigama</h4>
            <p>Lead Developer</p>
        </div>
        <div class="team-member fade-in-up delay-3">
            <img src="../images/jojeeven2.jpg" alt="Team Member 3">
            <h4>Jo Jeeven</h4>
            <p>Lead Developer</p>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section id="vision" class="vision-mission fade-in-up">
    <h2>Our Vision and Mission</h2>
    <p>We aim to be the leading platform for seamless transactions and high-quality services. Our mission is to empower our customers, sellers, and service providers by providing an intuitive platform that connects the world.</p>
</section>

<!-- Contact Form Section -->
<section id="contact" class="fade-in-up">
    <h2>Contact Us</h2>
    <div class="contact-form">
       
        <input type="text" placeholder="Your Name" required>
        <input type="email" placeholder="Your Email" required>
        <textarea placeholder="Your Message" required></textarea>
        <button type="submit">Submit</button>
        
    </div>
</section>

    <?php include "../layouts/footer.php" ?>



    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const elements = document.querySelectorAll('.fade-in-up');
        
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2
        });

        elements.forEach(element => {
            observer.observe(element);
        });
    });
</script>

</body>

</html>
