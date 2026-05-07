<?php
require_once 'include/config.php';
require_once 'include/functions.php';
require_once 'include/header.php';

$pets = get_all_pets();
?>

<?php
$is_home = !isset($_GET['view']) && empty($search);

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
            foreach ($recent_pets as $pet):
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 pet-card" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s;">
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
        </div>
    </div>

<?php else: ?>
    <!-- Секція "Всі тварини" -->
    <div class="row">
        <?php foreach ($pets as $pet): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 pet-card">
                    <img src="img/<?= htmlspecialchars($pet['image']) ?: 'no-image.png' ?>" class="card-img-top pet-img" style="height: 220px; object-fit: cover;">
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title font-weight-bold"><?= htmlspecialchars($pet['name']) ?></h5>
                        <p class="card-text text-secondary">
                            <?= htmlspecialchars(mb_substr($pet['description'], 0, 100)) . '...' ?>
                        </p>
                        <a href="post.php?pet_id=<?= $pet['id'] ?>" class="btn btn-warning mt-auto font-weight-bold">Детальніше</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once 'include/footer.php'; ?>
