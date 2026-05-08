<?php
function get_menu() {
    global $conn;
    $sql = "SELECT * FROM menu ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_all_pets($search = '', $gender = '', $status = '', $limit = 9, $offset = 0) {
    global $conn;
    $sql = "SELECT pets.*, categories.name as category_name 
            FROM pets 
            LEFT JOIN categories ON pets.category_id = categories.id WHERE 1=1";
    
    if (!empty($search)) {
        $search = mysqli_real_escape_string($conn, $search);
        $sql .= " AND (pets.name LIKE '%$search%' OR pets.description LIKE '%$search%')";
    }
    if (!empty($gender)) {
        $gender = mysqli_real_escape_string($conn, $gender);
        $sql .= " AND pets.gender = '$gender'";
    }
    if (!empty($status)) {
        $status = mysqli_real_escape_string($conn, $status);
        $sql .= " AND pets.status = '$status'";
    }

    $sql .= " ORDER BY pets.id ASC LIMIT $limit OFFSET $offset";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_pets_count_filtered($search = '', $gender = '', $status = '', $category_id = null) {
    global $conn;
    $sql = "SELECT COUNT(*) as total FROM pets WHERE 1=1";
    if ($category_id) $sql .= " AND category_id = " . (int)$category_id;
    if (!empty($search)) {
        $search = mysqli_real_escape_string($conn, $search);
        $sql .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')";
    }
    if (!empty($gender)) {
        $gender = mysqli_real_escape_string($conn, $gender);
        $sql .= " AND gender = '$gender'";
    }
    if (!empty($status)) {
        $status = mysqli_real_escape_string($conn, $status);
        $sql .= " AND status = '$status'";
    }
    
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function get_pet_by_id($pet_id) {
    global $conn;
    $pet_id = mysqli_real_escape_string($conn, $pet_id);
    $sql = "SELECT pets.*, categories.name as category_name 
            FROM pets 
            LEFT JOIN categories ON pets.category_id = categories.id 
            WHERE pets.id = '$pet_id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function get_pets_by_category($category_id, $search = '', $gender = '', $status = '', $limit = 9, $offset = 0) {
    global $conn;
    $category_id = mysqli_real_escape_string($conn, $category_id);
    $sql = "SELECT pets.*, categories.name as category_name 
            FROM pets 
            LEFT JOIN categories ON pets.category_id = categories.id 
            WHERE category_id = '$category_id'";

    if (!empty($search)) {
        $search = mysqli_real_escape_string($conn, $search);
        $sql .= " AND (pets.name LIKE '%$search%' OR pets.description LIKE '%$search%')";
    }
    if (!empty($gender)) {
        $gender = mysqli_real_escape_string($conn, $gender);
        $sql .= " AND pets.gender = '$gender'";
    }
    if (!empty($status)) {
        $status = mysqli_real_escape_string($conn, $status);
        $sql .= " AND pets.status = '$status'";
    }

    $sql .= " ORDER BY pets.id ASC LIMIT $limit OFFSET $offset";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_categories_with_counts() {
    global $conn;
    $sql = "SELECT categories.*, COUNT(pets.id) as pet_count 
            FROM categories 
            LEFT JOIN pets ON categories.id = pets.category_id 
            GROUP BY categories.id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_total_pets_count() {
    global $conn;
    $result = mysqli_query($conn, "SELECT COUNT(id) as total FROM pets");
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function get_category_title($category_id) {
    global $conn;
    $category_id = mysqli_real_escape_string($conn, $category_id);
    $sql = "SELECT * FROM categories WHERE id = '$category_id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Функція для перевірки чи авторизований адмін
function is_admin() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['login']) && $_SESSION['login'] === 'admin';
}

function delete_pet($pet_id) {
    global $conn;
    $pet_id = mysqli_real_escape_string($conn, $pet_id);
    
    // Отримуємо назву фото перед видаленням запису
    $res = mysqli_query($conn, "SELECT image FROM pets WHERE id = '$pet_id'");
    if ($row = mysqli_fetch_assoc($res)) {
        $image_path = __DIR__ . "/../img/" . $row['image'];
        // Якщо фото існує і це не пустий рядок — видаляємо його фізично
        if (!empty($row['image']) && file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    $sql = "DELETE FROM pets WHERE id = '$pet_id'";
    return mysqli_query($conn, $sql);
}

function get_recent_pets($limit = 6) {
    global $conn;
    $sql = "SELECT pets.*, categories.name as category_name 
            FROM pets 
            LEFT JOIN categories ON pets.category_id = categories.id 
            ORDER BY pets.id DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}