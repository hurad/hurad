<div class="row-actions">
    <?php
    $approvedLink = $this->AdminLayout->approveLink($comment['Comment']['approved'], $this->Comment->getId());
    HuradRowActions::addAction('approved', $approvedLink, 'manage_comments');

    $viewLink = $this->Html->link(
        __d('hurad', 'View'),
        array('admin' => true, 'controller' => 'comments', 'action' => 'view', $this->Comment->getId())
    );
    HuradRowActions::addAction('view', $viewLink, 'manage_comments');

    $editLink = $this->Html->link(
        __d('hurad', 'Edit'),
        array('admin' => true, 'controller' => 'comments', 'action' => 'edit', $this->Comment->getId())
    );
    HuradRowActions::addAction('edit', $editLink, 'manage_comments');

    $spamLink = $this->Html->link(
        __d('hurad', 'Spam'),
        array('admin' => true, 'controller' => 'comments', 'action' => 'action', 'spam', $this->Comment->getId())
    );
    HuradRowActions::addAction('spam', $spamLink, 'manage_comments');

    $trashLink = $this->Html->link(
        __d('hurad', 'Trash'),
        array(
            'admin' => true,
            'controller' => 'comments',
            'action' => 'action',
            'trash',
            $this->Comment->getId()
        )
    );
    HuradRowActions::addAction('trash', $trashLink, 'manage_comments');

    $actions = HuradHook::apply_filters('comment_row_actions', HuradRowActions::getActions(), $comment);
    echo $this->AdminLayout->rowActions($actions);
    ?>
</div>