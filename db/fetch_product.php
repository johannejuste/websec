

<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_uuid'])) {
    header('Location: /login');
    exit();
}

try {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');
    $q = $db->prepare("SELECT * FROM products
                       INNER JOIN users
                       ON users.user_uuid = products.user_uuid 
                       WHERE product_id = '$product_id'");


    $q->execute();
    $product = $q->fetch();
} catch (PDOException $ex) {
    echo $ex;
}
