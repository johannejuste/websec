<?php



if (!isset($_SESSION)) {
  session_start();
}
require('./backendValidation/admin-login.php');
require('./db/globals.php');
try {


  require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');
  $q = $db->prepare('SELECT * FROM admins WHERE admin_user_email = :admin_user_email');
  $q->bindValue(':admin_user_email', $_POST['admin_user_email']);
  $q->execute();
  $admin = $q->fetch();
  $time = time();
  $check = hash($algo, $_POST['admin_user_password'] . $admin['admin_salt'] . $peberstring);


  if (!$admin) {
    $error_message = "The account you are trying to access does not exist";
    header("Location: /admin-login/error/$error_message");
    exit();
  }

  if ($check !== $admin['admin_user_password']) {

    //Her tjekkes salt

    // if login_attempts are less than 3 then count up +1
    if ($admin['admin_login_attempts'] < 3) {

      /*    echo $user['user_login_attempts'], "tis";
      exit; */
      $sql = $db->prepare("UPDATE admins SET admin_login_attempts = admin_login_attempts +1, admin_login_timestamp = $time WHERE admin_user_email = :admin_user_email");
      $sql->bindValue(':admin_user_email', $admin['admin_user_email']);
      $sql->execute();

      /*   echo $user['user_login_attempts'];
      exit; */
      $error_message = "wrong password";
      header("Location: /admin-login/error/$error_message");
      exit();
    }
    // if login_attempts is equal og greater than 3 then check timestamp
    if ($admin['admin_login_attempts'] >= 3) {
      // if timestamp diff are less than 5 minuts then block
      if (time() - $admin['admin_login_timestamp'] < 10) {
        $error_message = "you cannot login the next 5 minuts";
        header("Location: /admin-login/error/$error_message");
        exit();
        // if timestamp diff are greater than 5 minuts but wrong password 
        //then update login atempts to 1 and add new timestamp
      } else {
        $sql3 = $db->prepare("UPDATE admins SET admin_login_attempts = 1, admin_login_timestamp = $time WHERE admin_user_email = :admin_user_email LIMIT 1");
        $sql3->bindValue(':admin_user_email', $admin['admin_user_email']);
        $sql3->execute();
        /*      echo $user['user_login_attempts'];
        exit; */
        $error_message = "wrong password";
        header("Location: /admin-login/error/$error_message");
        exit();
      }
    }
  } else if ($check == $admin['admin_user_password']) {

    //if login attemps is below og equal to 3...
    if ($admin['admin_login_attempts'] >= 3) {
      // if timestamp diff is less than 5 minuts... 
      if (time() - $admin['admin_login_timestamp'] < 10) {
        //block user for 5 minuts
        $error_message = "you cannot login the next 5 minuts";
        header("Location: /admin-login/error/$error_message");
        exit();
      }
    };

    $sql4 = $db->prepare('UPDATE admins SET admin_login_attempts = 0 WHERE admin_user_email = :admin_user_email LIMIT 1');
    $sql4->bindValue(':admin_user_email', $admin['admin_user_email']);
    $sql4->execute();
    session_start();

    $_SESSION['admin_user_uuid'] = $admin['admin_user_uuid'];
    $_SESSION['admin_user_email'] = $admin['admin_user_email'];

    header('Location: /admin-index');
    exit();
  }
} catch (PDOException $ex) {
  echo $ex;
}
