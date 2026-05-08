<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== 'admin') {
    header('Location: ../login/index.php');
    exit();
}

require_once '../include/config.php';
require_once '../include/functions.php';

$pets = get_all_pets('', '', '', 100, 0);
$offset = 0;
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Адмін-панель</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Панель адміністратора</a>
        <span class="navbar-text mr-3">
            Привіт, Admin!
        </span>
        <ul class="navbar-nav flex-row">
            <li class="nav-item mr-3">
                <a class="nav-link" href="../index.php" target="_blank">На сайт</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-outline-light btn-sm mt-1" href="logout.php">Вихід</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link active font-weight-bold" href="index.php">🏠Тварини притулку</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" href="announcements.php">📢Загублені/Знайдені</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Список тварин притулку</h2>
        <a href="add-new.php" class="btn btn-success">Додати тварину</a>
    </div>

    <table class="table table-bordered table-striped shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>№</th>
                <th>Фото</th>
                <th>Кличка</th>
                <th>Категорія</th>
                <th>Стать</th>
                <th>Статус</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($pets)): ?>
                <tr>
                    <td colspan="7" class="text-center">Немає записів</td>
                </tr>
            <?php else: ?>
                <?php $counter = 1 + $offset;?>
                <?php foreach($pets as $pet): ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td>
                            <?php if(!empty($pet['image'])): ?>
                                <img src="../img/<?= htmlspecialchars($pet['image']) ?>" alt="Фото" width="50">
                            <?php else: ?>
                                <span class="text-muted">Немає</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($pet['name']) ?></td>
                        <td><?= htmlspecialchars($pet['category_name']) ?></td>
                        <td><?= htmlspecialchars($pet['gender']) ?></td>
                        <td><?= htmlspecialchars($pet['status']) ?></td>
                        <td>
                            <a href="edit-new.php?pet_id=<?= $pet['id'] ?>" class="btn btn-info btn-sm">Редагувати</a>
                            <a href="delete-new.php?pet_id=<?= $pet['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Ви впевнені?');">Видалити</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
