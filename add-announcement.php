<?php
require_once 'include/config.php';
require_once 'include/functions.php';

if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login/index.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = trim($_POST['type']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $user_id = $_SESSION['user_id'];
    
    $imageName = '';
    $upload_ok = true;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        $file_mime = mime_content_type($tmp_name);
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($file_mime, $allowed_types) && in_array($file_ext, $allowed_exts)) {
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            if (!file_exists('img/announcements')) mkdir('img/announcements', 0777, true);
            move_uploaded_file($tmp_name, 'img/announcements/' . $imageName);
        } else {
            $error = "Дозволено завантажувати лише зображення (JPG, PNG, GIF, WEBP)!";
            $upload_ok = false;
        }
    }

    if ($upload_ok) {
        $sql = "INSERT INTO announcements (type, title, description, image, phone, user_id) 
                VALUES ('$type', '$title', '$description', '$imageName', '$phone', '$user_id')";
        mysqli_query($conn, $sql);
        header("Location: lost-found.php");
        exit();
    }
}

require_once 'include/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3>Додати оголошення</h3>
                <hr>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger font-weight-bold">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <form action="add-announcement.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Тип оголошення</label>
                        <select name="type" class="form-control" required>
                            <option value="Я загубив тваринку">Я загубив тваринку</option>
                            <option value="Я знайшов тваринку">Я знайшов тваринку</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Заголовок (напр. "Загубився рудий кіт")</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Опис (місце, час, особливі прикмети)</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Номер телефону для зв'язку</label>
                        <input type="text" name="phone" class="form-control" placeholder="+380..." required>
                    </div>
                    <div class="form-group">
                        <label>Фото тваринки</label>
                        <input type="file" name="image" class="form-control-file">
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Опублікувати</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'include/footer.php'; ?>
