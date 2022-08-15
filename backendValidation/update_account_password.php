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


if (!isset($_POST['user_password'])) {
    header("Location: /account-edit/change-password");
    exit();
}

if (!isset($_POST['user_confirm_password'])) {
    header("Location: /account-edit/change-password");
    exit();
}

// #########################################################
// ################ INPUT VALUE VALIDATION #################
// #########################################################

if ($_POST['user_password'] != $_POST['user_confirm_password']) {
    $error_message = "Password doesn't match";
    header("Location: /account-edit/change-password/error/$error_message");
    exit();
}

if (
    strlen($_POST['user_password']) < 8 ||
    strlen($_POST['user_password']) > 50
) {
    $error_message = "Password must be between 8 and 50 characters ";
    header("Location: /account-edit/change-password/error/$error_message");
    exit();
}

if (
    strlen($_POST['user_confirm_password']) < 8 ||
    strlen($_POST['user_confirm_password']) > 50
) {
    $error_message = "Password must be between 8 and 50 characters ";
    header("Location: /account-edit/change-password/error/$error_message");
    exit();
}
