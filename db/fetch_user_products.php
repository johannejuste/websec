<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['admin_user_uuid'])) {
    header('Location: /admin-login');
    exit();
}

try {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');
    $q = $db->prepare("SELECT * FROM products WHERE user_uuid = '$user_id'");
    $q->execute();
    $products = $q->fetchAll();
} catch (PDOException $ex) {
    echo $ex;
}
