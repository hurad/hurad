<?php echo $this->Html->docType('html5'); ?>
<html lang="en">
    <head>
        <title><?php echo $title_for_layout; ?> &#8212; <?php echo __('Huard'); ?></title>
        <?php echo $this->Html->charset(); ?>
        <?php echo $this->Html->css(array('bootstrap.min.css', 'login')); ?>
        <?php echo $this->Html->script(array('admin/jquery-1.9.0.min', 'admin/jquery-ui-1.10.0.custom.min', 'bootstrap.min')); ?>        
    </head>
    <body>
        <div id="content">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="row-fluid">
                        <div class="span4 offset4">
                            <?php echo $this->Session->flash('flash'); ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4 offset4 well">
                            <div class="login-logo">
                                <?php echo $this->Html->image('hurad.png', array('width' => '80px')); ?>
                                <h1>Hurad<small>(alpha)</small></h1>
                            </div>
                            <?php echo $this->Session->flash('flash'); ?>
                            <?php echo $this->fetch('content'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>