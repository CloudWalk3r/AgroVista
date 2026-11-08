<?php
// Include this file at the top of all admin pages for consistent header
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
$current_admin_page = basename($_SERVER['PHP_SELF']);
?>

<a href="#main-content" class="skip-link">Skip to main content</a>

<!-- Admin Header -->
<header id="header" class="header admin-site-header d-flex align-items-center">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
        
        <a href="dashboard_admin.php" class="logo d-flex align-items-center text-decoration-none" aria-label="Agro Vista Admin Dashboard">
            <img src="../assets/img/logo.png" alt="Agro Vista logo" width="40" height="40" style="border-radius: 50%; width: 40px; height: 40px;" onerror="this.style.display='none'">
            <span class="sitename text-white ms-2 mb-0">Agro Vista Admin</span>
        </a>

        <nav id="navmenu" class="navmenu" aria-label="Admin navigation">
            <ul class="mb-0">
                <li>
                    <a href="dashboard_admin.php" class="text-white <?php echo $current_admin_page === 'dashboard_admin.php' ? 'active' : ''; ?>" <?php echo $current_admin_page === 'dashboard_admin.php' ? 'aria-current="page"' : ''; ?>>
                        Dashboard
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="text-white <?php echo in_array($current_admin_page, ['add_product.php', 'view_products.php', 'edit_product.php'], true) ? 'active' : ''; ?>" aria-haspopup="true" aria-expanded="false">
                        <span>Products</span> <i class="bi bi-chevron-down toggle-dropdown" aria-hidden="true"></i>
                    </a>
                    <ul>
                        <li><a href="add_product.php" <?php echo $current_admin_page === 'add_product.php' ? 'aria-current="page"' : ''; ?>>Add Product</a></li>
                        <li><a href="view_products.php" <?php echo $current_admin_page === 'view_products.php' ? 'aria-current="page"' : ''; ?>>View Products</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="text-white <?php echo in_array($current_admin_page, ['add_seller.php', 'view_sellers.php', 'edit_seller.php'], true) ? 'active' : ''; ?>" aria-haspopup="true" aria-expanded="false">
                        <span>Sellers</span> <i class="bi bi-chevron-down toggle-dropdown" aria-hidden="true"></i>
                    </a>
                    <ul>
                        <li><a href="add_seller.php" <?php echo $current_admin_page === 'add_seller.php' ? 'aria-current="page"' : ''; ?>>Add Seller</a></li>
                        <li><a href="view_sellers.php" <?php echo $current_admin_page === 'view_sellers.php' ? 'aria-current="page"' : ''; ?>>View Sellers</a></li>
                    </ul>
                </li>
                <li><a href="../shared/index.php" class="text-white">Storefront</a></li>
                <li><a href="../authentication/logout.php" class="text-white">Logout</a></li>
            </ul>
            <button type="button" class="mobile-nav-toggle d-xl-none text-white" aria-controls="navmenu" aria-expanded="false" aria-label="Open navigation menu">
                <i class="bi bi-list" aria-hidden="true"></i>
            </button>
        </nav>

    </div>
</header>

<style>
/* Admin Header Styles (WCAG 2.2 AA & Responsive 320px-1440px+) */
.admin-site-header {
    background: linear-gradient(135deg, #1b5e20, #1e4356) !important;
    position: sticky;
    top: 0;
    z-index: 1020;
    padding: 12px 0;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
}

.admin-site-header .logo .sitename {
    font-size: clamp(1.15rem, 1rem + 0.6vw, 1.5rem);
    font-weight: 700;
    color: #ffffff;
}

@media (min-width: 1200px) {
    .admin-site-header .navmenu ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .admin-site-header .navmenu li {
        position: relative;
    }

    .admin-site-header .navmenu > ul > li > a {
        color: #ffffff !important;
        text-decoration: none;
        font-weight: 500;
        padding: 10px 16px;
        border-radius: 999px;
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background-color 0.2s ease;
    }

    .admin-site-header .navmenu > ul > li > a:hover,
    .admin-site-header .navmenu > ul > li > a.active {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff !important;
    }

    .admin-site-header .navmenu .dropdown ul {
        position: absolute;
        top: 100%;
        left: 0;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        min-width: 190px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(6px);
        transition: all 0.2s ease;
        flex-direction: column;
        align-items: stretch;
        padding: 8px 0;
        z-index: 1050;
    }

    .admin-site-header .navmenu .dropdown:hover ul,
    .admin-site-header .navmenu .dropdown:focus-within ul {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .admin-site-header .navmenu .dropdown ul a {
        color: #1f2923 !important;
        padding: 10px 18px;
        border-radius: 0;
        display: flex;
        align-items: center;
        min-height: 44px;
        font-weight: 500;
    }

    .admin-site-header .navmenu .dropdown ul a:hover,
    .admin-site-header .navmenu .dropdown ul a:focus-visible {
        background: #e8f5e9;
        color: #1b5e20 !important;
    }
}

@media (max-width: 1199.98px) {
    .admin-site-header .navmenu ul a {
        color: #1f2923 !important;
        min-height: 44px;
    }

    .admin-site-header .navmenu ul a:hover,
    .admin-site-header .navmenu ul a.active {
        color: #1b5e20 !important;
    }
}
</style>
