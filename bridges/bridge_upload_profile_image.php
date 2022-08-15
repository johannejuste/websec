<?php

if (is_csrf_valid() != true) {
    header("Location: /404");
    exit();
}

if (!isset($_SESSION)) {
    session_start();
};

if (!$_FILES['file-to-upload']['name']) {
    header('Location: /account-edit');
    exit;
}



$valid_extensions = ['png', 'jpg', 'jpeg', 'jfif'];

$image_type = mime_content_type($_FILES['file-to-upload']['tmp_name']); // image/png
$extension = strrchr($image_type, '/'); // /png ... /tmp ... /jpg
$extension = ltrim($extension, '/'); // png ... jpg ... plain

if (!in_array($extension, $valid_extensions)) {
    echo "mmm.. hacking me?";
    exit();
}

$random_image_name = bin2hex(random_bytes(16)) . ".$extension";
move_uploaded_file($_FILES['file-to-upload']['tmp_name'], "profile-uploads/$random_image_name");


try {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');
    $q = $db->prepare("UPDATE users SET user_image = '$random_image_name' WHERE user_uuid = :user_uuid");
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->execute();
    if (!$q->rowCount()) {
        echo 'sometasdasdasg';
        exit();
    }

    $_SESSION['user_image'] = $random_image_name;



    header("Location: /account");

    exit();
} catch (PDOException $ex) {
    echo $ex;
}
