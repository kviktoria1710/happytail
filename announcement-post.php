<?php
require_once 'include/config.php';
require_once 'include/functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: lost-found.php");
    exit();
}

$id = (int)$_GET['id'];
$sql = "SELECT a.*, u.name as user_name 
        FROM announcements a 
        LEFT JOIN users u ON a.user_id = u.id 
        WHERE a.id = $id";
$result = mysqli_query($conn, $sql);
$item = mysqli_fetch_assoc($result);

if (!$item) {
    header("Location: lost-found.php");
    exit();
}

require_once 'include/header.php';
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-white px-0">
    <li class="breadcrumb-item"><a href="index.php">Головна</a></li>
    <li class="breadcrumb-item"><a href="lost-found.php">Загублені та знайдені</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($item['title']) ?></li>
  </ol>
</nav>

<div class="card shadow-sm mb-5" style="min-height: 550px; border-radius: 15px; overflow: hidden;">
    <div class="row no-gutters align-items-center">
        <div class="col-md-6" style="height: 550px;">
            <?php if($item['image']): ?>
                <img src="img/announcements/<?= $item['image'] ?>" class="w-100 h-100" style="object-fit: cover; background: #f8f9fa;">
            <?php else: ?>
                <div class="bg-light h-100 d-flex align-items-center justify-content-center">Немає фото</div>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <div class="card-body p-4">
                <span class="font-weight-bold d-block mb-3" style="font-size: 1.1rem;"><?= htmlspecialchars($item['type']) ?></span>
                <h2><?= htmlspecialchars($item['title']) ?></h2>
                <hr>
                <p class="card-text"><strong>Опис:</strong></p>
                <p class="card-text"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                
                <div class="alert alert-warning mt-4">
                    <h5>📞 Контактна інформація:</h5>
                    <p class="mb-0"><strong>Телефон:</strong> <a href="tel:<?= $item['phone'] ?>"><?= htmlspecialchars($item['phone']) ?></a></p>
                    <p class="mb-0"><strong>Додав:</strong> <?= htmlspecialchars($item['user_name']) ?></p>
                    <p class="mb-0 text-muted small">Дата публікації: <?= date('d.m.Y H:i', strtotime($item['created_at'])) ?></p>
                </div>

                <div class="mt-4">
                    <a href="lost-found.php" class="btn btn-outline-secondary">← Назад</a>
                    <?php if(is_admin() || (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $item['user_id'])): ?>
                        <a href="edit-announcement.php?id=<?= $item['id'] ?>" class="btn btn-info">Редагувати</a>
                        <a href="delete-announcement.php?id=<?= $item['id'] ?>" class="btn btn-danger" onclick="return confirm('Ви впевнені?')">Видалити</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'include/footer.php'; ?>
