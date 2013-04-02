<div class="row-actions">
    <span class="action-edit">
        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'users', 'action' => 'profile', $user['User']['id'])); ?> | 
    </span>                 
    <span class="action-delete">
        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'controller' => 'users', 'action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
    </span>
</div>