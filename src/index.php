<?php
// Start the session
session_start();

// Check if a user is logged in
if (!isset($_SESSION['user_role'])) {
    // If no user is logged in, redirect to the login page
    header("Location: pages/samples/login.php");
    exit();
}

// Check the user's role and redirect to the appropriate dashboard
$user_role = $_SESSION['user_role'];

if ($user_role === 'admin') {
    header("Location: admin_dashboard.php");
    exit();
} elseif ($user_role === 'user') {
    header("Location: User Dashboard.php");
    exit();
} else {
    // If the role is not recognized, log the user out and redirect to login
    session_destroy();
    header("Location: pages/samples/login.php");
    exit();
}
?>
