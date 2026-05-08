<?php
require_once '../include/config.php';
require_once '../include/functions.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Цей Email вже зареєстровано!";
    } else {
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?registered=1");
            exit();
        } else {
            $error = "Помилка реєстрації!";
        }
    }
}

$base_path = '../';
require_once '../include/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm mt-5">
            <div class="card-body">
                <h3 class="text-center">Реєстрація</h3>
                <hr>
                <?php if($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form action="register.php" method="post">
                    <div class="form-group">
                        <label>Ваше ім'я</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Зареєструватися</button>
                </form>
                <div class="mt-3 text-center">
                    Вже маєте акаунт? <a href="index.php">Увійти</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../include/footer.php'; ?>
