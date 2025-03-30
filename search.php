<?php
$connection = mysqli_connect("localhost", "root", "root", "handmade");


if (!$connection) {
    die(json_encode(["error" => "Database connection failed:" . mysqli_connect_error()]));
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if (!isset($_GET['query']) || empty(trim($_GET['query']))) {
    echo json_encode([]);
    exit;
}

$query = trim($_GET['query']);

$sql = "SELECT product_id, name, category_id FROM Product 
        WHERE LOWER(name) LIKE LOWER(?)";
$stmt = $connection->prepare($sql);
if (!$stmt) {
    echo json_encode(["error" => "Query preparation error: " . $connection->error]);
    exit;
}


$searchTerm = "%$query%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();

$result = $stmt->get_result();
if (!$result) {
    echo json_encode(["error" => "error: " . $stmt->error]);
    exit;
}


$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}


echo json_encode($products);

$stmt->close();
$connection->close();
?>