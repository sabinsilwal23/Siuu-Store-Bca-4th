<?php

if (file_exists('../config/db.php')) {
    include '../config/db.php';
}
if (file_exists('../includes/auth.php')) {
    include '../includes/auth.php';
    check_login();
}
if (file_exists('../templates/header.php')) {
    include '../templates/header.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siuu Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color:rgb(245, 134, 136);
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        #content {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logo {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        .background {
            padding: 20px;
            background-color:rgb(227, 191, 133);
            color: #fff;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .background h2 {
            margin-top: 0;
        }

        .background p {
            margin: 10px 0;
        }

        .background button {
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .background button:hover {
            background-color: #218838;
        } 
        

        .featured-products {
            margin: 20px 0;
        }

        .featured-products h2 {
            color: #333;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .product {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: calc(25% - 20px);
            box-sizing: border-box;
            text-align: center;
            transition: transform 0.2s;
        }

        .product:hover {
            transform: translateY(-10px);
        }

        .product img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .product h3 {
            color:rgb(244, 165, 120);
            margin: 10px 0;
        }

        .product p {
            color: #555;
        }

        .testimonials {
            margin: 20px 0;
        }

        .testimonials h2 {
            color: #333;
        }

        .testimonial {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px 0;
        }

        .testimonial p {
            color: #555;
        }

    

        .social-icons {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .social-icons a {
            margin: 0 5px;
        }

        .social-icons img {
            width: 24px; 
            height: auto;
            transition: transform 0.3s ease;
        }

        .social-icons img:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Siuu Store</h1>
    </header>

    
    <main>
        <section id="content">
            <img src="Siuu.jpg" alt="Siuu Store Logo" class="logo"> 
            <div class="background">
                
                <p>Your one-stop shop for all your shoe needs. Explore our wide range of products and enjoy a seamless shopping experience.</p>
                <button id="productsButton" onclick="window.location.href='products.php';">View Products</button>
            </div>
           
        </section>

        
        
        <section class="testimonials">
            <h2>What Our Customers Say</h2>
            <div class="testimonial">
                <p>"Great products and excellent customer service!" - John Doe</p>
            </div>
            <div class="testimonial">
                <p>"I love the variety of shoes available. Highly recommend!" - Jane Smith</p>
            </div>
        </section>
    </main>

    
    
       
        <div class="social-icons">
        <p>Follow us on social media:</p>
            <a href="https://www.instagram.com/_ig_sabin/" target="_blank"><img src="image.jpg" alt="Instagram"></a>
            <a href="https://www.facebook.com/" target="_blank"><img src="imageee.jpg" alt="Facebook"></a>
   
        </div>
      
   
</body>
</html>
