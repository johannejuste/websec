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
    $q = $db->prepare("SELECT * FROM comments 
                        INNER JOIN users
                        ON users.user_uuid = comments.user_uuid
                        WHERE product_id = '$product_id'
                        ORDER BY comment_timestamp DESC
                        ");
    $q->execute();
    $comments = $q->fetchAll();
} catch (PDOException $ex) {
    echo $ex;
}
