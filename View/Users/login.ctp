<?php
echo $this->Form->create('User', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>

<div class="control-group <?php echo $this->Form->isFieldError('username') ? 'error' : ''; ?>">
    <?php
    echo $this->Form->input('username', array(
        'error' => array(
            'usernameRule-1' => __('Minimum length of 5 characters.'), //minLength rule message
            'usernameRule-2' => __('This username has already been taken.'), //isUnique rule message
            'usernameRule-3' => __('This field cannot be left blank.'), //notEmpty rule message
            'attributes' => array(
                'wrap' => 'span',
                'class' => 'help-inline'
            )
        ),
        'required' => FALSE, //For disable HTML5 validation
        'type' => 'text',
        'class' => 'input-block-level',
        'placeholder' => __('Username')
            )
    );
    ?>
</div>

<div class="control-group <?php echo $this->Form->isFieldError('password') ? 'error' : ''; ?>">
    <?php
    echo $this->Form->input('password', array(
        'error' => array(
            'passwordRule-1' => __('Passwords must be between 5 and 32 characters long.'), //between rule message
            'attributes' => array(
                'wrap' => 'span',
                'class' => 'help-inline'
            )
        ),
        'required' => FALSE, //For disable HTML5 validation
        'type' => 'password',
        'class' => 'input-block-level',
        'placeholder' => __('Password')
            )
    );
    ?>
</div>

<label class="checkbox">
    <?php echo $this->Form->input('remember_me', array('label' => __('Remember Me'), 'type' => 'checkbox')); ?>
</label>

<?php echo $this->Form->button(__('Login'), array('div' => false, 'type' => 'submit', 'class' => 'btn btn-info btn-block')); ?>
</form>