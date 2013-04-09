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

<div class="control-group <?php echo $this->Form->isFieldError('confirm_password') ? 'error' : ''; ?>">
    <?php
    echo $this->Form->input('confirm_password', array(
        'error' => array(
            'confirmPasswordRule-1' => __('Entered passwords do not match.'), //checkPasswords rule message
            'attributes' => array(
                'wrap' => 'span',
                'class' => 'help-inline'
            )
        ),
        'required' => FALSE, //For disable HTML5 validation
        'type' => 'password',
        'class' => 'input-block-level',
        'placeholder' => __('Confirm Password')
            )
    );
    ?>
</div>

<div class="control-group <?php echo $this->Form->isFieldError('email') ? 'error' : ''; ?>">
    <?php
    echo $this->Form->input('email', array(
        'error' => array(
            'emailRule-1' => __('Please enter valid email.'), //email rule message
            'emailRule-2' => __('This email has already exist.'), //isUnique rule message
            'attributes' => array(
                'wrap' => 'span',
                'class' => 'help-inline'
            )
        ),
        'required' => FALSE, //For disable HTML5 validation
        'type' => 'text',
        'class' => 'input-block-level',
        'placeholder' => __('Email')
            )
    );
    ?>
</div>    

<?php echo $this->Form->button(__('Register'), array('div' => false, 'type' => 'submit', 'class' => 'btn btn-info btn-block')); ?>

<?php echo $this->Form->end(); ?>
