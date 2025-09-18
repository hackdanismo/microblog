# PHP

+ [Connect to a MySQL database](#connect-to-a-mysql-database)

## Connect to a MySQL database
To connect to a `MySQL database` using `PDO`:

```php
<?php
// Variables containing the database credentials
$host = "localhost";
$database = "database_name_here";
$username = "username";
$password = "password";

try {
  // Create a new instance of the PDO Object to connect to the MySQL database
  $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
  // Set the PDO error mode to exception for better error handling
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // Output message if connected to the databases
  echo "Database Connected Successfully";
} catch(PDOException $e) {
  // Output error message if the database connection has failed
  echo "Connection failed: " . $e->getMessage();
}
?>
```

This can be extended:

```php
<?php
// Database host (usually localhost if running on the same server)
$host = "localhost";
// Database name
$db = "database_name_here";
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
?>
```
