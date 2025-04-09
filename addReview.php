<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$connection = mysqli_connect("localhost", "root", "root", "handmade");


if (!$connection) {
    die("ERROR WHILE COONECTION " . mysqli_connect_error());
}

$_SESSION['user_id']=$_SESSION['user_id'];

echo "<pre>";
print_r($_POST);
echo "</pre>";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $user_id = $_SESSION['user_id']; 
    $product_id = isset($_POST["product_id"]) ? (int)$_POST["product_id"] : 0; 
    $review_text = $_POST["reviewText"];
    $rating = (int) $_POST["rating"];
    
      //$rating = 6 - $rating;
    
     
   
    $imagePath = "";
    if (!empty($_FILES["reviewImage"]["name"])) {
        $fileName = time() . "_" . basename($_FILES["reviewImage"]["name"]); // إنشاء اسم فريد
        $imagePath = "./" . $fileName; 

      
       if (move_uploaded_file($_FILES["reviewImage"]["tmp_name"], $imagePath)) {
            echo "the photo is upload: " . $imagePath . "<br>";
        } else {
            echo "the photo didnot upload!<br>";
            $imagePath = "";
        }
    } else {
        echo "No image selected.<br>";
    }
  if (empty($product_id) || empty($review_text) || $rating == 0 || empty($imagePath)) {
        echo "<script>alert(' Please fill in all required fields!');window.history.back();</script>"; 
        exit();
    }
    // insert to database
    $sql = "INSERT INTO review (user_id, product_id, review_text, rating, img_url) 
            VALUES (?, ?, ?, ?, ?)";

    // prepare 
    $stmt = mysqli_prepare($connection, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iisis", $user_id, $product_id, $review_text, $rating, $imagePath);

        if (mysqli_stmt_execute($stmt)) {
            echo "Review added successfully!";
            header("Location: HomePage.html"); 
            exit();
        } else {
            echo "Error while entering data:" . mysqli_error($connection);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR";
    }
}

// close connection
mysqli_close($connection);
?>