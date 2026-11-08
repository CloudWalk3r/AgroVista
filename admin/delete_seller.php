<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../authentication/login.php");
    exit;
}
include '../db/DBcon.php';

if (isset($_GET['seller_id'])) { 
    // Cast to int to prevent SQL injection (seller_id is an integer column)
    $seller_id = (int) $_GET['seller_id']; 
    $user_id = $_SESSION['user_id'];
    
    // Delete related products first (if any)
    $conn->query("DELETE FROM products WHERE seller_id = $seller_id");
    
    // Delete the seller
    $delete_result = $conn->query("DELETE FROM sellers WHERE seller_id = $seller_id");
    
    if ($delete_result) {
        header("Location: view_sellers.php?success=seller_deleted");
        exit;
    } else {
        echo "Error: Could not delete seller!";
    }
} else {
    echo "Error: Invalid request!";
}
?>
