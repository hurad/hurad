<!-- File: /app/View/Elements/flash_error.ctp -->
<div class="flash_error" id="message">
    <p>
        <strong><?php echo __('Error: ') ?></strong>
        <?php echo $message; ?>
    </p>
    <?php if ($errors) { ?>
        <ul style="margin-left: 20px; padding-bottom: 5px;">
            <?php
            foreach ($errors as $fields) {
                foreach ($fields as $error) {
                    echo '<li>' . $error . '</li>' . "\n";
                }
            }
            ?>
        </ul>
    <?php } ?>
</div>