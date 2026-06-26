<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p><a href="logout.php">Logout</a></p>
    <h3>All Posts</h3>
    <p><a href="create.php">+ Add New Post</a></p>

    <table border="1" cellpadding="10">
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['content']); ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <a href="update.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>