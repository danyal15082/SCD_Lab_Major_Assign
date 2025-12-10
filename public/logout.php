<?php
/**
 * Logout Script
 * Classroom Resource Booking System
 */

require_once 'config/config.php';

// Destroy session and redirect to login page
session_unset();
session_destroy();

// Clear session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect to login with message
session_start();
setFlashMessage('You have been logged out successfully.', 'success');
redirect(SITE_URL . '/login.php');
?>