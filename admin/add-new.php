<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== 'admin') {
    header('Location: ../login/index.php');
    exit();
}

require_once '../include/config.php';
// Отримуємо список категорій для селекта
$sql_cat = "SELECT * FROM categories";
$res_cat = mysqli_query($conn, $sql_cat);
$categories = mysqli_fetch_all($res_cat, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Додати тварину</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4 mb-5">
    <h2>Додати нову тварину</h2>
    <a href="index.php" class="btn btn-outline-secondary mb-3">Назад</a>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (isset($_SESSION['upload_error'])): ?>
                <div class="alert alert-danger font-weight-bold">
                    <?= htmlspecialchars($_SESSION['upload_error']) ?>
                </div>
                <?php unset($_SESSION['upload_error']); ?>
            <?php endif; ?>
            <form action="check-new.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Кличка тварини <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="category_id">Категорія <span class="text-danger">*</span></label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="">-- Оберіть категорію --</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="age">Вік (напр. "2 роки", "6 місяців")</label>
                    <input type="text" class="form-control" id="age" name="age">
                </div>

                <div class="form-group">
                <label>Стать</label>
                <select name="gender" class="form-control">
                    <option value="Хлопчик">Хлопчик</option>
                    <option value="Дівчинка">Дівчинка</option>
                    <option value="Не вказано">Не вказано</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Статус <span class="text-danger">*</span></label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Шукає дім">Шукає дім</option>
                        <option value="Зарезервовано">Зарезервовано</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Опис</label>
                    <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Фото тварини</label>
                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="created_at">Дата додавання <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="created_at" name="created_at" value="<?= date('Y-m-d') ?>" required>
                </div>

                <button type="submit" class="btn btn-success">Зберегти</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
