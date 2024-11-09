<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to signup_login.html
header("Location: signup_login.html");
exit();
?>
