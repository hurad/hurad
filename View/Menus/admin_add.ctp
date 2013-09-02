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
    <?php echo $this->Form->label('name', __('Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('name', array('type' => 'text')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('alias', __('Alias'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('slug', array('type' => 'text')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('description', __('Description'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('description', array('class' => 'span5')); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo $this->Form->submit(__('Add menu'), array('class' => 'btn btn-primary')); ?>
</div>

<?php echo $this->Form->end(null); ?>