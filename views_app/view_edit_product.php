<?php

session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /login');
    exit();
}

require('./db/db.php');
require('./db/globals.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_top.php');

require('./db/fetch_product.php');
$message = out(openssl_decrypt(base64_decode($product['product_description']), $encrypt_algo, $key, OPENSSL_RAW_DATA, base64_decode($product['product_iv'])));
$image = json_decode($product['product_image']);
?>

<main id="edit">

    <div class=" text-center form_container_max_width">
        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/components/component_errormsg.php');
        ?>
        <h1 class="page-title">Edit Product</h1>
        <form id="create_product" action="/update-product/<?= $product['product_id'] ?>" method="POST" enctype="multipart/form-data" onsubmit="return validate()">

            <?= set_csrf() ?>
            <div class="form-group">
                <h5 for="product_title">Title </h5>
                <input name="product_title" type="text" value="<?= $product['product_title'] ?>" placeholder="Enter title" data-validate="str" data-min="1" data-max="50" />
                <span>Please provide a title</span>
            </div>

            <div class="form-group">
                <h5 for="product_price">price </h5>
                <input name="product_price" type="text" value="<?= $product['product_price'] ?>" placeholder="Enter title" data-validate="int" data-min="1" data-max="50" />
                <span>Please provide price</span>
            </div>
            <div class="form-group">
                <h5 for="product_category">category </h5>
                <input name="product_category" type="text" value="<?= $product['product_category'] ?>" placeholder="Enter title" data-validate="str" data-min="1" data-max="50" />
                <span>Please provide a category</span>
            </div>
            <div class="form-group">
                <h5 for="product_description">Description </h5>
                <textarea name="product_description" data-validate="str" data-min="1" data-max="500"><?= $message ?></textarea>
                <span>Please provide a description of the product</span>
            </div>
            <div id="file-input" class="form-group">

                <?php
                if (isset($error_message)) {

                ?>
                    <h5 for="product_images">Images</h5>
                    <input id="input" type="file" name="file-to-upload[]" multiple id="fileToUpload" data-validate="file" data-min="1" data-max="4" value="<?= out($image[0]) ?>" onchange="printImages(this)">
                    <span>Please provide 1-4 images of the product</span>

                <?php

                } else {


                ?>
                    <i id="new-images" class="fas fa-upload" onclick="newImages()"></i>


                    <div id="images-preview-container">
                        <?php
                        foreach ($image as $img) {
                        ?>
                            <img src="/product-images/<?= out($img) ?>" alt="Current product image">
                        <?php
                        }
                        ?>
                    </div>
                <?php


                }
                ?>


            </div>



            <div class="form-group">

                <button type=" submit" class="submit button large">Update product</button>
            </div>

        </form>
    </div>



</main>


<script>
    function printImages(element) {
        const div = document.getElementById("images-preview-container");
        const h2 = document.createElement("h2");
        h2.textContent = "Selected images";
        h2.classList = "grid-c-2";
        div.innerHTML = "";

        let files = element.files;

        if (files.length < 1 || files.length > 4) {
            alert('1-4 images');
            return
        }
        for (var i = 0; i < files.length; i++) {
            let output = document.createElement("img")
            div.appendChild(output);
            output.src = URL.createObjectURL(event.target.files[i]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }
    }


    function newImages() {
        const div = document.getElementById("images-preview-container");
        div.innerHTML = "";
        const button = document.getElementById("new-images");
        const container = document.getElementById("file-input")
        button.remove();

        let inputPairContent = `
        
                <h5 for="product_images">Images</h5>
                <input id="input" type="file" name="file-to-upload[]" multiple id="fileToUpload" data-validate="file" data-min="1" data-max="4" value="<?= out($image[0]) ?>" onchange="printImages(this)">
                <span>Please provide 1-4 images of the product</span>
  `

        container.insertAdjacentHTML('beforeend', inputPairContent)

    }
</script>

<script src="/js/headerScroll.js"></script>

<script src="/js/image_preload.js"></script>

<script src="/js/validator.js"></script>

</body>

</html>