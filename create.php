<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        header("Location: read.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Post</title>
</head>
<body>
    <h2>Add New Post</h2>
    <form method="POST" action="create.php">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>
        <label>Content:</label><br>
        <textarea name="content" rows="5" cols="40" required></textarea><br><br>
        <button type="submit">Add Post</button>
    </form>
    <p><a href="read.php">Back to Posts</a></p>
</body>
</html>
