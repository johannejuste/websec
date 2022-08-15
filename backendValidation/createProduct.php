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
    header("Location: /create-product/error/$error_message");
    exit();
}
if (!isset($_POST['product_price'])) {
    $error_message = "Please provide a Password";
    header("Location: /create-product/error/$error_message");
    exit();
}
if (!isset($_POST['product_category'])) {
    $error_message = "Please provide a category";
    header("Location: /create-product/error/$error_message");
    exit();
}
if (!isset($_POST['product_description'])) {
    $error_message = "Please provide a product description";
    header("Location: /create-product/error/$error_message");
    exit();
}

if (!isset($_FILES['file-to-upload']['name'])) {

    $error_message = "provide a product image";
    header("Location: /create-product/error/$error_message");
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
    header("Location: /create-product/error/$error_message");
    exit();
}
if (
    !is_numeric($_POST['product_price'])
) {
    $error_message = "Price must be a number";
    header("Location: /create-product/error/$error_message");
    exit();
}
if (
    strlen($_POST['product_category']) < 2 ||
    strlen($_POST['product_category']) > 50
) {
    $error_message = "Category must be between 2 and 50 characters";
    header("Location: /create-product/error/$error_message");
    exit();
}
if (
    strlen($_POST['product_description']) < 2 ||
    strlen($_POST['product_description']) > 800
) {
    $error_message = "Description must be between 2 and 800 characters";
    header("Location: /create-product/error/$error_message");
    exit();
}


$arrayLength = count($_FILES['file-to-upload']['name']);
if ($arrayLength < 1 || $arrayLength > 4) {
    $error_message = "You must choose between 1 and 4 images";
    header("Location: /create-product/error/$error_message");
    exit();
}
