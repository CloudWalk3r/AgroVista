<?php
include 'session_active.php';
$_SESSION['category'] = 'Utilized';
$_SESSION['product'] = 'products';

include '../db/DBcon.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Products - Agro Vista</title>
  <meta name="description" content="Browse authentic Sri Lankan agricultural products including Ceylon Cinnamon, Kithul, Handmade Tea, and Dry Fish.">
  <meta name="keywords" content="Agro Vista products, Ceylon Cinnamon, Kithul, Handmade Tea, Dry Fish">

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
        <h1>Products</h1>
        <p>
          This Digital Trade Fair is organized by the undergraduates of the Faculty of Agricultural Sciences, Sabaragamuwa University of Sri Lanka. It is a part of our academic initiative to promote and support local agricultural industries by introducing high-quality Sri Lankan products such as kithul, cinnamon, dry fish, and tea to both local and international markets.
        </p>
        <nav class="breadcrumbs" aria-label="Breadcrumb">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current" aria-current="page">Products</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="container text-center">
        <h2 class="visually-hidden">Product Categories</h2>
        <div class="shell py-2">
          <div class="row g-4">
            <div class="col-lg-3 col-sm-6">
              <a href="cinnamon.php" class="wsk-cp-product">
                <div class="wsk-cp-img">
                  <img src="../assets/img/products/cinnomon.jpg" alt="Authentic Ceylon Cinnamon bark and spices" width="400" height="300" loading="lazy" decoding="async" />
                </div>
                <div class="wsk-cp-text">
                  <div class="title-product">
                    <h3>Cinnamon</h3>
                  </div>
                  <span class="av-category-card__cta">Explore Cinnamon <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-sm-6">
              <a href="kithul.php" class="wsk-cp-product">
                <div class="wsk-cp-img">
                  <img src="../assets/img/products/kithul.jpg" alt="Traditional Kithul treacle and palm jaggery" width="400" height="300" loading="lazy" decoding="async" />
                </div>
                <div class="wsk-cp-text">
                  <div class="title-product">
                    <h3>Kithul</h3>
                  </div>
                  <span class="av-category-card__cta">Explore Kithul <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-sm-6">
              <a href="tea.php" class="wsk-cp-product">
                <div class="wsk-cp-img">
                  <img src="../assets/img/products/tea.jpg" alt="Handcrafted Ceylon Tea leaves" width="400" height="300" loading="lazy" decoding="async" />
                </div>
                <div class="wsk-cp-text">
                  <div class="title-product">
                    <h3>Handmade Tea</h3>
                  </div>
                  <span class="av-category-card__cta">Explore Tea <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-sm-6">
              <a href="dry_fish.php" class="wsk-cp-product">
                <div class="wsk-cp-img">
                  <img src="../assets/img/products/dry_fish.jpg" alt="Sun-dried coastal Sri Lankan Dry Fish" width="400" height="300" loading="lazy" decoding="async" />
                </div>
                <div class="wsk-cp-text">
                  <div class="title-product">
                    <h3>Dry Fish</h3>
                  </div>
                  <span class="av-category-card__cta">Explore Dry Fish <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

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
          <p>Stay connected with us and keep up with the latest updates, news, and insights. Follow us on our social media channels for a closer look at our journey, achievements, and behind-the-scenes moments.</p>
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
