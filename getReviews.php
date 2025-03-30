<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 

$servername = "localhost";
$username = "root";
$password = "root"; 
$dbname = "handmade";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    echo json_encode(["error" => "error " . $conn->connect_error]);
    exit;
}


$sql = "SELECT 
            r.review_id,
            u.name AS user_name,
            p.name AS product_name,
            r.rating,
            r.review_text,
            r.img_url,
            r.likes,    
            r.dislikes  
        FROM review r
        JOIN User u ON r.user_id = u.user_id
        JOIN Product p ON r.product_id = p.product_id";
$result = $conn->query($sql);

$reviews = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
} 


echo json_encode($reviews, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$conn->close();
?>
