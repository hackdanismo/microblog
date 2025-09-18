<?php
// Database host (usually localhost if running on the same server)
$host = "localhost";
// Database name
$db = "db-microblog";
// Database username (replace with actual username)
$user = "username";
// Database password (replace with actual password)
$pass = "password";
// Character set to be used when communicating with the database
$charset = "utf8mb4";

// Build the Data Source Name (DSN) string for the PDO connection
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
    // Create a new PDO instance (database connection) using DSN, username, password and options
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connection to database was successful.";
} catch (PDOException $e) {
    // If the connection fails, display an error message
    echo "Connection to database failed: " . $e->getMessage();
}

// Handle form submissions to add a post to the database table
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["content"])) {
    // Get submitted post content, removing whitespace using the trim() method
    $content = trim($_POST["content"]);
    $user_id = 1;   // Static user for now

    // Prepare SQL statement to insert a new post into the "posts" table
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
    // Execute the query with provided values
    $stmt->execute([$user_id, $content]);

    // Success message
    echo "<p>Post added successfully.<p>";
}

// Handle delete requests to delete a post
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_id"])) {
    // Convert the submitted ID to an integer for safety
    $delete_id = (int) $_POST["delete_id"];

    // Prepare SQL statement to delete a post by ID
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    // Execute the query with the post ID
    $stmt->execute([$delete_id]);

    // Success message
    echo "<p>Post deleted successfully.</p>";
}
?>

<form method="POST">
    <textarea name="content" rows="4" cols="50" placeholder="What's on your mind?" required></textarea><br>
    <button type="submit">Post</button>
</form>

<?php
// Fetch all posts from the database, newest post first
$stmt = $pdo->query("SELECT id, user_id, content, created_at FROM posts ORDER BY created_at DESC");

echo "<h2>All Posts</h2>";

// Loop through each post retrieved from the database
while ($row = $stmt->fetch()) {
    // Display the user ID (escaped for security)
    echo "<p>User " . htmlspecialchars($row["user_id"]) . "</p>";
    // Display post content (escaped and convert to newlines to <br> tags)
    echo "<p>" . nl2br(htmlspecialchars($row["content"])) . "</p>";
    // Display the creation date of the post
    echo "<p>Posted on: " . htmlspecialchars($row["created_at"]) . "</p>";

    // Form to delete a specified selected post
    echo "<form method='post'>
        <input type='hidden' name='delete_id' value='" . $row['id'] ."'>
        <button type='submit'>Delete</button>
    </form>";
}
?>