<?php

// ########### VALIDATION ######################

if (is_csrf_valid() != true) {
    header("Location: /404");
    exit();
}

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_uuid'])) {
    header('Location: /login');
    exit();
}

// ########### UPDATE user status (delete) ##############

require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');

try {
    $q = $db->prepare("UPDATE products SET product_status = 0 WHERE product_id = :product_id AND user_uuid = :user_uuid AND product_status = :product_status");
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->bindValue(':product_id', $_POST['user_product']);
    $q->bindValue(':product_status', 1);
    $q->execute();

    // $success_message = "Your product has been deleted";
    header("Location: /account");
    exit();
} catch (PDOException $ex) {
    echo 'Oops, something went wrong';
};
