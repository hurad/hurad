<h4 class="comment-title">
    <?= __d('hurad', '%s Comment', $post['Post']['comment_count']); ?>
</h4>

<?php
if ($this->Comment->commentsOpen()) {
    echo $this->Comment->treeList($post);
    echo $this->Comment->form($post);
} else {
    echo __d('hurad', 'Comment Closed');
}