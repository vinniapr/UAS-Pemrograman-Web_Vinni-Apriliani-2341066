<?php
// Memulai session untuk cek login
session_start();

// Jika belum login, redirect ke login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Jika sudah login, redirect ke dashboard (halaman utama sekarang)
header('Location: dashboard.php');
exit;
?>