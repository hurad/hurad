<div class="users form">
<h2><?php echo __('Forgot Password'); ?></h2>
<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'forgot')));?>
<fieldset>
<?php
            echo $this->Form->input('username');
        ?>
</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>