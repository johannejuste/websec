<?php


session_start();


if (is_csrf_valid() != true) {
    header("Location: /404");
    exit();
}


if (!isset($_SESSION)) {
    echo  $_SESSION['user_uuid'];
}
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /login');
    exit();
}
if (!isset($_POST['reply_message'])) {
    header("Location: /single-product/$product_id");
    exit();
}
if (
    strlen($_POST['reply_message']) < 1 ||
    strlen($_POST['reply_message']) > 800
) {

    header("Location: /single-product/$product_id");
    exit();
}



//DATABASE
$tz = 'Europe/Copenhagen';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
$currentDate = $dt->format('F j Y, H:i:s');


//$comment_id = $_POST['comment_id'];
/*  var_dump($comment_id);
    exit(); */

try {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db/globals.php');
    $encryptedReply = openssl_encrypt($_POST['reply_message'], $encrypt_algo, $key, OPENSSL_RAW_DATA, $iv);
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');
    $q = $db->prepare("INSERT INTO `replies` VALUES ( :reply_id, :reply_iv, :user_uuid, :comment_id, :reply_body, :created_at, :updated_at )");
    $q->bindValue(':reply_id', bin2hex(random_bytes(16)));
    $q->bindValue(':reply_iv',  base64_encode($iv));
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->bindValue(':comment_id', $comment_id);
    $q->bindValue(':reply_body',  base64_encode($encryptedReply));
    $q->bindValue(':created_at', $currentDate);
    $q->bindValue(':updated_at', $currentDate);





    $q->execute();
    if (!$q->rowCount()) {
        echo 'vi er her', $_SESSION['user_uuid'];

        exit;
    }
    header("Location: /single-product/$product_id");
    exit();
} catch (PDOException $ex) {
    echo $ex;
}
