<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

// Get all sellers from the database
$sellers_query = "SELECT seller_id, seller_name FROM sellers";
$sellers_result = $conn->query($sellers_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debug: Log file upload info
    error_log("File upload debug - POST received");
    if (isset($_FILES['video_file'])) {
        error_log("File info: " . print_r($_FILES['video_file'], true));
    }
    
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $seller_id = mysqli_real_escape_string($conn, $_POST['seller_id']);
    
    // Validate required fields
    if (empty($name) || empty($category) || empty($seller_id)) {
        $error_message = "Product name, category, and seller are required.";
    } else {
        // Handle video file upload
        $video_url = null;
        
        // Check if a file was uploaded
        if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
            // Determine the upload directory based on category
            $category_path = strtolower($category); // 'Utilized' or 'UnderUtilized'
            
            if ($category_path === 'utilized') {
                // For utilized products, determine subcategory based on product name
                $subcategory = 'general'; // default
                $product_name_lower = strtolower($name);
                
                if (preg_match('/cinnamon|spice|bark/', $product_name_lower)) {
                    $subcategory = 'cinnamon';
                } elseif (preg_match('/kithul|palm|treacle|jaggery/', $product_name_lower)) {
                    $subcategory = 'kithul';
                } elseif (preg_match('/tea|ceylon|black tea|green tea/', $product_name_lower)) {
                    $subcategory = 'tea';
                } elseif (preg_match('/fish|dried|seafood|maldive/', $product_name_lower)) {
                    $subcategory = 'dry_fish';
                }
                
                $upload_dir = "../assets/videos/products/utilized/{$subcategory}/";
            } else {
                // For underutilized products
                $upload_dir = '../assets/videos/products/underutilized/';
            }
            
            // Create directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_extension = strtolower(pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['mp4', 'webm', 'ogg', 'avi', 'mov'];
            
            if (in_array($file_extension, $allowed_extensions)) {
                $file_name = uniqid() . '.' . $file_extension;
                $target_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['video_file']['tmp_name'], $target_path)) {
                    // Store relative path for database (without ../)
                    $video_url = str_replace('../', '', $target_path);
                } else {
                    $error_message = "Error uploading video file. Please try again.";
                }
            } else {
                $error_message = "Invalid video format. Please upload MP4, WebM, OGG, AVI, or MOV files.";
            }
        } else {
            // Check for upload errors
            if (isset($_FILES['video_file'])) {
                switch ($_FILES['video_file']['error']) {
                    case UPLOAD_ERR_NO_FILE:
                        $error_message = "Please select a video file to upload.";
                        break;
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $error_message = "Video file is too large. Please choose a smaller file.";
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $error_message = "Video file upload was interrupted. Please try again.";
                        break;
                    default:
                        $error_message = "Error uploading video file. Please try again.";
                        break;
                }
            } else {
                $error_message = "Please select a video file to upload.";
            }
        }
        
        // Insert product if no errors
        if (!isset($error_message)) {
            $sql = "INSERT INTO products (seller_id, name, category, video_url) 
                    VALUES ('$seller_id', '$name', '$category', '$video_url')";

            if ($conn->query($sql) === TRUE) {
                header("Location: view_products.php?success=product_added");
                exit;
            } else {
                $error_message = "Error: " . $conn->error;
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
    <title>Add Product | Agro Vista Admin</title>

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
        
        .form-body {
            padding: 36px;
        }
        
        .category-info {
            background: #eef3f0;
            border: 1px solid #cbd5ce;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 28px;
        }

        .category-info h2 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1e4356;
            margin-bottom: 10px;
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
        
        .form-help {
            font-size: 0.85rem;
            color: #4a5950;
            margin-top: 6px;
        }
        
        .form-control[type="file"] {
            padding: 8px 12px;
        }
        
        .form-control[type="file"]::-webkit-file-upload-button {
            background: #1b5e20;
            color: #ffffff;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            margin-right: 12px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .form-control[type="file"]::-webkit-file-upload-button:hover {
            background: #144718;
        }
    </style>
</head>
<body class="index-page">

    <?php include 'admin_header.php'; ?>

    <main id="main-content" class="main">
        <div class="container">
            <div class="form-container" data-aos="fade-up">
                <div class="form-header">
                    <h1><i class="bi bi-plus-circle me-2" aria-hidden="true"></i>Add New Product</h1>
                    <p class="mb-0">Add products with demonstration video files to your agricultural marketplace</p>
                </div>
                
                <div class="form-body">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert" aria-live="assertive">
                            <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                            <span><?php echo htmlspecialchars($error_message); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="category-info">
                        <h2><i class="bi bi-info-circle me-1" aria-hidden="true"></i> Category Information</h2>
                        <ul class="mb-0">
                            <li><strong>Utilized Products:</strong> Traditional Sri Lankan products like Cinnamon, Kithul, Tea, and Dry Fish</li>
                            <li><strong>UnderUtilized Fruits:</strong> Indigenous and rare fruits that are underutilized in the market</li>
                        </ul>
                    </div>
                    
                    <form method="POST" enctype="multipart/form-data" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="seller_id" class="form-label">
                                        <i class="bi bi-person" aria-hidden="true"></i> Select Seller
                                    </label>
                                    <select name="seller_id" id="seller_id" class="form-select" required>
                                        <option value="">Choose a seller...</option>
                                        <?php while ($seller = $sellers_result->fetch_assoc()) { ?>
                                            <option value="<?php echo (int)$seller['seller_id']; ?>">
                                                <?php echo htmlspecialchars($seller['seller_name']); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category" class="form-label">
                                        <i class="bi bi-tag" aria-hidden="true"></i> Product Category
                                    </label>
                                    <select name="category" id="category" class="form-select" required>
                                        <option value="">Select category...</option>
                                        <option value="Utilized">Utilized Products (Cinnamon, Kithul, Tea, Dry Fish)</option>
                                        <option value="UnderUtilized">UnderUtilized Fruits</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="product_name" class="form-label">
                                <i class="bi bi-box-seam" aria-hidden="true"></i> Product Name
                            </label>
                            <input type="text" name="product_name" id="product_name" class="form-control" placeholder="e.g., Pure Ceylon Cinnamon Quills" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="video_file" class="form-label">
                                <i class="bi bi-camera-video" aria-hidden="true"></i> Video File
                            </label>
                            <input type="file" name="video_file" id="video_file" class="form-control" 
                                   accept=".mp4,.webm,.ogg,.avi,.mov" aria-describedby="video_file_help" required />
                            <div id="video_file_help" class="form-help">
                                Upload a demonstration video file. Supported formats: MP4, WebM, OGG, AVI, MOV.
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" name="add_product" class="btn-submit" data-loading-text="Uploading & Adding Product...">
                                <i class="bi bi-plus-circle" aria-hidden="true"></i> Add Product
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="view_products.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to Products
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
