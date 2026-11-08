# AgroVista — Agricultural Trade-Fair Platform

![AgroVista Logo](assets/img/logo.png)

AgroVista is a digital agricultural trade-fair and e-commerce platform that
promotes and showcases high-quality Sri Lankan agricultural products to local
and international markets. It provides a public storefront for browsing products
and product videos, plus a secure admin panel for managing products and sellers.

> Originally developed as an academic project at the Faculty of Agricultural
> Sciences, Sabaragamuwa University of Sri Lanka, now being standardized for a
> public product release.

---

## Table of Contents

- [Features](#features)
- [Screenshots](#screenshots)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Setup & Installation](#setup--installation)
- [Environment / Configuration Variables](#environment--configuration-variables)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [Deployment](#deployment)
- [Security Notes](#security-notes)
- [Contributing](#contributing)
- [License](#license)

---

## Features

### Public storefront
- Browse **Utilized Products** (Ceylon Cinnamon, Kithul, Handmade Tea, Dry Fish).
- Browse **Underutilized Fruits** — indigenous and rare fruits.
- Product video demonstrations with an image-fallback system.
- Responsive, mobile-first design.
- Contact page and profile editing.

### Admin panel
- Secure, session-based admin authentication.
- Full CRUD for **products** and **sellers**.
- Video upload for product demonstrations.
- Category filtering of product listings.

---

## Screenshots

> Replace the placeholders below with real screenshots before release.

| Home | Product Listing | Admin Dashboard |
| --- | --- | --- |
| _placeholder_ | _placeholder_ | _placeholder_ |

---

## Tech Stack

| Layer | Technology |
| --- | --- |
| Language | PHP (>= 7.4; tested on 8.x) |
| Database | MySQL 5.7+ / MariaDB |
| DB driver | `mysqli` |
| Config | [`vlucas/phpdotenv`](https://github.com/vlucas/phpdotenv) via `.env` |
| Frontend | HTML5, CSS3, Bootstrap 5, Bootstrap Icons, AOS |
| Dependency mgr | Composer |
| Web server | Apache (XAMPP) or PHP built-in server |

---

## Prerequisites

- **PHP 7.4 or higher** with `mysqli`, `gd`, and `fileinfo` extensions enabled.
- **MySQL 5.7+** or MariaDB.
- **Composer** (for the `phpdotenv` dependency).
- A web server — **XAMPP** (Apache + MySQL) is the easiest option on Windows,
  or you can use PHP's built-in server for development.

---

## Setup & Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd AgroVista
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Create the database and import the schema**
   ```bash
   mysql -u your_username -p -e "CREATE DATABASE agriecom;"
   mysql -u your_username -p agriecom < db.sql
   ```

4. **Configure environment variables**
   ```bash
   cp .env.example .env    # Windows: copy .env.example .env
   ```
   Edit `.env` and set your database credentials (see the table below).

5. **Create the first admin account**
   ```bash
   # PowerShell
   $env:ADMIN_EMAIL="you@example.com"; $env:ADMIN_PASSWORD="a-strong-password"
   php authentication/create_admin.php

   # bash
   ADMIN_EMAIL="you@example.com" ADMIN_PASSWORD="a-strong-password" php authentication/create_admin.php
   ```

6. **Run the application**
   - **With XAMPP:** place the project in `htdocs/` and visit
     `http://localhost/AgroVista/shared/index.php`.
   - **With PHP's built-in server:**
     ```bash
     php -S localhost:8000
     ```
     Then open `http://localhost:8000/shared/index.php`.

---

## Environment / Configuration Variables

All configuration is read from a gitignored `.env` file (see `.env.example`).
**Never commit real credentials.**

| Variable | Description | Example |
| --- | --- | --- |
| `DB_HOST` | MySQL host | `localhost` |
| `DB_USER` | MySQL username | `root` |
| `DB_PASSWORD` | MySQL password | `secret` |
| `DB_NAME` | Database name | `agriecom` |
| `ADMIN_EMAIL` | Email for the seeded admin (seed script only) | `admin@example.com` |
| `ADMIN_PASSWORD` | Password for the seeded admin (min 8 chars) | `a-strong-password` |

The database connection is centralized in `db/DBcon.php`, which loads these
values via `phpdotenv`.

---

## Project Structure

```
AgroVista/
├── admin/                      # Admin panel (session-protected)
│   ├── add_product.php
│   ├── edit_product.php
│   ├── delete_product.php
│   ├── view_products.php
│   ├── add_seller.php
│   ├── edit_seller.php
│   ├── delete_seller.php
│   ├── view_sellers.php
│   ├── admin_header.php
│   └── dashboard_admin.php
├── authentication/             # Login / register / admin seeding
│   ├── login.php
│   ├── register.php
│   ├── logout.php
│   └── create_admin.php
├── shared/                     # Public pages
│   ├── index.php               # Homepage
│   ├── products.php            # Utilized products
│   ├── ufruits.php             # Underutilized fruits
│   ├── cinnamon.php / kithul.php / tea.php / dry_fish.php
│   ├── contact.php
│   ├── edit_profile.php
│   └── session_active.php
├── db/
│   └── DBcon.php               # DB connection (reads .env)
├── assets/                     # CSS, JS, images, fonts, vendor libs, videos
├── db.sql                      # Database schema + seed data
├── composer.json
├── .env.example
├── VIDEO_FEATURES.md           # Video subsystem docs
└── VIDEO_ORGANIZATION.md
```

> Note: There are a few development/debug helpers (`admin/upload_test.php`,
> `shared/debug_videos.php`, `shared/test_videos.php`). Remove these before a
> public production deployment — see `RELEASE_READINESS.md`.

---

## Database Schema

| Table | Purpose |
| --- | --- |
| `users` | Admin/user authentication (email + bcrypt `password_hash`, `user_type`) |
| `sellers` | Seller profiles (name, phone, address) |
| `products` | Products linked to a seller, category ENUM, video URL |

Relationships:
- `products.seller_id` → `sellers.seller_id` (`ON DELETE CASCADE`).
- `category` is an ENUM of `'Utilized'` / `'UnderUtilized'`.

---

## Deployment

1. Provision a server with PHP 7.4+ and MySQL, and a web server (Apache/Nginx).
2. Deploy the code and run `composer install --no-dev --optimize-autoloader`.
3. Create the production database and import `db.sql`.
4. Create a `.env` file with production credentials (outside version control).
5. Point the document root at the project directory; ensure the storefront and
   admin paths resolve (e.g. `shared/index.php`, `admin/`).
6. Ensure the upload directories (`assets/videos/products/...`) are writable by
   the web server user.
7. **Remove the debug/test scripts** listed above.
8. Serve over **HTTPS** and set secure session cookie flags.

---

## Security Notes

AgroVista is being hardened for release. Key points:

- Credentials are loaded from a gitignored `.env` (no hardcoded secrets).
- Passwords are hashed with bcrypt (`password_hash` / `password_verify`).
- Admin pages are gated by a session + `user_type` check.
- Integer IDs used in admin delete/edit queries are cast to `int`.

**Open items** (tracked in `RELEASE_READINESS.md`): public registration currently
allows creating admin accounts, several queries still use escaping instead of
prepared statements, and uploads are validated by extension only. Review these
before a public launch.

---

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md).

---

## License

Released under the [MIT License](LICENSE). Copyright (c) 2026 Kavindu Aluthwaththa.
