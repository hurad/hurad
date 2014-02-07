<div class="alert<?php echo isset($class) ? ' alert-' . $class : ''; ?>">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong><?php echo __d('hurad', 'Warning!'); ?></strong> <?php echo $message; ?>
</div>