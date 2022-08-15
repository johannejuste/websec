<?php

session_start();

if (!isset($_SESSION['admin_user_uuid'])) {
    header('Location: /admin-login');
    exit();
}

require('./db/db.php');
require('./db/fetch_users.php');
require('./db/globals.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_top_admin.php');

?>
<main id="admin">

    <div class="admin-container">
        <h1>ADMIN PAGE</h1>

        <table class="users-container">
            <tr class="user">
                <th>User id</th>
                <th>User name</th>
                <th>User lastname</th>
                <th>User email</th>
                <th>User status</th>
                <th>Change status</th>
                <th>User products</th>
            </tr>
            <?php
            foreach ($users as $user) {

            ?>

                <tr class="user">
                    <td><?= $user['user_uuid'] ?></td>
                    <td><?= $user['user_firstname'] ?></td>
                    <td><?= $user['user_lastname'] ?></td>
                    <td><?= $user['user_email'] ?></td>
                    <td>
                        <?php if ($user['user_status'] == 1) { ?>
                            Active
                        <?php } else {
                        ?> Blocked <?php
                                } ?></td>
                    <td>
                        <form action="/admin/change-user-status" method="POST">
                            <?= set_csrf() ?>
                            <input type="hidden" name="user_id" value="<?= $user['user_uuid'] ?>">
                            <input type="hidden" name="user_status" value="<?= $user['user_status'] ?>">
                            <button class="button medium_button button_bg_light" type="submit"> <?php if ($user['user_status'] == 1) { ?>Block user <?php } else {
                                                                                                                                                    ?> Unblock user<?php
                                                                                                                                                                } ?>
                            </button>
                        </form>
                    </td>
                    <td>
                        <a class="link" href="/admin/show_user_products/<?= $user['user_uuid'] ?>">Show products</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</main>
<script src="/js/headerScroll.js"></script>

</body>

</html>