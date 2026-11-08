<?php
session_start();
include '../db/DBcon.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../authentication/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Get current user data
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: ../authentication/login.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $new_user_type = isset($_POST['user_type']) ? $_POST['user_type'] : $user['user_type'];
    
    // Validate current password
    if (!password_verify($current_password, $user['password_hash'])) {
        $error = "Current password is incorrect.";
    } else {
        // Check if email already exists (and it's not the current user's email)
        if ($new_email !== $user['email']) {
            $check_email_sql = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
            $check_stmt = $conn->prepare($check_email_sql);
            $check_stmt->bind_param("si", $new_email, $user_id);
            $check_stmt->execute();
            $email_result = $check_stmt->get_result();
            
            if ($email_result->num_rows > 0) {
                $error = "Email address is already in use.";
            }
        }
        
        // Validate new password if provided
        if (!empty($new_password)) {
            if (strlen($new_password) < 6) {
                $error = "New password must be at least 6 characters long.";
            } elseif ($new_password !== $confirm_password) {
                $error = "New passwords do not match.";
            }
        }
        
        // Only admins can change user type
        if ($user['user_type'] !== 'admin' && $new_user_type !== $user['user_type']) {
            $error = "You don't have permission to change user type.";
        }
        
        // Update profile if no errors
        if (empty($error)) {
            if (!empty($new_password)) {
                // Update email, password, and user_type
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE users SET email = ?, password_hash = ?, user_type = ? WHERE user_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("sssi", $new_email, $password_hash, $new_user_type, $user_id);
            } else {
                // Update only email and user_type
                $update_sql = "UPDATE users SET email = ?, user_type = ? WHERE user_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ssi", $new_email, $new_user_type, $user_id);
            }
            
            if ($update_stmt->execute()) {
                // Update session variables
                $_SESSION['email'] = $new_email;
                $_SESSION['user_type'] = $new_user_type;
                
                // Refresh user data
                $user['email'] = $new_email;
                $user['user_type'] = $new_user_type;
                
                $message = "Profile updated successfully!";
            } else {
                $error = "Error updating profile. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Agro Vista</title>

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main & Design System CSS Files -->
    <link href="../assets/css/design-system.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--av-bg, #f6f9f7);
        }
        
        .edit-profile-container {
            min-height: 100vh;
            padding: 40px 0;
        }
        
        .profile-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: var(--av-shadow-md);
            border: 1px solid var(--av-border);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .profile-header h1 {
            color: var(--av-secondary, #1e4356);
            font-weight: 700;
            font-size: var(--av-text-2xl);
            margin-bottom: 10px;
        }
        
        .profile-header p {
            color: var(--av-text-muted);
            margin-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .btn-primary {
            background: var(--av-primary, #1b5e20);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            color: #ffffff;
            transition: all 0.25s ease;
        }
        
        .btn-primary:hover,
        .btn-primary:focus-visible {
            background: var(--av-primary-hover, #144718);
            color: #ffffff;
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: var(--av-secondary, #1e4356);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            color: #ffffff;
            transition: all 0.25s ease;
        }
        
        .btn-secondary:hover,
        .btn-secondary:focus-visible {
            background: var(--av-secondary-hover, #153140);
            color: #ffffff;
            transform: translateY(-1px);
        }
        
        .user-type-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .badge-admin {
            background: var(--av-danger, #b02a37);
            color: white;
        }
        
        .badge-user {
            background: var(--av-primary, #1b5e20);
            color: white;
        }
        
        .back-links {
            text-align: center;
            margin-top: 30px;
        }
        
        .back-links a {
            color: var(--av-primary, #1b5e20);
            text-decoration: none;
            margin: 0 15px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            min-height: 44px;
        }
        
        .back-links a:hover {
            color: var(--av-primary-hover, #144718);
            text-decoration: underline;
        }

        .password-section {
            border-top: 2px solid #e9ecef;
            padding-top: 25px;
            margin-top: 25px;
        }

        .password-section h2 {
            color: var(--av-secondary, #1e4356);
            font-size: 1.15rem;
            margin-bottom: 20px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <main id="main-content" class="edit-profile-container">
        <div class="container">
            <div class="profile-card">
                <div class="profile-header">
                    <h1>Edit Profile</h1>
                    <p>Update your account information</p>
                    <span class="user-type-badge <?php echo $user['user_type'] === 'admin' ? 'badge-admin' : 'badge-user'; ?>">
                        <?php echo htmlspecialchars(ucfirst($user['user_type'])); ?>
                    </span>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-success" role="status" aria-live="polite">
                        <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i>
                        <span><?php echo htmlspecialchars($message); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" role="alert" aria-live="assertive">
                        <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i>
                        <span><?php echo htmlspecialchars($error); ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($user['email']); ?>" autocomplete="email" required>
                    </div>

                    <?php if ($user['user_type'] === 'admin'): ?>
                    <div class="form-group">
                        <label for="user_type" class="form-label">User Type</label>
                        <select class="form-select" id="user_type" name="user_type" aria-describedby="user_type_help">
                            <option value="admin" <?php echo $user['user_type'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="user" <?php echo $user['user_type'] === 'user' ? 'selected' : ''; ?>>User</option>
                        </select>
                        <small id="user_type_help" class="form-text text-muted">Only admins can change user type.</small>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="current-password" aria-describedby="current_password_help" required>
                        <small id="current_password_help" class="form-text text-muted">Required to make any changes.</small>
                    </div>

                    <div class="password-section">
                        <h2>Change Password <small class="text-muted fw-normal">(Optional)</small></h2>
                        
                        <div class="form-group">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" 
                                   minlength="6" autocomplete="new-password" aria-describedby="new_password_help" placeholder="Leave blank to keep current password">
                            <small id="new_password_help" class="form-text text-muted">Minimum 6 characters.</small>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                   autocomplete="new-password" placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                        <button type="submit" class="btn btn-primary me-md-2" data-loading-text="Saving...">
                            <i class="bi bi-save me-1" aria-hidden="true"></i> Update Profile
                        </button>
                        <?php if ($user['user_type'] === 'admin'): ?>
                            <a href="../admin/dashboard_admin.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1" aria-hidden="true"></i> Back to Dashboard
                            </a>
                        <?php else: ?>
                            <a href="../shared/index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1" aria-hidden="true"></i> Back to Home
                            </a>
                        <?php endif; ?>
                    </div>
                </form>

                <div class="back-links">
                    <a href="../authentication/logout.php">
                        <i class="bi bi-box-arrow-right me-1" aria-hidden="true"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="../assets/js/main.js"></script>

    <script>
        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = this.value;
            
            if (newPassword && confirmPassword && newPassword !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        // Clear confirm password when new password changes
        document.getElementById('new_password').addEventListener('input', function() {
            const confirmPassword = document.getElementById('confirm_password');
            if (confirmPassword.value) {
                confirmPassword.dispatchEvent(new Event('input'));
            }
        });
    </script>
</body>
</html>
