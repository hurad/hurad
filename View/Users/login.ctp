<?php
echo $this->Form->create('User', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>
<p>
    <?php echo $this->Form->label('username', 'Username'); ?><br>
    <?php echo $this->Form->input('username'); ?>
</p>
<p>
    <?php echo $this->Form->label('password', 'Password'); ?><br>
    <?php echo $this->Form->input('password'); ?>
</p>
<p class="remember_me">
    <?php echo $this->Form->input('remember_me', array('label' => 'Remember Me', 'type' => 'checkbox')); ?>
</p>
<p class="submit_login">
    <?php echo $this->Form->submit('Login', array('div' => false, 'name' => 'publish', 'class' => 'login-button')); ?>
</p>
</form>