<?php if ($logged_in): ?>
    <div id="user_info">
        <p>
            <?php echo __('Hello,'); ?>
            <?php echo $this->Html->link($this->AdminLayout->currentUser(), array('admin' => TRUE, 'controller' => 'users', 'action' => 'profile', $this->AdminLayout->currentUser('id'))); ?> | 
            <?php echo $this->Html->link(__('Logout'), array('plugin' => NULL, 'admin' => FALSE, 'controller' => 'users', 'action' => 'logout')); ?>
        </p>
    </div>
<?php else: ?>
    <div id="user_info">
        <p>
            <?php echo $this->Html->link(__('Login'), array('plugin' => NULL, 'admin' => FALSE, 'controller' => 'users', 'action' => 'login')); ?>
        </p>
    </div>
<?php endif; ?>