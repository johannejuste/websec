<?php
session_start();
if (!isset($_SESSION['user_uuid'])) {
  header('Location: /login');
  exit();
}


try {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');
  $q = $db->prepare('SELECT * FROM users WHERE user_uuid = :user_uuid');
  $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
  $q->execute();
  $user = $q->fetch();
  if (!$user) {
    header('Location: /login');
    exit();
  }
?>

  <?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_top.php');
  ?>
  <main>
    <div class="account_container">
      <h1>My account</h1>
      <div class="account_content_container">

        <div class="account-sidenav">
          <ul>
            <li>
              <a href="/account">My overview</a>
            </li>
            <li>
              <a href="/account-edit/my-user-information" class="active"> My user information</a>
            </li>
            <li>
              <a href="/account-edit/change-password">Change password</a>
            </li>
            <li>
              <button type="submit" class="button medium_button" onclick="open_confirm_modal_account()">Delete account</button>
            </li>
          </ul>
        </div>

        <div class="account-content">
          <h2 class="account-title">Edit user information</h2>




          <form class="form_container_max_width margin margin-20-top" id="update-account-information" method="POST" action="/update-account-information" onsubmit="return validate()">
            <?php
            require_once('./components/component_errormsg.php');
            require_once('./components/component_succcessmsg.php');
            ?>
            <?= set_csrf() ?>
            <div class="form-group">
              <h5 id="fname-txt">First name</h5>
              <input type="text" name="user_firstname" data-validate="str" data-min="2" data-max="50" value="<?= $user['user_firstname'] ?>">
              <span class="error-message">Please provide a first name | 2-50 characters</span>
            </div>

            <div class="form-group">
              <h5 id="lname-txt">Last name</h5>
              <input type="text" name="user_lastname" data-validate="str" data-min="2" data-max="50" value="<?= $user['user_lastname'] ?>">
              <span class="error-message">Please provide a last name | 2-50 characters</span>
            </div>

            <div class="form-group">
              <h5 id="email-txt">Email</h5>
              <input type="text" name="user_email" data-validate="email" data-min="" data-max="" value="<?= $user['user_email'] ?>">
              <span class="error-message">Please provide a valid email</span>
            </div>

            <div class="form-group">
              <h5 id="phone-txt">Phone</h5>
              <input type="text" name="user_phone" data-validate="int" data-min="2" data-max="10" value="<?= $user['user_phone'] ?>">
              <span class="error-message">Please provide a valid phone nr. (8 digits)</span>
            </div>
            <div class="btn-position-right">
              <button type="submit" class="button large">Update user information</button>
            </div>
          </form>
        </div>

      </div>

    </div>

  </main>
  <script src="/js/headerScroll.js"></script>



  <script src="/js/validator.js"></script>

  </body>

  </html>
<?php


} catch (PDOException $ex) {
  echo $ex;
}
