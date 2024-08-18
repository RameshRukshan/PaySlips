<?php
// Database credentials
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'star_admin';

$conn = new mysqli($host, $user, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    header("Location: error500.php");
    exit();
}


?>
