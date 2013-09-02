<div class="row-actions">
    <?php
    $editLink = $this->Html->link(
        __d('hurad', 'Edit'),
        array('admin' => TRUE, 'controller' => 'categories', 'action' => 'edit', $category['Category']['id'])
    );
    HuradRowActions::addAction('edit', $editLink, 'manage_categories');

    $deleteLink = $this->Form->postLink(
        __d('hurad', 'Delete'),
        array('admin' => TRUE, 'controller' => 'categories', 'action' => 'delete', $category['Category']['id']),
        null,
        __d('hurad', 'Are you sure you want to delete “%s”?', $category['Category']['name'])
    );
    HuradRowActions::addAction('delete', $deleteLink, 'manage_categories');

    $actions = HuradHook::apply_filters('category_row_actions', HuradRowActions::getActions(), $category);
    $this->AdminLayout->rowActions($actions);
    ?>
</div>