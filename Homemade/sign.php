<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$connect=mysqli_connect("localhost","root","root","Handmade");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["id"])&& isset($_POST["name"]) && isset($_POST["pass"])&& isset($_POST["email"]))
{
    $i=$_POST["id"];
    $n=$_POST["name"];
    $p=$_POST["pass"];
    $e=$_POST["email"];
    
    $sql="INSERT INTO User(user_id,name,email,password) VALUES('$i','$n','$e','$p')";
    $result= mysqli_query($connect,$sql);
    
    
    if ($result) {
        
        $_SESSION['user_id'] = $i;
        $_SESSION['user_name'] = $n;
        $_SESSION['user_email'] = $e;
        
        // Redirect to HomePage after successful signup
        header("Location: ../HomePage.html");
        exit();
    } 
    
}
?>
