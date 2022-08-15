<?php
// ################### CSRF ###############################



if (is_csrf_valid() != true) {
    header("Location: /404");
    exit();
}


// #########################################################
// ################### ISSET ###############################
// #########################################################


if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /login');
    exit();
}
if (!isset($_POST['product_title'])) {
    $error_message = "Please provide a title";
    header("Location: /update-product/error/$error_message/$product_id");
    exit();
}
if (!isset($_POST['product_price'])) {
    $error_message = "Please provide a Password";
    header("Location: /update-product/error/$error_message/$product_id");
    exit();
}
if (!isset($_POST['product_category'])) {
    $error_message = "Please provide a category";
    header("Location: /update-product/error/$error_message/$product_id");
    exit();
}
if (!isset($_POST['product_description'])) {
    $error_message = "Please provide a product description";
    header("Location: /update-product/error/$error_message/$product_id");
    exit();
}


// #########################################################
// ################### INPUT VALUE VALIDATION ##############
// #########################################################

if (
    strlen($_POST['product_title']) < 2 ||
    strlen($_POST['product_title']) > 50
) {
    $error_message = "Title must be between 2 and 50 characters";
    header("Location: /update-product/error/$error_message/$product_id");
    exit();
}
if (
    !is_numeric($_POST['product_price'])
) {
    $error_message = "Price must be a number";
    header("Location: /update-product/error/$error_message/$product_id");
    exit();
}
if (
    strlen($_POST['product_category']) < 2 ||
    strlen($_POST['product_category']) > 50
) {
    $error_message = "Category must be between 2 and 50 characters";
    header("Location: /update-product/error/$error_message/$product_id");
    exit();
}
if (
    strlen($_POST['product_description']) < 2 ||
    strlen($_POST['product_description']) > 800
) {
    $error_message = "Description must be between 2 and 800 characters";
    header("Location: /update-product/error/$error_message/$product_id");
    exit();
}




//require_once($_SERVER['DOCUMENT_ROOT'] . '/backendValidation/createProduct.php');


try {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db/globals.php');
    $encryptedDescription = openssl_encrypt($_POST['product_description'], $encrypt_algo, $key, OPENSSL_RAW_DATA, $iv);
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');
    $q = $db->prepare("UPDATE `products` SET product_title = :product_title, product_description = :product_description, product_price = :product_price, product_category = :product_category, product_iv = :product_iv
                        WHERE product_id = '$product_id'");
    $q->bindValue(':product_title', $_POST['product_title']);
    $q->bindValue(':product_description', base64_encode($encryptedDescription));
    $q->bindValue(':product_price', $_POST['product_price']);
    $q->bindValue(':product_category', $_POST['product_category']);
    $q->bindValue(':product_iv',  base64_encode($iv));
    $q->execute();
    if (!$q->rowCount()) {
        echo 'vi er her', $_SESSION['user_uuid'];

        exit;
    }
    header('Location: /account');
    exit();
} catch (PDOException $ex) {
    echo $ex;
}
