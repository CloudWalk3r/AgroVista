<?php
include 'session_active.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home - Agro Vista Digital Trade Fair</title>
  <meta name="description" content="Agro Vista connects you with Sri Lanka's finest agricultural producers of Ceylon cinnamon, kithul products, handmade tea, dry fish, and underutilized fruits.">
  <meta name="keywords" content="Agro Vista, Sri Lanka agriculture, Ceylon cinnamon, kithul, handmade tea, dry fish, underutilized fruits">

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

<body class="index-page">

  <a href="#main-content" class="skip-link">Skip to main content</a>

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center" aria-label="Agro Vista Home">
        <img src="../assets/img/logo.png" alt="Agro Vista logo" width="32" height="32" style="border-radius: 50%;" onerror="this.style.display='none'">
        <span class="sitename">Agro Vista</span>
      </a>

      <nav id="navmenu" class="navmenu" aria-label="Primary navigation">
        <ul>
          <li><a href="index.php" class="active" aria-current="page">Home</a></li>
          <li><a href="products.php">Products</a></li>
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

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <div id="hero-carousel" class="carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <div class="container position-relative">

          <div class="carousel-item active">
            <div class="carousel-container">
              <h1>Welcome to Agro Vista</h1>
              <p>
                Discover the rich heritage and craftsmanship behind Sri Lanka’s finest agri-products. From pure Ceylon cinnamon and traditional kithul to handmade teas and dry fish delicacies, our platform connects you with passionate local producers. Explore, support, and shop directly from trusted sellers – all in one place.
                In addition, don’t miss our special segment dedicated to underutilized fruits in Sri Lanka, featuring informative videos that highlight their unique value, benefits, and potential for innovation.
              </p>
              <a href="#about" class="btn-get-started">Read More</a>
            </div>
          </div><!-- End Carousel Item -->
        </div>

      </div>

    </section><!-- /Hero Section -->

    <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Our Products</h2>
      </div>

      <div class="container">

        <div class="row gy-4">

          <div class="col-xl-3 col-sm-6 d-flex" data-aos="fade-up" data-aos-delay="100">
            <a href="cinnamon.php" class="container1" aria-label="Browse Ceylon Cinnamon products">
              <img src="../assets/img/products/cinnomon.jpg" alt="Ceylon Cinnamon bark and spice sticks" class="image" width="260" height="260" loading="lazy" decoding="async">
              <div class="middle">
                <div class="text">Ceylon Cinnamon</div>
              </div>
            </a>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-sm-6 d-flex" data-aos="fade-up" data-aos-delay="200">
            <a href="kithul.php" class="container1" aria-label="Browse Kithul products">
              <img src="../assets/img/products/kithul.jpg" alt="Traditional Sri Lankan Kithul treacle and jaggery" class="image" width="260" height="260" loading="lazy" decoding="async">
              <div class="middle">
                <div class="text">Kithul Products</div>
              </div>
            </a>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-sm-6 d-flex" data-aos="fade-up" data-aos-delay="300">
            <a href="tea.php" class="container1" aria-label="Browse Handmade Tea products">
              <img src="../assets/img/products/tea.jpg" alt="Freshly harvested Handmade Ceylon Tea leaves" class="image" width="260" height="260" loading="lazy" decoding="async">
              <div class="middle">
                <div class="text">Handmade Tea</div>
              </div>
            </a>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-sm-6 d-flex" data-aos="fade-up" data-aos-delay="400">
            <a href="dry_fish.php" class="container1" aria-label="Browse Dry Fish products">
              <img src="../assets/img/products/dry_fish.jpg" alt="Sun-dried Sri Lankan coastal Dry Fish" class="image" width="260" height="260" loading="lazy" decoding="async">
              <div class="middle">
                <div class="text">Dry Fish</div>
              </div>
            </a>
          </div><!-- End Service Item -->
        </div>

      </div>

    </section><!-- /Featured Services Section -->

    <!-- About Section -->
    <section id="about" class="about section light-background">

      <div class="container">

        <div class="row gy-4 align-items-center">
          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
            <img src="../assets/img/products/cinnomon.jpg" class="img-fluid rounded-3 shadow-sm" alt="Sri Lankan agricultural spices and traditional produce" width="600" height="400" loading="lazy" decoding="async">
          </div>
          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
            <h2>Our Mission</h2>
            <p class="fst-italic">
              To empower Sri Lankan producers of Cinnamon, Kithul products, Handmade Tea, and Dry Fish by providing a trusted digital marketplace that enhances visibility, facilitates fair trade, and connects them directly with consumers and buyers island wide and globally, while also promoting awareness and appreciation of Sri Lanka’s underutilized fruits through dedicated video content.
            </p>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Features Section -->
    <section id="features" class="features section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Our Vision</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4 align-items-center features-item">
          <div class="col-md-5 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="100">
            <img src="../assets/img/products/tea.jpg" class="img-fluid rounded-3 shadow-sm" alt="Lush Sri Lankan tea harvest representing sustainable trade" width="500" height="350" loading="lazy" decoding="async">
          </div>
          <div class="col-md-7" data-aos="fade-up" data-aos-delay="100">
            <p class="fst-italic">
              To create a dynamic digital platform that connects islandwide sellers and buyers of Cinnamon, Kithul products, Handmade Tea, and Dry Fish—promoting local entrepreneurship, cultural heritage, and sustainable trade across Sri Lanka and beyond, while also raising awareness on the value of underutilized fruits through dedicated video content.
            </p>
          </div>
        </div><!-- Features Item -->

      </div>

    </section><!-- /Features Section -->

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
