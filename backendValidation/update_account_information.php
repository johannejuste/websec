<?php

// #########################################################
// ################### ISSET ###############################
// #########################################################

if (!isset($_SESSION)) {
    session_start();
}

if (is_csrf_valid() != true) {
    header("Location: /404");
    exit();
}


if (!isset($_POST['user_firstname'])) {
    header('Location: /account-edit/my-user-information');
    exit();
}

if (!isset($_POST['user_lastname'])) {
    header('Location: /account-edit/my-user-information');
    exit();
}

if (!isset($_POST['user_email'])) {
    header('Location: /account-edit/my-user-information');
    exit();
}

if (!isset($_POST['user_phone'])) {
    header('Location: /account-edit/my-user-information');
    exit();
}


// #########################################################
// ################ INPUT VALUE VALIDATION #################
// #########################################################

if (
    strlen($_POST['user_firstname']) < 2 ||
    strlen($_POST['user_firstname']) > 50
) {
    $error_message = "Firstname must be between 2 and 50 characters";
    header("Location: /account-edit/my-user-information/error/$error_message");
    exit();
}

if (
    strlen($_POST['user_lastname']) < 2 ||
    strlen($_POST['user_lastname']) > 50
) {
    $error_message = "Lastname must be between 2 and 50 characters";
    header("Location: /account-edit/my-user-information/error/$error_message");
    exit();
}

if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    header("Location: /account-edit/my-user-information/error/$error_message");
    exit();
}
if (!preg_match('/^[0-9]{8}+$/', $_POST['user_phone'])) {
    header("Location: /account-edit/my-user-information/error/$error_message");
    exit();
}
