<?php
/**
 * Logout Handler
 * Destroys user session and redirects to login page
 */

require_once 'includes/auth.php';
require_once 'includes/functions.php';

// Logout user
logoutUser();

// Set flash message
setFlashMessage('success', 'You have been logged out successfully');

// Redirect to login page
redirect('login.php');
?>