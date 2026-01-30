<?php
include "functions.php"; // Memanggil fungsi keranjang

$id = $_GET["id"]; // Mengambil ID produk yang akan dihapus

removeItem($id); // Menghapus produk dari keranjang

header("Location: cart.php"); // Redirect kembali ke halaman keranjang
?>
