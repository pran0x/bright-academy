<?php
/**
 * Authentication Middleware
 * Include this at the top of protected admin pages
 */
require_once '../config/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirectTo('login.php');
}

// Check session timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();
    redirectTo('login.php?timeout=1');
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Get current user info
$userId = getUserId();
$userRole = getUserRole();
$userName = $_SESSION['full_name'];
?>
