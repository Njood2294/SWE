<?php
session_start();
$connection = mysqli_connect("localhost", "root", "root", "handmade");

if (!$connection) {
    die(json_encode(["status" => "error", "message" => "فشل الاتصال بقاعدة البيانات."]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review_id = isset($_POST["review_id"]) ? (int)$_POST["review_id"] : 0;
    $action = $_POST["action"]; // "like" أو "dislike"

    if ($review_id > 0) {
        if ($action === "like") {
            $sql = "UPDATE review SET likes = likes + 1 WHERE review_id = ?";
        } elseif ($action === "dislike") {
            $sql = "UPDATE review SET dislikes = dislikes + 1 WHERE review_id = ?";
        } else {
            echo json_encode(["status" => "error", "message" => "طلب غير صالح."]);
            exit();
        }

        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $review_id);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            echo json_encode(["status" => "success", "message" => "تم تحديث البيانات بنجاح."]);
        } else {
            echo json_encode(["status" => "error", "message" => "حدث خطأ أثناء التحديث."]);
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($connection);
?>
