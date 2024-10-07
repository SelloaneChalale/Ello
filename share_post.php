<?php
// share_post.php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $postId = $_POST['post_id'];

    $stmt = $conn->prepare("INSERT INTO shares (user_id, post_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $postId);
    $stmt->execute();

    echo json_encode(['status' => 'success']);
}
?>
