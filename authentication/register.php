<?php
session_start();
include '../db/DBcon.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['pass'];
    $confirm_password = $_POST['re_pass'];
    
    // Validation
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        // Check if email already exists
        $check_sql = "SELECT * FROM users WHERE email = '$email'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            $error = "Email already exists. Please use a different email.";
        } else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : 'admin'; // Default to admin for this registration
            
            $sql = "INSERT INTO users (email, password_hash, user_type) 
                    VALUES ('$email', '$password_hash', '$user_type')";

            if ($conn->query($sql) === TRUE) {
                header("Location: login.php?success=registered");
                exit;
            } else {
                $error = "Error: " . $conn->error;
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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Registration | Agro Vista</title>

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    
    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/design-system.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #eef3f0 0%, #d5e0d8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        
        .register-container {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(27, 43, 34, 0.12);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
            min-height: 580px;
            border: 1px solid var(--av-border, #d5e0d8);
        }
        
        .register-image {
            flex: 1;
            background: linear-gradient(135deg, #1b5e20, #1e4356);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #ffffff;
            padding: 40px;
            position: relative;
        }
        
        .register-image h2 {
            font-size: clamp(1.75rem, 1.4rem + 1.5vw, 2.4rem);
            font-weight: 700;
            margin-bottom: 16px;
            text-align: center;
            color: #ffffff;
        }
        
        .register-image p {
            font-size: 1.05rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.92);
            margin-bottom: 10px;
        }
        
        .register-form {
            flex: 1;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-title {
            font-size: clamp(1.5rem, 1.3rem + 0.8vw, 2rem);
            font-weight: 700;
            color: #1e4356;
            margin-bottom: 8px;
            text-align: center;
        }
        
        .form-subtitle {
            color: #4a5950;
            text-align: center;
            margin-bottom: 24px;
        }
        
        .form-group {
            margin-bottom: 18px;
        }

        .input-with-icon {
            position: relative;
        }
        
        .form-control,
        .form-select {
            width: 100%;
            padding: 12px 16px 12px 46px;
            border: 2px solid #cbd5ce;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.25s ease;
            background: #ffffff;
            color: #1f2923;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: #1b5e20;
            background: #ffffff;
        }
        
        .form-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #1b5e20;
            font-size: 18px;
            pointer-events: none;
        }
        
        .btn-register {
            background: #1b5e20;
            color: #ffffff;
            border: none;
            padding: 14px 32px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            transition: all 0.25s ease;
            margin-top: 12px;
        }
        
        .btn-register:hover,
        .btn-register:focus-visible {
            background: #144718;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(27, 94, 32, 0.25);
        }
        
        .back-link {
            text-align: center;
            margin-top: 16px;
        }
        
        .back-link a,
        .login-link a {
            color: #1b5e20;
            text-decoration: none;
            font-weight: 600;
        }
        
        .back-link a:hover,
        .login-link a:hover {
            color: #144718;
            text-decoration: underline;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #e9ecef;
        }
        
        @media (max-width: 767.98px) {
            .register-container {
                flex-direction: column;
            }
            
            .register-image {
                padding: 28px 20px;
            }
            
            .register-form {
                padding: 32px 20px;
            }
        }
    </style>
</head>
<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <main id="main-content" class="w-100 d-flex justify-content-center">
        <div class="register-container">
            <!-- Register Image/Branding Side -->
            <div class="register-image">
                <h2>Agro Vista</h2>
                <p>Join the Agricultural E-Commerce Platform</p>
                <p class="mb-0">Create an account to access the marketplace</p>
            </div>

            <!-- Register Form Side -->
            <div class="register-form">
                <h1 class="form-title">User Registration</h1>
                <p class="form-subtitle">Create your account to access Agro Vista</p>
                
                <?php if (isset($_GET['success']) && $_GET['success'] == 'registered') { ?>
                    <div class="success-message av-alert av-alert-success" role="status" aria-live="polite">
                        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                        <span>Registration successful! You can now sign in.</span>
                    </div>
                <?php } ?>
                
                <?php if (!empty($error)) { ?>
                    <div class="error-message av-alert av-alert-danger" role="alert" aria-live="assertive">
                        <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                        <span><?php echo htmlspecialchars($error); ?></span>
                    </div>
                <?php } ?>

                <div id="client-error-banner" class="error-message av-alert av-alert-danger d-none" role="alert" aria-live="assertive">
                    <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                    <span id="client-error-text"></span>
                </div>
                
                <form method="POST" id="register-form" action="">
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-with-icon">
                            <i class="bi bi-envelope form-icon" aria-hidden="true"></i>
                            <input type="email" name="email" id="email" class="form-control" 
                                   placeholder="you@example.com" autocomplete="email" required />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="pass" class="form-label">Password <small class="text-muted fw-normal">(min. 6 characters)</small></label>
                        <div class="input-with-icon">
                            <i class="bi bi-lock form-icon" aria-hidden="true"></i>
                            <input type="password" name="pass" id="pass" class="form-control" 
                                   placeholder="Create a password" autocomplete="new-password" required minlength="6" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="re_pass" class="form-label">Confirm Password</label>
                        <div class="input-with-icon">
                            <i class="bi bi-lock-fill form-icon" aria-hidden="true"></i>
                            <input type="password" name="re_pass" id="re_pass" class="form-control" 
                                   placeholder="Confirm your password" autocomplete="new-password" required />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="user_type" class="form-label">Account Role</label>
                        <div class="input-with-icon">
                            <i class="bi bi-person-badge form-icon" aria-hidden="true"></i>
                            <select name="user_type" id="user_type" class="form-select" required>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" name="signup" class="btn-register" data-loading-text="Creating Account...">
                        <i class="bi bi-person-plus" aria-hidden="true"></i> Create Account
                    </button>
                </form>
                
                <div class="login-link">
                    <p class="mb-0">Already have an account? 
                       <a href="login.php">Sign in here</a>
                    </p>
                </div>
                
                <div class="back-link">
                    <a href="../shared/index.php">
                        <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to Main Site
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Vendor & Main JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
    
    <!-- Accessible Password Confirmation Script -->
    <script>
        document.getElementById('register-form').addEventListener('submit', function(e) {
            const password = document.getElementById('pass').value;
            const confirmPassword = document.getElementById('re_pass').value;
            const errorBanner = document.getElementById('client-error-banner');
            const errorText = document.getElementById('client-error-text');
            
            if (password !== confirmPassword) {
                e.preventDefault();
                errorText.textContent = 'Passwords do not match. Please verify and try again.';
                errorBanner.classList.remove('d-none');
                document.getElementById('re_pass').focus();
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                errorText.textContent = 'Password must be at least 6 characters long.';
                errorBanner.classList.remove('d-none');
                document.getElementById('pass').focus();
                return false;
            }

            errorBanner.classList.add('d-none');
        });
    </script>

</body>
</html>
