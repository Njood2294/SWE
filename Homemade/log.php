<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$connect = mysqli_connect("localhost", "root", "root", "Handmade");

if (!$connect) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["pass"])) {
    $i = $_POST["id"];
    $p = $_POST["pass"];

    // Check if the user exists
    $sql = "SELECT * FROM User WHERE user_id = '$i' AND password = '$p'";
    $result = mysqli_query($connect, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Store user data in session
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];

        // Redirect to homepage
        header("Location: ../HomePage.html");
        exit();
    } else {
        echo "<script>alert('Invalid ID or Password!'); window.location.href='login.html';</script>";
    }
}
?>
