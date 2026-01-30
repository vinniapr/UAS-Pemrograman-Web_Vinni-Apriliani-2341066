<?php
include 'db.php'; // Sertakan koneksi database

// Jika form dikirim via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password untuk keamanan

    // Insert user baru ke database
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt->execute([$username, $password])) {
        header('Location: login.php'); // Redirect ke login setelah berhasil
        exit;
    } else {
        $error = "Pendaftaran gagal.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Font Google untuk styling -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Daftar Akun</h1> <!-- Judul halaman -->
    </header>
    <main>
        <form method="post" class="login-form">
            <h2>Daftar Akun Baru</h2> <!-- Subjudul form -->
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?> <!-- Tampilkan error jika ada -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required> <!-- Input username -->
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required> <!-- Input password -->
            <button type="submit">Daftar</button> <!-- Tombol submit -->
            <p>Sudah punya akun? <a href="login.php">Login</a></p> <!-- Link ke login -->
        </form>
    </main>
</body>
</html>