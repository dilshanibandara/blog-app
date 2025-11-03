<?php
/**
 * Delete Blog Handler
 * Allows users to delete their own blog posts
 */

require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

// Require authentication
requireLogin();

// Get blog ID from URL
$blog_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($blog_id <= 0) {
    setFlashMessage('error', 'Invalid blog ID');
    redirect('index.php');
}

$conn = getDBConnection();

// Fetch blog post to verify ownership
$stmt = $conn->prepare("SELECT user_id FROM blogPost WHERE id = ?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    setFlashMessage('error', 'Blog post not found');
    redirect('index.php');
}

$blog = $result->fetch_assoc();
$stmt->close();

// Check if user owns this blog
if (!isOwner($blog['user_id'])) {
    setFlashMessage('error', 'You are not authorized to delete this blog post');
    redirect('index.php');
}

// Delete the blog post
$stmt = $conn->prepare("DELETE FROM blogPost WHERE id = ? AND user_id = ?");
$user_id = getUserId();
$stmt->bind_param("ii", $blog_id, $user_id);

if ($stmt->execute()) {
    setFlashMessage('success', 'Blog post deleted successfully');
} else {
    setFlashMessage('error', 'Failed to delete blog post');
}

$stmt->close();
closeDBConnection($conn);

// Redirect to home page
redirect('index.php');
?>