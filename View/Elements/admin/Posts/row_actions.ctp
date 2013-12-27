<div class="row-actions">
    <?php
    $viewLink = $this->Html->link(
        __d('hurad', 'View'),
        $this->Content->getPermalink(),
        array('title' => __d('hurad', 'View “%s”', $this->Content->getTitle()), 'rel' => 'permalink')
    );
    HuradRowActions::addAction('view', $viewLink, 'read', array('wrap' => 'span', 'class' => 'action-edit'));

    $editLink = $this->Html->link(
        __d('hurad', 'Edit'),
        array('admin' => TRUE, 'controller' => 'posts', 'action' => 'edit', $this->Content->getId()),
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
        array('admin' => TRUE, 'action' => 'delete', $this->Content->getId()),
        array('title' => __d('hurad', 'Delete this item')),
        __d('hurad', 'Are you sure you want to delete “%s”?', $this->Content->getTitle())
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