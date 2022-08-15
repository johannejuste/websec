<?php
if (isset($error_message)) {
?>
    <div class="error-message">
        <h3>
            ERROR!
        </h3>
        <p>
            <?= urldecode($error_message) ?>
        </p>
    </div>
<?php
}
?>