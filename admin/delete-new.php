<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== 'admin') {
    header('Location: ../login/index.php');
    exit();
}

require_once '../include/config.php';
require_once '../include/functions.php';

if (isset($_GET['pet_id']) && is_numeric($_GET['pet_id'])) {
    $pet_id = (int)$_GET['pet_id'];
    delete_pet($pet_id);
}

header("Location: index.php");
exit();
?>
