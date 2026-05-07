<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== 'admin') {
    header('Location: ../login/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        require_once '../include/config.php';

        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $status = $_POST['status'];
        $description = $_POST['description'];
        $created_at = !empty($_POST['created_at']) ? $_POST['created_at'] . ' ' . date('H:i:s') : date('Y-m-d H:i:s');
        
        $imageName = '';

        // Завантаження файлу
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            $file_mime = mime_content_type($tmp_name);
            $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
            if (in_array($file_mime, $allowed_types) && in_array($file_ext, $allowed_exts)) {
                $imageName = uniqid('pet_') . '.' . $file_ext;
                $upload_dir = '../img/';
                
                // Створення папки img, якщо її немає
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                move_uploaded_file($tmp_name, $upload_dir . $imageName);
            } else {
                $_SESSION['upload_error'] = "Дозволено завантажувати лише зображення (JPG, PNG, GIF, WEBP)!";
                header("Location: add-new.php");
                exit();
            }
        }

        // Вставка через PDO bindValue
        $sql = "INSERT INTO pets (name, image, description, age, gender, status, category_id, created_at) 
                VALUES (:name, :image, :description, :age, :gender, :status, :category_id, :created_at)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':image', $imageName);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':age', $age);
        $stmt->bindValue(':gender', $gender);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':category_id', $category_id);
        $stmt->bindValue(':created_at', $created_at);

        $stmt->execute();

        header("Location: index.php");
        exit();

    } catch (PDOException $e) {
        die("Помилка БД: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}
?>
