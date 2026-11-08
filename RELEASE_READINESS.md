# Release Readiness — AgroVista

This document captures the current state of the repository, the standardization
changes applied, and the remaining work required to reach public-release quality.
It is intended as a living punch list for the maintainer.

_Last reviewed: 2026-10-27_

---

## 1. Current State

AgroVista is a plain-PHP + MySQL agricultural trade-fair / e-commerce app with a
public storefront (`shared/`) and a session-protected admin panel (`admin/`).
Configuration is externalized to a `.env` file via `vlucas/phpdotenv`, and the
database schema ships in `db.sql`. The repository is functional but was written
as an academic project; it needs security hardening and cleanup before a public
launch.

**Detected stack:** PHP (>= 7.4, works on 8.x), MySQL 5.7+/MariaDB, `mysqli`
driver, Composer, Bootstrap 5 / AOS frontend, Apache/XAMPP.

---

## 2. Changes Made in This Standardization Pass

All changes are **additive or low-risk** and left **uncommitted**.

### Documentation & project metadata
- Rewrote `README.md` into a comprehensive guide (features, stack, prerequisites,
  `.env` setup, accurate project structure, deployment, security notes, license).
- Added `LICENSE` (MIT, © 2026 Kavindu Aluthwaththa).
- Added `CONTRIBUTING.md`.
- Added this `RELEASE_READINESS.md`.
- Enriched `composer.json` with name, description, license, authors, and
  `php`/`ext-mysqli` requirements (helps `composer validate`).

### Tooling / CI
- Added `.editorconfig`.
- Added `.php-cs-fixer.dist.php` (PSR-12 based; project intentionally NOT
  mass-reformatted).
- Added `.github/workflows/ci.yml` running `php -l` across all PHP files on PHP
  7.4/8.1/8.3 and `composer validate`, plus a non-blocking style check.

### Security fixes (low-risk)
- **SQL injection:** cast integer IDs to `(int)` before use in queries in
  `admin/delete_product.php`, `admin/delete_seller.php`, `admin/edit_product.php`,
  and `admin/edit_seller.php` (these previously interpolated raw `$_GET` values).
- **Hardcoded credentials:** `authentication/create_admin.php` no longer contains
  a hardcoded `admin@agrovista.com` / `admin123` pair. It now reads `ADMIN_EMAIL`
  and `ADMIN_PASSWORD` from the environment, enforces a minimum length, uses
  prepared statements, and no longer echoes the password.

### Configuration hygiene
- Added `.env.example` documenting all required variables.
- Fixed `.gitignore`: removed the misleading `db/DBcon.php` and
  `shared/session_active.php` entries (both are already tracked and now contain
  no secrets), and clarified the `.env` comment.

---

## 3. Remaining Gaps & Risks

### 🔴 Critical (fix before any public exposure)

1. **Open admin self-registration.**
   `authentication/register.php` lets anyone submit the public form and the only
   offered `user_type` is `admin` (defaulting to `admin`). Any visitor can create
   an administrator account. **Recommended fix:** remove public registration, or
   hard-code `user_type = 'user'` server-side and gate admin creation behind the
   CLI seed script / an existing admin. This is a behavior change and was left for
   the maintainer to decide.

2. **Debug/test endpoints exposed.**
   `admin/upload_test.php`, `shared/debug_videos.php`, and `shared/test_videos.php`
   leak server configuration (PHP ini values, paths) and should be deleted or
   access-restricted before release. `admin/upload_test.php` is not session-gated.

### 🟠 High

3. **SQL still relies on escaping, not prepared statements.**
   `login.php`, `register.php`, `add_product.php`, `edit_product.php`,
   `add_seller.php`, `edit_seller.php`, `edit_profile.php`, and `view_products.php`
   use `mysqli_real_escape_string` / string interpolation. These are mitigated but
   should be migrated to parameterized `prepare()`/`bind_param()` queries.

4. **File upload validated by extension only.**
   `admin/add_product.php` and `admin/edit_product.php` check the file extension
   but not the real MIME type/content, and create upload dirs with `0777`.
   Recommend: verify MIME via `finfo`, enforce a size cap, use `0755` dirs, and
   store uploads outside the web root or block script execution there.

5. **No CSRF protection.**
   Admin state-changing forms (add/edit/delete) have no CSRF tokens. Add
   per-session tokens to all POST forms and the GET-based delete links.

6. **GET-based destructive actions.**
   `delete_product.php` / `delete_seller.php` delete via `GET` links — should be
   POST + CSRF-protected.

### 🟡 Medium

7. **XSS review.** Audit all echoed values for `htmlspecialchars()`; error
   messages (e.g. `echo $error`) and some fields are rendered unescaped.
8. **Session hardening.** Set `session.cookie_httponly`, `cookie_secure`,
   `SameSite`, and regenerate session IDs on login.
9. **Weak password policy.** Registration requires only 6 characters.
10. **`composer.lock` not committed.** For an application, commit the lockfile
    (currently gitignored and absent) for reproducible installs.
11. **Verbose DB errors.** Several handlers echo `$conn->error` to the page;
    log server-side instead.

### 🟢 Low / polish
12. Add real screenshots to the README.
13. Add automated tests (none currently).
14. Consider a small router / front controller instead of deep relative paths.

---

## 4. Prioritized Punch List

1. Close open admin registration (#1).
2. Remove debug/test scripts (#2).
3. Add CSRF tokens + convert deletes to POST (#5, #6).
4. Migrate remaining queries to prepared statements (#3).
5. Harden file uploads (MIME, size, permissions, exec blocking) (#4).
6. Full XSS output-escaping audit (#7).
7. Session + password-policy hardening (#8, #9).
8. Commit `composer.lock`; suppress verbose DB errors in production (#10, #11).
9. Screenshots, tests, polish (#12–#14).
