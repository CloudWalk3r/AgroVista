<?php
include 'session_active.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Contact Us - Agro Vista</title>
  <meta name="description" content="Get in touch with the Agro Vista Digital Trade Fair team at the Faculty of Agricultural Sciences, Sabaragamuwa University of Sri Lanka.">
  <meta name="keywords" content="Contact Agro Vista, Sabaragamuwa University, agricultural trade fair contact">

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

<body class="contact-page">

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
          <li><a href="products.php">Products</a></li>
          <li><a href="ufruits.php">Underutilized Fruits</a></li>
          <li><a href="contact.php" class="active" aria-current="page">Contact</a></li>
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
        <h1>Contact</h1>
        <p>Have questions or want to get in touch with us? We’d love to hear from you! Whether you need more information or have feedback to share, feel free to reach out. Our team is here to assist you and ensure you get the support you need.</p>
        <nav class="breadcrumbs" aria-label="Breadcrumb">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current" aria-current="page">Contact</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <h2 class="visually-hidden">Contact Information and Inquiry Form</h2>

        <div class="row gy-4">
          <div class="col-lg-6">
            <div class="row gy-4">

              <div class="col-lg-12">
                <div class="info-item d-flex flex-column justify-content-center align-items-center p-4 bg-white rounded-3 shadow-sm border" data-aos="fade-up" data-aos-delay="200">
                  <i class="bi bi-geo-alt fs-2 text-success mb-2" aria-hidden="true"></i>
                  <h3 class="h5 fw-bold">Address</h3>
                  <p class="mb-0 text-center">Faculty of Agricultural Sciences, Sabaragamuwa University of Sri Lanka</p>
                </div>
              </div><!-- End Info Item -->

              <div class="col-md-12">
                <div class="info-item d-flex flex-column justify-content-center align-items-center p-4 bg-white rounded-3 shadow-sm border" data-aos="fade-up" data-aos-delay="400">
                  <i class="bi bi-envelope fs-2 text-success mb-2" aria-hidden="true"></i>
                  <h3 class="h5 fw-bold">Email Us</h3>
                  <p class="mb-0"><a href="mailto:agribizdigitaltradefair@gmail.com">agribizdigitaltradefair@gmail.com</a></p>
                </div>
              </div><!-- End Info Item -->

            </div>
          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" class="php-email-form p-4 bg-white rounded-3 shadow-sm border" data-aos="fade-up" data-aos-delay="500">
              <div class="row gy-3">

                <div class="col-md-6">
                  <label for="contact-name" class="form-label">Your Name</label>
                  <input type="text" id="contact-name" name="name" class="form-control" placeholder="Enter your full name" autocomplete="name" required>
                </div>

                <div class="col-md-6">
                  <label for="contact-email" class="form-label">Your Email</label>
                  <input type="email" id="contact-email" class="form-control" name="email" placeholder="you@example.com" autocomplete="email" required>
                </div>

                <div class="col-md-12">
                  <label for="contact-subject" class="form-label">Subject</label>
                  <input type="text" id="contact-subject" class="form-control" name="subject" placeholder="How can we help?" required>
                </div>

                <div class="col-md-12">
                  <label for="contact-message" class="form-label">Message</label>
                  <textarea id="contact-message" class="form-control" name="message" rows="4" placeholder="Write your message here..." required></textarea>
                </div>

                <div class="col-md-12 text-center mt-3">
                  <button type="submit" class="contact-button" data-loading-text="Sending...">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

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
