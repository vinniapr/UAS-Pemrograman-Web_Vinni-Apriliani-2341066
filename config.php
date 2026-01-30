<?php
$host = 'localhost';
$user = 'root'; // Ganti dengan username DB Anda
$pass = ''; // Ganti dengan password DB Anda
$db = 'ecommerce_db';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>