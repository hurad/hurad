<!-- app/View/Elements/comment_reply_form.ctp -->

<?php if ($logged_in) { ?>
    <?php echo $this->Form->create(null, array('url' => '/comments/reply/' . $urls[0] . '/' . $urls[1] . '/')); ?>
    <fieldset>
        <legend><?php echo __('Add Comment'); ?></legend>
        <?php
        //echo $this->Form->input('post_id', array('type' => 'hidden', 'value' => 5));
        echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $current_user['id']));
        echo $this->Form->input('author', array('readonly' => TRUE, 'value' => $current_user['username']));
        echo $this->Form->input('author_email', array('readonly' => TRUE, 'value' => $current_user['email']));
        echo $this->Form->input('author_url', array('readonly' => TRUE, 'value' => $current_user['url']));
        //echo $this->Form->input('author_ip');
        echo $this->Form->input('content');
        //echo $this->Form->input('approved');
        //echo $this->Form->input('agent');
        //echo $this->Form->input('post_id', array('type' => 'hidden', 'value' => $urls[0]));
        //echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => $urls[1]));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit Comment')); ?>
<?php } else { ?>
    <?php echo $this->Form->create(null, array('url' => '/comments/reply/' . $urls[0] . '/' . $urls[1] . '/')); ?>
    <fieldset>
        <legend><?php echo __('Add Comment'); ?></legend>
        <?php
        //echo $this->Form->input('post_id', array('type' => 'hidden', 'value' => $urls[0]));
        //echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => $urls[1]));
        echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => '0'));
        echo $this->Form->input('author');
        echo $this->Form->input('author_email');
        echo $this->Form->input('author_url');
        echo $this->Form->input('content');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit Comment')); ?>
<?php } ?>
