<?php

// ################### csrf valid ###############################

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

if (!isset($_POST['user_firstname'])) {
    header("Location: /signup/error/$error_message");
    exit();
}

if (!isset($_POST['user_lastname'])) {
    header("Location: /signup/error/$error_message");
    exit();
}

if (!isset($_POST['user_email'])) {
    header("Location: /signup/error/$error_message");
    exit();
}

if (!isset($_POST['user_phone'])) {
    header("Location: /signup/error/$error_message");
    exit();
}

if (!isset($_POST['user_password'])) {
    header("Location: /signup/error/$error_message");
    exit();
}

if (!isset($_POST['user_confirm_password'])) {
    header("Location: /signup/error/$error_message");
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
    header("Location: /signup/error/$error_message");
    exit();
}

if (
    strlen($_POST['user_lastname']) < 2 ||
    strlen($_POST['user_lastname']) > 50
) {
    $error_message = "Lastname must be between 2 and 50 characters";
    header("Location: /signup/error/$error_message");
    exit();
}

if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    $error_message = "Invalid email format";
    header("Location: /signup/error/$error_message");
    exit();
}

if (!preg_match('/^[1-9]\d{7}$/', $_POST['user_phone'])) {
    $error_message = 'Phone number cannot start with a 0, and must be 8 digits.';
    header("Location: /signup/error/$error_message");
    exit();
}

if (
    strlen($_POST['user_password']) < 8 ||
    strlen($_POST['user_password']) > 50
) {
    $error_message = "Password must be between 8 and 50 characters";
    header("Location: /signup/error/$error_message");
    exit();
}

if ($_POST['user_password'] != $_POST['user_confirm_password']) {
    $error_message = 'Password and Password confirm dont match';
    header("Location: /signup/error/$error_message");
    exit();
}
