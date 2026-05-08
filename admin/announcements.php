<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== 'admin') {
    header('Location: ../login/index.php');
    exit();
}

require_once '../include/config.php';
require_once '../include/functions.php';

$sql = "SELECT a.*, u.name as user_name 
        FROM announcements a 
        LEFT JOIN users u ON a.user_id = u.id 
        ORDER BY a.id ASC";
$result = mysqli_query($conn, $sql);
$announcements = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Адмінка - Оголошення</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Панель адміністратора</a>
        <ul class="navbar-nav flex-row">
            <li class="nav-item mr-3"><a class="nav-link" href="../index.php">На сайт</a></li>
            <li class="nav-item"><a class="btn btn-outline-light btn-sm mt-1" href="logout.php">Вихід</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link" href="index.php">🏠Тварини притулку</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active font-weight-bold" href="announcements.php">📢Загублені/Знайдені</a>
        </li>
    </ul>

    <h2>Керування оголошеннями користувачів</h2>
    <hr>

    <table class="table table-bordered table-hover bg-white shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Тип</th>
                <th>Заголовок</th>
                <th>Автор</th>
                <th>Дата</th>
                <th width="200">Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($announcements as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= htmlspecialchars($item['type']) ?></td>
                    <td><?= htmlspecialchars($item['title']) ?></td>
                    <td><?= htmlspecialchars($item['user_name']) ?></td>
                    <td><?= date('d.m.y', strtotime($item['created_at'])) ?></td>
                    <td>
                        <a href="../edit-announcement.php?id=<?= $item['id'] ?>" class="btn btn-info btn-sm">Редагувати</a>
                        <a href="../delete-announcement.php?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Видалити оголошення?')">Видалити</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
