<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "handmade";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if (!isset($_POST['cart_data'])) {
    die("No cart data received.");
}

$cart = json_decode($_POST['cart_data'], true);
if (!$cart || count($cart) == 0) {
    die("Empty cart.");
}

$total_price = 0;
$category_id = 1; 

foreach ($cart as $index => $item) {
    $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 1;
    $price = isset($item['price']) ? (float)$item['price'] : 0;

    $total_price += $price * $quantity;

    if ($index == 0 && isset($item['category_id'])) {
        $category_id = (int)$item['category_id'];
        echo "Category ID from Cart: " . $category_id . "<br>"; 

        $product_name = $item['name'];
        echo "Product Name: '$product_name'<br>"; 

        $stmt = $conn->prepare("SELECT Category_id FROM category WHERE BINARY name = ? LIMIT 1");
        $stmt->bind_param("s", $product_name);
        $stmt->execute();
        $stmt->bind_result($category_id);
        $stmt->fetch();
        $stmt->close();

        echo "Fetched Category ID from database: " . $category_id . "<br>";

        if ($category_id === null || $category_id == 0) {
            echo "Warning: Category not found for product: $product_name. Defaulting to category 1.<br>";
            $category_id = 1; // fallback لقيمة افتراضية
        } else {
            echo "Successfully fetched category_id: " . $category_id . "<br>";
        }
    }
}


$order_date = date('Y-m-d H:i:s');

$sql = "INSERT INTO `order` (user_id, category_id, order_date, total_price)
        VALUES ('$user_id', '$category_id', '$order_date', '$total_price')";


if ($conn->query($sql) === TRUE) {
    echo "✅ Order placed successfully! ";
} else {
   echo "❌ Error placing order: " . $conn->error;

}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hand Made - Order Confirmation</title>
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3d6dd;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        /* Header */
        header {
            background-color: #d77a8b;
            color: white;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
        }

        /* Order Confirmation Container */
        .order-container {
            width: 50%;
            background-color: white;
            padding: 20px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        /* Order Item Styling */
        .order-items {
            text-align: left;
        }

        .order-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid #ccc;
        }

        .order-item img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            margin-right: 15px;
        }

        .order-summary {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        /* Buttons */
        .home-btn {
            background-color: #d77a8b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: 0.3s;
        }

        .home-btn:hover {
            background-color: #b85f72;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            padding: 15px;
            margin-top: 30px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <header>Order Confirmation</header>

    <div class="order-container">
        <h2>Thank You! Your Order is Confirmed 🎉</h2>
        <p>Your order has been successfully placed.</p>

        <div id="orderItemsContainer" class="order-items">
            <!-- Ordered items dynamically added here -->
        </div>
        
        <div class="order-summary">
            <p>Total Paid: SAR <span id="total-price">0.00</span></p>
        </div>

        <button onclick="window.location.href='HomePage.html'" class="home-btn">Return to Home</button>
    </div>

    <footer>
        &copy; 2024 Hand Made. All rights reserved.
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const orderItemsContainer = document.getElementById("orderItemsContainer");
            const totalPriceDisplay = document.getElementById("total-price");

            // استلام بيانات السلة من localStorage
            let cartItems = JSON.parse(localStorage.getItem("cart")) || [];
            let totalPrice = 0;

            if (cartItems.length === 0) {
                orderItemsContainer.innerHTML = "<p>No items found. Please return to the shop.</p>";
            } else {
                cartItems.forEach(item => {
                    const itemDiv = document.createElement("div");
                    itemDiv.classList.add("order-item");
                    itemDiv.innerHTML = `
                        <img src="${item.image}" alt="${item.name}">
                        <div>
                            <h4>${item.name}</h4>
                            <p>SAR ${item.price * item.quantity}</p>
                        </div>
                        <div>
                            <p>Quantity: ${item.quantity}</p>
                        </div>
                    `;
                    orderItemsContainer.appendChild(itemDiv);
                    totalPrice += item.price * item.quantity;
                });
            }

            totalPriceDisplay.textContent = totalPrice.toFixed(2);

            // مسح السلة بعد تأكيد الطلب
            localStorage.removeItem("cart");
        });
    </script>

</body>
</html>
