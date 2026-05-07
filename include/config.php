<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$conn = mysqli_connect('localhost', 'root', '', 'shelter');
if (mysqli_connect_errno()) {
    echo 'Помилка підключення до БД: ' . mysqli_connect_error();
    exit();
}
mysqli_set_charset($conn, "utf8mb4");

try {
    $pdo = new PDO('mysql:host=localhost;dbname=shelter;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Помилка підключення PDO: " . $e->getMessage());
}