<h4 class="comment-title">
    <?= __d('hurad', '%s Comment', $this->Content->content[$this->Content->contentModel]['comment_count']); ?>
</h4>
<?php echo $this->Session->flash('comment-flash'); ?>
<?php
if ($this->Comment->commentsIsOpen()) {
    echo $this->Comment->treeList($content);
    echo $this->Comment->form($content);
} else {
    echo __d('hurad', 'Comment Closed');
}