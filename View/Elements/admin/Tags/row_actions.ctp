<div class="row-actions">
    <?php
    $editLink = $this->Html->link(
        __d('hurad', 'Edit'),
        array('admin' => TRUE, 'controller' => 'Tags', 'action' => 'edit', $tag['Tag']['id'])
    );
    HuradRowActions::addAction('edit', $editLink, 'manage_tags');

    $deleteLink = $this->Form->postLink(
        __d('hurad', 'Delete'),
        array('action' => 'delete', $tag['Tag']['id']),
        null,
        __d('hurad', 'Are you sure you want to delete “%s”?', $tag['Tag']['name'])
    );
    HuradRowActions::addAction('delete', $deleteLink, 'manage_tags');

    $actions = HuradHook::apply_filters('tag_row_actions', HuradRowActions::getActions(), $tag);
    $this->AdminLayout->rowActions($actions);
    ?>
</div>