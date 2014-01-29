<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create(
    'Option',
    array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        ),
        'url' => array(
            'controller' => 'options',
            'action' => 'prefix',
            $prefix,
        )
    )
);
?>

<div class="form-group">
    <?php echo $this->Form->label(
        'show_posts_per_page',
        __d('hurad', 'Show posts per page'),
        array('class' => 'control-label col-lg-3')
    ); ?>
    <div class="col-lg-4">
        <?php echo $this->Form->input('show_posts_per_page', array('class' => 'form-control')); ?>
    </div>
</div>

<?php echo $this->Form->button(__d('hurad', 'Update'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>

<?php echo $this->Form->end(); ?>