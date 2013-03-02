<?php if ($logged_in): ?>
    <div class="btn-group pull-right">
        <button class="btn btn-small"><?php echo $this->AdminLayout->currentUser(); ?></button>
        <button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><?php echo $this->Html->link($this->Html->tag('i', null, array('class' => 'icon-user')) . '</i>' . ' ' . __('Profile'), array('admin' => TRUE, 'controller' => 'users', 'action' => 'profile', $this->AdminLayout->currentUser('id')), array('escape' => FALSE)); ?></li>
            <li class="divider"></li>
            <li><?php echo $this->Html->link($this->Html->tag('i', null, array('class' => 'icon-off')) . '</i>' . ' ' . __('Logout'), array('plugin' => NULL, 'admin' => FALSE, 'controller' => 'users', 'action' => 'logout'), array('escape' => FALSE)); ?></li>
        </ul>
    </div>
<?php else: ?>
    <?php // ?>
<?php endif; ?>
