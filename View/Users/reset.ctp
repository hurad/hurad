<div class="users form">
    <?php echo $this->Form->create(
        'User',
        array('url' => array('controller' => 'users', 'action' => 'reset', $key))
    ); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php
        echo $this->Form->input('password', array('label' => __('New password')));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>

