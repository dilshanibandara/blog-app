<?php
/**
 * Authentication Functions
 * Handles user sessions and authentication checks
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 * @return bool True if logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Require user to be logged in
 * Redirects to login page if not authenticated
 */
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = "Please login to access this page";
        header('Location: login.php');
        exit();
    }
}

/**
 * Get current logged-in user's ID
 * @return int|null User ID or null if not logged in
 */
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current logged-in user's username
 * @return string|null Username or null if not logged in
 */
function getUsername() {
    return $_SESSION['username'] ?? null;
}

/**
 * Get current logged-in user's email
 * @return string|null Email or null if not logged in
 */
function getUserEmail() {
    return $_SESSION['email'] ?? null;
}

/**
 * Login user - Create session
 * @param array $user User data from database
 */
function loginUser($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];
    
    // Regenerate session ID for security
    session_regenerate_id(true);
}

/**
 * Logout user - Destroy session
 */
function logoutUser() {
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    // Destroy the session
    session_destroy();
}

/**
 * Check if user owns a specific blog post
 * @param int $blogUserId The user_id from the blog post
 * @return bool True if current user owns the blog
 */
function isOwner($blogUserId) {
    return isLoggedIn() && getUserId() == $blogUserId;
}
?>