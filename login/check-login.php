<?php
require_once '../include/config.php';
require_once '../include/functions.php';

// Безпечне підключення конфігураційного файлу
if (file_exists('../include/credentials.php')) {
    require_once '../include/credentials.php';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_or_login = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Перевірка на адміна
    if (defined('ADMIN_LOGIN') && defined('ADMIN_PASSWORD') && $email_or_login === ADMIN_LOGIN && $password === ADMIN_PASSWORD) {
        $_SESSION['login'] = 'admin';
        header("Location: ../index.php");
        exit();
    }
    else {
        $_SESSION['login_error'] = "Невірний логін або пароль!";
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
