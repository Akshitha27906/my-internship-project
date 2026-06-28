<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Pagination settings
$posts_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $posts_per_page;

// Build query based on search
if ($search !== '') {
    $searchParam = "%$search%";
    $countStmt = $conn->prepare("SELECT COUNT(*) as total FROM posts WHERE title LIKE ? OR content LIKE ?");
    $countStmt->bind_param("ss", $searchParam, $searchParam);
    $countStmt->execute();
    $totalRows = $countStmt->get_result()->fetch_assoc()['total'];
    $countStmt->close();

    $stmt = $conn->prepare("SELECT * FROM posts WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ssii", $searchParam, $searchParam, $posts_per_page, $offset);
} else {
    $countResult = $conn->query("SELECT COUNT(*) as total FROM posts");
    $totalRows = $countResult->fetch_assoc()['total'];

    $stmt = $conn->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $posts_per_page, $offset);
}

$stmt->execute();
$result = $stmt->get_result();
$total_pages = ceil($totalRows / $posts_per_page);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p><a href="logout.php">Logout</a></p>

        <h3>All Posts</h3>
        <p><a href="create.php" class="btn">+ Add New Post</a></p>

        <form method="GET" action="read.php" class="search-form">
            <input type="text" name="search" placeholder="Search posts..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
            <?php if ($search !== ''): ?>
                <a href="read.php">Clear</a>
            <?php endif; ?>
        </form>

        <table>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['content']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                     <a href="update.php?id=<?php echo $row['id']; ?>">Edit</a>
<?php if ($_SESSION['role'] === 'admin'): ?>
    | <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
<?php endif; ?>               
                </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No posts found.</td></tr>
            <?php endif; ?>
        </table>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page-1; ?>&search=<?php echo urlencode($search); ?>">&laquo; Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page+1; ?>&search=<?php echo urlencode($search); ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>