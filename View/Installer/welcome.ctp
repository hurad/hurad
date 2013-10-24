<?php echo $this->element('Installer/header', array('message' => __("Welcome to Hurad"))); ?>
<div class="container">
    <div class="row">
        <?php echo $this->Html->link(
            __d('hurad', 'Enter to admin section'),
            '/admin',
            array('class' => 'btn btn-lg btn-block btn-success')
        ); ?>
        <?php echo $this->Html->link(
            __d('hurad', 'View site'),
            '/',
            array('class' => 'btn btn-lg btn-block btn-primary')
        ); ?>
    </div>
</div>