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

<div class="control-group">
    <?php echo $this->Form->label('name', __d('hurad', 'Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('name', array('type' => 'text')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('alias', __d('hurad', 'Alias'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('slug', array('type' => 'text')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('description', __d('hurad', 'Description'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('description', array('class' => 'col-md-5')); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo $this->Form->submit(__d('hurad', 'Add menu'), array('class' => 'btn btn-primary')); ?>
</div>

<?php echo $this->Form->end(null); ?>