<!-- app/View/Users/register.ctp -->
<?php
echo $this->Form->create('User', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>
<table class="login">
    <tbody>
        <tr>
            <td>
                <?php echo $this->Form->label('username', __('Username')); ?><br>
                <?php echo $this->Form->input('username', array('error' => array('wrap' => FALSE))); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $this->Form->label('password', __('Password')); ?><br>
                <?php echo $this->Form->input('password'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $this->Form->label('confirm_password', __('Confirm Password')); ?><br>
                <?php echo $this->Form->input('confirm_password', array('type' => 'password')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $this->Form->label('email', __('Email')); ?><br>
                <?php echo $this->Form->input('email'); ?>
            </td>
        </tr>
        <tr class="submit_login">
            <td>
                <?php echo $this->Form->submit(__('Register'), array('div' => false, 'name' => 'publish', 'class' => 'login-button')); ?>
            </td>
        </tr>
    </tbody>
</table>
</form>
