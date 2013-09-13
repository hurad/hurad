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
                'error' => array(
                    'usernameRule-1' => __d('hurad', 'Minimum length of 5 characters.'), //minLength rule message
                    'usernameRule-2' => __d('hurad', 'This username has already been taken.'), //isUnique rule message
                    'usernameRule-3' => __d('hurad', 'This field cannot be left blank.'), //notEmpty rule message
                    'attributes' => array(
                        'wrap' => 'span',
                        'class' => 'help-inline'
                    )
                ),
                'required' => false, //For disable HTML5 validation
                'type' => 'text',
                'class' => 'input-block-level',
                'placeholder' => __d('hurad', 'Username')
            )
        );
        ?>
    </div>

    <div class="control-group <?php echo $this->Form->isFieldError('password') ? 'error' : ''; ?>">
        <?php
        echo $this->Form->input(
            'password',
            array(
                'error' => array(
                    'passwordRule-1' => __d('hurad', 'Passwords must be between 5 and 32 characters long.'),
                    //between rule message
                    'attributes' => array(
                        'wrap' => 'span',
                        'class' => 'help-inline'
                    )
                ),
                'required' => false, //For disable HTML5 validation
                'type' => 'password',
                'class' => 'input-block-level',
                'placeholder' => __d('hurad', 'Password')
            )
        );
        ?>
    </div>

    <label class="checkbox">
        <?php echo $this->Form->input('remember_me', array('label' => __d('hurad', 'Remember Me'), 'type' => 'checkbox')); ?>
    </label>

<?php if (Configure::check('General.users_can_register') && Configure::read('General.users_can_register') == 1) : ?>
    <div class="control-group">
        <?php echo $this->Html->link(__d('hurad', 'Not registered?'), array('controller' => 'users', 'action' => 'register')); ?>
    </div>
<?php endif; ?>

    <div class="control-group">
        <?php echo $this->Html->link(__d('hurad', 'Forgot password?'), array('controller' => 'users', 'action' => 'forgot')); ?>
    </div>

<?php echo $this->Form->button(
    __d('hurad', 'Login'),
    array('div' => false, 'type' => 'submit', 'class' => 'btn btn-info btn-block')
); ?>

<?php echo $this->Form->end(); ?>