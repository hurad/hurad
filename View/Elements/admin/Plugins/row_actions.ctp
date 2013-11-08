<div class="row-actions">
    <?php
    if (HuradPlugin::isActive($alias)) {
        $toggleText = __d('hurad', 'Deactivate');
    } else {
        $toggleText = __d('hurad', 'Activate');
    }

    $toggleLink = $this->Html->Link(
        $toggleText,
        array('admin' => true, 'controller' => 'plugins', 'action' => 'toggle', $alias)
    );
    HuradRowActions::addAction('toggle', $toggleLink, 'activate_plugins');

    $deleteLink = $this->Form->postLink(
        __d('hurad', 'Delete'),
        array('admin' => true, 'action' => 'delete', $alias),
        null,
        __d('hurad', 'Are you sure you want to delete "%s"?', $alias)
    );
    HuradRowActions::addAction('delete', $deleteLink, 'delete_plugins');

    $actions = HuradHook::apply_filters('plugin_row_actions', HuradRowActions::getActions(), $alias);
    echo $this->AdminLayout->rowActions($actions);
    ?>
</div>