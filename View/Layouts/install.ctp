<?php echo $this->Html->docType(); ?>
<html lang="en">
    <head>
        <title><?php echo $title_for_layout . ' &dash; ' .__('Hurad'); ?></title>
        <?php echo $this->Html->charset(); ?>
        <?php echo $this->Html->css(array('admin/bootstrap.min', 'Installer/install')); ?>
    </head>
    <body>
        <div class="container">
            <?php echo $this->Session->flash('auth'); ?>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
        </div>
    </body>
</html>