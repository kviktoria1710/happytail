<?php
require_once 'include/config.php';
require_once 'include/functions.php';

if (!isset($_GET['pet_id']) || !is_numeric($_GET['pet_id'])) {
    header("Location: /index.php");
    exit();
}

$pet_id = (int)$_GET['pet_id'];
$pet = get_pet_by_id($pet_id);

if (!$pet) {
    header("Location: index.php");
    exit();
}

require_once 'include/header.php';
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent px-0">
            <li class="breadcrumb-item"><a href="index.php" class="text-primary">Головна</a></li>
            <li class="breadcrumb-item"><a href="category.php?category_id=<?= $pet['category_id'] ?>" class="text-primary"><?= htmlspecialchars($pet['category_name']) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($pet['name']) ?></li>
        </ol>
    </nav>
    
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px; overflow: hidden; background: #fff; min-height: 550px;">
        <div class="row no-gutters align-items-center">
            <div class="col-md-6" style="height: 550px;">
                <img src="img/<?= htmlspecialchars($pet['image'] ?: 'no-image.png') ?>" class="w-100 h-100" style="object-fit: cover;">
            </div>
            <div class="col-md-6">
                <div class="card-body p-4">
                    <h1 class="display-5 font-weight-bold text-dark mb-4 pb-2 border-bottom"><?= htmlspecialchars($pet['name']) ?></h1>
                    
                    <div class="mb-4" style="font-size: 1.1rem;">
                        <p class="mb-2"><strong>Вік:</strong> <?= htmlspecialchars($pet['age']) ?></p>
                        <p class="mb-2"><strong>Стать:</strong> <?= htmlspecialchars($pet['gender']) ?></p>
                        <p class="mb-2"><strong>Статус:</strong> <span class="badge badge-success px-2 py-1"><?= htmlspecialchars($pet['status']) ?></span></p>
                        <p class="mb-1"><strong>Опис:</strong></p>
                        <p class="text-secondary"><?= nl2br(htmlspecialchars($pet['description'])) ?></p>
                    </div>

                    <div class="p-3 mb-4" style="background-color: #f8f9fa; border-radius: 10px; border: 1px solid #e9ecef;">
                        <h5 class="font-weight-bold mb-2">Контакти для зв'язку:</h5>
                        <p class="mb-1" style="font-size: 1.2rem; color: #333;"><strong>+38 (097) 123-45-67 (Марія)</strong></p>
                        <small class="text-muted">Телефонуйте з 10:00 до 18:00</small>
                    </div>

                    <div class="d-flex align-items-center">
                        <button class="btn btn-warning px-3 py-2 mr-3 shadow-sm font-weight-bold text-white d-flex align-items-center" style="background-color: #f39c12; border: none; border-radius: 8px;" onclick="showAdoptInfo()">
                            <i class="fas fa-paw mr-2"></i> Забрати тваринку
                        </button>
                        <a href="javascript:history.back()" class="btn btn-outline-secondary px-3 py-2" style="border-radius: 8px;">← Назад</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок з інструкцією -->
    <div id="adoptInfo" class="mt-5 p-5 text-center position-relative shadow-sm" style="display: none; background-color: #f2f2f2; border-radius: 5px; border-left: 8px solid #f39c12;">
        <button type="button" class="close position-absolute" style="top: 15px; right: 20px;" onclick="document.getElementById('adoptInfo').style.display='none'">&times;</button>
        
        <h3 class="font-weight-bold mb-4">Вирішили взяти хвостатого друга додому? Це чудово!</h3>
        
        <p class="lead mb-0" style="font-size: 1.3rem; line-height: 1.6;">
            Насамперед, зателефонуйте за номером, вказаним вище. 
            Будьте готові до невеликої співбесіди - нам важливо знати, в які руки потрапить наш вихованець. 
            Ми розповімо про всі нюанси догляду саме за цією тваринкою та домовимось про зустріч!
        </p>
    </div>
</div>

<script>
function showAdoptInfo() {
    var info = document.getElementById('adoptInfo');
    info.style.display = 'block';
    info.scrollIntoView({ behavior: 'smooth' });
}
</script>

<?php require_once 'include/footer.php'; ?>
