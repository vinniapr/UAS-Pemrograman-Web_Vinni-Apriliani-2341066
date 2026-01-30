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
$products = getProductsFromDB($pdo); // Ambil daftar produk dari database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <!-- Font Google untuk styling teks -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Sertakan file CSS -->
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Daftar Produk</h1> <!-- Judul halaman produk -->
            <div>
                <a href="cart.php" class="cart-btn">
                    <i class="fas fa-shopping-cart"></i> Keranjang (<?php echo $cart_count; ?>) <!-- Tombol keranjang -->
                </a>
                <a href="dashboard.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard <!-- Tombol kembali -->
                </a>
            </div>
        </div>
    </header>
    <main>
        <div class="products">
            <?php foreach ($products as $product): ?> <!-- Loop untuk tampilkan produk -->
                <div class="product">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"> <!-- Gambar produk -->
                    <h3><?php echo $product['name']; ?></h3> <!-- Nama produk -->
                    <p><?php echo $product['description']; ?></p> <!-- Deskripsi produk -->
                    <p>Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></p> <!-- Harga produk -->
                    <div class="quantity-controls">
                        <button class="qty-btn" onclick="changeQuantity(<?php echo $product['id']; ?>, -1)">-</button> <!-- Tombol kurang quantity -->
                        <input type="number" id="qty-<?php echo $product['id']; ?>" value="1" min="1" readonly> <!-- Input quantity -->
                        <button class="qty-btn" onclick="changeQuantity(<?php echo $product['id']; ?>, 1)">+</button> <!-- Tombol tambah quantity -->
                    </div>
                    <button class="add-btn" onclick="addToCart(<?php echo $product['id']; ?>)">
                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang <!-- Icon tambah ke keranjang -->
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <script src="script.js"></script> <!-- Sertakan file JavaScript -->
</body>
</html>