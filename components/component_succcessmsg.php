<?php
if (isset($success_message)) {
?>
    <div class="success-message">
        <h3>
            Success!
        </h3>
        <p>
            <?= urldecode($success_message) ?>
        </p>
    </div>
<?php
}
?>