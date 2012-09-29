<?php echo $this->Html->docType('html5'); ?>
<html lang="en-US" dir="ltr">
    <head>
        <title><?php echo $title_for_layout; ?></title>
        <?php echo $this->Html->charset(); ?>
        <?php echo $this->Html->css(array('reset', 'main', 'color-gray', 'login')); ?>
        <?php echo $this->Html->script(array('jquery-1.6.3.min', 'ckeditor/ckeditor', 'modernizr.custom.39710', 'form')); ?>        
    </head>
    <body>
        <div id="wrap">
            <div id="container">
                <div id="header">             
                    <?php echo $this->element('admin/user_info'); ?>
                </div>
                <div id="wrapper_login">

                    <div class="wrap_login">
                        <div id="login">
                            <?php echo $this->Session->flash('flash', array('element' => 'flash-admin_login')); ?>
                            <?php echo $this->fetch('content'); ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div id="footer">
            <p><?php echo __("Thank you for using Arad CMS."); ?></p>
        </div>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>