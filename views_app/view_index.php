<?php

session_start();

if (!isset($_SESSION['user_uuid'])) {
    header('Location: /login');
    exit();
}

require('./db/db.php');
require('./db/fetch_products.php');
require('./db/globals.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_top.php');
?>
<main id="index">

    <div class="index_intro_banner flex flex_center_center flex_row_reverse">
        <div class="banner-container">
            <img src="/assets/imgs/people-discussing-about-online-payment.svg" alt="">
            <h1> <span>Reboot</span> the things your are not using, and give them a <span>new life today</span>. </h1>
        </div>
    </div>

    <div class="broad-page-container">

        <div class="search-container">
            <div class="">

            </div>
            <form onsubmit="return false" id="search-form">
                <?= set_csrf() ?>
                <i class="fas fa-search"></i>
                <input class="search-input" name="search_for" type="text" placeholder="Search for product" oninput=search(); onclick="show_results()">
                <i class="clear-input fas fa-times-circle" onclick="clear_input()"></i>
            </form>

        </div>


        <section id="newest-products">
            <h3 class="h1 section-header">Newest Products</h3>
            <div class="new-products-container">


                <?php require('./db/fetch_newest_products.php');
                foreach ($newest_products as $product) {
                    $image = json_decode($product['product_image']);
                    $newest_description = out(openssl_decrypt(base64_decode($product['product_description']), $encrypt_algo, $key, OPENSSL_RAW_DATA, base64_decode($product['product_iv'])));
                ?>

                    <div class="product">
                        <div class="img-container">
                            <img src="/product-images/<?= out($image[0]) ?>" alt="Image of <?= out($product['product_title']) ?>">
                            <div class="price"> <?= out($product['product_price']) ?> <span>dkk</span></div>
                        </div>
                        <div class="product-info">
                            <p class="h5 title"> <?= out($product['product_title']) ?></p>
                            <p class="description">
                                <?= $newest_description ?>
                            </p>
                        </div>
                        <a href="/single-product/<?= $product['product_id'] ?>"></a>
                    </div>
                <?php
                }

                ?>
            </div>

        </section>
        <section id="main-content">
            <h3 class="h1 section-header search-result-amount">All Products</h3>
            <div class="main-content-container">

                <div id="search_results"></div>
                <div class="product-container">
                    <?php
                    foreach ($products as $product) {
                        $image = json_decode($product['product_image']);
                        $description = out(openssl_decrypt(base64_decode($product['product_description']), $encrypt_algo, $key, OPENSSL_RAW_DATA, base64_decode($product['product_iv'])));
                    ?>
                        <div class="product">
                            <div class="img-container">
                                <img src="/product-images/<?= out($image[0]) ?>" alt="Image of <?= out($product['product_title']) ?>">
                                <div class="price"> <?= out($product['product_price']) ?> <span>dkk</span></div>

                            </div>
                            <div class="product-info">
                                <p class="h5 title"> <?= out($product['product_title']) ?></p>
                                <p class="description">
                                    <?= $description ?>
                                </p>
                            </div>
                            <a href="/single-product/<?= $product['product_id'] ?>"></a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>
</main>
<script src="/js/headerScroll.js"></script>
<script src="/js/search.js"></script>

</body>

</html>
