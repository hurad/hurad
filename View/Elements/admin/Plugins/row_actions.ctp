<div class="row-actions">
    <?php
    if (HuradPlugin::isActive($alias)) {
        $toggleText = __('Deactivate');
    } else {
        $toggleText = __('Activate');
    }

    $toggleLink = $this->Html->Link(
        $toggleText,
        array('admin' => true, 'controller' => 'plugins', 'action' => 'toggle', $alias)
    );
    HuradRowActions::addAction('toggle', $toggleLink, 'activate_plugins');

    $deleteLink = $this->Form->postLink(
        __('Delete'),
        array('admin' => true, 'action' => 'delete', $alias),
        null,
        __('Are you sure you want to delete "%s"?', $alias)
    );
    HuradRowActions::addAction('delete', $deleteLink, 'delete_plugins');

    $actions = HuradHook::apply_filters('plugin_row_actions', HuradRowActions::getActions(), $alias);
    $this->AdminLayout->rowActions($actions);
    ?>
</div>