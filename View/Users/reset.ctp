<div class="users form">
    <?php echo $this->Form->create(
        'User',
        array('url' => array('controller' => 'users', 'action' => 'reset', $key))
    ); ?>
    <fieldset>
        <legend><?php echo __d('hurad', 'Add User'); ?></legend>
        <?php
        echo $this->Form->input('password', array('label' => __d('hurad', 'New password')));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__d('hurad', 'Submit')); ?>
</div>

