<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create('User', array(
    'class' => 'form-horizontal',
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>

<div class="control-group <?php echo $this->Form->isFieldError('username') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('username', __('Username'), array('class' => 'control-label')); ?>
    <div class="controls">
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
            'type' => 'text')
        );
        ?>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('email') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('email', __('e-Mail'), array('class' => 'control-label')); ?>
    <div class="controls">
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
            'type' => 'text')
        );
        ?>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('UserMeta.firstname') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('UserMeta.firstname', __('First Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('UserMeta.firstname', array('type' => 'text')); ?>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('UserMeta.lastname') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('UserMeta.lastname', __('Last Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('UserMeta.lastname', array('type' => 'text')); ?>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('url') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('url', __('Website'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('url', array(
            'error' => array(
                'urlRule-1' => __('Please enter valid url.'), //url rule message
                'attributes' => array(
                    'wrap' => 'span',
                    'class' => 'help-inline'
                )
            ),
            'required' => FALSE, //For disable HTML5 validation
            'type' => 'text'));
        ?>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('password') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('password', __('Password'), array('class' => 'control-label')); ?>
    <div class="controls">
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
            'type' => 'password')
        );
        ?>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('confirm_password') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('confirm_password', __('Retype Password'), array('class' => 'control-label')); ?>
    <div class="controls">
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
            'type' => 'password')
        );
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('role', __('Role'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('role', array(
            'options' => array(
                'user' => __('User'),
                'author' => __('Author'),
                'editor' => __('Editor'),
                'admin' => __('Administrator')
            )
        ));
        ?>
    </div>
</div>

<div class="form-actions">
    <?php echo $this->Form->button(__('Add New User'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
</div>