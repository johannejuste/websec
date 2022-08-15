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
    $q = $db->prepare("UPDATE users SET user_status = 0 WHERE user_uuid = :user_uuid AND user_status = :user_status");
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->bindValue(':user_status', 1);
    $q->execute();

    $success_message = "Your account has been deleted";
    header("Location: /login/success/$success_message");
    exit();
} catch (PDOException $ex) {
    echo 'Oops, something went wrong';
};
