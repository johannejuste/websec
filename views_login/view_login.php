<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views_login/view_top.php');
session_start();
?>
<main class="main_login_signup">
  <div class="flex_container">

    <div class="image_signup_login_container container_login_bg flex flex_center_center">
      <img src="/assets/imgs/shopping.svg" alt="background image">
    </div>

    <div class="login_signup_form flex flex_center_center">

      <div class=" text-center form_container_max_width">
        <div>
          <h1>Sign in</h1>
          <div>Sign in to your account</div>
        </div>


        <?php
        require_once('./components/component_errormsg.php');
        require_once('./components/component_succcessmsg.php');
        ?>

        <form class="margin-20-top" action="/login" method="POST" onsubmit="return validate()">
          <?= set_csrf() ?>

          <div class="form-group">
            <h5 id="email-txt">Email</h5>
            <input onclick="clear_validate_error()" data-validate="email" type="email" name="user_email" id="logemail" autocomplete="on">
            <span class="error-message" id="email-error">Please provide a valid email</span>
            <i class="input-icon uil uil-at"></i>
          </div>
          <div class="form-group ">
            <h5 id="pword-txt">Password</h5>
            <input onclick="clear_validate_error()" maxlength="50" data-validate="str" data-min="8" data-max="50" type="password" name="user_password" id="logpass" autocomplete="on">
            <span class="error-message" id="password-error">Please provide a valid password | 8-50 characters</span>
            <i class="input-icon uil uil-lock-alt"></i>
          </div>


          <div class="master-flex margin-10-bottom">
            <a href="/admin-login" class="link">Login as admin</a>
          </div>

          <div class="btn-position">
            <button type="submit" class="button large margin">sign in</button>
            <div>
              <p>Don't have an account?</p> <a href="/signup" class="link">sign up</a>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>

</main>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views_login/view_bottom.php');
?>