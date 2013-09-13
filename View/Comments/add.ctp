<div class="comments form">
    <?php echo $this->Form->create('Comment'); ?>
    <fieldset>
        <legend><?php echo __d('hurad', 'Add Comment'); ?></legend>
        <?php
        echo $this->Form->input('parent_id');
        echo $this->Form->input('post_id');
        echo $this->Form->input('user_id');
        echo $this->Form->input('author');
        echo $this->Form->input('author_email');
        echo $this->Form->input('author_url');
        echo $this->Form->input('author_ip');
        echo $this->Form->input('content');
        echo $this->Form->input('approved');
        echo $this->Form->input('agent');
        echo $this->Form->input('lft');
        echo $this->Form->input('rght');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__d('hurad', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('hurad', 'Actions'); ?></h3>
    <ul>

        <li><?php echo $this->Html->link(__d('hurad', 'List Comments'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'List Comments'),
                array('controller' => 'comments', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'New Parent Comment'),
                array('controller' => 'comments', 'action' => 'add')
            ); ?> </li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'List Posts'),
                array('controller' => 'posts', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(__d('hurad', 'New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'List Users'),
                array('controller' => 'users', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(__d('hurad', 'New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
    </ul>
</div>
