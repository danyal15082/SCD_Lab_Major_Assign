<?php
/**
 * Application Configuration
 * Classroom Resource Booking System
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database configuration
require_once __DIR__ . '/database.php';

// Establish database connection
$conn = getDBConnection();

// Application Constants
define('SITE_NAME', 'Classroom Resource Booking System');
define('SITE_URL', 'http://localhost/webapp');
define('ADMIN_EMAIL', 'admin@classroom.com');

// File Upload Settings
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'pdf']);

// Timezone
date_default_timezone_set('Asia/Karachi');

// Error Reporting (Development Mode)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// For Production, use:
// error_reporting(0);
// ini_set('display_errors', 0);
// ini_set('log_errors', 1);
// ini_set('error_log', __DIR__ . '/../logs/error.log');

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Function to check if user is admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Function to require login
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . SITE_URL . '/login.php');
        exit();
    }
}

// Function to require admin
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header('Location: ' . SITE_URL . '/user/dashboard.php');
        exit();
    }
}

// Function to redirect
function redirect($url) {
    header('Location: ' . $url);
    exit();
}

// Function to set flash message
function setFlashMessage($message, $type = 'info') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type; // success, error, warning, info
}

// Function to get flash message
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'info';
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

// Function to format date
function formatDate($date) {
    return date('M d, Y', strtotime($date));
}

// Function to format datetime
function formatDateTime($datetime) {
    return date('M d, Y h:i A', strtotime($datetime));
}

// Function to format time
function formatTime($time) {
    return date('h:i A', strtotime($time));
}

// Function to get user role badge class
function getRoleBadgeClass($role) {
    return $role === 'admin' ? 'badge-danger' : 'badge-primary';
}

// Function to get booking status badge class
function getBookingStatusBadge($status) {
    $badges = [
        'pending' => 'badge-warning',
        'approved' => 'badge-success',
        'rejected' => 'badge-danger',
        'cancelled' => 'badge-secondary'
    ];
    return $badges[$status] ?? 'badge-secondary';
}

// Function to get resource status badge class
function getResourceStatusBadge($status) {
    $badges = [
        'available' => 'badge-success',
        'maintenance' => 'badge-warning',
        'unavailable' => 'badge-danger'
    ];
    return $badges[$status] ?? 'badge-secondary';
}

// Function to validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Function to validate phone
function isValidPhone($phone) {
    return preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $phone);
}

// Function to generate random string
function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

/**
 * Sanitizes string input for use in SQL queries to prevent SQL injection.
 *
 * @param mysqli $conn The database connection object.
 * @param string $data The input data to sanitize.
 * @return string The sanitized data.
 */
function sanitizeInput($conn, $data) {
    $data = trim($data);
    if ($conn) { // Ensure connection object exists
        return $conn->real_escape_string($data);
    }
    // Fallback if no connection, but this should be avoided.
    return $data;
}
?>
