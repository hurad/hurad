<div class="row-actions">
    <span class="action-edit">
        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'Tags', 'action' => 'edit', $tag['Tag']['id'])); ?> | 
    </span>                 
    <span class="action-delete">
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tag['Tag']['id']), null, __('Are you sure you want to delete %s?', $tag['Tag']['name'])); ?>
    </span>
</div>