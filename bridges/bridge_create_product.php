<?php
session_start();



require_once($_SERVER['DOCUMENT_ROOT'] . '/backendValidation/createProduct.php');

$valid_extensions = ['png', 'jpg', 'jpeg', 'jfif'];
$images = [];
foreach ($_FILES['file-to-upload']['tmp_name'] as $file) {
    $image_type = mime_content_type($file);
    $extension = strrchr($image_type, '/');
    $extension = ltrim($extension, '/');
    if (!in_array($extension, $valid_extensions)) {
        echo "mmm.. hacking me?";
        exit();
    }
    $random_image_name = bin2hex(random_bytes(16)) . ".$extension";
    array_push($images, $random_image_name);
    move_uploaded_file($file, "product-images/$random_image_name");
};

$images = json_encode($images);

//DATABASE

$tz = 'Europe/Copenhagen';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
$currentDate = $dt->format('F j Y, H:i:s');

try {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db/globals.php');
    $encryptedDescription = openssl_encrypt($_POST['product_description'], $encrypt_algo, $key, OPENSSL_RAW_DATA, $iv);
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');
    $q = $db->prepare("INSERT INTO `products` VALUES ( :product_id, :user_uuid, :product_title, :product_description, :product_image, :product_timestamp, :product_price, :product_category, :product_iv, :product_status)");
    $q->bindValue(':product_id', bin2hex(random_bytes(16)));
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->bindValue(':product_title', $_POST['product_title']);
    $q->bindValue(':product_description', base64_encode($encryptedDescription));
    $q->bindValue(':product_image', $images);
    $q->bindValue(':product_timestamp', $currentDate);
    $q->bindValue(':product_price', $_POST['product_price']);
    $q->bindValue(':product_category', $_POST['product_category']);
    $q->bindValue(':product_iv',  base64_encode($iv));
    $q->bindValue(':product_status',  1);

    $q->execute();
    if (!$q->rowCount()) {
        echo 'vi er her', $_SESSION['user_uuid'];

        exit;
    }
    header('Location: /index');
    exit();
} catch (PDOException $ex) {
    echo $ex;
}
