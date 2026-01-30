<?php
session_start();

function getProducts() {
    return [
        1 => ["name" => "Lip Gloss Pink", "price" => 25000, "img" => "lipgloss.jpg"],
        2 => ["name" => "Soft Blush", "price" => 30000, "img" => "blush.jpg"],
        3 => ["name" => "Pastel Notebook", "price" => 15000, "img" => "notebook.jpg"],

        // PRODUK TAMBAHAN UTS
        4 => ["name" => "Binder B5", "price" => 28000, "img" => "binder.jpg"],
        5 => ["name" => "Loose Leaf B5", "price" => 12000, "img" => "looseleaf.jpg"],
        6 => ["name" => "Pencil Case Pink", "price" => 18000, "img" => "pencilcase.jpg"],
        7 => ["name" => "Stabilo Paket Pink", "price" => 35000, "img" => "stabilo.jpg"]
    ];
}

function addToCart($id) {
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id]++;
    }
}

function updateCart($id, $qty) {
    if ($qty <= 0) {
        unset($_SESSION['cart'][$id]);
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
}

function removeItem($id) {
    unset($_SESSION['cart'][$id]);
}
?>
