<?php
// Memulai session untuk cek login pengguna
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect ke login jika belum login
    exit;
}
include 'db.php'; // Sertakan file koneksi database
include 'functions.php'; // Sertakan file fungsi utilitas

$user_id = $_SESSION['user_id'];
$cart_count = getCartCount($pdo, $user_id); // Hitung jumlah item di keranjang
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Font Google untuk styling teks -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Sertakan file CSS -->
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Dashboard</h1> <!-- Judul halaman dashboard -->
            <a href="cart.php" class="cart-btn">
                <i class="fas fa-shopping-cart"></i> Keranjang (<?php echo $cart_count; ?>) <!-- Tombol keranjang dengan icon di header -->
            </a>
        </div>
    </header>
    <main>
        <h2>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2> <!-- Salam pengguna -->
        <p>Ringkasan: Anda memiliki <?php echo $cart_count; ?> item di keranjang.</p> <!-- Info jumlah item keranjang -->
        <div class="dashboard-links">
            <a href="products.php" class="product-link">
                <i class="fas fa-list"></i> Lihat Daftar Produk <!-- Link ke halaman produk -->
            </a>
        </div>
        <div class="bottom-links">
            <button class="logout-btn" onclick="window.location.href='logout.php'">
                <i class="fas fa-sign-out-alt"></i> Logout <!-- Icon logout -->
            </button>
        </div>
    </main>
    <script src="script.js"></script> <!-- Sertakan file JavaScript -->
</body>
</html>