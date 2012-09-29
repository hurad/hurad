
<?php if (!empty($post['Comment'])): ?>
    <?php
    $i = 0;
    foreach ($post['Comment'] as $comment):
        ?>
        <?php //echo $comment['id']; ?>
        <?php //echo $comment['parent_id']; ?>
        <?php //echo $comment['post_id']; ?>
        <?php //echo $comment['user_id']; ?>
        <small><?php echo $comment['author']; ?></small>
        <small><?php echo $comment['created']; ?></small>
        <?php //echo $comment['author_email']; ?>
        <?php //echo $comment['author_url']; ?>
        <?php //echo $comment['author_ip']; ?>
        <p><?php echo $comment['content']; ?></p>
        <?php //echo $comment['approved']; ?>
        <?php //echo $comment['agent']; ?>
        <?php //echo $comment['lft']; ?>
        <?php //echo $comment['rght']; ?>

        <?php //echo $comment['modified']; ?>
        <?php echo $this->Html->link('Reply', array('controller' => 'comments', 'action' => 'reply', $post['Post']['id'], $comment['id']));
        ?>
        <hr>
    <?php endforeach; ?>

<?php endif; ?>