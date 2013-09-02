<?php
echo $this->Form->create(
    'User',
    array(
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    )
);
?>

    <div class="control-group <?php echo $this->Form->isFieldError('username') ? 'error' : ''; ?>">
        <?php
        echo $this->Form->input(
            'username',
            array(
                'error' => false,
                'required' => false, //For disable HTML5 validation
                'type' => 'text',
                'class' => 'input-block-level',
                'placeholder' => __('Username')
            )
        );
        ?>
    </div>

<?php echo $this->Form->button(
    __('Submit'),
    array('div' => false, 'type' => 'submit', 'class' => 'btn btn-info btn-block')
); ?>

<?php echo $this->Form->end(); ?>