<?php
// One-off CLI/seed script to create the first admin user.
// Credentials are read from environment variables so they are never committed.
// Usage (PowerShell example):
//   $env:ADMIN_EMAIL="you@example.com"; $env:ADMIN_PASSWORD="a-strong-password"; php authentication/create_admin.php
include __DIR__ . '/../db/DBcon.php';

// Configuration - supplied via environment variables (see .env.example)
$admin_email = $_ENV['ADMIN_EMAIL'] ?? getenv('ADMIN_EMAIL') ?: null;
$admin_password = $_ENV['ADMIN_PASSWORD'] ?? getenv('ADMIN_PASSWORD') ?: null;

if (!$admin_email || !$admin_password) {
    fwrite(STDERR, "ERROR: Set ADMIN_EMAIL and ADMIN_PASSWORD environment variables before running this script.\n");
    exit(1);
}

if (strlen($admin_password) < 8) {
    fwrite(STDERR, "ERROR: ADMIN_PASSWORD must be at least 8 characters long.\n");
    exit(1);
}

// Check if admin already exists (parameterized)
$check_stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
$check_stmt->bind_param("s", $admin_email);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo "Admin user with email '$admin_email' already exists.\n";
} else {
    // Hash the password
    $password_hash = password_hash($admin_password, PASSWORD_DEFAULT);

    // Insert new admin user (parameterized)
    $insert_stmt = $conn->prepare("INSERT INTO users (email, password_hash, user_type) VALUES (?, ?, 'admin')");
    $insert_stmt->bind_param("ss", $admin_email, $password_hash);

    if ($insert_stmt->execute()) {
        echo "Admin user created successfully!\n";
        echo "Email: $admin_email\n";
        echo "You can now login at: authentication/login.php\n";
    } else {
        echo "Error creating admin user: " . $conn->error . "\n";
    }
}

$conn->close();
?>
