<?php
// Memulai session untuk cek login
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect ke login jika belum login
    exit;
}
include 'db.php'; // Sertakan koneksi database
include 'functions.php'; // Sertakan fungsi utilitas

$user_id = $_SESSION['user_id'];
$cart = getCartFromDB($pdo, $user_id); // Ambil data keranjang dari database
$total = getTotalFromDB($pdo, $user_id); // Hitung total harga

// Jika form dikirim (update atau remove)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['remove'])) {
        removeFromCartDB($pdo, $user_id, $_POST['product_id']); // Hapus item dari keranjang
        header('Location: cart.php'); // Redirect kembali ke keranjang
    } elseif (isset($_POST['update'])) {
        updateCartDB($pdo, $user_id, $_POST['product_id'], $_POST['quantity']); // Update quantity
        header('Location: cart.php'); // Redirect kembali ke keranjang
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <!-- Font Google untuk styling -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Sertakan CSS -->
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Keranjang Belanja</h1> <!-- Judul halaman keranjang -->
            <a href="products.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali ke Produk <!-- Tombol kembali ke produk -->
            </a>
        </div>
    </header>
    <main>
        <?php if (empty($cart)): ?> <!-- Jika keranjang kosong -->
            <p>Keranjang kosong.</p> <!-- Pesan kosong -->
        <?php else: ?> <!-- Jika ada item -->
            <table>
                <thead>
                    <tr>
                        <th>Produk</th> <!-- Kolom produk -->
                        <th>Harga</th> <!-- Kolom harga -->
                        <th>Jumlah</th> <!-- Kolom quantity -->
                        <th>Total</th> <!-- Kolom total -->
                        <th>Aksi</th> <!-- Kolom aksi -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item): ?> <!-- Loop item keranjang -->
                        <tr>
                            <td><?php echo $item['name']; ?></td> <!-- Nama produk -->
                            <td>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td> <!-- Harga -->
                            <td>
                                <div class="quantity-controls">
                                    <button class="qty-btn" onclick="changeQuantityInCart(<?php echo $item['id']; ?>, -1)">-</button> <!-- Tombol kurang -->
                                    <input type="number" id="cart-qty-<?php echo $item['id']; ?>" value="1" min="1" readonly> <!-- Input quantity -->
                                    <button class="qty-btn" onclick="changeQuantityInCart(<?php echo $item['id']; ?>, 1)">+</button> <!-- Tombol tambah -->
                                </div>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <input type="hidden" id="hidden-qty-<?php echo $item['id']; ?>" name="quantity" value="<?php echo $item['quantity']; ?>">
                                    <button type="submit" name="update" class="update-btn">
                                        <i class="fas fa-sync-alt"></i> Update <!-- Icon update -->
                                    </button>
                                </form>
                            </td>
                            <td>Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td> <!-- Total per item -->
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" name="remove" class="remove-btn">
                                        <i class="fas fa-trash"></i> Hapus <!-- Icon hapus -->
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Total: Rp <?php echo number_format($total, 0, ',', '.'); ?></p> <!-- Total keseluruhan -->
            <button class="checkout-btn" onclick="window.location.href='checkout.php'">
                <i class="fas fa-credit-card"></i> Bayar <!-- Icon bayar -->
            </button>
        <?php endif; ?>
    </main>
    <script src="script.js"></script> <!-- Sertakan JavaScript -->
</body>
</html>