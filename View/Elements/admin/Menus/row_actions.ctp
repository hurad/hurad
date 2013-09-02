<div class="row-actions">
    <?php
    $editLink = $this->Html->link(
        __d('hurad', 'Edit'),
        array('admin' => true, 'controller' => 'menus', 'action' => 'edit', $menu['Menu']['id'])
    );
    HuradRowActions::addAction('edit', $editLink, 'manage_menus');

    $deleteLink = $this->Form->postLink(
        __d('hurad', 'Delete'),
        array('admin' => true, 'controller' => 'menus', 'action' => 'delete', $menu['Menu']['id']),
        null,
        __d('hurad', 'Are you sure you want to delete “%s”?', $menu['Menu']['name'])
    );
    HuradRowActions::addAction('delete', $deleteLink, 'manage_menus');

    $actions = HuradHook::apply_filters('menu_row_actions', HuradRowActions::getActions(), $menu);
    $this->AdminLayout->rowActions($actions);
    ?>
</div>