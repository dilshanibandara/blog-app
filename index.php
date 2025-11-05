<?php
/**
 * Home Page - Blog List
 * Displays all blog posts
 */

require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$flash = getFlashMessage();

// Fetch all blog posts with author information
$conn = getDBConnection();
$query = "SELECT blogpost.*, user.username 
          FROM blogpost 
          INNER JOIN user ON blogpost.user_id = user.id 
          ORDER BY blogpost.created_at DESC";
$result = $conn->query($query);
$blogs = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
}

closeDBConnection($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog App - Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container nav-container">
            <a href="index.php" class="logo">
    <img src="assets/images/logo.png" alt="BlogApp" class="logo-image">
    <span class="logo-text">BlogApp</span>
</a>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <?php if (isLoggedIn()): ?>
                     <li><span class="nav-user">Hello, <?php echo e(getUsername()); ?></span></li>
                    <li><a href="create-blog.php" class="btn btn-primary btn-sm">Create Blog</a></li>
                    <li><a href="logout.php" class="btn btn-secondary btn-sm">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn btn-secondary btn-sm">Login</a></li>
                    <li><a href="register.php" class="btn btn-primary btn-sm">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container main-content">
        <div class="page-header">
            <h1>Latest Blog Posts</h1>
            
            
        </div>
        <?php if (isLoggedIn()): ?>
                <a href="create-blog.php" class="btn btn-primary">
                    <span>+</span> New Post
                </a>
            <?php endif; ?>

        <?php if ($flash): ?>
            <div class="alert alert-<?php echo e($flash['type']); ?>">
                <?php echo e($flash['message']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($blogs)): ?>
            <div class="empty-state">
                <h2>No blog posts yet</h2>
                <p>Be the first to create a blog post!</p>
                <?php if (isLoggedIn()): ?>
                    <a href="create-blog.php" class="btn btn-primary">Create First Post</a>
                <?php else: ?>
                    <a href="register.php" class="btn btn-primary">Register to Post</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="blog-grid">
                <?php foreach ($blogs as $blog): ?>
                    <article class="blog-card">
                        <div class="blog-card-header">
                            <h2>
                                <a href="view-blog.php?id=<?php echo $blog['id']; ?>">
                                    <?php echo e($blog['title']); ?>
                                </a>
                            </h2>
                        </div>
                        <div class="blog-card-body">
                            <p><?php echo e(createExcerpt($blog['content'], 150)); ?></p>
                        </div>
                        <div class="blog-card-footer">
                            <div class="blog-meta">
                                <span class="blog-author">
                                    By <?php echo e($blog['username']); ?>
                                </span>
                                <span class="blog-date">
                                    <?php echo formatDate($blog['created_at']); ?>
                                </span>
                            </div>
                            <div class="blog-actions">
                                <a href="view-blog.php?id=<?php echo $blog['id']; ?>" class="btn btn-sm btn-secondary">
                                    Read More
                                </a>
                                <?php if (isOwner($blog['user_id'])): ?>
                                    <a href="edit-blog.php?id=<?php echo $blog['id']; ?>" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                    <a href="delete-blog.php?id=<?php echo $blog['id']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this blog?');">
                                        Delete
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 BlogApp. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>