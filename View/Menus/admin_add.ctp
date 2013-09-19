<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create(
    'Menu',
    array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    )
);
?>

<div class="form-group">
    <?php echo $this->Form->label('name', __d('hurad', 'Name'), array('class' => 'control-label col-lg-2')); ?>
    <div class="col-lg-4">
        <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
    </div>
</div>
<div class="form-group">
    <?php echo $this->Form->label('alias', __d('hurad', 'Alias'), array('class' => 'control-label col-lg-2')); ?>
    <div class="col-lg-4">
        <?php echo $this->Form->input('slug', array('class' => 'form-control')); ?>
    </div>
</div>
<div class="form-group">
    <?php echo $this->Form->label(
        'description',
        __d('hurad', 'Description'),
        array('class' => 'control-label col-lg-2')
    ); ?>
    <div class="col-lg-4">
        <?php echo $this->Form->input('description', array('class' => 'form-control')); ?>
    </div>
</div>

<?php echo $this->Form->submit(__d('hurad', 'Add menu'), array('class' => 'btn btn-primary')); ?>

<?php echo $this->Form->end(); ?>