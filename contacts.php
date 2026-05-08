<?php
require_once 'include/config.php';
require_once 'include/functions.php';
require_once 'include/header.php';
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-white px-0">
    <li class="breadcrumb-item"><a href="index.php">Головна</a></li>
    <li class="breadcrumb-item active" aria-current="page">Контакти</li>
  </ol>
</nav>

<div class="row">
    <div class="col-md-6">
        <h2>Зв'яжіться з нами</h2>
        <hr>
        <p><strong>Адреса:</strong> м. Гусятин, вул. Незалежності, 1</p>
        <p><strong>Телефон:</strong> +38 (067) 123-45-67</p>
        <p><strong>Email:</strong> happytail@gmail.com</p>
        <p><strong>Години роботи:</strong> Щодня з 09:00 до 18:00</p>
        
        <div class="mt-4">
            <h4>Ми в соцмережах</h4>
            <a href="#" class="btn btn-primary btn-sm">Facebook</a>
            <a href="#" class="btn btn-danger btn-sm">Instagram</a>
            <a href="#" class="btn btn-info btn-sm">Telegram</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-light shadow-sm">
            <div class="card-body">
                <h4>Напишіть нам</h4>
                <form>
                    <div class="form-group">
                        <label>Ваше ім'я</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Повідомлення</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Відправити</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'include/footer.php'; ?>
