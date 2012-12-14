<?php echo $this->Html->docType('html5'); ?>
<html lang="en-US" dir="ltr">
    <head>
        <title><?php echo $title_for_layout; ?></title>
        <?php echo $this->Html->charset(); ?>
        <?php echo $this->Html->css(array('reset', 'main', 'color-gray', 'admin-menu', 'error')); ?>
        <?php echo $this->fetch('css'); ?>
        <?php
        echo $this->AdminLayout->jsVar();
        echo $this->Html->script(array(
            'jquery-1.6.3.min',
            'password-strength-meter',
            'user-profile',
            'ckeditor/ckeditor',
            'modernizr.custom.39710',
            'form',
            'common',
            'slug',
            'sidebar-menu',
            'theme-preview',
            'jquery-ui-1.8.23.custom.min',
                )
        );
        ?>
        <?php echo $this->fetch('headerScript'); ?>
        <?php echo $this->Js->writeBuffer(); ?>
    </head>
    <body>
        <div id="wrap">
            <div id="container">
                <div id="header">             
                    <?php echo $this->element('admin/user_info'); ?>
                </div>
                <div id="wrapper">
                    <div id="right-side">
                        <?php echo $this->element('admin/sidebar'); ?>
                    </div>
                    <div id="left-side">
                        <div class="wrap">
                            <?php echo $this->Session->flash(); ?>
                            <?php echo $this->fetch('content'); ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div id="footer">
            <p><?php echo __("Thank you for using Hurad CMS."); ?></p>
        </div>
        <?php //echo $this->element('sql_dump');  ?>
    </body>
</html>