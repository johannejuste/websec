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
                            <a href="/account-edit/my-user-information"> My user information</a>
                        </li>
                        <li>
                            <a href="/account-edit/change-password" class="active">Change password</a>
                        </li>
                        <li>
                            <button type="submit" class="button medium_button" onclick="open_confirm_modal_account()">Delete account</button>
                        </li>
                    </ul>
                </div>

                <div class="account-content">
                    <h2 class="account-title">Change password</h2>



                    <form class="form_container_max_width margin margin-20-top" id="update-account-information" method="POST" action="/update-user-account-password" onsubmit="return validate();">
                        <?php
                        require_once('./components/component_errormsg.php');
                        require_once('./components/component_succcessmsg.php');
                        ?>
                        <?= set_csrf() ?>
                        <div class="form-group">
                            <h5 id="new-pword-txt">New password</h5>
                            <input type="password" name="user_password" data-validate="str" data-min="4" data-max="16">
                            <span class="error-message">Please provide a valid password | 8-50 characters</span>
                        </div>

                        <div class="form-group">
                            <h5 id="conf-pword-txt">Confirm password</h5>
                            <input type="password" name="user_confirm_password" data-match-name="user_password" data-validate="match" data-min="4" data-max="16" id="logpassconfirm">
                            <span class="error-message">Your password &amp; confirm password must match | 8-50 characters</span>
                        </div>
                        <div class="btn-position">
                            <button type="submit" class="button large">Change password</button>
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
