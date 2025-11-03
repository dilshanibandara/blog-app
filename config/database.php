<?php
/**
 * Database Configuration File
 * This file handles the database connection for the blog application
 */

// Database credentials
define('DB_HOST', 'localhost');     // Database host (usually localhost)
define('DB_USER', 'root');          // Database username (default is root for XAMPP/WAMP)
define('DB_PASS', '');              // Database password (empty for local development)
define('DB_NAME', 'blog-app');      // Database name

/**
 * Get Database Connection
 * Returns a mysqli connection object
 */
function getDBConnection() {
    // Create new mysqli connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check if connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset to utf8mb4 for proper character support
    $conn->set_charset("utf8mb4");
    
    return $conn;
}

/**
 * Close Database Connection
 */
function closeDBConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}
?>