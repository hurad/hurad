<div class="row-actions">
    <?php
    $viewLink = $this->Html->link(
        __d('hurad', 'View'),
        $this->Post->getPermalink(),
        array('title' => __d('hurad', 'View “%s”', $this->Post->getTheTitle()), 'rel' => 'permalink')
    );
    HuradRowActions::addAction('view', $viewLink, 'read', array('wrap' => 'span', 'class' => 'action-edit'));

    $editLink = $this->Html->link(
        __d('hurad', 'Edit'),
        array('admin' => TRUE, 'controller' => 'posts', 'action' => 'edit', $this->Post->getTheID()),
        array('title' => __d('hurad', 'Edit this item'))
    );
    HuradRowActions::addAction(
        'edit',
        $editLink,
        'edit_published_posts',
        array('wrap' => 'span', 'class' => 'action-edit')
    );

    $deleteLink = $this->Form->postLink(
        __d('hurad', 'Delete'),
        array('admin' => TRUE, 'action' => 'delete', $this->Post->getTheID()),
        array('title' => __d('hurad', 'Delete this item')),
        __d('hurad', 'Are you sure you want to delete “%s”?', $this->Post->getTheTitle())
    );
    HuradRowActions::addAction(
        'delete',
        $deleteLink,
        'delete_posts',
        array('wrap' => 'span', 'class' => 'action-delete')
    );

    $actions = HuradHook::apply_filters('post_row_actions', HuradRowActions::getActions(), $post);
    echo $this->AdminLayout->rowActions($actions);
    ?>
</div>