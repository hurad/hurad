<?php echo $this->Html->docType(); ?>
<html lang="en">
<head>
    <title><?php echo $title_for_layout . ' &dash; ' . __d('hurad', 'Hurad'); ?></title>
    <?php echo $this->Html->charset(); ?>
    <?php echo $this->Html->css(array('bootstrap.min', 'Installer/install')); ?>
</head>
<body>
<div class="container">
    <div class="installer">
        <?php echo $this->Session->flash('auth'); ?>
        <?php echo $this->Session->flash(); ?>
    </div>
    <div class="well installer">
        <?php echo $this->fetch('content'); ?>
    </div>
</div>
</body>
</html>