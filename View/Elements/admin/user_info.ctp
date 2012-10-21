<?php if ($logged_in): ?>
    <div id="user_info">
        <p>
            <?php echo __('Hello,'); ?>
            <?php echo $this->Html->link($current_user['username'], array('admin' => FALSE, 'controller' => 'users', 'action' => 'profile', 'admin' => TRUE, $current_user['id'])); ?> | 
            <?php echo $this->Html->link('Logout', array('admin' => FALSE, 'controller' => 'users', 'action' => 'logout')); ?>
        </p>
    </div>
<?php else: ?>
    <div id="user_info">
        <p>
            <?php echo $this->Html->link('Login', array('admin' => FALSE, 'controller' => 'users', 'action' => 'login')); ?>
        </p>
    </div>
<?php endif; ?>