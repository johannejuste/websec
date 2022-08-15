<?php

// ################### csrf valid ###############################

if (is_csrf_valid() != true) {
    header("Location: /404");
    exit();
}

// ################### ISSET ###############################

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_POST['user_email'])) {
    header("Location: /login/error/$error_message");
    exit();
}

if (!isset($_POST['user_password'])) {
    header("Location: /login/error/$error_message");
    exit();
}

// ################ INPUT VALUE VALIDATION #################

if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    $error_message = "Invalid email format";
    header("Location: /login/error/$error_message");
    exit();
}
if (
    strlen($_POST['user_password']) < 8 ||
    strlen($_POST['user_password']) > 50
) {
    $error_message = "Password must be between 8 and 50 characters";
    header("Location: /login/error/$error_message");
    exit();
}
