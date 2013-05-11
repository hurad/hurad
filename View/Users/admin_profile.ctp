<?php $this->Html->css('admin/Users/pass-strength', null, array('inline' => FALSE)); ?>
<?php $this->Html->script(array('admin/Users/profile', 'admin/Users/password-strength-meter'), array('block' => 'scriptHeader')); ?>

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
            'type' => 'text',
            'disabled' => true)
        );
        ?>
    </div>
</div>

<div class="control-group <?php echo $this->Form->isFieldError('UserMeta.firstname') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('UserMeta.firstname', __('First Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('UserMeta.firstname', array(
//            'error' => array(
//                'usernameRule-1' => __('Minimum length of 5 characters.'), //minLength rule message
//                'usernameRule-2' => __('This username has already been taken.'), //isUnique rule message
//                'usernameRule-3' => __('This field cannot be left blank.'), //notEmpty rule message
//                'attributes' => array(
//                    'wrap' => 'span',
//                    'class' => 'help-inline'
//                )
//            ),
            'required' => FALSE, //For disable HTML5 validation
            'type' => 'text')
        );
        ?>
    </div>
</div>

<div class="control-group <?php echo $this->Form->isFieldError('UserMeta.lastname') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('UserMeta.lastname', __('Last Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('UserMeta.lastname', array(
//            'error' => array(
//                'usernameRule-1' => __('Minimum length of 5 characters.'), //minLength rule message
//                'usernameRule-2' => __('This username has already been taken.'), //isUnique rule message
//                'usernameRule-3' => __('This field cannot be left blank.'), //notEmpty rule message
//                'attributes' => array(
//                    'wrap' => 'span',
//                    'class' => 'help-inline'
//                )
//            ),
            'required' => FALSE, //For disable HTML5 validation
            'type' => 'text')
        );
        ?>
    </div>
</div>

<div class="control-group <?php echo $this->Form->isFieldError('UserMeta.nickname') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('UserMeta.nickname', __('Nickname'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('UserMeta.nickname', array(
//            'error' => array(
//                'usernameRule-1' => __('Minimum length of 5 characters.'), //minLength rule message
//                'usernameRule-2' => __('This username has already been taken.'), //isUnique rule message
//                'usernameRule-3' => __('This field cannot be left blank.'), //notEmpty rule message
//                'attributes' => array(
//                    'wrap' => 'span',
//                    'class' => 'help-inline'
//                )
//            ),
            'required' => FALSE, //For disable HTML5 validation
            'type' => 'text')
        );
        ?>
    </div>
</div>

<div class="control-group <?php echo $this->Form->isFieldError('UserMeta.display_name') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('UserMeta.display_name', __('Display Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('UserMeta.display_name', array(
            'options' => $this->AdminLayout->displayNameOptions($current_user),
//            'error' => array(
//                'usernameRule-1' => __('Minimum length of 5 characters.'), //minLength rule message
//                'usernameRule-2' => __('This username has already been taken.'), //isUnique rule message
//                'usernameRule-3' => __('This field cannot be left blank.'), //notEmpty rule message
//                'attributes' => array(
//                    'wrap' => 'span',
//                    'class' => 'help-inline'
//                )
//            ),
                //'required' => FALSE, //For disable HTML5 validation
                )
        );
        ?>
    </div>
</div>

<div class="control-group <?php echo $this->Form->isFieldError('email') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('email', __('Email'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('email', array(
//            'error' => array(
//                'usernameRule-1' => __('Minimum length of 5 characters.'), //minLength rule message
//                'usernameRule-2' => __('This username has already been taken.'), //isUnique rule message
//                'usernameRule-3' => __('This field cannot be left blank.'), //notEmpty rule message
//                'attributes' => array(
//                    'wrap' => 'span',
//                    'class' => 'help-inline'
//                )
//            ),
            'required' => FALSE, //For disable HTML5 validation
            'type' => 'text')
        );
        ?>
    </div>
</div>

<div class="control-group <?php echo $this->Form->isFieldError('url') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('url', __('Website'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('url', array(
            'error' => array(
                'urlRule-1' => __('Enter valid url.'), //url rule message
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

<div class="control-group">
    <?php echo $this->Form->label('password', __('Password'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('password', array(
            'error' => false,
            'required' => false, //For disable HTML5 validation
            'value' => '',
            'type' => 'password',
            'autocomplete' => 'off',)
        );
        ?>
        <span class="help-inline"><?php echo __('If you would like to change the password type a new one. Otherwise leave this blank.') ?></span>
    </div>
</div>

<div class="control-group">
    <?php echo $this->Form->label('confirm_password', __('Confirm Password'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('confirm_password', array(
            'error' => false,
            'required' => false, //For disable HTML5 validation
            'type' => 'password',
            'autocomplete' => 'off',)
        );
        ?>
        <span class="help-inline"><?php echo __('Type your new password again.') ?></span>
        <span class="help-block">
            <div id="pass-strength-result"><?php echo __('Strength indicator'); ?></div>
            <p class="description indicator-hint"><?php echo __('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ & ).'); ?></p>
        </span>
    </div>
</div>

<div class="form-actions">
    <?php echo $this->Form->button(__('Update Profile'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
</div>

<?php echo $this->Form->end(); ?>

<script type='text/javascript'>
    /* <![CDATA[ */
    var commonL10n = {
        warnDelete: "You are about to permanently delete the selected items.\n  \'Cancel\' to stop, \'OK\' to delete."
    };
    try {
        convertEntities(commonL10n);
    } catch (e) {
    }
    ;
    var pwsL10n = {
        empty: "<?php echo __('Strength indicator') ?>",
        shortly: "<?php echo __('Very weak') ?>",
        bad: "<?php echo __('Weak') ?>",
        good: "<?php echo __('Medium') ?>",
        strong: "<?php echo __('Strong') ?>",
        mismatch: "<?php echo __('Mismatch') ?>"
    };
    try {
        convertEntities(pwsL10n);
    } catch (e) {
    }
    ;
    /* ]]> */
</script>