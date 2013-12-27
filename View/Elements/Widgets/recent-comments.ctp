<?php $comments = ClassRegistry::init('Comment')->getLatest($data['count']); ?>

<ul class="list-unstyled">
    <?php
    if (count($comments) > 0) {
        foreach ($comments as $comment) {
            $this->Comment->setComment($comment);
            echo '<li>' . $this->Comment->getCommentLink($comment['Comment']['post_id']) . '</li>';
        }
    } else {
        echo '<li>' . __d('hurad', 'No comments were found') . '</li>';
    }
    ?>
</ul>
