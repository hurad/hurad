<div id="respond">
    <h3 id="reply-title"><?= __d('hurad', 'Leave a Reply'); ?></h3>
    <?php
    echo $this->Form->create(
        'Comment',
        array(
            'action' => 'add',
            'id' => 'commentform',
            'inputDefaults' => array(
                'label' => false,
                'div' => false
            )
        )
    );
    ?>
    <p>
        <?php echo $this->Form->input('author', array('tabindex' => '1', 'size' => '22')); ?>
        <label for="CommentAuthor">
            <small><?= __d('hurad', 'Name (Required)'); ?></small>
        </label>
    </p>

    <p>
        <?php echo $this->Form->input('author_email', array('tabindex' => '2', 'size' => '22')); ?>
        <label for="CommentAuthorEmail">
            <small><?= __d('hurad', 'eMail (Required)'); ?></small>
        </label>
    </p>

    <p>
        <?php echo $this->Form->input('author_url', array('tabindex' => '3', 'size' => '22')); ?>
        <label for="CommentAuthorUrl">
            <small><?= __d('hurad', 'URL'); ?></small>
        </label>
    </p>

    <p>
        <?php echo $this->Form->input('content', array('tabindex' => '4', 'rows' => '10', 'cols' => '74%')); ?>
    </p>

    <p style="display: none;">
        <?php echo $this->Form->input('post_id', array('type' => 'hidden', 'value' => $post['Post']['id'])); ?>
    </p>

    <p>
        <?php echo $this->Form->end(
            array('label' => __d('hurad', 'Post Comment'), 'div' => false, 'tabindex' => '5')
        ); ?>
    </p>

    <div style="clear: both;"></div>
</div>