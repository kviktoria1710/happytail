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

    // Перевірка на звичайного користувача
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email_or_login'");
    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            
            // Розумний редирект
            $redirect = '../index.php';
            if (isset($_POST['referer']) && strpos($_POST['referer'], 'lost-found.php') !== false) {
                $redirect = '../lost-found.php';
            }
            
            header("Location: $redirect");
            exit();
        } else {
            $_SESSION['login_error'] = "Невірний пароль!";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Користувача не знайдено!";
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
