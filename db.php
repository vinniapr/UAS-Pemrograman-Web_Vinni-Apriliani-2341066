<?php
// Koneksi ke database MySQL menggunakan PDO
$host = 'localhost'; // Host database (biasanya localhost)
$dbname = 'ecommerce'; // Nama database yang Anda buat
$username = 'root'; // Username MySQL (default root)
$password = ''; // Password MySQL (kosong jika default)

// Coba koneksi
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set mode error untuk menampilkan exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Jika koneksi gagal, tampilkan pesan error
    die("Koneksi database gagal: " . $e->getMessage());
}
?>