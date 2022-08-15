<?php

session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /login');
    exit();
}

require('./db/db.php');
require('./db/globals.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_top.php');


?>

<main id="edit">

    <div class=" text-center form_container_max_width">
        <div>
            <h1>Create product</h1>

        </div>
        <form id="create_product" action="/create-new-product/<?= $_SESSION['user_uuid'] ?>" method="POST" enctype="multipart/form-data" onsubmit="return validate()">
            <?php
            require_once($_SERVER['DOCUMENT_ROOT'] . '/components/component_errormsg.php');
            ?>
            <?= set_csrf() ?>
            <div class="form-group">
                <h5 id="product_title">Title</h5>
                <input name="product_title" type="text" value="" data-validate="str" data-min="1" data-max="50" />
                <span class="error-message">Please provide a title</span>
            </div>

            <div class="form-group">
                <h5 id="product_price">Price</h5>
                <input name="product_price" type="text" value="" data-validate="int" data-min="1" data-max="50" />
                <span class="error-message">Please provide price</span>
            </div>
            <div class="form-group">
                <h5 id="product_category">Category</h5>
                <input name="product_category" type="text" value="" data-validate="str" data-min="1" data-max="50" />
                <span class="error-message">Please provide a category</span>
            </div>

            <div class="form-group">
                <h5 id="product_description">Description</h5>
                <textarea name="product_description" data-validate="str" data-min="1" data-max="500"></textarea>
                <span class="error-message">Please provide a description of the product</span>
            </div>

            <div class="form-group">
                <h5 id="product_images">Images</h5>
                <input id="input" type="file" name="file-to-upload[]" multiple id="fileToUpload" data-validate="file" data-min="1" data-max="4" value="Upload images" onchange="printImages(this)">
                <span class="error-message">Please provide 1-4 images of the product</span>
            </div>

            <div class="form-group">
                <div id="images-preview-container">

                </div>
            </div>

            <button type=" submit" class="button large">Create product</button>

        </form>

    </div>


</main>

<script>
    function printImages(element) {
        const div = document.getElementById("images-preview-container");
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
</script>
<script src="/js/headerScroll.js"></script>
<script src="/js/image_preload.js"></script>
<script src="/js/validator.js"></script>
</body>

</html>