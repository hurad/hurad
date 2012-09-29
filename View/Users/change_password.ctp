<!-- File: /app/View/Users/change_password.ctp -->
<h3>Change your password</h3>

<?php
echo $this->Form->create(array('action' => 'change_password'));
echo $this->Form->input('password_old', array('label' => 'Old password', 'type' => 'password', 'autocomplete' => 'off'));
echo $this->Form->input('password', array('label' => 'New password', 'type' => 'password', 'autocomplete' => 'off'));
echo $this->Form->input('confirm_password', array('label' => 'Re-enter new password', 'type' => 'password', 'autocomplete' => 'off'));
echo $this->Form->end('Update Password');
?>