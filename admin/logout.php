<?php
/**
 * Logout Script
 */
require_once '../config/config.php';

if (isLoggedIn()) {
    // Log the logout
    logActivity('logout', 'auth', 'User logged out');
    
    // Destroy session
    session_unset();
    session_destroy();
}

redirectTo('login.php');
?>
