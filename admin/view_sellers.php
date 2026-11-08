<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

$user_id = $_SESSION['user_id'];

// Get sellers
$sellers = $conn->query("SELECT * FROM sellers ORDER BY seller_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sellers - Agro Vista Admin</title>
    
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
            min-height: 100vh;
        }
        
        .main-content {
            padding: 30px 0 50px 0;
        }
        
        .page-header {
            background: #ffffff;
            padding: 24px;
            border-radius: 14px;
            margin-bottom: 24px;
            box-shadow: var(--av-shadow-sm);
            border: 1px solid var(--av-border, #d5e0d8);
        }

        .page-header h1 {
            font-size: var(--av-text-2xl);
            font-weight: 700;
            color: var(--av-secondary, #1e4356);
            margin-bottom: 4px;
        }
    </style>
</head>
<body class="index-page">

    <?php include 'admin_header.php'; ?>
    
    <!-- Main Content -->
    <main id="main-content" class="main-content">
        <div class="container">
            
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success" role="status" aria-live="polite">
                    <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                    <span>
                        <?php
                        if ($_GET['success'] === 'seller_updated') {
                            echo 'Seller details updated successfully.';
                        } elseif ($_GET['success'] === 'seller_deleted') {
                            echo 'Seller and associated products deleted successfully.';
                        } else {
                            echo 'Operation completed successfully.';
                        }
                        ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger" role="alert" aria-live="assertive">
                    <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                    <span>
                        <?php
                        if ($_GET['error'] === 'seller_not_found') {
                            echo 'Requested seller could not be found.';
                        } else {
                            echo 'An error occurred while processing your request.';
                        }
                        ?>
                    </span>
                </div>
            <?php endif; ?>

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center gy-3">
                    <div class="col-md-7">
                        <h1><i class="bi bi-people me-2 text-success" aria-hidden="true"></i>Seller Management</h1>
                        <p class="mb-0 text-muted">Manage all registered sellers and their contact details</p>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <a href="add_seller.php" class="btn-admin">
                            <i class="bi bi-person-plus" aria-hidden="true"></i> Add New Seller
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Responsive Sellers Table (Desktop Table + Mobile Stacked Cards) -->
            <?php if ($sellers && $sellers->num_rows > 0): ?>
                <div class="table-responsive av-table-card">
                    <table class="table av-table" aria-label="Registered sellers list">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Address</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($seller = $sellers->fetch_assoc()) { ?>
                                <tr>
                                    <td data-label="Seller ID">#<?php echo (int)$seller['seller_id']; ?></td>
                                    <td data-label="Seller Name" class="fw-semibold"><?php echo htmlspecialchars($seller['seller_name']); ?></td>
                                    <td data-label="Phone">
                                        <a href="tel:<?php echo htmlspecialchars($seller['phone_number']); ?>" class="text-decoration-none">
                                            <i class="bi bi-telephone me-1" aria-hidden="true"></i><?php echo htmlspecialchars($seller['phone_number']); ?>
                                        </a>
                                    </td>
                                    <td data-label="Address"><?php echo htmlspecialchars($seller['address']); ?></td>
                                    <td data-label="Actions">
                                        <div class="av-table-actions">
                                            <a href="edit_seller.php?seller_id=<?php echo (int)$seller['seller_id']; ?>" 
                                               class="btn-admin btn-edit"
                                               aria-label="Edit seller <?php echo htmlspecialchars($seller['seller_name']); ?>">
                                                <i class="bi bi-pencil" aria-hidden="true"></i> Edit
                                            </a>
                                            <a href="delete_seller.php?seller_id=<?php echo (int)$seller['seller_id']; ?>" 
                                               class="btn-admin btn-delete" 
                                               aria-label="Delete seller <?php echo htmlspecialchars($seller['seller_name']); ?>"
                                               onclick="return confirm('Are you sure you want to delete seller &quot;<?php echo htmlspecialchars(addslashes($seller['seller_name'])); ?>&quot; and their products? This action cannot be undone.');">
                                                <i class="bi bi-trash" aria-hidden="true"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="av-table-card p-5">
                        <i class="bi bi-people" style="font-size: 3rem; color: #6c757d;" aria-hidden="true"></i>
                        <h2 class="h4 mt-3">No Sellers Found</h2>
                        <p class="text-muted mb-3">No sellers have been added yet.</p>
                        <a href="add_seller.php" class="btn-admin">
                            <i class="bi bi-person-plus" aria-hidden="true"></i> Add First Seller
                        </a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    
    <!-- Main JS File -->
    <script src="../assets/js/main.js"></script>

</body>
</html>
