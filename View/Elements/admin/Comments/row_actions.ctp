<div class="row-actions">
    <?php
    $approvedLink = $this->AdminLayout->toggleCommentLink($comment['Comment']['status'], $this->Comment->getId());

    $viewLink = $this->Comment->getCommentLink($comment['Comment']['post_id'], __d('hurad', 'View'));

    $editLink = $this->Html->link(
        __d('hurad', 'Edit'),
        ['admin' => true, 'controller' => 'comments', 'action' => 'edit', $this->Comment->getId()]
    );

    if ($comment['Comment']['status'] == Comment::STATUS_SPAM) {
        $spamLink = $this->AdminLayout->toggleCommentLink($comment['Comment']['status'], $this->Comment->getId());
    } else {
        $spamLink = $this->Html->link(
            __d('hurad', 'Spam'),
            ['admin' => true, 'controller' => 'comments', 'action' => 'action', 'spam', $this->Comment->getId()]
        );
    }

    if ($comment['Comment']['status'] == Comment::STATUS_TRASH) {
        $trashLink = $this->AdminLayout->toggleCommentLink($comment['Comment']['status'], $this->Comment->getId());
    } else {
        $trashLink = $this->Html->link(
            __d('hurad', 'Trash'),
            [
                'admin' => true,
                'controller' => 'comments',
                'action' => 'action',
                'trash',
                $this->Comment->getId()
            ]
        );
    }


    if (!Router::getParam('pass')) {
        HuradRowActions::addAction('approved', $approvedLink, 'manage_comments');
        HuradRowActions::addAction('view', $viewLink, 'manage_comments');
        HuradRowActions::addAction('edit', $editLink, 'manage_comments');
        HuradRowActions::addAction('spam', $spamLink, 'manage_comments');
        HuradRowActions::addAction('trash', $trashLink, 'manage_comments');
    } else {
        switch (Router::getParam('pass')[0]) {
            case 'approved':
            case 'pending':
                HuradRowActions::addAction('approved', $approvedLink, 'manage_comments');
                HuradRowActions::addAction('view', $viewLink, 'manage_comments');
                HuradRowActions::addAction('edit', $editLink, 'manage_comments');
                HuradRowActions::addAction('spam', $spamLink, 'manage_comments');
                HuradRowActions::addAction('trash', $trashLink, 'manage_comments');
                break;

            case 'spam':
            case 'trash':
                HuradRowActions::addAction('view', $viewLink, 'manage_comments');
                HuradRowActions::addAction('edit', $editLink, 'manage_comments');
                HuradRowActions::addAction('spam', $spamLink, 'manage_comments');
                HuradRowActions::addAction('trash', $trashLink, 'manage_comments');
                break;
        }
    }

    $actions = HuradHook::apply_filters('comment_row_actions', HuradRowActions::getActions(), $comment);
    echo $this->AdminLayout->rowActions($actions);
    ?>
</div>