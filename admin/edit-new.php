<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== 'admin') {
    header('Location: ../login/index.php');
    exit();
}

require_once '../include/config.php';
require_once '../include/functions.php';

if (!isset($_GET['pet_id']) || !is_numeric($_GET['pet_id'])) {
    header("Location: index.php");
    exit();
}

$pet_id = (int)$_GET['pet_id'];
$pet = get_pet_by_id($pet_id);

if (!$pet) {
    header("Location: index.php");
    exit();
}

$sql_cat = "SELECT * FROM categories";
$res_cat = mysqli_query($conn, $sql_cat);
$categories = mysqli_fetch_all($res_cat, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Редагувати тварину</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4 mb-5">
    <h2>Редагувати тварину: <?= htmlspecialchars($pet['name']) ?></h2>
    <a href="index.php" class="btn btn-outline-secondary mb-3">Назад</a>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (isset($_SESSION['upload_error'])): ?>
                <div class="alert alert-danger font-weight-bold">
                    <?= htmlspecialchars($_SESSION['upload_error']) ?>
                </div>
                <?php unset($_SESSION['upload_error']); ?>
            <?php endif; ?>
            <form action="update-new.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $pet['id'] ?>">
                
                <div class="form-group">
                    <label for="name">Кличка тварини <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($pet['name']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="category_id">Категорія <span class="text-danger">*</span></label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $pet['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="age">Вік</label>
                    <input type="text" class="form-control" id="age" name="age" value="<?= htmlspecialchars($pet['age']) ?>">
                </div>

                <div class="form-group">
                    <label>Стать</label>
                    <select name="gender" class="form-control">
                        <option value="Хлопчик" <?= $pet['gender'] == 'Хлопчик' ? 'selected' : '' ?>>Хлопчик</option>
                        <option value="Дівчинка" <?= $pet['gender'] == 'Дівчинка' ? 'selected' : '' ?>>Дівчинка</option>
                        <option value="Не вказано" <?= $pet['gender'] == 'Не вказано' ? 'selected' : '' ?>>Не вказано</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Статус <span class="text-danger">*</span></label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Шукає дім" <?= $pet['status'] == 'Шукає дім' ? 'selected' : '' ?>>Шукає дім</option>
                        <option value="Зарезервовано" <?= $pet['status'] == 'Зарезервовано' ? 'selected' : '' ?>>Зарезервовано</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Опис</label>
                    <textarea class="form-control" id="description" name="description" rows="5"><?= htmlspecialchars($pet['description']) ?></textarea>
                </div>

                <div class="form-group">
                    <label>Поточне фото:</label><br>
                    <?php if(!empty($pet['image'])): ?>
                        <img src="../img/<?= htmlspecialchars($pet['image']) ?>" width="150" class="mb-2"><br>
                    <?php else: ?>
                        <p class="text-muted">Немає фото</p>
                    <?php endif; ?>
                    <label for="image">Нове фото (залишіть порожнім, щоб не змінювати)</label>
                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="created_at">Дата додавання <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="created_at" name="created_at" value="<?= date('Y-m-d', strtotime($pet['created_at'])) ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Оновити</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
