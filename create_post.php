<?php
include 'config.php';
// session_start();

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = $_POST['content'];
        $image = isset($_FILES['image']) ? $_FILES['image'] : null;

        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $image_path = 'uploads/' . uniqid() . '_' . basename($image['name']);
            if (move_uploaded_file($image['tmp_name'], $image_path)) {
                $sql = "INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("iss", $user_id, $content, $image_path);
                }
            } else {
                echo "Failed to upload image.";
                exit();
            }
        } else {
            $sql = "INSERT INTO posts (user_id, content, image,published) VALUES (?, ?, NULL,'1')";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("is", $user_id, $content);
            }
        }

        if ($stmt && $stmt->execute()) {
            echo "Post created successfully!";
            header('Location: home');
        } else {
            echo "Error: " . ($stmt ? $stmt->error : $conn->error);
        }

        if ($stmt) {
            $stmt->close();
        }
    }
} else {
    echo "You need to be logged in to create a post.";
}
?>
