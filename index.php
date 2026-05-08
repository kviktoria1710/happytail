<?php
require_once 'include/config.php';
require_once 'include/functions.php';
require_once 'include/header.php';

$search = $_GET['search'] ?? '';
$gender = $_GET['gender'] ?? '';
$status = $_GET['status'] ?? '';

$limit = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_pets = get_pets_count_filtered($search, $gender, $status);
$total_pages = ceil($total_pets / $limit);

$pets = get_all_pets($search, $gender, $status, $limit, $offset);
?>

<?php
// Визначаємо, чи це головна сторінка (без фільтрів та переглядів)
$is_home = !isset($_GET['view']) && empty($search) && empty($gender) && empty($status);

if ($is_home): 
?>
    <div class="jumbotron jumbotron-fluid bg-white py-2 mb-3 border-bottom shadow-sm" style="border-radius: 20px;">
        <div class="container text-center">
            <h4 class="font-weight-bold text-warning mb-1">Подаруйте дім тваринці</h4>
            <p class="text-secondary mx-auto mb-0" style="max-width: 650px; font-size: 0.95rem; line-height: 1.5;">
                Найзаповітніша мрія кожної безпритульної тваринки - знайти свою Людину. Навіть найкращий притулок не замінить затишку та любові справжньої родини. Наша місія - допомогти їм зустрітися з вами.
                Кожен наш підопічний має унікальний характер, тому ми створили для них особисті сторінки. Зручні фільтри допоможуть швидко знайти свого ідеального друга.
                <br>
                Якийсь хвостик запав вам у душу? Зателефонуйте за номером у його анкеті, знайомтеся ближче та забирайте своє щастя додому!
            </p>
        </div>
    </div>

    <!-- Секція "Недавні" -->
    <div class="mb-5">
        <h2 class="font-weight-bold mb-4 mt-2">Недавні</h2>
        <div class="row">
            <?php 
            $recent_pets = get_recent_pets(6);
            if (empty($recent_pets)): 
            ?>
                <div class="col-12"><p>На жаль, тварин поки немає.</p></div>
            <?php else: ?>
                <?php foreach ($recent_pets as $pet): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0 pet-card" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s;">
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
        <div class="text-center mt-4">
            <a href="index.php?view=all" class="btn btn-outline-warning btn-lg px-5">Переглянути всіх тварин</a>
        </div>
    </div>

<?php else: ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="font-weight-bold">Наші тварини, які шукають дім</h2>
        <?php if (is_admin()): ?>
            <a href="admin/add-new.php" class="btn btn-success btn-sm">+ Додати тварину</a>
        <?php endif; ?>
    </div>
    <hr class="mb-4">

    <?php require_once 'include/filters.php'; ?>

    <p class="text-muted mb-4">Знайдено тварин: <?= $total_pets ?></p>

    <!-- Секція "Всі тварини" -->
    <div class="row">
        <?php if (empty($pets)): ?>
            <div class="col-12"><p>На жаль, тварин поки немає.</p></div>
        <?php else: ?>
            <?php foreach ($pets as $pet): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 pet-card">
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
                        <a class="page-link shadow-sm mx-1" href="?page=<?= $i ?>&view=all&search=<?= urlencode($search) ?>&gender=<?= urlencode($gender) ?>&status=<?= urlencode($status) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
<?php endif; ?>

<?php require_once 'include/footer.php'; ?>
