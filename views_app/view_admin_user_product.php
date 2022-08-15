<?php
session_start();

require('./db/fetch_user_products.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_top_admin.php');

?>
<main id="admin">

    <div class="page-container">
        <a class="link" href="/admin-index">Go back</a>
        <h1 class="margin-20-top">Products of product <?= $user_id ?></h1>

        <?php
        if (!$products) {
        ?> <p class="no_products">No products</p>
        <?php } else { ?>
            <table class="users-container_products">
                <tr class="user">
                    <th>Product id</th>
                    <th>Product title</th>
                    <th>Product price</th>
                    <th>Product category</th>
                    <th>Product timestamp</th>
                    <th>Product status</th>
                    <th>Change status</th>
                </tr>
                <?php


                foreach ($products as $product) {
                ?> <tr class="user">
                        <td><?= out($product['product_id']) ?></td>
                        <td><?= out($product['product_title']) ?></td>
                        <td><?= out($product['product_price']) ?></td>
                        <td><?= out($product['product_category']) ?></td>
                        <td><?= out($product['product_timestamp']) ?></td>
                        <td>
                            <?php if ($product['product_status'] == 1) { ?>
                                Published
                            <?php } else {
                            ?> Unpublished <?php
                                        } ?></td>
                        <td>
                            <form action="/admin/change-product-status" method="POST">
                                <?= set_csrf() ?>
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <input type="hidden" name="user_uuid" value="<?= $product['user_uuid'] ?>">
                                <input type="hidden" name="product_status" value="<?= $product['product_status'] ?>">
                                <button type="submit" class="button medium_button button_bg_light"> <?php if ($product['product_status'] == 1) { ?>Unpublish <?php } else {
                                                                                                                                                                ?> Publish<?php
                                                                                                                                                                        } ?>
                                </button>
                            </form>
                        </td>
                    </tr>
            <?php

                }
            }
            ?>
            </table>
    </div>
</main>
<script src="/js/headerScroll.js"></script>


</body>

</html>