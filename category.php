<?php
require_once 'include/config.php';
require_once 'include/functions.php';

if (!isset($_GET['category_id']) || !is_numeric($_GET['category_id'])) {
    header("Location: index.php");
    exit();
}

$category_id = (int)$_GET['category_id'];
$category = get_category_title($category_id);

if (!$category) {
    header("Location: index.php");
    exit();
}

require_once 'include/header.php';

$search = $_GET['search'] ?? '';
$gender = $_GET['gender'] ?? '';
$status = $_GET['status'] ?? '';

$limit = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_pets = get_pets_count_filtered($search, $gender, $status, $category_id);
$total_pages = ceil($total_pets / $limit);

$pets = get_pets_by_category($category_id, $search, $gender, $status, $limit, $offset);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="font-weight-bold"><?= htmlspecialchars($category['name']) ?></h2>
    <?php if (is_admin()): ?>
        <a href="admin/add-new.php" class="btn btn-success btn-sm">+ Додати тварину</a>
    <?php endif; ?>
</div>
<hr class="mb-4">

<?php require_once 'include/filters.php'; ?>

<p class="text-muted mb-4">Знайдено у цій категорії: <?= $total_pets ?></p>

<div class="row">
    <?php if (empty($pets)): ?>
        <div class="col-12"><p>На жаль, тварин у цій категорії поки немає.</p></div>
    <?php else: ?>
        <?php foreach ($pets as $pet): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 pet-card" style="border-radius: 15px; overflow: hidden;">
                    <?php if (!empty($pet['image'])): ?>
                        <img src="img/<?= htmlspecialchars($pet['image']) ?>" class="card-img-top pet-img" alt="<?= htmlspecialchars($pet['name']) ?>" style="height: 220px; object-fit: cover;">
                    <?php else: ?>
                        <img src="img/no-image.png" class="card-img-top pet-img" alt="Немає фото" style="height: 220px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title font-weight-bold"><?= htmlspecialchars($pet['name']) ?></h5>
                        <p class="card-text text-muted small">Статус: <?= htmlspecialchars($pet['status']) ?></p>
                        <p class="card-text text-secondary">
                            <?= htmlspecialchars(mb_substr($pet['description'], 0, 100)) . '...' ?>
                        </p>
                        <div class="d-flex justify-content-between mt-auto">
                            <a href="post.php?pet_id=<?= $pet['id'] ?>" class="btn btn-warning flex-grow-1 mr-2 font-weight-bold">Детальніше</a>
                            <?php if (is_admin()): ?>
                                <a href="admin/edit-new.php?pet_id=<?= $pet['id'] ?>" class="btn btn-outline-info px-3" title="Редагувати">✏️</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if ($total_pages > 1): ?>
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?category_id=<?= $category_id ?>&page=<?= $i ?>&search=<?= urlencode($search) ?>&gender=<?= urlencode($gender) ?>&status=<?= urlencode($status) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>

<?php require_once 'include/footer.php'; ?>
