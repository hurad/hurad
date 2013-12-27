<?php
if ($data['hasChildren']) {
    $this->Tree->addTypeAttribute('class', 'children');
}
$this->Tree->addItemAttribute('class', $this->Comment->getClass('', $comment));
?>

<div id="comment-<?= $this->Comment->getId($comment); ?>" class="well well-sm">
    <div class="comment-author v-card row">
        <div class="comment-author-avatar col-sm-1">
            <?php echo $this->Gravatar->image(
                $this->Comment->getAuthorEmail($comment),
                array('size' => '48', 'default' => 'mm')
            ); ?>
        </div>
        <div class="comment-author-name">
            <cite>
                <?= $this->Comment->getAuthorLink($comment); ?>
            </cite>
            <span class="says"><?= __d('hurad', 'Says:') ?></span>
        </div>
        <div class="comment-meta-data">
            <?php echo $this->Html->link(
                $this->Comment->getDate('', $comment) . __d('hurad', ' at ') . $this->Comment->getTime('', $comment),
                $this->Content->getPermalink() . '#comment-' . $this->Comment->getId($comment)
            ); ?>
        </div>
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
                'controller' => 'comments',
                'action' => 'reply',
                $this->Comment->getId($comment)
            ),
            array('class' => 'comment-reply-link')
        ) ?>
    </div>
</div>
