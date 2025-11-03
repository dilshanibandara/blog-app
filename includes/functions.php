<?php
/**
 * Helper Functions
 * Utility functions used throughout the application
 */

/**
 * Sanitize user input to prevent XSS attacks
 * @param string $data Input data
 * @return string Sanitized data
 */
function sanitizeInput($data) {
    $data = trim($data);                    // Remove whitespace
    $data = stripslashes($data);             // Remove backslashes
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Convert special characters
    return $data;
}

/**
 * Validate email format
 * @param string $email Email address
 * @return bool True if valid email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Hash password securely
 * @param string $password Plain text password
 * @return string Hashed password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify password against hash
 * @param string $password Plain text password
 * @param string $hash Hashed password from database
 * @return bool True if password matches
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Redirect to a specific page
 * @param string $page Page URL
 */
function redirect($page) {
    header("Location: $page");
    exit();
}

/**
 * Set flash message in session
 * @param string $type Message type (success, error, warning, info)
 * @param string $message Message content
 */
function setFlashMessage($type, $message) {
    $_SESSION['flash_type'] = $type;
    $_SESSION['flash_message'] = $message;
}

/**
 * Get and clear flash message
 * @return array|null Flash message array or null
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $flash = [
            'type' => $_SESSION['flash_type'],
            'message' => $_SESSION['flash_message']
        ];
        unset($_SESSION['flash_type']);
        unset($_SESSION['flash_message']);
        return $flash;
    }
    return null;
}

/**
 * Format date for display
 * @param string $date Date string from database
 * @return string Formatted date
 */
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

/**
 * Format datetime for display
 * @param string $datetime Datetime string from database
 * @return string Formatted datetime
 */
function formatDateTime($datetime) {
    return date('F j, Y \a\t g:i A', strtotime($datetime));
}

/**
 * Create excerpt from content
 * @param string $content Full content
 * @param int $length Maximum length
 * @return string Excerpt
 */
function createExcerpt($content, $length = 150) {
    if (strlen($content) <= $length) {
        return $content;
    }
    
    $excerpt = substr($content, 0, $length);
    $lastSpace = strrpos($excerpt, ' ');
    
    if ($lastSpace !== false) {
        $excerpt = substr($excerpt, 0, $lastSpace);
    }
    
    return $excerpt . '...';
}

/**
 * Escape output for HTML
 * @param string $string String to escape
 * @return string Escaped string
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>