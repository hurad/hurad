<?php $this->Html->css('pass-strength', null, array('inline' => FALSE)); ?>
<?php echo $this->Html->script(array('users.profile', 'password-strength-meter'), array('block' => 'headerScript')); ?>

<h2><?php echo $title_for_layout; ?></h2>
<?php
echo $this->Form->create('User', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>
<h3><?php echo __('Name'); ?></h3>
<table class="form-table">
    <tbody>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('username', __('User Name')); ?></th>
            <td>
                <?php echo $this->Form->input('username', array('disabled' => TRUE)); ?>
                <span class="description"><?php echo __('Usernames cannot be changed.'); ?></span>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('firstname', __('First Name')); ?></th>
            <td><?php echo $this->Form->input('firstname'); ?></td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('lastname', __('Last Name')); ?></th>
            <td><?php echo $this->Form->input('lastname'); ?></td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('nickname', __('Nickname')); ?></th>
            <td><?php echo $this->Form->input('nickname'); ?></td>
        </tr>
    </tbody>
</table>
<h3><?php echo __('Contact Info'); ?></h3>
<table class="form-table">
    <tbody>
        <tr class="form-field">
            <th scope="row">
                <?php echo $this->Form->label('email', __('Email')); ?>
                <span class="description"><?php echo __('(Required)'); ?></span>
            </th>
            <td><?php echo $this->Form->input('email'); ?></td>
        </tr>         
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('url', __('Website')); ?></th>
            <td><?php echo $this->Form->input('url'); ?></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <?php echo $this->Form->label('password', __('New Password')); ?>
            </th>
            <td>
                <?php echo $this->Form->input('password', array('type' => 'password', 'autocomplete' => 'off', 'value' => '', 'size' => '16', 'error' => FALSE)); ?>
                <span class="description"><?php echo __('If you would like to change the password type a new one. Otherwise leave this blank.'); ?></span>
                <br>
                <?php echo $this->Form->input('confirm_password', array('type' => 'password', 'autocomplete' => 'off', 'value' => '', 'size' => '16', 'error' => FALSE)); ?>
                <span class="description"><?php echo __('Type your new password again.'); ?></span>
                <br>
                <div id="pass-strength-result"><?php echo __('Strength indicator'); ?></div>
                <p class="description indicator-hint"><?php echo __('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ & ).'); ?></p>
            </td>
        </tr>
    </tbody>
</table>
<?php echo $this->Form->input(__('Update Profile'), array('type' => 'submit', 'class' => 'add_button')); ?>

<script type='text/javascript'>
    /* <![CDATA[ */
    var commonL10n = {
        warnDelete: "You are about to permanently delete the selected items.\n  \'Cancel\' to stop, \'OK\' to delete."
    };
    try{convertEntities(commonL10n);}catch(e){};
    var pwsL10n = {
        empty: "<?php echo __('Strength indicator') ?>",
        shortly: "<?php echo __('Very weak') ?>",
        bad: "<?php echo __('Weak') ?>",
        good: "<?php echo __('Medium') ?>",
        strong: "<?php echo __('Strong') ?>",
        mismatch: "<?php echo __('Mismatch') ?>"
    };
    try{convertEntities(pwsL10n);}catch(e){};
    /* ]]> */
</script>