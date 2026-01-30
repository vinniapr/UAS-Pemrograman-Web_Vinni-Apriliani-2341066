<?php
// Memulai session untuk autentikasi
session_start();
include 'db.php'; // Sertakan koneksi database

// Jika form dikirim via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Verifikasi password dan redirect jika berhasil
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Font Google untuk styling -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Login</h1> <!-- Judul halaman -->
    </header>
    <main>
        <form method="post" class="login-form">
            <h2>Masuk ke Akun</h2> <!-- Subjudul form -->
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?> <!-- Tampilkan error jika ada -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required> <!-- Input username -->
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required> <!-- Input password -->
            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Login <!-- Icon login -->
            </button>
            <p>Belum punya akun? <a href="register.php">Daftar</a></p> <!-- Link ke register -->
        </form>
    </main>
</body>
</html>