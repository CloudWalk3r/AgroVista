<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

$user_id = $_SESSION['user_id'];

// Get filter parameter
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Build query based on filter
$query = "
    SELECT p.*, s.seller_name 
    FROM products p 
    LEFT JOIN sellers s ON p.seller_id = s.seller_id 
";

if ($category_filter) {
    $query .= " WHERE p.category = '" . mysqli_real_escape_string($conn, $category_filter) . "'";
}

$query .= " ORDER BY p.product_id DESC";

$products = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products - Agro Vista Admin</title>
    
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
        
        .filter-section {
            background: #ffffff;
            padding: 20px 24px;
            border-radius: 14px;
            margin-bottom: 24px;
            box-shadow: var(--av-shadow-sm);
            border: 1px solid var(--av-border, #d5e0d8);
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
                        if ($_GET['success'] === 'product_added') {
                            echo 'Product was added successfully.';
                        } elseif ($_GET['success'] === 'product_updated') {
                            echo 'Product was updated successfully.';
                        } elseif ($_GET['success'] === 'product_deleted') {
                            echo 'Product was deleted successfully.';
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
                        if ($_GET['error'] === 'product_not_found') {
                            echo 'Requested product could not be found.';
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
                        <h1><i class="bi bi-box-seam me-2 text-success" aria-hidden="true"></i>Product Management</h1>
                        <p class="mb-0 text-muted">View, filter, edit, or remove products across the marketplace</p>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <a href="add_product.php" class="btn-admin">
                            <i class="bi bi-plus-circle" aria-hidden="true"></i> Add New Product
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Filter Section -->
            <div class="filter-section">
                <form method="GET" action="view_products.php" class="row align-items-center gy-3">
                    <div class="col-md-5">
                        <label for="category-filter" class="form-label mb-0 fw-bold fs-6">
                            <i class="bi bi-funnel me-1 text-success" aria-hidden="true"></i> Filter by Category
                        </label>
                    </div>
                    <div class="col-md-7">
                        <div class="d-flex flex-wrap flex-sm-nowrap gap-2">
                            <select id="category-filter" name="category" class="form-select" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                <option value="Utilized" <?php echo ($category_filter == 'Utilized') ? 'selected' : ''; ?>>Utilized Products</option>
                                <option value="UnderUtilized" <?php echo ($category_filter == 'UnderUtilized') ? 'selected' : ''; ?>>UnderUtilized Fruits</option>
                            </select>
                            <button type="submit" class="btn btn-outline-success">Apply</button>
                            <?php if ($category_filter): ?>
                                <a href="view_products.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-lg" aria-hidden="true"></i> Clear
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Responsive Products Table (Desktop Table + Mobile Stacked Cards) -->
            <?php if ($products && $products->num_rows > 0): ?>
                <div class="table-responsive av-table-card">
                    <table class="table av-table" aria-label="Products list">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Seller</th>
                                <th scope="col">Video</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($product = $products->fetch_assoc()) {
                                $video_href = $product['video_url'] ?? '';
                                if (!empty($video_href) && strpos($video_href, 'http') !== 0 && strpos($video_href, '../') !== 0) {
                                    $video_href = '../' . ltrim($video_href, '/');
                                }
                            ?>
                                <tr>
                                    <td data-label="Product ID">#<?php echo (int)$product['product_id']; ?></td>
                                    <td data-label="Product Name" class="fw-semibold"><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td data-label="Category">
                                        <span class="category-badge <?php echo $product['category'] == 'Utilized' ? 'category-utilized' : 'category-underutilized'; ?>">
                                            <?php echo htmlspecialchars($product['category']); ?>
                                        </span>
                                    </td>
                                    <td data-label="Seller"><?php echo htmlspecialchars($product['seller_name'] ?? 'Unknown'); ?></td>
                                    <td data-label="Video">
                                        <?php if (!empty($video_href)): ?>
                                            <a href="<?php echo htmlspecialchars($video_href); ?>" target="_blank" rel="noopener noreferrer" class="fw-semibold">
                                                <i class="bi bi-play-circle-fill me-1" aria-hidden="true"></i>Watch Video
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">None</span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Actions">
                                        <div class="av-table-actions">
                                            <a href="edit_product.php?product_id=<?php echo (int)$product['product_id']; ?>" 
                                               class="btn-admin btn-edit"
                                               aria-label="Edit <?php echo htmlspecialchars($product['name']); ?>">
                                                <i class="bi bi-pencil" aria-hidden="true"></i> Edit
                                            </a>
                                            <a href="delete_product.php?product_id=<?php echo (int)$product['product_id']; ?>" 
                                               class="btn-admin btn-delete" 
                                               aria-label="Delete <?php echo htmlspecialchars($product['name']); ?>"
                                               onclick="return confirm('Are you sure you want to delete the product &quot;<?php echo htmlspecialchars(addslashes($product['name'])); ?>&quot;? This action cannot be undone.');">
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
                        <i class="bi bi-box-seam" style="font-size: 3rem; color: #6c757d;" aria-hidden="true"></i>
                        <h2 class="h4 mt-3">No Products Found</h2>
                        <p class="text-muted mb-3">
                            <?php if ($category_filter): ?>
                                No products found in the "<?php echo htmlspecialchars($category_filter); ?>" category.
                            <?php else: ?>
                                No products have been added yet.
                            <?php endif; ?>
                        </p>
                        <a href="add_product.php" class="btn-admin">
                            <i class="bi bi-plus-circle" aria-hidden="true"></i> Add First Product
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
