<!DOCTYPE html>
<html dir="<?= Configure::read('Hurad.language.catalog')['direction'] ?>">
<head>
    <title><?php echo $title_for_layout; ?> &#8212; <?php echo __d('hurad', 'Huard'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php echo $this->Html->charset(); ?>
    <?php echo $this->Html->css(array('bootstrap.min.css', 'admin/main')); ?>
    <?php echo $this->fetch('css'); ?>
    <?php
    echo $this->AdminLayout->jsVar();
    echo $this->Html->script(
        array(
            'jquery-1.9.0.min',
            'jquery-ui-1.10.0.custom.min',
            'bootstrap.min',
            'admin/sidebar-menu',
        )
    );
    ?>
    <?php echo $this->fetch('scriptHeader'); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</head>
<body>
<?php echo $this->element('admin/header'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-2" id="sidebar" role="navigation">
            <?php echo $this->element('admin/sidebar'); ?>
        </div>
        <div class="col-md-10">
            <?php echo $this->Session->flash('auth'); ?>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
        </div>
    </div>
</div>
<?php echo $this->element('admin/footer'); ?>
<?php echo $this->fetch('scriptFooter'); ?>
</body>
</html>