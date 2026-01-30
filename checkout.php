<?php
// Memulai session dan cek login
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect jika belum login
    exit;
}
include 'db.php'; // Koneksi database
include 'functions.php'; // Fungsi utilitas

$user_id = $_SESSION['user_id'];
$cart = getCartFromDB($pdo, $user_id); // Ambil keranjang dari DB
$total = getTotalFromDB($pdo, $user_id); // Hitung total
$showSuccess = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Buat pesanan
    $order_id = createOrder($pdo, $user_id, $total);
    // Tambah item pesanan
    addOrderItems($pdo, $order_id, $cart);
    // Kosongkan keranjang
    clearCart($pdo, $user_id);
    $showSuccess = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Font Google untuk styling -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Checkout</h1> <!-- Judul halaman -->
    </header>
    <main>
        <?php if ($showSuccess): ?> <!-- Jika pembayaran berhasil -->
            <div class="success-message">
                <img src="image/sukses.png" alt="Success" style="width:100px; height:100px;"> <!-- Gambar sukses -->
                <h2>Pembayaran Berhasil!</h2> <!-- Pesan sukses -->
                <p>Terima kasih atas pembelian Anda.</p>
                <a href="dashboard.php" class="back-btn">
                    <i class="fas fa-home"></i> Kembali ke Dashboard <!-- Tombol kembali ke dashboard -->
                </a>
            </div>
        <?php else: ?> <!-- Jika belum checkout -->
            <h2>Ringkasan Pesanan</h2> <!-- Judul ringkasan -->
            <ul>
                <?php foreach ($cart as $item): ?> <!-- Loop item keranjang -->
                    <li><?php echo $item['name']; ?> x <?php echo $item['quantity']; ?> - Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></li>
                <?php endforeach; ?>
            </ul>
            <p>Total: Rp <?php echo number_format($total, 0, ',', '.'); ?></p> <!-- Total harga -->
            <form method="post">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" required> <!-- Input nama -->
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required> <!-- Input email -->
                <label for="address">Alamat:</label>
                <textarea id="address" name="address" required></textarea> <!-- Input alamat -->
                <button type="submit" class="checkout-btn">
                    <i class="fas fa-credit-card"></i> Bayar <!-- Icon bayar -->
                </button>
            </form>
            <div class="bottom-links">
                <a href="cart.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Kembali ke Keranjang <!-- Tombol kembali ke keranjang dengan icon -->
                </a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>