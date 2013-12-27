<?php
if ($data['hasChildren']) {
    $this->Tree->addTypeAttribute('class', 'children');
}
$this->Tree->addItemAttribute('class', $this->Comment->commentClass('', false, $comment));
?>

<div id="comment-<?= $this->Comment->getId($comment); ?>">
    <div class="comment-author vcard">
        <div class="comment-author-avatar">
            <?php echo $this->Gravatar->image(
                $this->Comment->getAuthorEmail($comment),
                array('size' => '48', 'default' => 'mm')
            ); ?>
        </div>
        <div class="comment-author-name">
            <cite>
                <?php echo $this->Comment->getAuthorLink($comment); ?>
            </cite>
            <span class="says"><?= __d('hurad', 'Says:') ?></span>
        </div>
    </div>

    <div class="comment-meta-data">
        <?php echo $this->Html->link(
            $this->Comment->getDate('', $comment) . __d('hurad', ' at ') . $this->Comment->getTime('', $comment),
            $this->Content->getPermalink() . '#comment-' . $this->Comment->getId($comment)
        ); ?>
    </div>

    <div class="comment-body">
        <?= $this->Comment->getText($comment); ?>
    </div>

    <div class="comment-reply">
        <?php echo $this->Html->link(
            __d(
                'hurad',
                'Reply'
            ),
            array(
                'controller' => 'Comments',
                'action' => 'reply',
                $comment['Comment']['post_id'],
                $this->Comment->getId($comment)
            ),
            array('class' => 'comment-reply-link')
        ) ?>
    </div>
</div>