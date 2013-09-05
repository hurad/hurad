<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title_for_layout; ?> &#8212; <?php echo __d('hurad', 'Huard'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $this->Html->charset(); ?>
    <?php echo $this->Html->css(array('admin/bootstrap.min.css', 'admin/main')); ?>
    <?php echo $this->fetch('css'); ?>
    <?php
    echo $this->AdminLayout->jsVar();
    echo $this->Html->script(
        array(
            'admin/jquery-1.9.0.min',
            'admin/jquery-ui-1.10.0.custom.min',
            'admin/bootstrap.min',
            'admin/sidebar-menu',
        )
    );
    ?>
    <?php echo $this->fetch('scriptHeader'); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</head>
<body>
<?php echo $this->element('admin/header'); ?>
<div id="content">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span2">
                <?php echo $this->element('admin/sidebar'); ?>
            </div>
            <div class="span10">
                <?php echo $this->Session->flash('auth'); ?>
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('admin/footer'); ?>
<?php echo $this->fetch('scriptFooter'); ?>
</body>
</html>