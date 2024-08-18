<?php
session_start();

// Clear the session
session_unset();
session_destroy();

// Redirect to login page
header("Location: pages/samples/login.php");
exit();
?>
