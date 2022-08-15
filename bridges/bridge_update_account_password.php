<?php
require('./backendValidation/update_account_password.php');
require_once('./db/globals.php');
$salt = bin2hex(openssl_random_pseudo_bytes(50));
$hashed = hash($algo, $_POST['user_password'] . $salt . $peberstring);

try {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');
  $q = $db->prepare('UPDATE users SET user_password = :user_password, user_salt = :user_salt WHERE user_uuid = :user_uuid');
  $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
  $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
  $q->bindValue(':user_password', $hashed);
  $q->bindValue(':user_salt', $salt);
  $q->execute();

  $success_message = "You have changed your password";
  header("Location: /account-edit/change-password/success/$success_message");
} catch (PDOException $ex) {
  echo $ex;
}
