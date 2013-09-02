<div class="well installer">
    <?php echo $this->element('Installer/header', array('message' => __("Welcome to Hurad"))); ?>
    <div class="container-fluid">
        <div class="row">
            <?php echo $this->Html->link(
                __('Enter to admin section'),
                '/admin',
                array('class' => 'btn btn-large btn-block btn-success')
            ); ?>
            <?php echo $this->Html->link(
                __('View site'),
                '/',
                array('class' => 'btn btn-large btn-block btn-primary')
            ); ?>
        </div>
    </div>
</div>