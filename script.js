// Fungsi untuk mengubah quantity produk di halaman dashboard
function changeQuantity(productId, delta) {
    // Ambil elemen input quantity berdasarkan productId
    const qtyInput = document.getElementById('qty-' + productId);
    // Ambil nilai quantity saat ini dan ubah berdasarkan delta (+1 atau -1)
    let currentQty = parseInt(qtyInput.value);
    currentQty += delta;
    // Pastikan quantity tidak kurang dari 1
    if (currentQty < 1) currentQty = 1;
    // Update nilai input
    qtyInput.value = currentQty;
}

// Fungsi untuk mengubah quantity produk di halaman keranjang
function changeQuantityInCart(productId, delta) {
    // Ambil elemen input quantity di keranjang
    const qtyInput = document.getElementById('cart-qty-' + productId);
    // Ambil elemen hidden input untuk form update
    const hiddenInput = document.getElementById('hidden-qty-' + productId);
    // Ambil nilai quantity saat ini dan ubah berdasarkan delta
    let currentQty = parseInt(qtyInput.value);
    currentQty += delta;
    // Pastikan quantity tidak kurang dari 1
    if (currentQty < 1) currentQty = 1;
    // Update nilai input dan hidden input
    qtyInput.value = currentQty;
    hiddenInput.value = currentQty;
}

// Fungsi untuk menambah produk ke keranjang via AJAX
function addToCart(productId) {
    // Ambil elemen input quantity
    const qtyInput = document.getElementById('qty-' + productId);
    // Ambil nilai quantity yang dipilih
    const quantity = parseInt(qtyInput.value);
    // Kirim request POST ke add_to_cart.php
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'product_id=' + productId + '&quantity=' + quantity
    })
    .then(response => response.text()) // Ambil response sebagai teks
    .then(data => {
        // Jika sukses, tampilkan alert dan reload halaman untuk update header
        if (data === 'success') {
            alert('Produk ditambahkan ke keranjang!');
            qtyInput.value = 1; // Reset quantity ke 1
            location.reload(); // Reload halaman untuk update angka keranjang
        } else {
            // Jika error, tampilkan pesan error
            alert('Error: ' + data);
        }
    })
    .catch(error => {
        // Tangani error jaringan
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menambah ke keranjang.');
    });
}