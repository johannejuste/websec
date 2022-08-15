<?php

session_start();
if (!isset($_SESSION['user_uuid'])) {
  header('Location: /login');
  exit();
}

require('./db/db.php');

require('./db/globals.php');

require('./db/fetch_product.php');
$image = json_decode($product['product_image']);
$message = out(openssl_decrypt(base64_decode($product['product_description']), $encrypt_algo, $key, OPENSSL_RAW_DATA, base64_decode($product['product_iv'])));



require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_top.php');

?>
<main>
  <div class="page-container">
    <div class="product-content-container">
      <h2 class=" h1 product-title"><?= out($product['product_title']) ?></h2>

      <div class="product-imgs">
        <div class="img-display">
          <div class="img-showcase">
            <?php

            foreach ($image as $index => $item) {

            ?>
              <img src="/product-images/<?= out($item) ?>" alt="product image">
            <?php


            }
            ?>
          </div>
        </div>
        <div class="img-select">
          <?php
          $count = 0;
          if (count($image) > 1) {


            foreach ($image as $index => $item) {
              $count++
              // other
          ?>
              <div class="img-item">
                <a href="#" data-id="<?= $count ?>">
                  <img src="/product-images/<?= out($item) ?>" alt="product image">
                </a>
              </div>
          <?php
            }
          }
          ?>
        </div>
        <?php

        ?>
      </div>
      <!-- card right -->
      <div class="product-content">
        <div class="description">

          <h2 class="product-title h2"> About this product </h2>
          <p><?= $message ?></p>
        </div>


        <div class="product-info">
          <div class="created-by">
            <p class="price"><span><?= out($product['product_price']) ?></span> DKK</p>
            <div>

              <p>Created: <span><?= out($product['product_timestamp']) ?></span></p>
              <p>By: <span><?= out($product['user_firstname']) ?> <?= out($product['user_lastname']) ?></span></p>
            </div>
          </div>
          <a href="#comments-section" class="button large">Contact seller</a>
        </div>

      </div>

    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db/fetch_comments.php');
    ?>
    <section id="comments-section">

      <div class="create-comment-container">
        <div class="create-comment-form-container">
          <h4>Write a message to <?= out($product['user_firstname']) ?></h4>
          <img src="/profile-uploads/<?= $_SESSION['user_image'] ?>" alt="Image of <?= $_SESSION['user_firstname'] ?>">
          <form id="create_comment" action="/create-comment/<?= $product_id  ?>" method="POST" onsubmit="return validate(this)">
            <?= set_csrf() ?>
            <div class="form-group">
              <input type="hidden" name="product_id" value="<?= $product_id ?>">
              <textarea name="comment_message" class="resize-ta" id="" data-validate="str" data-min="1" data-max="800" placeholder="Add a comment"></textarea>
              <span class="error-message">Comment has to be between 1-800 characters</span>
            </div>
            <button class="button submit-create-comment" type="submit"> Send</button>
          </form>
        </div>
      </div>
      <div class="all-comments-container">
        <?php foreach ($comments as $comment) {
          $commentMessage = out(openssl_decrypt(base64_decode($comment['comment_message']), $encrypt_algo, $key, OPENSSL_RAW_DATA, base64_decode($comment['comment_iv'])));
        ?>
          <div class="single-comment-container">

            <img src="/profile-uploads/<?= $comment['user_image'] ?> " alt="profile image of <?= $comment['user_firstname'] ?>">
            <div class="heading">
              <h6><?= $comment['user_firstname'] ?> <?= $comment['user_lastname'] ?></h6><i class="circle fas fa-circle"></i><span><?= $comment['comment_timestamp'] ?></span>
            </div>
            <div class="comment-content"><?= $commentMessage ?> </div>
            <div class="comment-buttons">
              <div class="replies_number_container">
                <i class="fas fa-caret-down" onclick="showReplies(this)"></i>
                <span class="comment_replies_number"> 6 replies</span>
              </div>
              <i class="circle fas fa-circle"></i>
              <button class="replybtn" type="button" data-target="<?= $comment['comment_id'] ?>" onclick="showReplyForm(this)">Reply</button>

            </div>
            <form action="/create-reply/<?= $comment['comment_id'] ?>/<?= $product_id  ?>" data-target="<?= $comment['comment_id'] ?>" onsubmit="return validate(this)" method="POST" class="reply-form">
              <?= set_csrf() ?>
              <div class="form-group">
                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                <textarea name="reply_message" class="resize-ta" rows="0" data-validate="str" data-min="1" data-max="800" placeholder="Reply to comment"></textarea>
                <span class="error-message">Comment has to be between 1-800 characters</span>
              </div>
              <button class="button smallest" type="submit">Send</button>

              <i type="button" class="fas fa-times" onclick="cancelReply(this)"></i>
            </form>
            <div class="replies-container">
              <?php
              $comment_id = $comment['comment_id'];
              require($_SERVER['DOCUMENT_ROOT'] . '/db/fetch_replies.php');
              $count = 0;
              foreach ($replies as $reply) {
                $count++;
                $replyMessage = out(openssl_decrypt(base64_decode($reply['reply_body']), $encrypt_algo, $key, OPENSSL_RAW_DATA, base64_decode($reply['reply_iv'])));
              ?>
                <div class="single-reply-container" data-times="<?= $count ?>">
                  <img src="/profile-uploads/<?= $reply['user_image'] ?>" alt="Profile image of <?= $reply['user_firstname'] ?> ">
                  <div class="heading">
                    <h6><?= $reply['user_firstname'] ?> <?= $reply['user_lastname'] ?></h6><i class="circle fas fa-circle"></i><span><?= $reply['updated_at'] ?></span>
                  </div>
                  <div class="reply-message">


                    <p><?= $replyMessage ?> </p>

                  </div>
                </div>
              <?php
              }
              ?>
            </div>

          </div>

        <?php
        }
        ?>
      </div>

    </section>

    <section id="newest-products">
      <h3 class="h3 section-header">Other products on Reboot</h3>
      <div class="new-products-container">


        <?php require('./db/fetch_products.php');
        foreach ($products as $product) {
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


  </div>
</main>


<script src="/js/headerScroll.js"></script>
<script src="/js/validateSingle.js"></script>
<script src="/js/singleProduct.js"></script>
</body>

</html>