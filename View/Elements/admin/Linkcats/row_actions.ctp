<div class="row-actions">
    <?php
    $editLink = $this->Html->link(
        __d('hurad', 'Edit'),
        array('admin' => true, 'controller' => 'linkcats', 'action' => 'edit', $linkcat['Linkcat']['id'])
    );
    HuradRowActions::addAction('edit', $editLink, 'manage_links');

    $deleteLink = $this->Form->postLink(
        __d('hurad', 'Delete'),
        array('admin' => true, 'controller' => 'linkcats', 'action' => 'delete', $linkcat['Linkcat']['id']),
        null,
        __d('hurad', 'Are you sure you want to delete “%s”?', $linkcat['Linkcat']['name'])
    );
    HuradRowActions::addAction('delete', $deleteLink, 'manage_links');

    $actions = HuradHook::apply_filters('linkcat_row_actions', HuradRowActions::getActions(), $linkcat);
    echo $this->AdminLayout->rowActions($actions);
    ?>
</div>
