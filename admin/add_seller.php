<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "INSERT INTO sellers (seller_name, phone_number, address) 
            VALUES ('$name', '$phone', '$address')";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard_admin.php?success=Added_Seller");
        exit;
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Seller | Agro Vista Admin</title>

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
    
    <!-- Main & Design System CSS Files -->
    <link href="../assets/css/design-system.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--av-bg, #f6f9f7);
        }
        
        .form-container {
            max-width: 800px;
            margin: 32px auto 48px auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: var(--av-shadow-md);
            border: 1px solid var(--av-border, #d5e0d8);
            overflow: hidden;
        }
        
        .form-header {
            background: linear-gradient(135deg, #1b5e20, #1e4356);
            color: #ffffff;
            padding: 28px 24px;
            text-align: center;
        }

        .form-header h1 {
            color: #ffffff;
            font-size: var(--av-text-2xl);
            font-weight: 700;
            margin-bottom: 6px;
        }
        
        .form-group {
            margin-bottom: 22px;
        }
        
        .form-label {
            font-weight: 600;
            color: #1f2923;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }
        
        .form-label i {
            margin-right: 8px;
            color: #1b5e20;
        }
        
        .btn-submit {
            background: #1b5e20;
            color: #ffffff;
            border: none;
            padding: 14px 36px;
            border-radius: 999px;
            font-weight: 600;
            width: 100%;
            transition: all 0.25s ease;
        }
        
        .btn-submit:hover,
        .btn-submit:focus-visible {
            background: #144718;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(27, 94, 32, 0.25);
        }
    </style>
</head>
<body class="index-page">

    <?php include 'admin_header.php'; ?>

    <main id="main-content" class="main">
        <div class="container">
            <div class="form-container" data-aos="fade-up">
                <div class="form-header">
                    <h1><i class="bi bi-person-plus me-2" aria-hidden="true"></i>Add New Seller</h1>
                    <p class="mb-0">Register a new seller to the marketplace</p>
                </div>
                
                <div class="form-body p-4">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert" aria-live="assertive">
                            <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                            <span><?php echo htmlspecialchars($error_message); ?></span>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="bi bi-person" aria-hidden="true"></i> Seller Name
                            </label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   placeholder="Enter seller's full name" autocomplete="name" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">
                                <i class="bi bi-telephone" aria-hidden="true"></i> Phone Number
                            </label>
                            <input type="tel" name="phone" id="phone" class="form-control" 
                                   placeholder="e.g., +94 71 234 5678" autocomplete="tel" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="address" class="form-label">
                                <i class="bi bi-geo-alt" aria-hidden="true"></i> Address
                            </label>
                            <textarea name="address" id="address" class="form-control" rows="3"
                                      placeholder="Enter complete business or farm address" autocomplete="street-address" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-submit" data-loading-text="Adding Seller...">
                                <i class="bi bi-check-circle" aria-hidden="true"></i> Add Seller
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="view_sellers.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to Sellers
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    
    <!-- Main JS File -->
    <script src="../assets/js/main.js"></script>

</body>
</html>
