<!-- app/View/Elements/comment_form.ctp -->

<?php if ($logged_in) { ?>
    <?php //echo $this->Form->create('Comment', array('action' => 'add')); ?>
    <fieldset>
        <legend><?php echo __('Add Comment'); ?></legend>
        <?php
        echo $this->Form->input('post_id', array('type' => 'hidden', 'value' => $post['Post']['id']));
        echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $current_user['id']));
        echo $this->Form->input('author', array('readonly' => TRUE, 'value' => $current_user['username']));
        echo $this->Form->input('author_email', array('readonly' => TRUE, 'value' => $current_user['email']));
        echo $this->Form->input('author_url', array('readonly' => TRUE, 'value' => $current_user['url']));
        //echo $this->Form->input('author_ip');
        echo $this->Form->input('content');
        //echo $this->Form->input('approved');
        //echo $this->Form->input('agent');
        //echo $this->Form->input('lft');
        //echo $this->Form->input('rght');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit Comment')); ?>    
<?php } else { ?>
    <?php echo $this->Form->create('Comment', array('action' => 'add')); ?>
    <fieldset>
        <legend><?php echo __('Add Comment'); ?></legend>
        <?php
        echo $this->Form->input('post_id', array('type' => 'hidden', 'value' => $post['Post']['id']));
        echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => '0'));
        echo $this->Form->input('author');
        echo $this->Form->input('author_email');
        echo $this->Form->input('author_url');
        echo $this->Form->input('content');
        ?>
    </fieldset>
    <?php //echo $this->Form->end(__('Submit Comment')); ?>  
<?php } ?>




<div id="respond">
    <h3 id="reply-title">Leave a Reply <small><a style="display:none;" href="/demo/testing-this-theme-with-more-posts.php#respond" id="cancel-comment-reply-link" rel="nofollow">Cancel</a></small></h3>
    <?php
    echo $this->Form->create('Comment', array(
        'action' => 'add',
        'id' => 'commentform',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    ));
    ?>
    <p class="comment-form-author">
        <?php echo $this->Form->input('author'); ?><label for="author">Your Name</label> <span class="required">*</span>
    </p>
    <p class="comment-form-email">
        <input type="text" class="required email" size="30" value="" name="email" id="email"><label for="email">Your Email</label> <span class="required">*</span>
    </p>
    <p class="comment-form-url"><input type="text" size="30" value="" name="url" id="url"><label for="website">Your Website</label> </p>
    <p class="comment-form-comment"><textarea class="required" aria-required="true" rows="8" cols="45" name="comment" id="comment"></textarea></p>	

    <?php
    $options = array(
        'label' => 'Update',
        'div' => FALSE
    );
    echo $this->Form->end(array('label' => 'Update', 'div' => FALSE));
    ?>
    <input type="hidden" id="comment_post_ID" value="62" name="comment_post_ID">
    <input type="hidden" value="0" id="comment_parent" name="comment_parent">

</div>