/**
 * Main JavaScript File
 * Handles client-side functionality
 */

// Run when DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // ===== Character Counter for Title =====
    const titleInput = document.getElementById('title');
    const titleCount = document.getElementById('titleCount');
    
    if (titleInput && titleCount) {
        // Update count on page load
        updateTitleCount();
        
        // Update count on input
        titleInput.addEventListener('input', updateTitleCount);
        
        function updateTitleCount() {
            const length = titleInput.value.length;
            const maxLength = titleInput.getAttribute('maxlength') || 255;
            titleCount.textContent = `${length} / ${maxLength} characters`;
            
            // Change color when approaching limit
            if (length > maxLength * 0.9) {
                titleCount.style.color = '#ef4444';
            } else {
                titleCount.style.color = '#6b7280';
            }
        }
    }
    
    // ===== Character Counter for Content =====
    const contentInput = document.getElementById('content');
    const contentCount = document.getElementById('contentCount');
    
    if (contentInput && contentCount) {
        // Update count on page load
        updateContentCount();
        
        // Update count on input
        contentInput.addEventListener('input', updateContentCount);
        
        function updateContentCount() {
            const length = contentInput.value.length;
            const minLength = 50;
            contentCount.textContent = `${length} characters (minimum ${minLength})`;
            
            // Change color based on length
            if (length < minLength) {
                contentCount.style.color = '#ef4444';
            } else {
                contentCount.style.color = '#10b981';
            }
        }
    }
    
    // ===== Form Validation =====
    const blogForm = document.getElementById('blogForm');
    
    if (blogForm) {
        blogForm.addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const content = document.getElementById('content').value.trim();
            let errors = [];
            
            // Validate title
            if (title.length === 0) {
                errors.push('Title is required');
            } else if (title.length > 255) {
                errors.push('Title must not exceed 255 characters');
            }
            
            // Validate content
            if (content.length === 0) {
                errors.push('Content is required');
            } else if (content.length < 50) {
                errors.push('Content must be at least 50 characters');
            }
            
            // Show errors if any
            if (errors.length > 0) {
                e.preventDefault();
                alert('Please fix the following errors:\n\n' + errors.join('\n'));
            }
        });
    }
    
    // ===== Registration Form Validation =====
    const registerForm = document.getElementById('registerForm');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            let errors = [];
            
            // Validate username
            if (username.length < 3) {
                errors.push('Username must be at least 3 characters');
            }
            
            // Validate email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errors.push('Invalid email format');
            }
            
            // Validate password
            if (password.length < 6) {
                errors.push('Password must be at least 6 characters');
            }
            
            // Validate password match
            if (password !== confirmPassword) {
                errors.push('Passwords do not match');
            }
            
            // Show errors if any
            if (errors.length > 0) {
                e.preventDefault();
                alert('Please fix the following errors:\n\n' + errors.join('\n'));
            }
        });
    }
    
    // ===== Login Form Validation =====
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            let errors = [];
            
            // Validate email
            if (email.length === 0) {
                errors.push('Email is required');
            }
            
            // Validate password
            if (password.length === 0) {
                errors.push('Password is required');
            }
            
            // Show errors if any
            if (errors.length > 0) {
                e.preventDefault();
                alert('Please fix the following errors:\n\n' + errors.join('\n'));
            }
        });
    }
    
    // ===== Auto-hide Flash Messages =====
    const alerts = document.querySelectorAll('.alert');
    
    if (alerts.length > 0) {
        alerts.forEach(function(alert) {
            // Auto-hide success messages after 5 seconds
            if (alert.classList.contains('alert-success')) {
                setTimeout(function() {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 5000);
            }
        });
    }
    
    // ===== Confirm Delete Action =====
    const deleteButtons = document.querySelectorAll('a[href*="delete-blog.php"]');
    
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this blog post? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
    
    // ===== Mobile Menu Toggle (if needed in future) =====
    // You can add hamburger menu functionality here if you want
    
});

// ===== Helper Functions =====

/**
 * Format date to readable string
 */
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-US', options);
}

/**
 * Truncate text to specified length
 */
function truncateText(text, length) {
    if (text.length <= length) return text;
    return text.substring(0, length) + '...';
}