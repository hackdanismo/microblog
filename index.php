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
?>