<?php
session_start();
include '../db/DBcon.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Agro Vista</title>
    
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
    
    <!-- Custom Admin CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--av-bg, #f6f9f7);
        }
        
        .dashboard-container {
            padding: 32px 0 48px 0;
        }
        
        .dashboard-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 24px;
            box-shadow: var(--av-shadow-sm);
            border: 1px solid var(--av-border, #d5e0d8);
            height: calc(100% - 24px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--av-shadow-md);
        }
        
        .dashboard-card h2 {
            color: var(--av-secondary, #1e4356);
            font-size: var(--av-text-xl);
            font-weight: 700;
            margin-bottom: 12px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 200px), 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #ffffff;
            padding: 24px 20px;
            border-radius: 14px;
            text-align: center;
            box-shadow: var(--av-shadow-sm);
            border: 1px solid var(--av-border, #d5e0d8);
        }
        
        .stat-number {
            font-size: clamp(2rem, 1.6rem + 1.5vw, 2.75rem);
            font-weight: 700;
            color: var(--av-primary, #1b5e20);
            line-height: 1.2;
        }
        
        .stat-label {
            color: var(--av-text-muted, #4a5950);
            font-weight: 600;
            font-size: var(--av-text-sm);
            margin-top: 6px;
        }
        
        .welcome-banner {
            background: linear-gradient(135deg, #1b5e20, #1e4356);
            color: #ffffff;
            padding: 36px 28px;
            border-radius: 16px;
            margin-bottom: 28px;
            text-align: center;
            box-shadow: var(--av-shadow-md);
        }
        
        .welcome-banner h1 {
            color: #ffffff;
            font-size: var(--av-text-2xl);
            font-weight: 700;
            margin-bottom: 8px;
        }
    </style>
</head>
<body class="index-page">

    <?php include 'admin_header.php'; ?>

    <main id="main-content" class="main">
        <div class="container dashboard-container">
            
            <?php if (isset($_GET['success']) && $_GET['success'] === 'Added_Seller'): ?>
                <div class="alert alert-success" role="status" aria-live="polite">
                    <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                    <span>Seller has been added successfully!</span>
                </div>
            <?php endif; ?>

            <!-- Welcome Banner -->
            <div class="welcome-banner" data-aos="fade-up">
                <h1>Welcome to Admin Dashboard</h1>
                <p class="mb-0">Hello, <?php echo htmlspecialchars($_SESSION['name'] ?? 'Administrator'); ?>! Manage your agri-ecommerce platform efficiently.</p>
            </div>

            <!-- Statistics Grid -->
            <section aria-label="Platform Statistics">
                <h2 class="visually-hidden">Platform Statistics</h2>
                <div class="stats-grid" data-aos="fade-up" data-aos-delay="100">
                    <?php
                    // Get statistics
                    $total_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
                    $total_sellers = $conn->query("SELECT COUNT(*) as count FROM sellers")->fetch_assoc()['count'];
                    $utilized_products = $conn->query("SELECT COUNT(*) as count FROM products WHERE category = 'Utilized'")->fetch_assoc()['count'];
                    $underutilized_products = $conn->query("SELECT COUNT(*) as count FROM products WHERE category = 'UnderUtilized'")->fetch_assoc()['count'];
                    ?>
                    
                    <div class="stat-card">
                        <div class="stat-number"><?php echo (int)$total_products; ?></div>
                        <div class="stat-label">Total Products</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-number"><?php echo (int)$total_sellers; ?></div>
                        <div class="stat-label">Total Sellers</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-number"><?php echo (int)$utilized_products; ?></div>
                        <div class="stat-label">Utilized Products</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-number"><?php echo (int)$underutilized_products; ?></div>
                        <div class="stat-label">UnderUtilized Fruits</div>
                    </div>
                </div>
            </section>

            <!-- Action Cards -->
            <div class="row g-4 mb-2" data-aos="fade-up" data-aos-delay="200">
                <div class="col-lg-6">
                    <div class="dashboard-card">
                        <div>
                            <h2><i class="bi bi-box-seam me-2 text-success" aria-hidden="true"></i>Product Management</h2>
                            <p class="text-muted">Manage all products including both utilized and underutilized categories.</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <a href="view_products.php" class="btn-admin">
                                <i class="bi bi-eye" aria-hidden="true"></i> View All Products
                            </a>
                            <a href="add_product.php" class="btn-admin">
                                <i class="bi bi-plus-circle" aria-hidden="true"></i> Add New Product
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="dashboard-card">
                        <div>
                            <h2><i class="bi bi-people me-2 text-success" aria-hidden="true"></i>Seller Management</h2>
                            <p class="text-muted">Manage seller accounts and their contact information.</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <a href="view_sellers.php" class="btn-admin">
                                <i class="bi bi-eye" aria-hidden="true"></i> View All Sellers
                            </a>
                            <a href="add_seller.php" class="btn-admin">
                                <i class="bi bi-person-plus" aria-hidden="true"></i> Add New Seller
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="dashboard-card mt-3" data-aos="fade-up" data-aos-delay="300">
                <h2><i class="bi bi-lightning me-2 text-success" aria-hidden="true"></i>Quick Actions</h2>
                <div class="row g-3 mt-1">
                    <div class="col-sm-6 col-md-4">
                        <a href="../shared/index.php" class="btn-admin w-100">
                            <i class="bi bi-house" aria-hidden="true"></i> View Frontend
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <a href="../shared/edit_profile.php" class="btn-admin btn-secondary w-100">
                            <i class="bi bi-person-gear" aria-hidden="true"></i> Edit Profile
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <a href="../authentication/logout.php" class="btn-admin btn-danger w-100">
                            <i class="bi bi-box-arrow-right" aria-hidden="true"></i> Logout
                        </a>
                    </div>
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
