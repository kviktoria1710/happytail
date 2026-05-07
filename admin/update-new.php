<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== 'admin') {
    header('Location: ../login/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        require_once '../include/config.php';

        $id = $_POST['id'];
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $status = $_POST['status'];
        $description = $_POST['description'];
        $created_at = !empty($_POST['created_at']) ? $_POST['created_at'] . ' ' . date('H:i:s') : date('Y-m-d H:i:s');
        
        $sql = "UPDATE pets SET name = :name, category_id = :category_id, age = :age, gender = :gender, status = :status, description = :description, created_at = :created_at";
        
        // Перевіряємо чи завантажено нове фото
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            $file_mime = mime_content_type($tmp_name);
            $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
            if (in_array($file_mime, $allowed_types) && in_array($file_ext, $allowed_exts)) {
                $imageName = uniqid('pet_') . '.' . $file_ext;
                $upload_dir = '../img/';
                
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $stmtOld = $pdo->prepare("SELECT image FROM pets WHERE id = :id");
                $stmtOld->execute([':id' => $id]);
                $oldPhoto = $stmtOld->fetchColumn();
                if ($oldPhoto && file_exists('../img/' . $oldPhoto)) {
                    unlink('../img/' . $oldPhoto);
                }
                
                move_uploaded_file($tmp_name, $upload_dir . $imageName);
                $sql .= ", image = :image";
            } else {
                $_SESSION['upload_error'] = "Дозволено завантажувати лише зображення (JPG, PNG, GIF, WEBP)!";
                header("Location: edit-new.php?pet_id=" . $id);
                exit();
            }
        }

        $sql .= " WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':id', $id);
        
        if (isset($imageName)) {
            $stmt->bindParam(':image', $imageName);
        }

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
