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
    $q = $db->prepare("SELECT * FROM replies INNER JOIN users
                        ON users.user_uuid = replies.user_uuid
                        WHERE comment_id = '$comment_id'
                        ORDER BY created_at ASC

    ");
    $q->execute();
    $replies = $q->fetchAll();
} catch (PDOException $ex) {
    echo $ex;
}
