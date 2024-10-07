<?php
// like_post.php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $postId = $_POST['post_id'];
    $reaction = $_POST['reaction']; // Reaction type: Like, Love, Haha, etc.

    // Check if user already liked/reacted to the post
    $stmt = $conn->prepare("SELECT id FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->bind_param("ii", $userId, $postId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update reaction
        $stmt = $conn->prepare("UPDATE likes SET reaction = ? WHERE user_id = ? AND post_id = ?");
        $stmt->bind_param("sii", $reaction, $userId, $postId);
    } else {
        // Insert new reaction
        $stmt = $conn->prepare("INSERT INTO likes (user_id, post_id, reaction) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $userId, $postId, $reaction);
    }

    $stmt->execute();
    echo json_encode(['status' => 'success']);
}
?>
