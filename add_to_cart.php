<?php
// Sertakan koneksi database dan fungsi
include 'db.php';
include 'functions.php';

// Mulai session untuk mendapatkan user_id
session_start();
if (!isset($_SESSION['user_id'])) {
    echo 'error: not logged in'; // Jika belum login, kirim error
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = (int)$_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    // Tambah ke keranjang di database
    addToCartDB($pdo, $user_id, $product_id, $quantity);
    echo 'success';
}
?>