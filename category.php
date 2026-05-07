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

$pets = get_pets_by_category($category_id);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="font-weight-bold"><?= htmlspecialchars($category['name']) ?></h2>
</div>
<hr class="mb-4">

<div class="row">
    <?php if (empty($pets)): ?>
        <div class="col-12"><p>На жаль, тварин у цій категорії поки немає.</p></div>
    <?php else: ?>
        <?php foreach ($pets as $pet): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 pet-card" style="border-radius: 15px; overflow: hidden;">
                    <img src="img/<?= htmlspecialchars($pet['image']) ?>" class="card-img-top pet-img" alt="<?= htmlspecialchars($pet['name']) ?>" style="height: 220px; object-fit: cover;">
                    <img src="img/no-image.png" class="card-img-top pet-img" alt="Немає фото" style="height: 220px; object-fit: cover;">
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title font-weight-bold"><?= htmlspecialchars($pet['name']) ?></h5>
                        <p class="card-text text-secondary">
                            <?= htmlspecialchars(mb_substr($pet['description'], 0, 100)) . '...' ?>
                        </p>
                        <a href="post.php?pet_id=<?= $pet['id'] ?>" class="btn btn-warning flex-grow-1 mr-2 font-weight-bold">Детальніше</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once 'include/footer.php'; ?>
