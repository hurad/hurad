<div class="row-actions">
    <?php
    $editLink = $this->Html->link(
        __d('hurad', 'Edit'),
        array('admin' => true, 'controller' => 'users', 'action' => 'profile', $user['User']['id'])
    );
    HuradRowActions::addAction('edit', $editLink, 'edit_users');

    $deleteLink = $this->Form->postLink(
        __d('hurad', 'Delete'),
        array('admin' => true, 'controller' => 'users', 'action' => 'delete', $user['User']['id']),
        null,
        __d('hurad', 'Are you sure you want to delete “%s”?', $user['User']['username'])
    );
    HuradRowActions::addAction('delete', $deleteLink, 'edit_users');

    $actions = HuradHook::apply_filters('user_row_actions', HuradRowActions::getActions(), $user);
    $this->AdminLayout->rowActions($actions);
    ?>
</div>