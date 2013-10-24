<div id="respond">
    <h3 id="reply-title"><?php __d('hurad', 'Leave a Reply'); ?></h3>

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
    <p class="logged-in-as">
        <?php
        echo __(
            'Logged in as %s. ',
            $this->Html->link(
                $current_user['username'],
                array('admin' => true, 'controller' => 'users', 'action' => 'profile', $current_user['id'])
            )
        );
        echo $this->Html->link(
            __d('hurad', 'Log out?'),
            '/logout',
            array('title' => __d('hurad', 'Log out of this account'))
        );
        ?>
    </p>

    <p>
        <?php echo $this->Form->input('content', array('tabindex' => '4', 'rows' => '10', 'cols' => '74%')); ?>
    </p>

    <p style="display: none;">
        <?php
        echo $this->Form->input('post_id', array('type' => 'hidden', 'value' => $post['Post']['id']));
        ?>
    </p>

    <p>
        <?php echo $this->Form->end(
            array('label' => __d('hurad', 'Post Comment'), 'div' => false, 'tabindex' => '5')
        ); ?>
    </p>

    <div style="clear: both;"></div>
</div>