<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create(
    'Media',
    array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        ),
        'type' => 'file'
    )
);
?>

<div class="form-group">
    <?php echo $this->Form->label('file', __d('hurad', 'Choose File'), array('class' => 'control-label col-lg-2')); ?>
    <div class="col-lg-4">
        <?php
        echo $this->Form->input(
            'file',
            array(
                'required' => false, //For disable HTML5 validation
                'type' => 'file',
                'class' => 'form-control'
            )
        );
        ?>
    </div>
</div>

<?php echo $this->Form->button(__d('hurad', 'Upload'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>

<?php echo $this->Form->end(); ?>