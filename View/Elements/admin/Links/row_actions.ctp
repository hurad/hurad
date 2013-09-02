<div class="row-actions">
    <?php
    $visitLink = $this->Html->link(__d('hurad', 'Visit Link'), $link['Link']['url'], array('target' => '_blank'));
    HuradRowActions::addAction('visit_link', $visitLink, 'manage_links');

    $editLink = $this->Html->link(
        __d('hurad', 'Edit'),
        array('admin' => true, 'controller' => 'links', 'action' => 'edit', $link['Link']['id'])
    );
    HuradRowActions::addAction('edit', $editLink, 'manage_links');

    $deleteLink = $this->Form->postLink(
        __d('hurad', 'Delete'),
        array('admin' => true, 'controller' => 'links', 'action' => 'delete', $link['Link']['id']),
        null,
        __d('hurad', 'Are you sure you want to delete “%s”?', $link['Link']['name'])
    );
    HuradRowActions::addAction('delete', $deleteLink, 'manage_links');

    $actions = HuradHook::apply_filters('link_row_actions', HuradRowActions::getActions(), $link);
    $this->AdminLayout->rowActions($actions);
    ?>
</div>