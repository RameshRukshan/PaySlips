<?php
// Database credentials
$host = 'localhost';
$port = 3306;
$user = 'root';
$password = 'root';
$dbname = 'star_admin';

$conn = new mysqli($host, $user, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    header("Location: error500.php");
    exit();
}

$conn->close();
?>
