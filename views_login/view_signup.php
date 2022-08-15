<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views_login/view_top.php');
session_start();
?>
<?php
?>


<main class="main_login_signup">

  <div class="flex_container">

    <div class="login_signup_form flex flex_center_center">

      <div class="form_container_max_width text-center">
        <div>
          <h1>Sign up</h1>
          <div>Create a new account</div>
        </div>

        <form class="margin-20-top" action="/signup" name="signup_form" method="POST" onsubmit="return validate()">
          <?php
          require_once('./components/component_errormsg.php');
          require_once('./components/component_succcessmsg.php');
          ?>
          <?= set_csrf() ?>
          <div class="form-group">
            <h5 id="fname-txt">First name</h5>
            <input onclick="clear_validate_error()" type="text" name="user_firstname" data-validate="str" data-min="2" data-max="50" value="" id="logfname" autocomplete="off">
            <span class="error-message" id="fname-error">Please provide a first name | 2-50 characters</span>
            <i class="input-icon uil uil-at"></i>
          </div>
          <div class="form-group">
            <h5 id="lname-txt">Last name</h5>
            <input onclick="clear_validate_error()" type="text" name="user_lastname" data-validate="str" data-min="2" data-max="50" id="loglname" autocomplete="off">
            <span class="error-message" id="lname-error">Please provide a last name | 2-50 characters</span>
            <i class="input-icon uil uil-at"></i>
          </div>
          <div class="form-group">
            <h5 id="email-txt">Email</h5>
            <input onclick="clear_validate_error()" type="text" name="user_email" data-validate="email" data-min="1" data-max="50" id="logemail" autocomplete="off">
            <span class="error-message" id="email-error">Please provide a valid email</span>
            <i class="input-icon uil uil-at"></i>
          </div>
          <div class="form-group">
            <h5 id="phone-txt">Phone</h5>
            <input onclick="clear_validate_error()" type="text" name="user_phone" pattern="\d*" data-validate="int" data-min="8" data-max="8" id="logemail" autocomplete="off">
            <span class="error-message" id="email-error">Please provide a valid phone nr. (8 digits)</span>
            <i class="input-icon uil uil-at"></i>
          </div>
          <div class="form-group">
            <h5 id="pword-txt">Password</h5>
            <input onclick="clear_validate_error()" type="password" name="user_password" data-validate="str" data-min="8" data-max="50" id="logpass" autocomplete="on">
            <span class="error-message" id="password-error">Please provide a valid password | 8-50 characters</span>
            <i class="input-icon uil uil-lock-alt"></i>
          </div>
          <div class="form-group">
            <h5 id="pwordc-txt">Confirm Password</h5>
            <input type="password" onclick="clear_validate_error()" name="user_confirm_password" data-match-name="user_confirm_password" data-validate="match" data-min="8" data-max="50" id="logpassconfirm">
            <span class="error-message" id="password-confirm-error">Your password &amp; confirm password must match | 8-50 characters</span>
            <i class="input-icon uil uil-lock-alt"></i>
          </div>

          <div class="btn-position">
            <button type="submit" class="button large margin">sign up</button>
            <div>
              <p>Already have an account?</p> <a href=" /login" class="link">sign in</a>
            </div>
          </div>

        </form>
      </div>
    </div>

    <div class="image_signup_login_container container_signup_bg flex flex_center_center">
      <img src="/assets/imgs/man-working-remotely-and-drinking-coffee.svg" alt="">
    </div>

  </div>


</main>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views_login/view_bottom.php');
?>