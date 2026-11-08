<?php
include 'session_active.php';
include '../db/DBcon.php';

$page_title = 'Dry Fish';
$category_type = 'dry_fish';

// Fetch products with category "Utilized" and filter by dry fish-related names
$sql = "SELECT p.*, s.seller_name 
        FROM products p 
        JOIN sellers s ON p.seller_id = s.seller_id 
        WHERE p.category = 'Utilized' 
        AND (LOWER(p.name) LIKE '%fish%' OR LOWER(p.name) LIKE '%dried%' OR LOWER(p.name) LIKE '%seafood%' OR LOWER(p.name) LIKE '%maldive%')
        ORDER BY p.product_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo htmlspecialchars($page_title); ?> - Agro Vista</title>
  <meta name="description" content="Discover premium dried fish products from Sri Lankan coastal fishermen">
  <meta name="keywords" content="dry fish, dried fish, seafood, maldive fish, sri lanka, coastal">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main & Design System CSS Files -->
  <link href="../assets/css/design-system.css" rel="stylesheet">
  <link href="../assets/css/main.css" rel="stylesheet">

  <!-- Custom CSS for Products -->
  <style>
    .product-category-badge {
      background: #1e4356;
      color: #ffffff;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
    }

    .no-products {
      padding: 60px 20px;
      text-align: center;
      background: #ffffff;
      border: 1px solid var(--av-border, #d5e0d8);
      border-radius: 16px;
      margin: 20px 0;
      box-shadow: var(--av-shadow-sm);
    }

    .no-products h3 {
      color: #1e4356;
      margin-bottom: 16px;
    }
  </style>
</head>

<body class="team-page">

  <a href="#main-content" class="skip-link">Skip to main content</a>

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center" aria-label="Agro Vista Home">
        <img src="../assets/img/logo.png" alt="Agro Vista logo" width="32" height="32" style="border-radius: 50%;" onerror="this.style.display='none'">
        <span class="sitename">Agro Vista</span>
      </a>

      <nav id="navmenu" class="navmenu" aria-label="Primary navigation">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="products.php" class="active" aria-current="page">Products</a></li>
          <li><a href="ufruits.php">Underutilized Fruits</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <button type="button" class="mobile-nav-toggle d-xl-none" aria-controls="navmenu" aria-expanded="false" aria-label="Open navigation menu">
          <i class="bi bi-list" aria-hidden="true"></i>
        </button>
      </nav>

    </div>
  </header>

  <main id="main-content" class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container position-relative">
        <h1><?php echo htmlspecialchars($page_title); ?></h1>
        <p>
          Experience the rich flavors of the ocean with our premium dried fish products. Sourced from the pristine coastal waters of Sri Lanka and processed using traditional sun-drying methods, our dried fish collection offers authentic taste and exceptional quality that has been treasured for generations.
        </p>
        <nav class="breadcrumbs" aria-label="Breadcrumb">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li class="current" aria-current="page"><?php echo htmlspecialchars($page_title); ?></li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Products Section -->
    <section id="products" class="team section">

      <div class="container">
        <h2 class="visually-hidden">Available <?php echo htmlspecialchars($page_title); ?> Products</h2>
        <div class="row gy-4">

          <?php
          if ($result && $result->num_rows > 0) {
              $default_images = ['dry_fish.jpg'];
              $image_index = 0;
              
              while($row = $result->fetch_assoc()) {
                  $display_image = "../assets/img/products/" . $default_images[$image_index % count($default_images)];
                  $image_index++;
                  
                  $video_url = $row['video_url'];
                  $video_id = '';
                  $video_type = '';
                  
                  if (!empty($video_url)) {
                      // Check if it's a YouTube video
                      if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $matches)) {
                          $video_id = $matches[1];
                          $video_type = 'youtube';
                      }
                      // Check if it's a Vimeo video
                      elseif (preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches)) {
                          $video_id = $matches[1];
                          $video_type = 'vimeo';
                      }
                      // Check for local video files (relative paths or file extensions)
                      elseif (preg_match('/\.(mp4|webm|ogg|avi|mov)$/i', $video_url) || 
                              strpos($video_url, 'assets/') === 0 || 
                              strpos($video_url, '../assets/') === 0 ||
                              strpos($video_url, '/assets/') !== false) {
                          $video_type = 'local';
                          // Ensure proper path for local videos
                          if (strpos($video_url, '../') !== 0 && strpos($video_url, 'http') !== 0) {
                              // If it's just a filename or relative path, construct full path
                              if (strpos($video_url, 'assets/') === 0) {
                                  $video_url = '../' . $video_url;
                              } elseif (!preg_match('/^\.\.\//', $video_url)) {
                                  // Default to dry_fish category folder for local files
                                  $video_url = '../assets/videos/products/utilized/dry_fish/' . basename($video_url);
                              }
                          }
                      }
                      // Default to iframe for other URLs
                      else {
                          $video_type = 'iframe';
                      }
                  }
                  
                  $product_id = 'product_' . (int)$row['product_id'];
          ?>
          <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="100">
            <article class="member-card">
              <div class="member-img">
                <img src="<?php echo htmlspecialchars($display_image); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['name'] . ' by ' . $row['seller_name']); ?>" width="400" height="250" loading="lazy" decoding="async">
                <?php if (!empty($video_url)): ?>
                  <button type="button" class="video-overlay" onclick="openVideoModal('<?php echo $product_id; ?>', this)" aria-label="Watch video demonstration for <?php echo htmlspecialchars($row['name']); ?>">
                    <i class="bi bi-play-circle-fill play-btn" aria-hidden="true"></i>
                    <span class="play-label">Watch Video</span>
                  </button>
                <?php endif; ?>
                <div class="social p-2">
                  <span class="product-category-badge"><?php echo htmlspecialchars($page_title); ?></span>
                </div>
              </div>
              <div class="member-info text-center">
                <div>
                  <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                  <p class="seller-meta mb-0">
                    <i class="bi bi-person-check" aria-hidden="true"></i>
                    <span>Seller: <?php echo htmlspecialchars($row['seller_name']); ?></span>
                  </p>
                </div>
                <?php if (!empty($video_url)): ?>
                  <div class="product-actions mt-3">
                    <button type="button" onclick="openVideoModal('<?php echo $product_id; ?>', this)" class="btn btn-admin btn-sm w-100">
                      <i class="bi bi-play-circle" aria-hidden="true"></i> Watch Video
                    </button>
                  </div>
                <?php endif; ?>
              </div>
            </article>
            
            <?php if (!empty($video_url)): ?>
            <!-- Video Modal -->
            <div id="<?php echo $product_id; ?>_modal" class="video-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="<?php echo $product_id; ?>_title">
              <div class="video-modal-content">
                <div class="video-modal-header">
                  <h3 id="<?php echo $product_id; ?>_title" class="video-modal-title"><?php echo htmlspecialchars($row['name']); ?></h3>
                  <button type="button" class="video-close" onclick="closeVideoModal('<?php echo $product_id; ?>')" aria-label="Close video modal">
                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                  </button>
                </div>
                <?php if ($video_type === 'youtube'): ?>
                  <iframe id="<?php echo $product_id; ?>_iframe" src="" 
                          title="<?php echo htmlspecialchars($row['name']); ?> video player"
                          allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                          allowfullscreen
                          data-src="https://www.youtube.com/embed/<?php echo htmlspecialchars($video_id); ?>"></iframe>
                <?php elseif ($video_type === 'vimeo'): ?>
                  <iframe id="<?php echo $product_id; ?>_iframe" src="" 
                          title="<?php echo htmlspecialchars($row['name']); ?> video player"
                          allow="fullscreen; picture-in-picture" 
                          allowfullscreen
                          data-src="https://player.vimeo.com/video/<?php echo htmlspecialchars($video_id); ?>"></iframe>
                <?php elseif ($video_type === 'local'): ?>
                  <video id="<?php echo $product_id; ?>_video" controls muted playsinline preload="metadata">
                    <source src="<?php echo htmlspecialchars($video_url); ?>" 
                            type="video/<?php echo htmlspecialchars(pathinfo($video_url, PATHINFO_EXTENSION)); ?>">
                    <p>Your browser does not support the video tag. Video path: <?php echo htmlspecialchars($video_url); ?></p>
                  </video>
                <?php else: ?>
                  <iframe id="<?php echo $product_id; ?>_iframe" src=""
                          title="<?php echo htmlspecialchars($row['name']); ?> video player"
                          allowfullscreen
                          data-src="<?php echo htmlspecialchars($video_url); ?>"></iframe>
                <?php endif; ?>
              </div>
            </div>
            <?php endif; ?>
          </div><!-- End Product -->
          <?php
              }
          } else {
          ?>
          <div class="col-12 text-center">
            <div class="no-products" role="status">
              <i class="bi bi-box-seam fs-1 text-muted mb-2 d-block" aria-hidden="true"></i>
              <h3>No Dry Fish Products Available</h3>
              <p>We're currently updating our dried fish inventory. Please check back soon for premium dried fish products!</p>
              <a href="products.php" class="btn btn-admin mt-3">View All Product Categories</a>
            </div>
          </div>
          <?php } ?>

        </div>

      </div>

    </section><!-- /Products Section -->

  </main>

  <footer id="footer" class="footer dark-background">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.php" class="d-flex align-items-center">
            <span class="sitename">Agro Vista</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Faculty of Agricultural Sciences</p>
            <p>Sabaragamuwa University of Sri Lanka</p>
            <p class="mt-3"><strong>Email:</strong> <span>agribizdigitaltradefair@gmail.com</span></p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right" aria-hidden="true"></i> <a href="index.php">Home</a></li>
            <li><i class="bi bi-chevron-right" aria-hidden="true"></i> <a href="products.php">Products</a></li>
            <li><i class="bi bi-chevron-right" aria-hidden="true"></i> <a href="ufruits.php">Underutilized Fruits</a></li>
            <li><i class="bi bi-chevron-right" aria-hidden="true"></i> <a href="contact.php">Contact</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Follow Us</h4>
          <p>Stay connected with us and keep up with the latest updates, news, and insights from our agricultural community.</p>
          <div class="social-links d-flex">
            <a href="#footer" aria-label="Follow Agro Vista on X (Twitter)"><i class="bi bi-twitter-x" aria-hidden="true"></i></a>
            <a href="#footer" aria-label="Follow Agro Vista on Facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a>
            <a href="#footer" aria-label="Follow Agro Vista on Instagram"><i class="bi bi-instagram" aria-hidden="true"></i></a>
            <a href="#footer" aria-label="Follow Agro Vista on LinkedIn"><i class="bi bi-linkedin" aria-hidden="true"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Agro Vista</strong> <span>All Rights Reserved</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center" aria-label="Scroll to top"><i class="bi bi-arrow-up-short" aria-hidden="true"></i></a>

  <!-- Preloader -->
  <div id="preloader" aria-hidden="true"></div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>
