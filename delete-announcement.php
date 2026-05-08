<?php
require_once 'include/config.php';
require_once 'include/functions.php';

if (session_status() == PHP_SESSION_NONE) session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: lost-found.php");
    exit();
}

$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT user_id FROM announcements WHERE id = $id");
$item = mysqli_fetch_assoc($result);

if (!$item) {
    header("Location: lost-found.php");
    exit();
}

// Перевірка прав: адмін або власник оголошення
if (!is_admin() && (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $item['user_id'])) {
    die("У вас немає прав для видалення цього оголошення!");
}

mysqli_query($conn, "DELETE FROM announcements WHERE id = $id");
header("Location: lost-found.php");
exit();
?>
