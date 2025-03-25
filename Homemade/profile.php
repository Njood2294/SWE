<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

?><?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$connect = mysqli_connect("localhost", "root", "root", "Handmade");

if (!$connect) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT * FROM User WHERE user_id = '$user_id'";
$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="../HomePageCSS.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #edd8e2;
        }
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 100px;
        }
        .profile-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
            border: 1px solid #ccc;
        }
        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        h2 {
            margin: 10px 0;
        }
        .username {
            color: gray;
        }
        .info p {
            display: flex;
            justify-content: space-between;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .edit-icon {
            cursor: pointer;
            color: gray;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-title">
            <img src="../Logo-removebg-preview - Copy.png" alt="Website Logo" width="25%" height="25%">
            <h3 id="logo-title">Hand Made</h3>
        </div>
        <div id="comHeader">
          <a href="../HomePage.html"> <img src="../Home.svg" alt="Home"></a>
          <a href="../Cart.html"> <img src="../cart-shopping-solid.svg" alt="cart"></a>
          <a href="profile.php"> <img src="../user-solid.svg" alt="profile"></a>
          <a href="../logout.php"> <img src="../logout.svg" alt="logout"></a>
        </div>
        <div id="comHeader1">
            <a href="../paintingkit.html" class="categories">Painting</a>
            <a href="../pottery.html" class="categories">Pottery</a>
            <a href="../woodcarving.html" class="categories">Wood Carving</a>
            <a href="../mirror.html" class="categories">Mirrors</a>
            <a href="../charms.html" class="categories">Chains</a>
        </div>
    </header>

    <div class="profile-container">
        <div class="profile-card">
            <img src="Images/Profile-PNG-File.png" alt="Profile Picture" class="profile-img">
            <h2><?php echo htmlspecialchars($row['name']); ?></h2>
            <p class="username">@<?php echo htmlspecialchars($row['name']); ?> <span class="edit-icon"><img src="764599.png" height="15em" width="15em"></span></p>

            <div class="info">
                <p><strong>ID:</strong> <span><?php echo htmlspecialchars($row['user_id']); ?></span> <span class="edit-icon"><img src="764599.png" height="15em" width="15em"></span></p>
                <p><strong>Username:</strong> <span><?php echo htmlspecialchars($row['name']); ?></span> <span class="edit-icon"><img src="764599.png" height="15em" width="15em"></span></p>
                <p><strong>Email:</strong> <span><?php echo htmlspecialchars($row['email']); ?></span> <span class="edit-icon"><img src="764599.png" height="15em" width="15em"></span></p>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-left">
            <p>Contact Us:</p>
            <img src="../twitter.webp" alt="Twitter Icon"> @HandMade
            <img src="../instagram.webp" alt="Instagram Icon"> @HandMade
            <img src="../email.png" alt="Email Icon"> HandMade@gmail.com
        </div>
        <div class="footer-right">
            &copy; 2025 HandMade
        </div>
    </footer>
</body>
</html>
      