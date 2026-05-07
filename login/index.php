<?php
$base_path = '../';
require_once '../include/config.php';
require_once '../include/functions.php';

$error = '';
if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

require_once '../include/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm mt-5">
            <div class="card-body">
                <h3 class="text-center">Вхід для користувачів</h3>
                <hr>
                <?php if($error): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form action="check-login.php" method="post">
                    <input type="hidden" name="referer" value="<?= htmlspecialchars($_SERVER['HTTP_REFERER'] ?? '') ?>">
                    <div class="form-group">
                        <label>Логін</label>
                        <input type="text" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Увійти</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../include/footer.php'; ?>
