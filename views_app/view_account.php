<?php

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['user_uuid'])) {
  header('Location: /login');
  exit();
}


?>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/fetch_user.php');
require('./db/globals.php');
?>

<main>

  <div class="account_container">

    <div class="account_content_container">

      <div class="account-sidenav">
        <h1 class="h2">My account</h1>
        <ul>
          <li>
          </li>
          <li>
            <a href="/account" class="active">My overview</a>
          </li>
          <li>
            <a href="/account-edit/my-user-information"> My user information</a>
          </li>
          <li>
            <a href="/account-edit/change-password">Change password</a>
          </li>
          <li>
            <button type="submit" class="button medium_button" onclick="open_confirm_modal_account()">Delete account</button>
          </li>
        </ul>
      </div>

      <div class="account-content flex column">
        <h2 class="h2">My overview</h2>

        <?php

        require_once($_SERVER['DOCUMENT_ROOT'] . '/components/component_succcessmsg.php');

        ?>

        <div class="flex_container flex_center_center row wrap  ">

          <form id="update-profile-image" action="/upload-profile-image" method="POST" enctype="multipart/form-data" onsubmit="return validate();">

            <?= set_csrf() ?>

            <div class=" flex_container column profile_image_container ">
              <img class="img-show-input profile-image-upload profile-image" src="/profile-uploads/<?= $user['user_image'] ?>" alt="Profile image of  <?= $user['user_lastname'] ?>">
              <label class="icon-upload-h5 pointer" for="upload-img"><i class="fas fa-camera"></i></label>
              <input class="file-to-upload" id="upload-img" type="file" name="file-to-upload" data-validate="file" class="img-input" onchange="loadFile(event)" style=" display: none;">
            </div>
            <button class="button upload-profile-image" type="submit">Upload image</button>
          </form>
          <div class="account-subtitle">
            <p> <?= $user['user_firstname'] ?> <?= $user['user_lastname'] ?></p>
            <p> <?= $user['user_email'] ?></p>
          </div>
        </div>


        <!-- ############## my products ##############s -->

        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/db/fetch_my_products.php');
        ?>

        <div class="flex column">
          <h3>My products</h3>

          <?php
          require_once('./components/component_errormsg.php');
          require_once('./components/component_succcessmsg.php');
          ?>

          <div class="products-container">
            <?php
            foreach ($user_products as $user_product) {
              $image = json_decode($user_product['product_image']);
              $description = out(openssl_decrypt(base64_decode($user_product['product_description']), $encrypt_algo, $key, OPENSSL_RAW_DATA, base64_decode($user_product['product_iv'])));
            ?>

              <div class="product_container">
                <div class="product">
                  <div class="img-container">
                    <img src="/product-images/<?= out($image[0]) ?>" alt="Image of <?= out($user_product['product_title']) ?>">
                    <div class="price"> <?= out($user_product['product_price']) ?> <span>dkk</span></div>

                  </div>
                  <div class="product-info">
                    <p class="h5 title"> <?= out($user_product['product_title']) ?></p>
                    <p class="description">
                      <?= $description ?>
                    </p>
                  </div>
                  <a href="/single-product/<?= $user_product['product_id'] ?>"></a>
                </div>
                <div class="edit_product_container">
                  <a class="button small" href="/edit-product/<?= $user_product['product_id'] ?>">Edit</a>
                  <a id="<?= $user_product['product_id'] ?>" title="<?= $user_product['product_title'] ?>" class="link pointer small" onclick="open_confirm_modal_product(this)">
                    Delete
                  </a>
                </div>
              </div>
            <?php

            }
            ?>
          </div>

          <div id="confirm_modal_delete_account" class="confirm_modal text-center ">
            <div class="confirm_modal_content">
              <h3>Are you sure?</h3>
              <p class="margin-5"> You are about to delete your account</p>
              <div class="flex_container flex_row_reverse flex_center_center margin-20-top">
                <form action="/delete-account" method="POST">
                  <?= set_csrf() ?>
                  <button class=" margin-5 button medium_button">Delete account</button>
                </form>
                <button class=" margin-5 close_account button medium_button button_bg_light">Cancel</button>
              </div>

            </div>
          </div>

          <div id="confirm_modal_delete_product" class="confirm_modal text-center ">
            <div class="confirm_modal_content">
              <h3>Are you sure?</h3>
              <div class="flex_container flex_center_center">
                <p class="margin-5"> You are about to delete product:</p>
                <p class="margin-5" id="product_name_show"> </p>
              </div>
              <div class="flex_container flex_row_reverse flex_center_center margin-20-top">
                <form action="/delete-product" method="POST">
                  <?= set_csrf() ?>
                  <input type="hidden" name="user_product" id="user_product" value="">
                  <button class=" margin-5 button medium_button">Delete product</button>
                </form>
                <button class="margin-5 close button medium_button button_bg_light">Cancel</button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</main>

<script>
  // confirm modal delete account
  let modal_account = document.getElementById("confirm_modal_delete_account");
  let span_account = document.getElementsByClassName("close_account")[0];

  function open_confirm_modal_account() {
    modal_account.style.display = "block";
  }

  span_account.onclick = function() {
    modal_account.style.display = "none";
  }

  window.onclick = function(event) {
    if (event.target == modal_account) {
      modal_account.style.display = "none";
    }
  }

  // confirm modal delete product
  let modal_product = document.getElementById("confirm_modal_delete_product");
  let span = document.getElementsByClassName("close")[0];
  const input = document.querySelector('#user_product');

  function open_confirm_modal_product(element) {
    modal_product.style.display = "block";
    input.value = element.id;
    let product_title = element.title;
    document.getElementById('product_name_show').innerHTML = product_title
  }

  span.onclick = function() {
    modal_product.style.display = "none";
  }

  window.onclick = function(event) {
    if (event.target == modal_product) {
      modal_product.style.display = "none";
    }
  }
</script>


<script src="/js/headerScroll.js"></script>
<script src="/js/image_preload.js"></script>

</body>

</html>