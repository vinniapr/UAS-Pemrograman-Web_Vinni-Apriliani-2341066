<?php
// Memulai session jika belum aktif, untuk menyimpan data pengguna
if (!session_id()) {
    session_start();
}

// Fungsi untuk mendapatkan produk dari database
function getProductsFromDB($pdo) {
    // Query untuk mengambil semua produk
    $stmt = $pdo->query("SELECT * FROM products");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fungsi untuk menghitung jumlah item di keranjang berdasarkan user_id
function getCartCount($pdo, $user_id) {
    // Query untuk menjumlahkan quantity di tabel cart
    $stmt = $pdo->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch();
    return $result['total'] ?? 0; // Kembalikan 0 jika kosong
}

// Fungsi untuk menambah produk ke keranjang (database)
function addToCartDB($pdo, $user_id, $product_id, $quantity) {
    // Cek apakah produk sudah ada di keranjang
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    $existing = $stmt->fetch();
    if ($existing) {
        // Jika ada, update quantity
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + ? WHERE id = ?");
        $stmt->execute([$quantity, $existing['id']]);
    } else {
        // Jika tidak, insert baru
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $product_id, $quantity]);
    }
}

// Fungsi untuk mendapatkan keranjang dari database
function getCartFromDB($pdo, $user_id) {
    // Join tabel cart dan products untuk mendapatkan detail produk
    $stmt = $pdo->prepare("
        SELECT c.quantity, p.* FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fungsi untuk update quantity di keranjang
function updateCartDB($pdo, $user_id, $product_id, $quantity) {
    if ($quantity <= 0) {
        // Jika quantity 0 atau kurang, hapus dari keranjang
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
    } else {
        // Update quantity
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$quantity, $user_id, $product_id]);
    }
}

// Fungsi untuk menghapus produk dari keranjang
function removeFromCartDB($pdo, $user_id, $product_id) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
}

// Fungsi untuk menghitung total harga keranjang
function getTotalFromDB($pdo, $user_id) {
    // Hitung total dengan join cart dan products
    $stmt = $pdo->prepare("
        SELECT SUM(c.quantity * p.price) as total FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch();
    return $result['total'] ?? 0;
}

// Fungsi untuk membuat pesanan baru
function createOrder($pdo, $user_id, $total) {
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmt->execute([$user_id, $total]);
    return $pdo->lastInsertId(); // Kembalikan ID pesanan
}

// Fungsi untuk menambah item pesanan
function addOrderItems($pdo, $order_id, $cart_items) {
    foreach ($cart_items as $item) {
        // Insert setiap item ke order_items
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
    }
}

// Fungsi untuk mengosongkan keranjang setelah checkout
function clearCart($pdo, $user_id) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
}
?>