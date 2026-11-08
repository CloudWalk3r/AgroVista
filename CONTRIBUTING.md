# Contributing to AgroVista

Thanks for your interest in improving AgroVista! This is a short guide to get you started.

## Getting started

1. Fork the repository and clone your fork.
2. Copy `.env.example` to `.env` and fill in your local MySQL credentials.
3. Import the database schema: `mysql -u <user> -p <db_name> < db.sql`.
4. Install PHP dependencies: `composer install`.
5. Serve the project with XAMPP/Apache or `php -S localhost:8000`.

## Development workflow

- Create a feature branch: `git checkout -b feature/short-description`.
- Keep changes focused and small; one logical change per pull request.
- Run the checks below before opening a PR.

## Checks

```bash
# Syntax-check the files you changed
php -l path/to/file.php

# Validate composer metadata
composer validate --no-check-publish

# Optional: code style (do NOT mass-reformat unrelated files)
vendor/bin/php-cs-fixer fix --dry-run --diff
```

## Coding guidelines

- Use **prepared statements** for all SQL that includes user input (no string concatenation).
- Escape output with `htmlspecialchars()` to prevent XSS.
- Never commit secrets. All credentials belong in the gitignored `.env`.
- Follow the existing file structure (`admin/`, `authentication/`, `shared/`, `db/`).
- Match PSR-12 style for new code (see `.php-cs-fixer.dist.php`).

## Reporting issues

Open an issue describing the problem, steps to reproduce, and expected behavior.
For security-sensitive reports, please contact the maintainer privately instead
of filing a public issue.
