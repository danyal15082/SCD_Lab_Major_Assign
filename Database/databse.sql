<?php
/**
 * Database Configuration and Functions
 * Classroom Resource Booking System
 */

// Database Credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Default XAMPP password is empty
define('DB_NAME', 'classroom_booking_system');

/**
 * Establishes a database connection and returns the connection object.
 * Uses a static variable to ensure only one connection is made (Singleton pattern).
 *
 * @return mysqli The database connection object.
 */
function getDBConnection() {
    static $conn = null;

    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Set character set to utf8mb4
        $conn->set_charset("utf8mb4");
    }

    return $conn;
}

/**
 * Closes the database connection.
 *
 * @param mysqli $connection The database connection object to close.
 */
function closeDBConnection($connection) {
    if ($connection) {
        $connection->close();
    }
}

/**
 * Executes a SQL query and returns the result.
 * Dies on error.
 *
 * @param mysqli $conn The database connection.
 * @param string $sql The SQL query to execute.
 * @return mysqli_result The result of the query.
 */
function executeQuery($conn, $sql) {
    $result = $conn->query($sql);
    if ($result === false) {
        die("Error executing query: " . $conn->error . "<br>Query: " . $sql);
    }
    return $result;
}
?>