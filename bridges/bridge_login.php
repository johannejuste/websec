<?php

if (!isset($_SESSION)) {
  session_start();
}
require('./backendValidation/login.php');
require('./db/globals.php');
try {


  require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');
  $q = $db->prepare('SELECT * FROM users WHERE user_email = :user_email AND user_status = 1');
  $q->bindValue(':user_email', $_POST['user_email']);
  $q->execute();
  $user = $q->fetch();
  $time = time();
  $check = hash($algo, $_POST['user_password'] . $user['user_salt'] . $peberstring);

  if (!$user) {
    $error_message = "The account you are trying to access does not exist";
    header("Location: /login/error/$error_message");
    exit();
  }

  if ($check !== $user['user_password']) {
    //Her tjekkes salt
    // if login_attempts are less than 3 then count up +1
    if ($user['user_login_attempts'] < 3) {

      /*    echo $user['user_login_attempts'], "tis";
      exit; */
      $sql = $db->prepare("UPDATE users SET user_login_attempts = user_login_attempts +1, user_login_timestamp = $time WHERE user_email = :user_email");
      $sql->bindValue(':user_email', $user['user_email']);
      $sql->execute();

      /*   echo $user['user_login_attempts'];
      exit; */
      $error_message = "wrong password";
      header("Location: /login/error/$error_message");
      exit();
    }
    // if login_attempts is equal og greater than 3 then check timestamp
    if ($user['user_login_attempts'] >= 3) {
      // if timestamp diff are less than 5 minuts then block
      if (time() - $user['user_login_timestamp'] < 10) {
        $error_message = "you cannot login the next 5 minuts";
        header("Location: /login/error/$error_message");
        exit();
        // if timestamp diff are greater than 5 minuts but wrong password 
        //then update login atempts to 1 and add new timestamp
      } else {
        $sql3 = $db->prepare("UPDATE users SET user_login_attempts = 1, user_login_timestamp = $time WHERE user_email = :user_email LIMIT 1");
        $sql3->bindValue(':user_email', $user['user_email']);
        $sql3->execute();
        /*      echo $user['user_login_attempts'];
        exit; */
        $error_message = "wrong password";
        header("Location: /login/error/$error_message");
        exit();
      }
    }
  } else if ($check == $user['user_password']) {

    //if login attemps is below og equal to 3...
    if ($user['user_login_attempts'] >= 3) {
      // if timestamp diff is less than 5 minuts... 
      if (time() - $user['user_login_timestamp'] < 300) {
        //block user for 5 minuts
        $error_message = "you cannot login the next 5 minuts";
        header("Location: /login/error/$error_message");
        exit();
      }
    };

    $sql4 = $db->prepare('UPDATE users SET user_login_attempts = 0 WHERE user_email = :user_email LIMIT 1');
    $sql4->bindValue(':user_email', $user['user_email']);
    $sql4->execute();
    session_start();

    $_SESSION['user_uuid'] = $user['user_uuid'];
    $_SESSION['user_firstname'] = $user['user_firstname'];
    $_SESSION['user_lastname'] = $user['user_lastname'];
    $_SESSION['user_image'] = $user['user_image'];
    $_SESSION['user_phone'] = $user['user_phone'];
    $_SESSION['user_email'] = $user['user_email'];

    header('Location: /index');
    exit();
  }
} catch (PDOException $ex) {
  echo $ex;
}
