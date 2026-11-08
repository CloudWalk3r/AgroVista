<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

if (isset($_GET['product_id'])) {
    // Cast to int to prevent SQL injection (product_id is an integer column)
    $product_id = (int) $_GET['product_id'];

    $check = $conn->query("SELECT * FROM products WHERE product_id = $product_id");

    if ($check->num_rows > 0) {
        // Delete the product
        $conn->query("DELETE FROM products WHERE product_id = $product_id");

        header("Location: view_products.php?success=product_deleted");
        exit;
    } else {
        echo "Error: Product not found!";
    }
} else {
    echo "Error: Invalid request!";
}
?>
