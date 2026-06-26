<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);

    if ($stmt->execute()) {
        header("Location: read.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>
    <h2>Edit Post</h2>
    <form method="POST" action="update.php?id=<?php echo $id; ?>">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>
        <label>Content:</label><br>
        <textarea name="content" rows="5" cols="40" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>
        <button type="submit">Update Post</button>
    </form>
    <p><a href="read.php">Back to Posts</a></p>
</body>
</html>