<!DOCTYPE html>
<?php
        error_reporting(E_ALL) ;
        ini_set('display_errors', 1) ;
        ini_set('log_errors', 1) ; ?>
        
        <?php
        $connection = mysqli_connect("localhost", "root", "root" , "handmade");
        if(mysqli_connect_error()) {
        die(mysqli_connect_error()) ;}
        
        
       ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Grid</title>
    <header>
        <link rel="stylesheet" href="HomePageCSS.css"> 
        <div class="logo-title">
            <img src="Logo-removebg-preview - Copy.png" alt="Website Logo" width="25%" height="25%">
            <h3 id="logo-title">Hand made</h3>
        </div>
        <div id="comHeader">
            <a href="HomePage.php"> <img src="Home.svg" alt="Home" ></a>
           <a href="Cart.php"> <img src="cart-shopping-solid.svg" alt="cart" ></a>
          <a href="Homemade/profile.php"> <img src="user-solid.svg" alt="profile"></a>
           <a href="Homemade/signin.php"> <img src="logout.svg" alt="logout" ></a>
          
         </div>
        <div id="comHeader1">
            <a href="paintingkit.php" class="categories">painting</a>
            <a href="pottery.php" class="categories">pottery</a>
            <a href="woodcarving.php" class="categories">Wood craving</a>
            <a href="mirror.php" class="categories">Mirrors</a>
            <a href="charms.php" class="categories">Chains</a>
        </div>



    </header>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #EDD8E2;
            margin: 0;
            padding: 20px;
        }

        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: auto;
        }

        .product-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: auto;
            max-width: 300px;
            margin-top: 20%;
        }

        .product-image {
            width: 100%;
            border-radius: 10px;
            height: auto;
        }

        .product-title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }

        .product-price {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }

        .add-to-cart {
            background: #BF7896;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .add-to-cart:hover {
            background: darkred;
        }

        .cart-message {
            display: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-top: 10px;
            text-align: center;
            border-radius: 5px;
        }

        .error-message {
            display: none;
            background-color: #FF6347;
            color: white;
            padding: 10px;
            margin-top: 10px;
            text-align: center;
            border-radius: 5px;
        }
        
        #total-price {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="product-container">
    <?php
    

    $sql = "SELECT * FROM product WHERE category_id = 4";
    $result = mysqli_query($connection, $sql);

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="product-card">';
            echo '<img src="' . $row['pic_src'] . '" alt="Product Image" class="product-image">';
            echo '<div class="product-title">' . $row['name'] . '</div>';
            echo '<div class="product-price">' . $row['price'] . ' SAR</div>';
            echo '<button class="add-to-cart">Add to cart</button>';
            echo '</div>';
        }
    } else {
        echo "No products available.";
    }
    ?>
</div>

        
    </div>
    <footer>
        <div class="footer-left">
            <p>Contact Us:</p>
            <img src="twitter.webp" alt="Twitter Icon"> @HandMade
            <img src="instagram.webp" alt="Instagram Icon"> @HandMade
            <img src="email.png" alt="Email Icon"> HandMade@gmail.com
        </div>
        <div class="footer-right">
            &copy; 2025 HandMade
        </div>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Handle Add to Cart functionality
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function () {
                    const productCard = this.closest('.product-card');
                    const cartMessage = productCard.querySelector('.cart-message');
                    
                    // Hide any previously shown messages
                    document.querySelectorAll('.cart-message').forEach(message => message.style.display = "none");

                    // Show the success message for the clicked product
                    cartMessage.style.display = "block";
                    cartMessage.textContent = "Item added to cart!";

                    // Add the item to the cart (this part can be customized)
                    let cart = JSON.parse(localStorage.getItem('cart')) || [];
                    const id = productCard.querySelector('.product-title').textContent;
                    const price = parseFloat(productCard.querySelector('.product-price').textContent.split(' ')[0]);
                    const imageSrc = productCard.querySelector('img').src; // جلب رابط الصورة


                    let item = cart.find(item => item.name === id);
                    if (item) {
                     item.quantity += 1;
                    } else {
                      cart.push({ name: id, price: price, image: imageSrc, quantity: 1 });
                    }

                    localStorage.setItem('cart', JSON.stringify(cart));
                });
            });

            // Handle the redirection to the cart when clicking the cart icon
            document.getElementById('cart-link').addEventListener('click', function () {
                window.location.href = "Cart.html";
            });
        });
    </script>
</body>
</html>

