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
    $q = $db->prepare('SELECT * FROM products where product_status = 1
        order by product_timestamp DESC
         LIMIT 4

  ');
    $q->execute();

    $newest_products = $q->fetchAll();
} catch (PDOException $ex) {
    echo $ex;
}
