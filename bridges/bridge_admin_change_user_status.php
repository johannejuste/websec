<?php

// ########### VALIDATION ######################

if (is_csrf_valid() != true) {
    header("Location: /404");
    exit();
}


if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['admin_user_uuid'])) {
    header('Location: /admin-login');
    exit();
}

// ########### UPDATE user status (delete) ##############

require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');

if ($_POST['user_status'] == 1) {

    try {
        $q = $db->prepare("UPDATE users SET user_status = 0 WHERE user_uuid = :user_uuid AND user_status = :user_status");
        $q->bindValue(':user_uuid', $_POST['user_id']);
        $q->bindValue(':user_status', 1);
        $q->execute();

        header("Location: /admin-index");
        exit();
    } catch (PDOException $ex) {
        echo 'Oops, something went wrong';
    };
} else {
    try {
        $q = $db->prepare("UPDATE users SET user_status = 1 WHERE user_uuid = :user_uuid AND user_status = :user_status");
        $q->bindValue(':user_uuid', $_POST['user_id']);
        $q->bindValue(':user_status', 0);
        $q->execute();

        header("Location: /admin-index");
        exit();
    } catch (PDOException $ex) {
        echo 'Oops, something went wrong';
    };
}
