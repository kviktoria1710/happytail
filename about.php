<?php
require_once 'include/config.php';
require_once 'include/functions.php';
require_once 'include/header.php';
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-white px-0">
        <li class="breadcrumb-item"><a href="index.php">Головна</a></li>
        <li class="breadcrumb-item active" aria-current="page">Про проєкт</li>
    </ol>
</nav>

<div class="row align-items-center">
    <div class="col-md-8">
        <h2 class="font-weight-bold">Про наш притулок</h2>
        <hr>
        <p class="lead">Наш притулок для тварин був заснований у 2024 році групою волонтерів, які не могли залишатися байдужими до долі безпритульних хвостиків.</p>
        
        <p>Наша мета - знайти люблячу родину для кожної тварини, яка потрапила до нас. Ми віримо, що кожне життя цінне, а кожен хвостик заслуговує на теплий дім та турботливого господаря.</p>
        
        <h5 class="font-weight-bold mt-4">Ми забезпечуємо тварин усім необхідним:</h5>
        <ul class="mt-3">
            <li class="mb-2">Збалансоване харчування преміум-класу</li>
            <li class="mb-2">Ветеринарний догляд, регулярна вакцинація та обробка</li>
            <li class="mb-2">Теплі, чисті та просторі вольєри</li>
            <li class="mb-2">Соціалізація, ігри та прогулянки з волонтерами</li>
        </ul>

        <div class="alert alert-warning mt-4 border-0 shadow-sm" style="border-radius: 10px;">
            <p class="mb-0"><strong>Кожна тварина заслуговує на другий шанс і теплий дім!</strong> Приєднуйтесь до нашої спільноти волонтерів або станьте новою родиною для одного з наших підопічних.</p>
        </div>
    </div>
    <div class="col-md-4">
        <img src="img/cat-and-dog.jpg" class="img-fluid rounded shadow-sm border" alt="Про нас" style="border-radius: 15px;">
        <div class="card mt-4 border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body text-center">
                <h6 class="font-weight-bold">Бажаєте допомогти?</h6>
                <p class="small text-muted">Ваша підтримка рятує життя</p>
                <a href="donate.php" class="btn btn-warning btn-sm btn-block font-weight-bold">Зробити внесок</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'include/footer.php'; ?>
