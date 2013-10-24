<?php echo $this->Form->create(
    null,
    array('url' => '/comments/reply/' . Router::getParam('postID') . '/' . Router::getParam('parentID') . '/')
); ?>

<?php if ($loggedIn) { ?>

    <fieldset>
        <legend><?php echo __d('hurad', 'Add Comment'); ?></legend>
        <?php echo $this->Form->input('content'); ?>
    </fieldset>
<?php } else { ?>
    <fieldset>
        <legend><?php echo __d('hurad', 'Add Comment'); ?></legend>
        <?php
        echo $this->Form->input('author');
        echo $this->Form->input('author_email');
        echo $this->Form->input('author_url');
        echo $this->Form->input('content');
        ?>
    </fieldset>
<?php
}
echo $this->Form->end(__d('hurad', 'Add Comment'));
?>
