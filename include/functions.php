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

    $sql .= " ORDER BY pets.id ASC LIMIT $limit OFFSET $offset";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
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

function get_recent_pets($limit = 6) {
    global $conn;
    $sql = "SELECT pets.*, categories.name as category_name 
            FROM pets 
            LEFT JOIN categories ON pets.category_id = categories.id 
            ORDER BY pets.id DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}