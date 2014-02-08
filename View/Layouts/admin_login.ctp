<?php echo $this->Html->docType('html5'); ?>
<html lang="en">
<head>
    <title><?php echo $title_for_layout; ?> &#8212; <?php echo __d('hurad', 'Huard'); ?></title>
    <?php echo $this->Html->charset(); ?>
    <?php echo $this->Html->css(array('bootstrap.min.css', 'login')); ?>
    <?php echo $this->Html->script(
        array('admin/jquery-1.9.0.min', 'admin/jquery-ui-1.10.0.custom.min', 'bootstrap.min')
    ); ?>
</head>
<body>
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?php echo $this->Session->flash('flash'); ?>
                <div class="login-logo well">
                    <?php echo $this->Html->image('hurad.png', array('width' => '80px')); ?>
                    <h1 class="text-muted clearfix">Hurad
                        <small>(alpha)</small>
                    </h1>
                    <?php echo $this->fetch('content'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
