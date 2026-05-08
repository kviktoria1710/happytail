<?php
require_once 'include/config.php';
require_once 'include/functions.php';

if (session_status() == PHP_SESSION_NONE) session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: lost-found.php");
    exit();
}

$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM announcements WHERE id = $id");
$item = mysqli_fetch_assoc($result);

if (!$item) {
    header("Location: lost-found.php");
    exit();
}

// Перевірка прав: адмін або власник
if (!is_admin() && (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $item['user_id'])) {
    die("У вас немає прав для редагування цього оголошення!");
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = trim($_POST['type']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    $sql = "UPDATE announcements SET `type`='$type', title='$title', description='$description', phone='$phone'";
    
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
            $sql .= ", image='$imageName'";
        } else {
            $error = "Дозволено завантажувати лише зображення (JPG, PNG, GIF, WEBP)!";
            $upload_ok = false;
        }
    }

    if ($upload_ok) {
        $sql .= " WHERE id = $id";
        mysqli_query($conn, $sql);
        header("Location: announcement-post.php?id=$id");
        exit();
    }
}

require_once 'include/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3>Редагувати оголошення</h3>
                <hr>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger font-weight-bold">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <form action="edit-announcement.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Тип оголошення</label>
                        <select name="type" class="form-control" required>
                            <option value="Я загубив тваринку" <?= (mb_stripos($item['type'], 'загубив') !== false || mb_stripos($item['type'], 'Загубл') !== false) ? 'selected' : '' ?>>Я загубив тваринку</option>
                            <option value="Я знайшов тваринку" <?= (mb_stripos($item['type'], 'знайшов') !== false || mb_stripos($item['type'], 'Знайд') !== false) ? 'selected' : '' ?>>Я знайшов тваринку</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Заголовок</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($item['title']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Опис</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($item['description']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Номер телефону</label>
                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($item['phone']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Змінити фото (залишіть порожнім, щоб не змінювати)</label>
                        <input type="file" name="image" class="form-control-file">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Зберегти зміни</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'include/footer.php'; ?>
