<?php
require_once 'include/config.php';
require_once 'include/functions.php';
require_once 'include/header.php';

$sql = "SELECT a.*, u.name as user_name 
        FROM announcements a 
        LEFT JOIN users u ON a.user_id = u.id 
        ORDER BY a.created_at DESC";
$result = mysqli_query($conn, $sql);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📢 Загублені та знайдені тварини</h2>
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="add-announcement.php" class="btn btn-success">Додати оголошення</a>
    <?php else: ?>
        <a href="login/index.php" class="btn btn-outline-primary btn-sm">Увійдіть, щоб додати</a>
    <?php endif; ?>
</div>

<div class="row">
    <?php if(empty($items)): ?>
        <div class="col-12"><p class="text-center text-muted">Оголошень поки немає.</p></div>
    <?php else: ?>
        <?php foreach($items as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 announcement-card pet-card" style="border-radius: 15px; overflow: hidden;">
                    <div class="position-relative">
                        <?php if($item['image']): ?>
                            <img src="img/announcements/<?= $item['image'] ?>" class="card-img-top pet-img" style="height: 220px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 220px;">Немає фото</div>
                        <?php endif; ?>
                        <div class="position-absolute" style="top: 15px; left: 15px;">
                            <span class="bg-white shadow-sm px-3 py-2" style="border-radius: 20px; font-weight: bold; font-size: 0.9rem;">
                                <?= htmlspecialchars($item['type']) ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title font-weight-bold mb-2"><?= htmlspecialchars($item['title']) ?></h5>
                        <p class="card-text text-secondary small mb-3">
                            <?= htmlspecialchars(mb_substr($item['description'], 0, 100)) ?>...
                        </p>
                        <div class="mt-auto pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-dark font-weight-bold small"><i class="fas fa-phone mr-1"></i> <?= htmlspecialchars($item['phone']) ?></span>
                                <span class="text-muted" style="font-size: 0.8rem;"><?= date('d.m.Y', strtotime($item['created_at'])) ?></span>
                            </div>
                            <div class="d-flex justify-content-between gap-2">
                                <a href="announcement-post.php?id=<?= $item['id'] ?>" class="btn btn-warning flex-grow-1 font-weight-bold py-2 shadow-sm">Детальніше</a>
                                <?php if(is_admin() || (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $item['user_id'])): ?>
                                    <div class="ml-2">
                                        <a href="edit-announcement.php?id=<?= $item['id'] ?>" class="btn btn-outline-info px-2" title="Редагувати">✏️</a>
                                        <a href="delete-announcement.php?id=<?= $item['id'] ?>" class="btn btn-outline-danger px-2" onclick="return confirm('Видалити?')" title="Видалити">🗑️</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once 'include/footer.php'; ?>
