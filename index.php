<?php
// Database host (usually localhost)
$host = "localhost";
// Database name
$db = "db-microblog";
// Database username
$user = "username";
// Database password
$pass = "password";
$charset = "utf8mb4";

// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    // Throw exceptions on errors instead of silent failures
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // Fetch associative arrays by default
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Use native prepared statements if possible to improve security and performance
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connection to database was successful.";
} catch (PDOException $e) {
    echo "Connection to database failed: " . $e->getMessage();
}

// Handle form submissions to add a post to the database table
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["content"])) {
    $content = trim($_POST["content"]);
    $user_id = 1;   // Static user for now

    $stmt = $pdo->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
    $stmt->execute([$user_id, $content]);

    echo "<p>Post added successfully.<p>";
}

// Handle delete requests
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_id"])) {
    $delete_id = (int) $_POST["delete_id"];

    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$delete_id]);

    echo "<p>Post deleted successfully.</p>";
}
?>

<form method="POST">
    <textarea name="content" rows="4" cols="50" placeholder="What's on your mind?" required></textarea><br>
    <button type="submit">Post</button>
</form>

<?php
// Fetch all posts from the database
$stmt = $pdo->query("SELECT id, user_id, content, created_at FROM posts ORDER BY created_at DESC");

echo "<h2>All Posts</h2>";

while ($row = $stmt->fetch()) {
    echo "<p>User " . htmlspecialchars($row["user_id"]) . "</p>";
    echo "<p>" . nl2br(htmlspecialchars($row["content"])) . "</p>";
    echo "<p>Posted on: " . htmlspecialchars($row["created_at"]) . "</p>";
    echo "<form method='post'>
        <input type='hidden' name='delete_id' value='" . $row['id'] ."'>
        <button type='submit'>Delete</button>
    </form>";
}
?>