<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create(
    'User',
    array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    )
);
?>

<div class="control-group <?php echo $this->Form->isFieldError('username') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('username', __d('hurad', 'Username'), array('class' => 'control-label')); ?>
    <div class="controls">
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
                'type' => 'text'
            )
        );
        ?>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('email') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('email', __d('hurad', 'e-Mail'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input(
            'email',
            array(
                'error' => array(
                    'emailRule-1' => __d('hurad', 'Please enter valid email.'), //email rule message
                    'emailRule-2' => __d('hurad', 'This email has already exist.'), //isUnique rule message
                    'attributes' => array(
                        'wrap' => 'span',
                        'class' => 'help-inline'
                    )
                ),
                'required' => false, //For disable HTML5 validation
                'type' => 'text'
            )
        );
        ?>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('UserMeta.firstname') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('UserMeta.firstname', __d('hurad', 'First Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('UserMeta.firstname', array('type' => 'text')); ?>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('UserMeta.lastname') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('UserMeta.lastname', __d('hurad', 'Last Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('UserMeta.lastname', array('type' => 'text')); ?>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('url') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('url', __d('hurad', 'Website'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input(
            'url',
            array(
                'error' => array(
                    'urlRule-1' => __d('hurad', 'Please enter valid url.'), //url rule message
                    'attributes' => array(
                        'wrap' => 'span',
                        'class' => 'help-inline'
                    )
                ),
                'required' => false, //For disable HTML5 validation
                'type' => 'text'
            )
        );
        ?>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('password') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('password', __d('hurad', 'Password'), array('class' => 'control-label')); ?>
    <div class="controls">
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
                'type' => 'password'
            )
        );
        ?>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('confirm_password') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('confirm_password', __d('hurad', 'Retype Password'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input(
            'confirm_password',
            array(
                'error' => array(
                    'confirmPasswordRule-1' => __d('hurad', 'Entered passwords do not match.'), //checkPasswords rule message
                    'attributes' => array(
                        'wrap' => 'span',
                        'class' => 'help-inline'
                    )
                ),
                'required' => false, //For disable HTML5 validation
                'type' => 'password'
            )
        );
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('role', __d('hurad', 'Role'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input(
            'role',
            array(
                'options' => array(
                    'user' => __d('hurad', 'User'),
                    'author' => __d('hurad', 'Author'),
                    'editor' => __d('hurad', 'Editor'),
                    'admin' => __d('hurad', 'Administrator')
                )
            )
        );
        ?>
    </div>
</div>

<div class="form-actions">
    <?php echo $this->Form->button(__d('hurad', 'Add New User'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
</div>

<?php echo $this->Form->end(); ?>