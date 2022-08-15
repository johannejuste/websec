<?php
require('./backendValidation/update_account_information.php');



try {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');
  $q = $db->prepare('UPDATE users SET user_firstname = :user_firstname, user_lastname = :user_lastname, user_email = :user_email,
                                      user_phone = :user_phone
                                      WHERE user_uuid = :user_uuid');
  $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
  $q->bindValue(':user_firstname', $_POST['user_firstname']);
  $q->bindValue(':user_lastname', $_POST['user_lastname']);
  $q->bindValue(':user_email', $_POST['user_email']);
  $q->bindValue(':user_phone', $_POST['user_phone']);
  $q->execute();

  $success_message = "You have changed your user information";
  header("Location: /account-edit/my-user-information/success/$success_message");
} catch (PDOException $ex) {
  echo $ex;
}
