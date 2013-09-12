<div class="alert<?php echo isset($class) ? ' alert-' . $class : ''; ?>">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo $message; ?>
</div>