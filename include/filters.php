<?php
$search = $_GET['search'] ?? '';
$gender = $_GET['gender'] ?? '';
$status = $_GET['status'] ?? '';
?>
<div class="card bg-light mb-4 shadow-sm">
    <div class="card-body">
        <form action="<?= basename($_SERVER['PHP_SELF']) ?>" method="get" class="form-row align-items-end">
            <?php if(isset($_GET['category_id'])): ?>
                <input type="hidden" name="category_id" value="<?= htmlspecialchars($_GET['category_id']) ?>">
            <?php endif; ?>
            <?php if(isset($_GET['view'])): ?>
                <input type="hidden" name="view" value="<?= htmlspecialchars($_GET['view']) ?>">
            <?php endif; ?>
            <div class="form-group col-md-4">
                <label>Пошук за назвою</label>
                <input type="text" name="search" class="form-control" placeholder="Кличка або опис..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="form-group col-md-2">
                <label>Стать</label>
                <select name="gender" class="form-control">
                    <option value="">Всі</option>
                    <option value="Хлопчик" <?= (isset($_GET['gender']) && $_GET['gender'] == 'Хлопчик') ? 'selected' : '' ?>>Хлопчик</option>
                    <option value="Дівчинка" <?= (isset($_GET['gender']) && $_GET['gender'] == 'Дівчинка') ? 'selected' : '' ?>>Дівчинка</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Статус</label>
                <select name="status" class="form-control">
                    <option value="">Всі</option>
                    <option value="Шукає дім" <?= $status == 'Шукає дім' ? 'selected' : '' ?>>Шукає дім</option>
                    <option value="Зарезервовано" <?= $status == 'Зарезервовано' ? 'selected' : '' ?>>Зарезервовано</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <button type="submit" class="btn btn-warning w-100">🔍 Знайти</button>
            </div>
        </form>
    </div>
</div>
