<?php
function get_menu() {
    global $conn;
    $sql = "SELECT * FROM menu ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}